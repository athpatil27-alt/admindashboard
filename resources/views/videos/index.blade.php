<x-app-layout>
    <x-slot name="title">Manage Videos - Data Table</x-slot>

    <!-- PAGE HEADER -->
    <div class="md:flex md:items-center md:justify-between mb-8 pb-6 border-b border-gray-800">
        <div>
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-400 border border-purple-500/20 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-video"></i>
                </div>
                <div>
                    <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-white tracking-tight">Videos Catalog Data Table</h1>
                    <p class="text-xs sm:text-sm text-gray-400 mt-0.5">Browse, search, watch in pop-up player, and edit educational video records connected to instructors.</p>
                </div>
            </div>
        </div>

        <div class="mt-4 md:mt-0 flex items-center space-x-3">
            <a href="{{ route('users.index') }}" 
               class="px-4 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-200 text-xs sm:text-sm font-semibold border border-gray-700 transition-colors flex items-center space-x-2">
                <i class="fa-solid fa-users text-emerald-400"></i>
                <span>Users Table</span>
            </a>
            
            <a href="{{ route('videos.add') }}" 
               class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white text-xs sm:text-sm font-heading font-semibold shadow-lg shadow-indigo-600/30 flex items-center space-x-2 transition-all transform hover:-translate-y-0.5">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add Video</span>
            </a>
        </div>
    </div>

    <!-- DATA TABLE CONTAINER -->
    <div class="bg-[#0b0f19] border border-gray-800 rounded-3xl p-6 shadow-2xl space-y-6">
        
        <!-- TOOLBAR: SEARCH & FILTERS -->
        <form method="GET" action="{{ route('videos.edit-list') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 sm:gap-4">
            
            <!-- Search Bar -->
            <div class="lg:col-span-5 relative">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search by title, description, or instructor..."
                       class="w-full pl-10 pr-10 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-white text-xs sm:text-sm placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                @if(request('search'))
                    <a href="{{ route('videos.edit-list', ['per_page' => request('per_page')]) }}" 
                       class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-white text-xs">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>

            <!-- Instructor Filter (Foreign Key: user_id) -->
            <div class="lg:col-span-3">
                <select name="user_id" 
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-xs sm:text-sm text-gray-200 focus:outline-none focus:border-indigo-500 transition-colors">
                    <option value="all" {{ request('user_id') === 'all' || !request('user_id') ? 'selected' : '' }}>All Instructors</option>
                    @foreach($availableTeachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ (string) request('user_id') === (string) $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Show Per Page Selector -->
            <div class="lg:col-span-2">
                <select name="per_page" 
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-xs sm:text-sm text-gray-200 focus:outline-none focus:border-indigo-500 transition-colors">
                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5 per page</option>
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 per page</option>
                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20 per page</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 per page</option>
                </select>
            </div>

            <!-- Filter Buttons -->
            <div class="lg:col-span-2 flex items-center space-x-2">
                <button type="submit" class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs sm:text-sm font-semibold transition-colors flex items-center justify-center space-x-1">
                    <i class="fa-solid fa-filter text-xs"></i>
                    <span>Apply</span>
                </button>

                @if(request('search') || (request('user_id') && request('user_id') !== 'all'))
                    <a href="{{ route('videos.edit-list') }}" 
                       title="Reset Filters"
                       class="p-2.5 bg-gray-800 hover:bg-gray-700 text-gray-400 hover:text-white rounded-xl text-xs transition-colors">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>

        </form>

        <!-- TABLE SECTION -->
        <div class="overflow-x-auto rounded-2xl border border-gray-800/80 bg-gray-950/40">
            <table class="w-full text-left text-xs sm:text-sm border-collapse">
                <thead>
                    <tr class="border-b border-gray-800 bg-[#0c1220] text-gray-400 font-semibold uppercase tracking-wider text-[11px]">
                        <th class="py-4 px-4 sm:px-6">Thumbnail & Video</th>
                        <th class="py-4 px-4">Embed Link</th>
                        <th class="py-4 px-4">Connected Instructor (FK)</th>
                        <th class="py-4 px-4 hidden md:table-cell">Created Date</th>
                        <th class="py-4 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/60">
                    @forelse($videos as $video)
                        <tr class="hover:bg-gray-900/50 transition-colors group">
                            
                            <!-- Thumbnail & Title -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="flex items-center space-x-3.5">
                                    <div class="relative w-20 h-13 rounded-xl bg-gray-950 border border-gray-800 overflow-hidden shrink-0 group-hover:border-indigo-500/50 transition-colors">
                                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover">
                                        <button type="button" 
                                                @click="openVideoModal(@js($video->title), @js($video->embed_url), @js($video->teacher_display_name))"
                                                class="absolute inset-0 m-auto w-6 h-6 rounded-full bg-indigo-600/90 text-white flex items-center justify-center text-[10px] shadow hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-play ml-0.5"></i>
                                        </button>
                                    </div>
                                    <div class="truncate max-w-[200px] sm:max-w-xs">
                                        <a href="{{ route('videos.edit', $video->id) }}" class="font-heading font-bold text-white text-sm hover:text-indigo-400 transition-colors truncate block">
                                            {{ $video->title }}
                                        </a>
                                        <p class="text-xs text-gray-400 truncate mt-0.5">{{ $video->description }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Embed Link + Play button -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <span class="px-2.5 py-1 rounded-lg bg-gray-900 border border-gray-800 text-[11px] font-mono text-indigo-300 max-w-[130px] truncate" 
                                          title="{{ $video->video_url }}">
                                        {{ Str::limit($video->video_url, 20) }}
                                    </span>

                                    <button type="button" 
                                            @click="openVideoModal(@js($video->title), @js($video->embed_url), @js($video->teacher_display_name))"
                                            class="px-2.5 py-1 rounded-lg bg-indigo-600/20 hover:bg-indigo-600 text-indigo-300 hover:text-white border border-indigo-500/30 text-xs font-semibold transition-all flex items-center space-x-1 shrink-0">
                                        <i class="fa-solid fa-circle-play text-[11px]"></i>
                                        <span>Play</span>
                                    </button>
                                </div>
                            </td>

                            <!-- Connected Instructor (Foreign Key) -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                @if($video->user)
                                    <a href="{{ route('users.edit', $video->user->id) }}" class="flex items-center space-x-2 group/user" title="View User Profile">
                                        <img src="{{ $video->user->avatar }}" class="w-7 h-7 rounded-lg object-cover ring-1 ring-purple-500/40 shrink-0">
                                        <div>
                                            <span class="font-semibold text-gray-200 group-hover/user:text-purple-300 transition-colors text-xs block">
                                                {{ $video->user->name }}
                                            </span>
                                            <span class="text-[10px] text-gray-500 capitalize">{{ $video->user->role }}</span>
                                        </div>
                                    </a>
                                @else
                                    <span class="px-2.5 py-1 rounded-lg bg-gray-800 text-gray-400 text-xs border border-gray-700">
                                        {{ $video->teacher_name ?? 'Unassigned' }}
                                    </span>
                                @endif
                            </td>

                            <!-- Created Date -->
                            <td class="py-4 px-4 text-gray-400 text-xs whitespace-nowrap hidden md:table-cell">
                                <div>{{ $video->created_at ? $video->created_at->format('M d, Y') : 'N/A' }}</div>
                                <div class="text-[10px] text-gray-500">{{ $video->created_at ? $video->created_at->diffForHumans() : '' }}</div>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('videos.edit', $video->id) }}" 
                                       class="px-3 py-1.5 rounded-xl bg-purple-600/20 hover:bg-purple-600 text-purple-300 hover:text-white border border-purple-500/30 text-xs font-semibold transition-all flex items-center space-x-1.5">
                                        <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                        <span>Edit</span>
                                    </a>

                                    <form method="POST" action="{{ route('videos.destroy', $video->id) }}" onsubmit="return confirm('Are you sure you want to delete this video record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl bg-rose-500/10 hover:bg-rose-600 text-rose-400 hover:text-white border border-rose-500/20 text-xs transition-all" title="Delete record">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center text-gray-500">
                                <div class="max-w-md mx-auto space-y-3">
                                    <div class="w-14 h-14 rounded-2xl bg-gray-900 border border-gray-800 flex items-center justify-center text-2xl text-gray-600 mx-auto">
                                        <i class="fa-solid fa-film"></i>
                                    </div>
                                    <h4 class="font-heading font-bold text-base text-white">No Videos Found</h4>
                                    <p class="text-xs text-gray-400">No video records match your search or selected instructor.</p>
                                    <a href="{{ route('videos.edit-list') }}" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold hover:bg-indigo-500 transition-colors">
                                        Clear Filter
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="pt-4 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-400">
            <div>
                Showing <span class="font-bold text-white">{{ $videos->firstItem() ?? 0 }}</span> to <span class="font-bold text-white">{{ $videos->lastItem() ?? 0 }}</span> of <span class="font-bold text-white">{{ $videos->total() }}</span> records
            </div>

            <div>
                {{ $videos->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
