<x-app-layout>
    <x-slot name="title">User Management - Display Table</x-slot>

    <!-- HEADER & ACTION BAR -->
    <div class="md:flex md:items-center md:justify-between mb-8 pb-6 border-b border-gray-800">
        <div>
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-white tracking-tight">User Management Directory</h1>
                    <p class="text-xs sm:text-sm text-gray-400 mt-0.5">Manage teachers, administrators, and instructors linked to video catalog records.</p>
                </div>
            </div>
        </div>

        <div class="mt-4 md:mt-0 flex items-center space-x-3">
            <a href="{{ route('videos.edit-list') }}" 
               class="px-4 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-200 text-xs sm:text-sm font-semibold border border-gray-700 transition-colors flex items-center space-x-2">
                <i class="fa-solid fa-video text-purple-400"></i>
                <span>View Video Catalog</span>
            </a>
            
            <a href="{{ route('users.create') }}" 
               class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white text-xs sm:text-sm font-heading font-semibold shadow-lg shadow-emerald-600/25 transition-all transform hover:-translate-y-0.5 flex items-center space-x-2">
                <i class="fa-solid fa-user-plus text-xs"></i>
                <span>Add New User</span>
            </a>
        </div>
    </div>

    <!-- METRICS OVERVIEW CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        
        <!-- Total Users Card -->
        <div class="bg-[#0e1424] border border-gray-800/90 rounded-2xl p-5 shadow-lg relative overflow-hidden group hover:border-gray-700 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Users</span>
                    <h3 class="font-heading font-extrabold text-2xl sm:text-3xl text-white mt-1">{{ $totalUsers }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-800/80 text-[11px] text-gray-400 flex items-center space-x-1.5">
                <i class="fa-solid fa-user-check text-indigo-400"></i>
                <span>System accounts registered</span>
            </div>
        </div>

        <!-- Active Teachers Card -->
        <div class="bg-[#0e1424] border border-gray-800/90 rounded-2xl p-5 shadow-lg relative overflow-hidden group hover:border-gray-700 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Active Teachers</span>
                    <h3 class="font-heading font-extrabold text-2xl sm:text-3xl text-white mt-1">{{ $activeTeachers }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-purple-500/10 text-purple-400 border border-purple-500/20 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-800/80 text-[11px] text-gray-400 flex items-center space-x-1.5">
                <span class="w-2 h-2 rounded-full bg-purple-400"></span>
                <span>Instructors teaching videos</span>
            </div>
        </div>

        <!-- Creators & Staff Card -->
        <div class="bg-[#0e1424] border border-gray-800/90 rounded-2xl p-5 shadow-lg relative overflow-hidden group hover:border-gray-700 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Instructors & Staff</span>
                    <h3 class="font-heading font-extrabold text-2xl sm:text-3xl text-white mt-1">{{ $totalCreators }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-award"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-800/80 text-[11px] text-gray-400 flex items-center space-x-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                <span>Teachers, Creators & Editors</span>
            </div>
        </div>

        <!-- Connected Videos via Foreign Key -->
        <div class="bg-[#0e1424] border border-gray-800/90 rounded-2xl p-5 shadow-lg relative overflow-hidden group hover:border-gray-700 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Connected Videos</span>
                    <h3 class="font-heading font-extrabold text-2xl sm:text-3xl text-white mt-1">{{ $totalConnectedVideos }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-link"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-800/80 text-[11px] text-gray-400 flex items-center space-x-1.5">
                <i class="fa-solid fa-database text-emerald-400"></i>
                <span>Linked via <code class="text-emerald-300">user_id</code> FK</span>
            </div>
        </div>

    </div>

    <!-- USER DISPLAY & DATA TABLE SECTION -->
    <div class="bg-[#0b0f19] border border-gray-800 rounded-3xl p-6 shadow-2xl space-y-6">
        
        <!-- SEARCH & FILTER TOOLBAR -->
        <form method="GET" action="{{ route('users.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 sm:gap-4">
                
                <!-- Search Input -->
                <div class="lg:col-span-4 relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500 text-sm">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ $search }}" 
                           placeholder="Search users by name, email, phone..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-900/90 border border-gray-800 rounded-xl text-xs sm:text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                </div>

                <!-- Role Filter -->
                <div class="lg:col-span-2">
                    <select name="role" 
                            onchange="this.form.submit()"
                            class="w-full px-3 py-2.5 bg-gray-900/90 border border-gray-800 rounded-xl text-xs sm:text-sm text-gray-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                        <option value="all" {{ $roleFilter === 'all' ? 'selected' : '' }}>All Roles</option>
                        <option value="admin" {{ $roleFilter === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="teacher" {{ $roleFilter === 'teacher' ? 'selected' : '' }}>Teacher</option>
                        <option value="creator" {{ $roleFilter === 'creator' ? 'selected' : '' }}>Creator</option>
                        <option value="editor" {{ $roleFilter === 'editor' ? 'selected' : '' }}>Editor</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="lg:col-span-2">
                    <select name="status" 
                            onchange="this.form.submit()"
                            class="w-full px-3 py-2.5 bg-gray-900/90 border border-gray-800 rounded-xl text-xs sm:text-sm text-gray-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                        <option value="all" {{ $statusFilter === 'all' ? 'selected' : '' }}>All Statuses</option>
                        <option value="active" {{ $statusFilter === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $statusFilter === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ $statusFilter === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>

                <!-- Sort By -->
                <div class="lg:col-span-2">
                    <select name="sort" 
                            onchange="this.form.submit()"
                            class="w-full px-3 py-2.5 bg-gray-900/90 border border-gray-800 rounded-xl text-xs sm:text-sm text-gray-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                        <option value="latest" {{ $sortBy === 'latest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ $sortBy === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="name_asc" {{ $sortBy === 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                        <option value="name_desc" {{ $sortBy === 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                        <option value="videos_desc" {{ $sortBy === 'videos_desc' ? 'selected' : '' }}>Most Videos</option>
                    </select>
                </div>

                <!-- Per Page & Action -->
                <div class="lg:col-span-2 flex items-center space-x-2">
                    <select name="per_page" 
                            onchange="this.form.submit()"
                            class="w-20 px-2 py-2.5 bg-gray-900/90 border border-gray-800 rounded-xl text-xs sm:text-sm text-gray-200 focus:outline-none focus:border-indigo-500">
                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    </select>

                    <button type="submit" 
                            class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs sm:text-sm font-semibold transition-colors flex items-center justify-center space-x-1.5">
                        <i class="fa-solid fa-filter text-xs"></i>
                        <span>Filter</span>
                    </button>

                    @if(!empty($search) || $roleFilter !== 'all' || $statusFilter !== 'all')
                    <a href="{{ route('users.index') }}" 
                       title="Reset Filters"
                       class="p-2.5 bg-gray-800 hover:bg-gray-700 text-gray-400 hover:text-white rounded-xl text-xs transition-colors">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                    @endif
                </div>

            </div>
        </form>

        <!-- USERS TABLE SECTION -->
        <div class="overflow-x-auto rounded-2xl border border-gray-800/80 bg-gray-950/40">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                
                <!-- Table Header -->
                <thead>
                    <tr class="border-b border-gray-800 bg-[#0c1220] text-gray-400 font-semibold uppercase tracking-wider text-[11px]">
                        <th class="py-4 px-4 sm:px-6">User & Profile</th>
                        <th class="py-4 px-4">Role</th>
                        <th class="py-4 px-4">Status</th>
                        <th class="py-4 px-4">Connected Videos (FK)</th>
                        <th class="py-4 px-4 hidden md:table-cell">Joined Date</th>
                        <th class="py-4 px-4 text-right">Actions</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-gray-800/60">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-900/50 transition-colors group">
                            
                            <!-- User & Profile -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="flex items-center space-x-3.5">
                                    <div class="relative shrink-0">
                                        <img src="{{ $user->avatar }}" 
                                             alt="{{ $user->name }}" 
                                             class="w-10 h-10 rounded-xl object-cover ring-2 ring-gray-800 group-hover:ring-indigo-500/50 transition-all">
                                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-gray-950 {{ $user->status === 'active' ? 'bg-emerald-500' : 'bg-gray-500' }}"></span>
                                    </div>
                                    <div class="truncate max-w-[200px] sm:max-w-xs">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('users.edit', $user->id) }}" class="font-heading font-bold text-white text-sm hover:text-indigo-400 transition-colors truncate">
                                                {{ $user->name }}
                                            </a>
                                            @if($user->id === auth()->id())
                                                <span class="px-1.5 py-0.5 text-[9px] font-bold bg-indigo-500/20 text-indigo-300 rounded">You</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-400 truncate mt-0.5 flex items-center space-x-2">
                                            <span>{{ $user->email }}</span>
                                            @if($user->phone)
                                                <span class="text-gray-600">•</span>
                                                <span class="text-gray-500 hidden sm:inline">{{ $user->phone }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Role Badge -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg capitalize {{ $user->role_badge_class }}">
                                    @if($user->role === 'admin')
                                        <i class="fa-solid fa-shield-halved mr-1 text-[10px]"></i>
                                    @elseif($user->role === 'teacher')
                                        <i class="fa-solid fa-chalkboard-user mr-1 text-[10px]"></i>
                                    @elseif($user->role === 'creator')
                                        <i class="fa-solid fa-video mr-1 text-[10px]"></i>
                                    @else
                                        <i class="fa-solid fa-pen-nib mr-1 text-[10px]"></i>
                                    @endif
                                    {{ $user->role }}
                                </span>
                            </td>

                            <!-- Status Pill with quick toggle -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <form method="POST" action="{{ route('users.toggle-status', $user->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            title="Click to toggle status"
                                            class="px-2.5 py-1 text-xs font-semibold rounded-lg flex items-center space-x-1.5 transition-opacity hover:opacity-80 {{ $user->status_badge_class }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $user->status === 'active' ? 'bg-emerald-400 animate-pulse' : 'bg-rose-400' }}"></span>
                                        <span class="capitalize">{{ $user->status }}</span>
                                    </button>
                                </form>
                            </td>

                            <!-- Connected Videos (Foreign Key) -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                @if(in_array($user->role, ['teacher', 'creator']))
                                    <div class="flex items-center space-x-2" x-data="{ videoPopover: false }">
                                        <a href="{{ route('videos.index', ['user_id' => $user->id]) }}" 
                                           class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-xl bg-purple-500/10 text-purple-300 border border-purple-500/20 hover:bg-purple-500/20 transition-colors font-semibold text-xs">
                                            <i class="fa-solid fa-chalkboard-user text-[11px] text-purple-400"></i>
                                            <span>{{ $user->videos_count }} {{ Str::plural('Video', $user->videos_count) }}</span>
                                        </a>

                                        @if($user->videos_count > 0)
                                        <div class="relative">
                                            <button @click="videoPopover = !videoPopover" 
                                                    @click.outside="videoPopover = false"
                                                    title="Quick preview linked videos"
                                                    class="w-6 h-6 rounded-lg bg-gray-800 text-gray-400 hover:text-white flex items-center justify-center text-[10px]">
                                                <i class="fa-solid fa-chevron-down"></i>
                                            </button>

                                            <!-- Popover Preview -->
                                            <div x-cloak 
                                                 x-show="videoPopover" 
                                                 x-transition 
                                                 class="absolute left-0 mt-2 w-72 rounded-2xl bg-gray-900 border border-gray-800 shadow-2xl p-3 z-30">
                                                <div class="text-[11px] font-bold text-gray-300 pb-2 border-b border-gray-800 flex items-center justify-between">
                                                    <span>Assigned Videos (FK)</span>
                                                    <span class="text-indigo-400">{{ $user->videos_count }} total</span>
                                                </div>
                                                <div class="mt-2 space-y-2 max-h-48 overflow-y-auto">
                                                    @foreach($user->videos as $v)
                                                        <div class="flex items-center space-x-2.5 p-1.5 rounded-lg bg-gray-950/60 border border-gray-800/60">
                                                            <img src="{{ $v->thumbnail_url }}" class="w-8 h-8 rounded object-cover shrink-0">
                                                            <div class="truncate text-[11px]">
                                                                <p class="text-gray-200 truncate font-medium">{{ $v->title }}</p>
                                                                <p class="text-gray-500 text-[10px]">{{ $v->created_at->format('M d, Y') }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="mt-2 pt-2 border-t border-gray-800 text-center">
                                                    <a href="{{ route('videos.index', ['user_id' => $user->id]) }}" class="text-[11px] text-indigo-400 hover:text-indigo-300 font-semibold">
                                                        Manage in Videos Table &rarr;
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-gray-500 italic flex items-center space-x-1">
                                        <i class="fa-solid fa-shield-halved text-[10px] text-indigo-400/60"></i>
                                        <span>System Admin (N/A)</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Joined Date -->
                            <td class="py-4 px-4 text-gray-400 text-xs whitespace-nowrap hidden md:table-cell">
                                <div>{{ $user->created_at->format('M d, Y') }}</div>
                                <div class="text-[10px] text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end space-x-2">
                                    
                                    <!-- Edit User Button -->
                                    <a href="{{ route('users.edit', $user->id) }}" 
                                       title="Edit User Profile & Connected Videos"
                                       class="px-3 py-1.5 rounded-xl bg-purple-600/20 hover:bg-purple-600 text-purple-300 hover:text-white border border-purple-500/30 text-xs font-semibold transition-all flex items-center space-x-1.5">
                                        <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                        <span>Edit</span>
                                    </a>

                                    <!-- Delete Button -->
                                    @if($user->id !== auth()->id())
                                    <div x-data="{ confirmDelete: false }">
                                        <button @click="confirmDelete = true" 
                                                title="Delete User"
                                                class="p-2 rounded-xl bg-rose-500/10 hover:bg-rose-600 text-rose-400 hover:text-white border border-rose-500/20 text-xs transition-all">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>

                                        <!-- Confirm Delete Modal -->
                                        <div x-cloak 
                                             x-show="confirmDelete" 
                                             class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4">
                                            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" @click="confirmDelete = false"></div>
                                            
                                            <div class="relative bg-gray-900 border border-gray-800 rounded-3xl p-6 max-w-sm w-full text-left shadow-2xl z-10 space-y-4">
                                                <div class="w-12 h-12 rounded-2xl bg-rose-500/20 text-rose-400 flex items-center justify-center text-xl">
                                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-heading font-bold text-lg text-white">Delete User Account?</h4>
                                                    <p class="text-xs text-gray-400 mt-1">
                                                        Are you sure you want to remove <strong class="text-white">{{ $user->name }}</strong>? Associated videos will have their author unlinked.
                                                    </p>
                                                </div>
                                                <div class="flex items-center justify-end space-x-3 pt-2">
                                                    <button @click="confirmDelete = false" type="button" class="px-4 py-2 rounded-xl bg-gray-800 text-gray-300 hover:bg-gray-700 text-xs font-semibold">
                                                        Cancel
                                                    </button>
                                                    <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs font-semibold">
                                                            Yes, Delete User
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-16">
                                <div class="max-w-md mx-auto space-y-3">
                                    <div class="w-16 h-16 rounded-3xl bg-gray-900 border border-gray-800 flex items-center justify-center text-2xl text-gray-600 mx-auto">
                                        <i class="fa-solid fa-users-slash"></i>
                                    </div>
                                    <h4 class="font-heading font-bold text-lg text-white">No Users Found</h4>
                                    <p class="text-xs text-gray-400">No user accounts matched your search criteria or role filters.</p>
                                    <a href="{{ route('users.index') }}" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold hover:bg-indigo-500 transition-colors">
                                        Clear All Filters
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION & RESULTS COUNT -->
        <div class="pt-4 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-400">
            <div>
                Showing <span class="font-semibold text-white">{{ $users->firstItem() ?? 0 }}</span> to <span class="font-semibold text-white">{{ $users->lastItem() ?? 0 }}</span> of <span class="font-semibold text-white">{{ $users->total() }}</span> registered users
            </div>
            
            <div>
                {{ $users->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
