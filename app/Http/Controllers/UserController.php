<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users with data table, search, role & status filters.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $roleFilter = $request->input('role', 'all');
        $statusFilter = $request->input('status', 'all');
        $sortBy = $request->input('sort', 'latest');
        $perPage = (int) $request->input('per_page', 10);

        if (!in_array($perPage, [5, 10, 20, 50])) {
            $perPage = 10;
        }

        // Summary Statistics for KPI cards
        $totalUsers = User::count();
        $activeTeachers = User::where('role', 'teacher')->where('status', 'active')->count();
        $totalCreators = User::whereIn('role', ['teacher', 'creator'])->count();
        $totalConnectedVideos = Video::whereNotNull('user_id')->count();

        // Build main query
        $query = User::withCount('videos')->with(['videos' => function ($q) {
            $q->orderBy('created_at', 'desc')->take(3);
        }]);

        // Search Filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%");
            });
        }

        // Role Filter
        if ($roleFilter !== 'all' && in_array($roleFilter, ['admin', 'teacher', 'editor', 'creator'])) {
            $query->where('role', $roleFilter);
        }

        // Status Filter
        if ($statusFilter !== 'all' && in_array($statusFilter, ['active', 'inactive', 'suspended'])) {
            $query->where('status', $statusFilter);
        }

        // Sorting
        switch ($sortBy) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'videos_desc':
                $query->orderBy('videos_count', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $users = $query->paginate($perPage)->withQueryString();

        return view('users.index', compact(
            'users',
            'search',
            'roleFilter',
            'statusFilter',
            'sortBy',
            'perPage',
            'totalUsers',
            'activeTeachers',
            'totalCreators',
            'totalConnectedVideos'
        ));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|in:admin,teacher,editor,creator',
            'status' => 'required|string|in:active,inactive,suspended',
            'phone' => 'nullable|string|max:50',
            'bio' => 'nullable|string|max:1000',
            'avatar_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'avatar_url' => 'nullable|string|url|max:500',
        ]);

        $avatarUrl = null;
        if ($request->hasFile('avatar_image')) {
            $path = $request->file('avatar_image')->store('avatars', 'public');
            $avatarUrl = asset('storage/' . $path);
        } elseif (!empty($validated['avatar_url'])) {
            $avatarUrl = $validated['avatar_url'];
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => $validated['status'],
            'phone' => $validated['phone'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'avatar_url' => $avatarUrl,
        ]);

        return redirect()->route('users.index')
            ->with('toaster_success', "User '{$user->name}' created successfully!");
    }

    /**
     * Show the form for editing the specified user along with connected videos.
     */
    public function edit(User $user)
    {
        // Eager load connected videos with foreign key relation
        $user->load(['videos' => function ($q) {
            $q->orderBy('created_at', 'desc');
        }]);

        // Fetch unassigned videos or other videos available for reassignment
        $unassignedVideos = Video::whereNull('user_id')->orWhere('user_id', '!=', $user->id)->get(['id', 'title', 'teacher_name', 'created_at']);

        return view('users.edit', compact('user', 'unassignedVideos'));
    }

    /**
     * Update the specified user in database.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|string|in:admin,teacher,editor,creator',
            'status' => 'required|string|in:active,inactive,suspended',
            'phone' => 'nullable|string|max:50',
            'bio' => 'nullable|string|max:1000',
            'password' => 'nullable|string|min:6|confirmed',
            'avatar_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'avatar_url' => 'nullable|string|max:500',
        ]);

        $avatarUrl = $user->avatar_url;
        if ($request->hasFile('avatar_image')) {
            $path = $request->file('avatar_image')->store('avatars', 'public');
            $avatarUrl = asset('storage/' . $path);
        } elseif ($request->filled('avatar_url')) {
            $avatarUrl = $validated['avatar_url'];
        }

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => $validated['status'],
            'phone' => $validated['phone'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'avatar_url' => $avatarUrl,
        ];

        // Only update password if a new one was provided
        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        // Also update teacher_name string in linked videos for consistency if name changed
        Video::where('user_id', $user->id)->update(['teacher_name' => $user->name]);

        return redirect()->route('users.index')
            ->with('toaster_success', "User '{$user->name}' updated successfully!");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent logged-in user from deleting themselves accidentally
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own active administrator account.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('users.index')
            ->with('toaster_success', "User '{$userName}' deleted successfully.");
    }

    /**
     * Toggle active/inactive user status.
     */
    public function toggleStatus(User $user)
    {
        $newStatus = ($user->status === 'active') ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'status' => $newStatus,
                'message' => "User status updated to {$newStatus}"
            ]);
        }

        return back()->with('toaster_success', "User '{$user->name}' status changed to {$newStatus}.");
    }
}
