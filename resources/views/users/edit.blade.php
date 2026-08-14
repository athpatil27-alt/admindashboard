<x-app-layout>
    <x-slot name="title">Edit User - {{ $user->name }}</x-slot>

    <!-- HEADER & BACK BUTTON -->
    <div class="md:flex md:items-center md:justify-between mb-8 pb-6 border-b border-gray-800">
        <div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('users.index') }}" 
                   class="w-10 h-10 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-white tracking-tight">
                        Edit {{ ucfirst($user->role) }} Profile
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-400 mt-0.5">
                        @if($user->role === 'admin')
                            Manage system administrator account, permissions, and security credentials.
                        @else
                            Update teacher profile credentials and manage assigned video catalog.
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-4 md:mt-0 flex items-center space-x-3">
            <a href="{{ route('users.index') }}" 
               class="px-4 py-2 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs sm:text-sm font-semibold border border-gray-700 transition-colors">
                <i class="fa-solid fa-users mr-1.5"></i> All Users
            </a>
            
            <!-- Only show Add Video shortcut for Teachers / Creators -->
            @if(in_array($user->role, ['teacher', 'creator']))
                <a href="{{ route('videos.add') }}?user_id={{ $user->id }}" 
                   class="px-4 py-2 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white text-xs sm:text-sm font-semibold shadow-lg shadow-indigo-600/20 transition-all flex items-center space-x-1.5">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Add Video for {{ Str::words($user->name, 1, '') }}</span>
                </a>
            @endif
        </div>
    </div>

    @if(in_array($user->role, ['teacher', 'creator']))
    <!-- TEACHER / CREATOR VIEW: TWO-COLUMN GRID (WITH CONNECTED VIDEOS) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- LEFT COLUMN: EDIT FORM (7 Cols) -->
        <div class="lg:col-span-7 space-y-6">
            
            <!-- User Summary Header Card -->
            <div class="bg-[#0e1424] border border-gray-800 rounded-3xl p-6 shadow-xl flex items-center space-x-4">
                <div class="relative shrink-0">
                    <img src="{{ $user->avatar }}" 
                         alt="{{ $user->name }}" 
                         class="w-16 h-16 rounded-2xl object-cover ring-2 ring-indigo-500/50 shadow-md">
                    <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-gray-900 {{ $user->status === 'active' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                </div>
                <div class="flex-1 truncate">
                    <div class="flex items-center space-x-2">
                        <h2 class="font-heading font-bold text-lg text-white truncate">{{ $user->name }}</h2>
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full capitalize {{ $user->role_badge_class }}">
                            {{ $user->role }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $user->email }}</p>
                    <div class="mt-2 flex items-center space-x-4 text-[11px] text-gray-500">
                        <span><i class="fa-regular fa-calendar-check mr-1 text-indigo-400"></i> Joined {{ $user->created_at->format('M d, Y') }}</span>
                        <span><i class="fa-solid fa-chalkboard-user mr-1 text-purple-400"></i> {{ $user->videos->count() }} Linked Videos</span>
                    </div>
                </div>
            </div>

            <!-- Edit Form Card -->
            <div class="bg-[#0b0f19] border border-gray-800 rounded-3xl p-6 sm:p-8 shadow-2xl">
                
                <div class="pb-4 mb-6 border-b border-gray-800 flex items-center justify-between">
                    <div>
                        <h3 class="font-heading font-bold text-base sm:text-lg text-white">Teacher Details</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Modify profile info, role, and credentials</p>
                    </div>
                    <span class="text-xs text-gray-500 font-mono">ID: #{{ $user->id }}</span>
                </div>

                @if($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-rose-950/80 border border-rose-500/40 text-rose-200 text-xs space-y-1">
                        <div class="font-semibold flex items-center space-x-1.5 text-rose-300">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>Please correct the errors below:</span>
                        </div>
                        <ul class="list-disc list-inside pl-2 space-y-0.5 text-rose-300/90">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        
                        <!-- Name -->
                        <div class="space-y-1.5">
                            <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                Full Name <span class="text-rose-400">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required
                                   class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                        </div>

                        <!-- Email -->
                        <div class="space-y-1.5">
                            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                Email Address <span class="text-rose-400">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required
                                   class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                        </div>

                        <!-- Phone -->
                        <div class="space-y-1.5">
                            <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                Phone Number
                            </label>
                            <input type="text" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $user->phone) }}" 
                                   placeholder="+1 (555) 000-0000"
                                   class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                        </div>

                        <!-- Role -->
                        <div class="space-y-1.5">
                            <label for="role" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                System Role <span class="text-rose-400">*</span>
                            </label>
                            <select id="role" 
                                    name="role" 
                                    required
                                    class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                                <option value="teacher" {{ old('role', $user->role) === 'teacher' ? 'selected' : '' }}>Teacher (Video Instructor)</option>
                                <option value="creator" {{ old('role', $user->role) === 'creator' ? 'selected' : '' }}>Creator (Content Author)</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator (Full Access)</option>
                                <option value="editor" {{ old('role', $user->role) === 'editor' ? 'selected' : '' }}>Editor (Reviewer)</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="space-y-1.5 sm:col-span-2">
                            <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                Account Status <span class="text-rose-400">*</span>
                            </label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="flex items-center space-x-2.5 p-3 rounded-xl bg-gray-900 border border-gray-800 cursor-pointer hover:border-gray-700 transition-colors">
                                    <input type="radio" name="status" value="active" {{ old('status', $user->status) === 'active' ? 'checked' : '' }} class="text-emerald-500 focus:ring-emerald-500">
                                    <span class="text-xs font-medium text-gray-200">Active</span>
                                </label>
                                <label class="flex items-center space-x-2.5 p-3 rounded-xl bg-gray-900 border border-gray-800 cursor-pointer hover:border-gray-700 transition-colors">
                                    <input type="radio" name="status" value="inactive" {{ old('status', $user->status) === 'inactive' ? 'checked' : '' }} class="text-rose-500 focus:ring-rose-500">
                                    <span class="text-xs font-medium text-gray-200">Inactive</span>
                                </label>
                                <label class="flex items-center space-x-2.5 p-3 rounded-xl bg-gray-900 border border-gray-800 cursor-pointer hover:border-gray-700 transition-colors">
                                    <input type="radio" name="status" value="suspended" {{ old('status', $user->status) === 'suspended' ? 'checked' : '' }} class="text-amber-500 focus:ring-amber-500">
                                    <span class="text-xs font-medium text-gray-200">Suspended</span>
                                </label>
                            </div>
                        </div>

                        <!-- Bio / Specialization -->
                        <div class="space-y-1.5 sm:col-span-2">
                            <label for="bio" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                Bio & Instructor Specialization
                            </label>
                            <textarea id="bio" 
                                      name="bio" 
                                      rows="3" 
                                      placeholder="e.g. Senior Frontend Architect specializing in Vue 3 and modern design systems..."
                                      class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">{{ old('bio', $user->bio) }}</textarea>
                        </div>

                        <!-- Avatar URL -->
                        <div class="space-y-1.5 sm:col-span-2">
                            <label for="avatar_url" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                Avatar Photo URL
                            </label>
                            <input type="text" 
                                   id="avatar_url" 
                                   name="avatar_url" 
                                   value="{{ old('avatar_url', $user->avatar_url) }}" 
                                   placeholder="https://images.unsplash.com/... or leave blank for auto-generated avatar"
                                   class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                        </div>

                        <!-- Avatar File Upload -->
                        <div class="space-y-1.5 sm:col-span-2">
                            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                Or Upload Custom Avatar File
                            </label>
                            <input type="file" 
                                   name="avatar_image" 
                                   accept="image/*"
                                   class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-gray-800 file:text-indigo-300 hover:file:bg-gray-700 transition-colors">
                        </div>

                    </div>

                    <!-- SECURITY & PASSWORD -->
                    <div class="pt-6 border-t border-gray-800 space-y-4">
                        <div>
                            <h4 class="font-heading font-semibold text-sm text-white">Security & Password</h4>
                            <p class="text-xs text-gray-500">Leave blank if you do not wish to change the password</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-400">
                                    New Password
                                </label>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       placeholder="••••••••"
                                       class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-600 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                            </div>

                            <div class="space-y-1.5">
                                <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-gray-400">
                                    Confirm New Password
                                </label>
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="••••••••"
                                       class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-600 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                            </div>
                        </div>
                    </div>

                    <!-- SUBMIT BUTTONS -->
                    <div class="pt-6 border-t border-gray-800 flex items-center justify-between">
                        <a href="{{ route('users.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs sm:text-sm font-semibold transition-colors">
                            Cancel
                        </a>

                        <button type="submit" 
                                class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white text-xs sm:text-sm font-heading font-semibold shadow-lg shadow-indigo-600/30 transition-all transform hover:-translate-y-0.5 flex items-center space-x-2">
                            <i class="fa-solid fa-floppy-disk text-xs"></i>
                            <span>Save Teacher Changes</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>

        <!-- RIGHT COLUMN: CONNECTED VIDEOS (TEACHER FOREIGN KEY SECTION) -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-[#0b0f19] border border-purple-500/30 rounded-3xl p-6 shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-purple-600/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="flex items-center justify-between pb-4 border-b border-gray-800">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-purple-500/10 text-purple-400 border border-purple-500/20 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <div>
                            <h3 class="font-heading font-bold text-base text-white">Teacher Video Lessons</h3>
                            <p class="text-[11px] text-purple-300/80">Foreign Key: <code class="text-purple-300">videos.user_id = {{ $user->id }}</code></p>
                        </div>
                    </div>

                    <span class="px-2.5 py-1 rounded-full bg-purple-500/20 text-purple-300 text-xs font-bold">
                        {{ $user->videos->count() }} {{ Str::plural('Video', $user->videos->count()) }}
                    </span>
                </div>

                <!-- List of connected videos -->
                <div class="mt-5 space-y-3.5 max-h-[600px] overflow-y-auto pr-1">
                    @forelse($user->videos as $video)
                        <div class="bg-gray-900/90 border border-gray-800 rounded-2xl p-3.5 hover:border-purple-500/40 transition-all group flex items-start space-x-3">
                            
                            <div class="relative w-20 h-14 rounded-xl overflow-hidden bg-gray-950 shrink-0">
                                <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover">
                                <button @click="openVideoModal(@js($video->title), @js($video->embed_url), @js($user->name))" 
                                        class="absolute inset-0 m-auto w-6 h-6 rounded-full bg-indigo-600/90 text-white flex items-center justify-center text-[10px] shadow hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-play ml-0.5"></i>
                                </button>
                            </div>

                            <div class="flex-1 min-w-0">
                                <h4 class="font-heading font-bold text-xs text-white truncate group-hover:text-purple-300 transition-colors">
                                    {{ $video->title }}
                                </h4>
                                <p class="text-[11px] text-gray-400 line-clamp-1 mt-0.5">
                                    {{ $video->description }}
                                </p>
                                <div class="mt-2 flex items-center justify-between text-[10px] text-gray-500">
                                    <span>{{ $video->created_at->format('M d, Y') }}</span>
                                    <a href="{{ route('videos.edit', $video->id) }}" 
                                       class="text-purple-400 hover:text-purple-300 font-semibold flex items-center space-x-1">
                                        <i class="fa-solid fa-pen-to-square text-[9px]"></i>
                                        <span>Edit Video</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    @empty
                        <div class="text-center py-10 px-4 rounded-2xl bg-gray-900/50 border border-gray-800/80 space-y-3">
                            <div class="w-12 h-12 rounded-2xl bg-gray-800 text-gray-500 flex items-center justify-center text-lg mx-auto">
                                <i class="fa-solid fa-film"></i>
                            </div>
                            <div>
                                <h4 class="font-heading font-bold text-sm text-white">No Connected Videos</h4>
                                <p class="text-xs text-gray-400 mt-1">This teacher doesn't have any video lessons assigned yet.</p>
                            </div>
                            <a href="{{ route('videos.add') }}?user_id={{ $user->id }}" 
                               class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl bg-purple-600 text-white text-xs font-semibold hover:bg-purple-500 transition-colors">
                                <i class="fa-solid fa-plus text-xs"></i>
                                <span>Assign First Video</span>
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Action Button: Upload video for this teacher -->
                <div class="mt-6 pt-4 border-t border-gray-800">
                    <a href="{{ route('videos.add') }}?user_id={{ $user->id }}" 
                       class="w-full py-2.5 rounded-xl bg-purple-600/20 hover:bg-purple-600/30 text-purple-300 border border-purple-500/30 text-xs font-semibold transition-all flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-cloud-arrow-up text-xs"></i>
                        <span>Upload Video for {{ Str::words($user->name, 1, '') }}</span>
                    </a>
                </div>

            </div>

        </div>

    </div>

    @else
    <!-- ADMIN / EDITOR VIEW: NO VIDEO SECTION (CLEAN & CENTERED) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- MAIN EDIT FORM (8 Cols) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- User Summary Header Card -->
            <div class="bg-[#0e1424] border border-gray-800 rounded-3xl p-6 shadow-xl flex items-center space-x-4">
                <div class="relative shrink-0">
                    <img src="{{ $user->avatar }}" 
                         alt="{{ $user->name }}" 
                         class="w-16 h-16 rounded-2xl object-cover ring-2 ring-indigo-500/50 shadow-md">
                    <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-gray-900 {{ $user->status === 'active' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                </div>
                <div class="flex-1 truncate">
                    <div class="flex items-center space-x-2">
                        <h2 class="font-heading font-bold text-lg text-white truncate">{{ $user->name }}</h2>
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full capitalize {{ $user->role_badge_class }}">
                            {{ $user->role }}
                        </span>
                        @if($user->id === auth()->id())
                            <span class="px-2 py-0.5 text-[9px] font-bold bg-indigo-500/20 text-indigo-300 rounded">Your Current Session</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $user->email }}</p>
                    <div class="mt-2 flex items-center space-x-4 text-[11px] text-gray-500">
                        <span><i class="fa-regular fa-calendar-check mr-1 text-indigo-400"></i> Registered {{ $user->created_at->format('M d, Y') }}</span>
                        <span><i class="fa-solid fa-shield-halved mr-1 text-indigo-400"></i> Full System Access</span>
                    </div>
                </div>
            </div>

            <!-- Edit Form Card -->
            <div class="bg-[#0b0f19] border border-gray-800 rounded-3xl p-6 sm:p-8 shadow-2xl">
                
                <div class="pb-4 mb-6 border-b border-gray-800 flex items-center justify-between">
                    <div>
                        <h3 class="font-heading font-bold text-base sm:text-lg text-white">Administrator Account Details</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Manage system permissions, personal info, and security credentials</p>
                    </div>
                    <span class="text-xs text-gray-500 font-mono">ID: #{{ $user->id }}</span>
                </div>

                @if($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-rose-950/80 border border-rose-500/40 text-rose-200 text-xs space-y-1">
                        <div class="font-semibold flex items-center space-x-1.5 text-rose-300">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>Please correct the errors below:</span>
                        </div>
                        <ul class="list-disc list-inside pl-2 space-y-0.5 text-rose-300/90">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        
                        <!-- Name -->
                        <div class="space-y-1.5">
                            <label for="admin_name" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                Full Name <span class="text-rose-400">*</span>
                            </label>
                            <input type="text" 
                                   id="admin_name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required
                                   class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                        </div>

                        <!-- Email -->
                        <div class="space-y-1.5">
                            <label for="admin_email" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                Email Address <span class="text-rose-400">*</span>
                            </label>
                            <input type="email" 
                                   id="admin_email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required
                                   class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                        </div>

                        <!-- Phone -->
                        <div class="space-y-1.5">
                            <label for="admin_phone" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                Phone Number
                            </label>
                            <input type="text" 
                                   id="admin_phone" 
                                   name="phone" 
                                   value="{{ old('phone', $user->phone) }}" 
                                   placeholder="+1 (555) 000-0000"
                                   class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                        </div>

                        <!-- Role -->
                        <div class="space-y-1.5">
                            <label for="admin_role" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                System Role <span class="text-rose-400">*</span>
                            </label>
                            <select id="admin_role" 
                                    name="role" 
                                    required
                                    class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator (Full Access)</option>
                                <option value="teacher" {{ old('role', $user->role) === 'teacher' ? 'selected' : '' }}>Teacher (Video Instructor)</option>
                                <option value="creator" {{ old('role', $user->role) === 'creator' ? 'selected' : '' }}>Creator (Content Author)</option>
                                <option value="editor" {{ old('role', $user->role) === 'editor' ? 'selected' : '' }}>Editor (Reviewer)</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="space-y-1.5 sm:col-span-2">
                            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                Account Status <span class="text-rose-400">*</span>
                            </label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="flex items-center space-x-2.5 p-3 rounded-xl bg-gray-900 border border-gray-800 cursor-pointer hover:border-gray-700 transition-colors">
                                    <input type="radio" name="status" value="active" {{ old('status', $user->status) === 'active' ? 'checked' : '' }} class="text-emerald-500 focus:ring-emerald-500">
                                    <span class="text-xs font-medium text-gray-200">Active</span>
                                </label>
                                <label class="flex items-center space-x-2.5 p-3 rounded-xl bg-gray-900 border border-gray-800 cursor-pointer hover:border-gray-700 transition-colors">
                                    <input type="radio" name="status" value="inactive" {{ old('status', $user->status) === 'inactive' ? 'checked' : '' }} class="text-rose-500 focus:ring-rose-500">
                                    <span class="text-xs font-medium text-gray-200">Inactive</span>
                                </label>
                                <label class="flex items-center space-x-2.5 p-3 rounded-xl bg-gray-900 border border-gray-800 cursor-pointer hover:border-gray-700 transition-colors">
                                    <input type="radio" name="status" value="suspended" {{ old('status', $user->status) === 'suspended' ? 'checked' : '' }} class="text-amber-500 focus:ring-amber-500">
                                    <span class="text-xs font-medium text-gray-200">Suspended</span>
                                </label>
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="space-y-1.5 sm:col-span-2">
                            <label for="admin_bio" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                Administrative Bio & Notes
                            </label>
                            <textarea id="admin_bio" 
                                      name="bio" 
                                      rows="3" 
                                      placeholder="Lead System Administrator & Director..."
                                      class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">{{ old('bio', $user->bio) }}</textarea>
                        </div>

                        <!-- Avatar URL -->
                        <div class="space-y-1.5 sm:col-span-2">
                            <label for="admin_avatar_url" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                Avatar Photo URL
                            </label>
                            <input type="text" 
                                   id="admin_avatar_url" 
                                   name="avatar_url" 
                                   value="{{ old('avatar_url', $user->avatar_url) }}" 
                                   placeholder="https://images.unsplash.com/... or leave blank for default avatar"
                                   class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                        </div>

                        <!-- Avatar File Upload -->
                        <div class="space-y-1.5 sm:col-span-2">
                            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                Or Upload Avatar Image File
                            </label>
                            <input type="file" 
                                   name="avatar_image" 
                                   accept="image/*"
                                   class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-gray-800 file:text-indigo-300 hover:file:bg-gray-700 transition-colors">
                        </div>

                    </div>

                    <!-- SECURITY & PASSWORD -->
                    <div class="pt-6 border-t border-gray-800 space-y-4">
                        <div>
                            <h4 class="font-heading font-semibold text-sm text-white">Security & Password</h4>
                            <p class="text-xs text-gray-500">Leave blank if you do not wish to change the administrator password</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label for="admin_password" class="block text-xs font-semibold uppercase tracking-wider text-gray-400">
                                    New Password
                                </label>
                                <input type="password" 
                                       id="admin_password" 
                                       name="password" 
                                       placeholder="••••••••"
                                       class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-600 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                            </div>

                            <div class="space-y-1.5">
                                <label for="admin_password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-gray-400">
                                    Confirm New Password
                                </label>
                                <input type="password" 
                                       id="admin_password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="••••••••"
                                       class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-600 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                            </div>
                        </div>
                    </div>

                    <!-- SUBMIT BUTTONS -->
                    <div class="pt-6 border-t border-gray-800 flex items-center justify-between">
                        <a href="{{ route('users.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs sm:text-sm font-semibold transition-colors">
                            Cancel
                        </a>

                        <button type="submit" 
                                class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-500 hover:to-indigo-400 text-white text-xs sm:text-sm font-heading font-semibold shadow-lg shadow-indigo-600/30 transition-all transform hover:-translate-y-0.5 flex items-center space-x-2">
                            <i class="fa-solid fa-floppy-disk text-xs"></i>
                            <span>Save Admin Changes</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>

        <!-- RIGHT COLUMN: ADMIN PERMISSIONS CARD (NO VIDEO SECTION) -->
        <div class="lg:col-span-4 space-y-6">
            
            <div class="bg-[#0b0f19] border border-indigo-500/30 rounded-3xl p-6 shadow-2xl relative overflow-hidden space-y-4">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="flex items-center space-x-3 pb-3 border-b border-gray-800">
                    <div class="w-9 h-9 rounded-xl bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 flex items-center justify-center text-sm">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <h3 class="font-heading font-bold text-base text-white">Administrator Role</h3>
                        <p class="text-[11px] text-indigo-300/80">Platform Management Privileges</p>
                    </div>
                </div>

                <div class="space-y-3 text-xs text-gray-300">
                    <div class="p-3 rounded-2xl bg-gray-900/80 border border-gray-800 space-y-2">
                        <span class="font-semibold text-white flex items-center space-x-1.5">
                            <i class="fa-solid fa-check text-emerald-400 text-xs"></i>
                            <span>Separation of Duties</span>
                        </span>
                        <p class="text-[11px] text-gray-400 leading-relaxed">
                            Admins manage user accounts, authentication, and database integrity. Course videos are assigned exclusively to <strong>Teacher</strong> accounts.
                        </p>
                    </div>

                    <div class="p-3 rounded-2xl bg-gray-900/80 border border-gray-800 space-y-1.5">
                        <span class="font-semibold text-white flex items-center space-x-1.5">
                            <i class="fa-solid fa-key text-indigo-400 text-xs"></i>
                            <span>Assigned Permissions</span>
                        </span>
                        <ul class="text-[11px] text-gray-400 space-y-1 pl-1">
                            <li>• Full User Management & CRUD</li>
                            <li>• Video Catalog Moderation</li>
                            <li>• Relational Database Control</li>
                        </ul>
                    </div>
                </div>

                <div class="pt-3 border-t border-gray-800 text-center">
                    <a href="{{ route('users.index') }}" class="text-xs text-indigo-400 hover:text-indigo-300 font-semibold inline-flex items-center space-x-1">
                        <span>View All Users Table</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

        </div>

    </div>
    @endif

</x-app-layout>
