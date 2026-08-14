<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Dashboard home page overview with analytics & teacher stats.
     */
    public function dashboard()
    {
        $totalVideos = Video::count();
        $totalUsers = User::count();
        
        // Only fetch users who are actual instructors / teachers
        $teachers = User::whereIn('role', ['teacher', 'creator'])->withCount('videos')->get();
        
        $teacherCounts = [];
        foreach ($teachers as $teacher) {
            $teacherCounts[$teacher->name] = $teacher->videos_count;
        }

        $recentVideos = Video::with('user')->orderBy('created_at', 'desc')->take(6)->get();
        $recentUsers = User::withCount('videos')->orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard', compact('totalVideos', 'totalUsers', 'teacherCounts', 'teachers', 'recentVideos', 'recentUsers'));
    }

    /**
     * Data table list page (Edit Videos list).
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $userFilter = $request->input('user_id', 'all');
        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, [5, 10, 20, 50, 100])) {
            $perPage = 10;
        }

        $query = Video::with('user');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('teacher_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($userFilter !== 'all' && is_numeric($userFilter)) {
            $query->where('user_id', $userFilter);
        }

        $videos = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();
        // Only list Instructors (Teachers & Creators) in filter dropdown
        $availableTeachers = User::whereIn('role', ['teacher', 'creator'])->orderBy('name')->get(['id', 'name', 'role']);

        return view('videos.index', compact('videos', 'search', 'userFilter', 'perPage', 'availableTeachers'));
    }

    /**
     * Show form to add a new video (only instructors/teachers can be selected).
     */
    public function create()
    {
        // Filter strictly to users who have the role 'teacher' or 'creator'
        $users = User::whereIn('role', ['teacher', 'creator'])->orderBy('name')->get();
        return view('videos.create', compact('users'));
    }

    /**
     * Store a newly created video in database with foreign key user_id.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_url' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'teacher_name' => 'nullable|string|max:255',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'thumbnail_url' => 'nullable|string',
        ]);

        $thumbnailPath = null;

        // Handle uploaded file
        if ($request->hasFile('thumbnail_image')) {
            $path = $request->file('thumbnail_image')->store('thumbnails', 'public');
            $thumbnailPath = $path;
        } elseif (!empty($validated['thumbnail_url'])) {
            $thumbnailPath = $validated['thumbnail_url'];
        }

        // Determine teacher display name from selected instructor user
        $assignedUser = User::find($validated['user_id']);
        $teacherName = $assignedUser ? $assignedUser->name : ($validated['teacher_name'] ?? 'Unassigned');

        Video::create([
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'video_url' => $validated['video_url'],
            'teacher_name' => $teacherName,
            'thumbnail_path' => $thumbnailPath,
        ]);

        return redirect()->route('videos.edit-list')
            ->with('toaster_success', "Video saved and connected to teacher '{$teacherName}'!");
    }

    /**
     * Show form to edit an existing video.
     */
    public function edit(Video $video)
    {
        // Only teachers and creators can be assigned
        $users = User::whereIn('role', ['teacher', 'creator'])->orderBy('name')->get();
        return view('videos.edit', compact('video', 'users'));
    }

    /**
     * Update video record in database.
     */
    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_url' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'teacher_name' => 'nullable|string|max:255',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'thumbnail_url' => 'nullable|string',
        ]);

        if ($request->hasFile('thumbnail_image')) {
            // Delete old file if existed locally
            if ($video->thumbnail_path && !filter_var($video->thumbnail_path, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($video->thumbnail_path);
            }
            $path = $request->file('thumbnail_image')->store('thumbnails', 'public');
            $video->thumbnail_path = $path;
        } elseif (!empty($validated['thumbnail_url'])) {
            $video->thumbnail_path = $validated['thumbnail_url'];
        }

        // Determine teacher display name
        $assignedUser = User::find($validated['user_id']);
        $teacherName = $assignedUser ? $assignedUser->name : $video->teacher_name;

        $video->update([
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'video_url' => $validated['video_url'],
            'teacher_name' => $teacherName,
            'thumbnail_path' => $video->thumbnail_path,
        ]);

        return redirect()->route('videos.edit-list')
            ->with('toaster_success', 'Video updated successfully!');
    }

    /**
     * Delete video record.
     */
    public function destroy(Video $video)
    {
        if ($video->thumbnail_path && !filter_var($video->thumbnail_path, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($video->thumbnail_path);
        }

        $video->delete();

        return redirect()->route('videos.edit-list')
            ->with('toaster_success', 'Video deleted successfully.');
    }
}
