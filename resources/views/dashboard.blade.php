<x-app-layout>
    <x-slot name="title">Admin Dashboard - Video & User Management</x-slot>

    <!-- DASHBOARD HEADER & QUICK ACTION BUTTONS -->
    <div class="md:flex md:items-center md:justify-between mb-8 pb-6 border-b border-gray-800">
        <div>
            <div class="flex items-center space-x-2 text-xs text-indigo-400 font-semibold mb-1">
                <span>Enterprise Dashboard</span>
                <span>•</span>
                <span class="text-gray-400">System Overview</span>
            </div>
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-white tracking-tight">Admin Overview Dashboard</h1>
            <p class="text-xs sm:text-sm text-gray-400 mt-0.5">Manage educational videos, instructor profiles, and relational database records.</p>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="mt-4 md:mt-0 flex flex-wrap items-center gap-2.5 sm:gap-3">
            <!-- Add Video Button -->
            <a href="{{ route('videos.add') }}" 
               class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-500 hover:to-indigo-400 text-white font-heading font-semibold text-xs sm:text-sm shadow-lg shadow-indigo-500/25 flex items-center space-x-2 transition-all transform hover:-translate-y-0.5">
                <i class="fa-solid fa-circle-plus text-xs"></i>
                <span>Add Video</span>
            </a>

            <!-- Add User Button -->
            <a href="{{ route('users.create') }}" 
               class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white font-heading font-semibold text-xs sm:text-sm shadow-lg shadow-emerald-500/25 flex items-center space-x-2 transition-all transform hover:-translate-y-0.5">
                <i class="fa-solid fa-user-plus text-xs"></i>
                <span>Add User</span>
            </a>

            <!-- Manage Videos Table -->
            <a href="{{ route('videos.edit-list') }}" 
               class="px-4 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-200 font-heading font-semibold text-xs sm:text-sm border border-gray-700 flex items-center space-x-2 transition-colors">
                <i class="fa-solid fa-table-list text-purple-400"></i>
                <span>Edit Videos</span>
            </a>
        </div>
    </div>

    <!-- METRICS & OVERVIEW CARDS (4 KPIs) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        
        <!-- Total Videos Card -->
        <div class="bg-[#0e1424] border border-gray-800/90 rounded-2xl p-5 shadow-lg relative overflow-hidden group hover:border-gray-700 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Videos</span>
                    <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-white mt-1">{{ $totalVideos }}</h2>
                </div>
                <div class="w-11 h-11 rounded-xl bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-video"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-800/80 text-[11px] text-gray-400 flex items-center justify-between">
                <span class="flex items-center space-x-1">
                    <i class="fa-solid fa-database text-indigo-400"></i>
                    <span>Videos Catalog</span>
                </span>
                <a href="{{ route('videos.edit-list') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold">View Table &rarr;</a>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="bg-[#0e1424] border border-gray-800/90 rounded-2xl p-5 shadow-lg relative overflow-hidden group hover:border-gray-700 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Registered Users</span>
                    <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-white mt-1">{{ $totalUsers }}</h2>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-800/80 text-[11px] text-gray-400 flex items-center justify-between">
                <span class="flex items-center space-x-1">
                    <i class="fa-solid fa-user-check text-emerald-400"></i>
                    <span>User Accounts</span>
                </span>
                <a href="{{ route('users.index') }}" class="text-emerald-400 hover:text-emerald-300 font-semibold">View Table &rarr;</a>
            </div>
        </div>

        <!-- Instructors & Creators Card -->
        <div class="bg-[#0e1424] border border-gray-800/90 rounded-2xl p-5 shadow-lg relative overflow-hidden group hover:border-gray-700 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Course Instructors</span>
                    <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-white mt-1">{{ $teachers->count() }}</h2>
                </div>
                <div class="w-11 h-11 rounded-xl bg-purple-500/10 text-purple-400 border border-purple-500/20 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-800/80 text-[11px] text-gray-400 flex items-center justify-between">
                <span class="flex items-center space-x-1">
                    <span class="w-2 h-2 rounded-full bg-purple-400"></span>
                    <span>Active Teaching Staff</span>
                </span>
                <span class="text-purple-300 font-medium">Multi-author</span>
            </div>
        </div>

        <!-- Relational Foreign Key Status Card -->
        <div class="bg-[#0e1424] border border-gray-800/90 rounded-2xl p-5 shadow-lg relative overflow-hidden group hover:border-gray-700 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Relational Status</span>
                    <h2 class="font-heading font-bold text-lg sm:text-xl text-emerald-400 mt-1 flex items-center space-x-1.5">
                        <i class="fa-solid fa-link text-sm"></i>
                        <span>FK Linked</span>
                    </h2>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-diagram-project"></i>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-gray-800/80 text-[11px] text-gray-400 flex items-center space-x-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span><code>users.id</code> &harr; <code>videos.user_id</code></span>
            </div>
        </div>

    </div>

    <!-- INSTRUCTOR PROFILES & VIDEO COUNTS ROW -->
    <div class="bg-[#0b0f19] border border-gray-800 rounded-3xl p-6 shadow-xl mb-8">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-800">
            <div>
                <h3 class="font-heading font-bold text-base sm:text-lg text-white">Instructors & Assigned Catalog</h3>
                <p class="text-xs text-gray-400">Instructors connected to video course records</p>
            </div>
            <a href="{{ route('users.index') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 flex items-center space-x-1">
                <span>Manage Instructors</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach($teachers as $teacher)
                <div class="p-4 rounded-2xl bg-gray-900/70 border border-gray-800 hover:border-indigo-500/40 transition-all flex items-center justify-between space-x-3 group">
                    <div class="flex items-center space-x-3 truncate">
                        <img src="{{ $teacher->avatar }}" alt="{{ $teacher->name }}" class="w-10 h-10 rounded-xl object-cover ring-1 ring-gray-700 group-hover:ring-indigo-500 transition-all shrink-0">
                        <div class="truncate">
                            <a href="{{ route('users.edit', $teacher->id) }}" class="font-heading font-bold text-xs sm:text-sm text-white hover:text-indigo-400 transition-colors truncate block">
                                {{ $teacher->name }}
                            </a>
                            <span class="text-[10px] text-gray-400 capitalize">{{ $teacher->role }}</span>
                        </div>
                    </div>

                    <a href="{{ route('videos.index', ['user_id' => $teacher->id]) }}" 
                       class="px-2.5 py-1 rounded-lg bg-indigo-500/10 hover:bg-indigo-500 text-indigo-300 hover:text-white text-xs font-bold transition-colors whitespace-nowrap shrink-0">
                        {{ $teacher->videos_count }} {{ Str::plural('Vid', $teacher->videos_count) }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- TWO-COLUMN CONTENT GRID: RECENT VIDEOS & RECENT USERS -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">
        
        <!-- COLUMN 1: RECENT VIDEOS (7 COLS) -->
        <div class="lg:col-span-7 bg-[#0b0f19] border border-gray-800 rounded-3xl p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-800">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-purple-500/10 text-purple-400 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-film"></i>
                    </div>
                    <h3 class="font-heading font-bold text-base text-white">Recent Videos</h3>
                </div>
                <a href="{{ route('videos.edit-list') }}" class="text-xs font-semibold text-purple-400 hover:text-purple-300">
                    All Videos &rarr;
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recentVideos as $vid)
                    <div class="p-3 rounded-2xl bg-gray-900/60 border border-gray-800/80 hover:border-gray-700 transition-colors flex items-center space-x-3 group">
                        
                        <!-- Thumbnail & Play trigger -->
                        <div class="relative w-16 h-11 rounded-lg bg-gray-950 overflow-hidden shrink-0">
                            <img src="{{ $vid->thumbnail_url }}" alt="{{ $vid->title }}" class="w-full h-full object-cover">
                            <button @click="openVideoModal(@js($vid->title), @js($vid->embed_url), @js($vid->teacher_display_name))" 
                                    class="absolute inset-0 m-auto w-5 h-5 rounded-full bg-indigo-600 text-white flex items-center justify-center text-[8px] hover:scale-110 transition-transform">
                                <i class="fa-solid fa-play ml-0.5"></i>
                            </button>
                        </div>

                        <!-- Video info -->
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('videos.edit', $vid->id) }}" class="font-heading font-bold text-xs text-white hover:text-indigo-400 transition-colors truncate block">
                                {{ $vid->title }}
                            </a>
                            <div class="text-[11px] text-gray-400 flex items-center space-x-2 mt-0.5">
                                <span><i class="fa-solid fa-user-tie mr-1 text-indigo-400"></i>{{ $vid->teacher_display_name }}</span>
                                <span>•</span>
                                <span>{{ $vid->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Edit link -->
                        <a href="{{ route('videos.edit', $vid->id) }}" class="p-2 rounded-lg text-gray-400 hover:text-purple-300 hover:bg-purple-500/10 text-xs transition-colors">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                    </div>
                @empty
                    <p class="text-xs text-gray-500 py-4 text-center">No videos in catalog.</p>
                @endforelse
            </div>
        </div>

        <!-- COLUMN 2: RECENT USERS DIRECTORY (5 COLS) -->
        <div class="lg:col-span-5 bg-[#0b0f19] border border-gray-800 rounded-3xl p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-800">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <h3 class="font-heading font-bold text-base text-white">Registered Users</h3>
                </div>
                <a href="{{ route('users.index') }}" class="text-xs font-semibold text-emerald-400 hover:text-emerald-300">
                    Users Table &rarr;
                </a>
            </div>

            <div class="space-y-3">
                @forelse($recentUsers as $usr)
                    <div class="p-3 rounded-2xl bg-gray-900/60 border border-gray-800/80 hover:border-gray-700 transition-colors flex items-center justify-between space-x-3">
                        <div class="flex items-center space-x-3 truncate">
                            <img src="{{ $usr->avatar }}" alt="{{ $usr->name }}" class="w-9 h-9 rounded-xl object-cover ring-1 ring-gray-700 shrink-0">
                            <div class="truncate">
                                <a href="{{ route('users.edit', $usr->id) }}" class="font-heading font-bold text-xs text-white hover:text-emerald-400 transition-colors truncate block">
                                    {{ $usr->name }}
                                </a>
                                <p class="text-[10px] text-gray-400 truncate">{{ $usr->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-0.5 text-[9px] font-bold rounded capitalize {{ $usr->role_badge_class }}">
                                {{ $usr->role }}
                            </span>
                            <a href="{{ route('users.edit', $usr->id) }}" class="p-1.5 text-gray-400 hover:text-white rounded-lg hover:bg-gray-800">
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-500 py-4 text-center">No users registered.</p>
                @endforelse
            </div>
        </div>

    </div>

</x-app-layout>
