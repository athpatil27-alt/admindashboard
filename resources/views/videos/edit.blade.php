<x-app-layout>
    <x-slot name="title">Edit Video - #{{ $video->id }}</x-slot>

    <!-- PAGE HEADER -->
    <div class="max-w-4xl mx-auto mb-8 pb-6 border-b border-gray-800 flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-2 text-xs text-indigo-400 font-semibold mb-1">
                <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
                <span>/</span>
                <a href="{{ route('videos.edit-list') }}" class="hover:underline">Edit Videos</a>
                <span>/</span>
                <span class="text-gray-400">Edit Record #{{ $video->id }}</span>
            </div>
            <h1 class="font-heading font-extrabold text-3xl text-white tracking-tight">Edit Video Details</h1>
            <p class="text-sm text-gray-400 mt-1">Modify title, embedded video player, instructor assignment, or thumbnail.</p>
        </div>

        <a href="{{ route('videos.edit-list') }}" class="px-4 py-2 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white text-xs font-semibold flex items-center space-x-2 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Back to Data Table</span>
        </a>
    </div>

    <!-- EDIT FORM CONTAINER -->
    <div class="max-w-4xl mx-auto bg-[#0b0f19] border border-gray-800 rounded-3xl p-6 sm:p-10 shadow-2xl space-y-6"
         x-data="{ 
            thumbnailPreview: @js($video->thumbnail_url),
            videoLink: @js($video->video_url),
            get iframeSrc() {
                let val = this.videoLink.trim();
                if (!val) return '';
                let matchSrc = val.match(/src=[&quot;']([^&quot;']+) shadow-lg[&quot;']/);
                if (matchSrc) return matchSrc[1];
                let vimeoMatch = val.match(/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/[^\/]*\/videos\/|album\/\d+\/video\/|video\/|)(\d+)/);
                if (vimeoMatch) return 'https://player.vimeo.com/video/' + vimeoMatch[1];
                if (val.startsWith('http')) return val;
                return @js($video->embed_url);
            },
            handleFileSelect(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (evt) => { this.thumbnailPreview = evt.target.result; };
                    reader.readAsDataURL(file);
                }
            }
         }">

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-950/70 border border-rose-500/40 text-rose-200 text-xs space-y-1">
                <div class="font-bold flex items-center space-x-2 text-rose-300">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Validation Errors:</span>
                </div>
                <ul class="list-disc pl-5 space-y-0.5 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('videos.update', $video->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- 1. Title Field (Pre-filled) -->
            <div>
                <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                    Title <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $video->title) }}" 
                       required 
                       class="w-full px-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-white placeholder-gray-600 text-sm focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors">
            </div>

            <!-- 2. Description Field (Pre-filled) -->
            <div>
                <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                    Description <span class="text-rose-500">*</span>
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4" 
                          required 
                          class="w-full px-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-white placeholder-gray-600 text-sm focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors">{{ old('description', $video->description) }}</textarea>
            </div>

            <!-- 3. EMBEDDED VIDEO PLAYER WHICH CAN BE PLAYED THERE -->
            <div class="bg-gray-950 border border-gray-800 rounded-2xl p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <label class="text-xs font-semibold uppercase tracking-wider text-purple-300 flex items-center space-x-2">
                        <i class="fa-solid fa-play-circle text-purple-400"></i>
                        <span>Embedded Video Preview (Playable)</span>
                    </label>
                    <span class="text-[10px] bg-purple-500/20 text-purple-300 px-2.5 py-0.5 rounded-full font-mono font-bold">Vimeo Embed</span>
                </div>

                <div class="relative w-full aspect-video rounded-xl overflow-hidden bg-black border border-gray-800 shadow-inner">
                    <iframe :src="iframeSrc" 
                            class="w-full h-full border-0" 
                            allow="autoplay; fullscreen; picture-in-picture" 
                            allowfullscreen></iframe>
                </div>
            </div>

            <!-- 4. Video Link / iFrame Field -->
            <div>
                <label for="video_url" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                    Video Link / iFrame Embed Code <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" 
                           id="video_url" 
                           name="video_url" 
                           x-model="videoLink"
                           value="{{ old('video_url', $video->video_url) }}" 
                           required 
                           class="w-full pl-10 pr-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-white placeholder-gray-600 text-sm font-mono focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-purple-400">
                        <i class="fa-brands fa-vimeo-v"></i>
                    </div>
                </div>
                <p class="text-[11px] text-gray-400 mt-1">Update the Vimeo link or iframe snippet above. The video player preview updates automatically.</p>
            </div>

            <!-- 5. Select Teacher / User Account (Foreign Key Relation: user_id) -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="user_id" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                        Assigned Teacher / Instructor <span class="text-rose-500">*</span>
                    </label>
                    <span class="text-[11px] text-purple-400 font-medium">
                        <i class="fa-solid fa-chalkboard-user mr-1"></i> Teacher Foreign Key
                    </span>
                </div>
                <div class="relative">
                    <select id="user_id" 
                            name="user_id" 
                            required
                            class="w-full px-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-purple-500 appearance-none transition-colors">
                        @foreach($users as $userOption)
                            <option value="{{ $userOption->id }}" {{ (string) old('user_id', $video->user_id) === (string) $userOption->id ? 'selected' : '' }}>
                                {{ $userOption->name }} ({{ ucfirst($userOption->role) }} • {{ $userOption->email }})
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>

                @if($video->user)
                <div class="mt-2.5 flex items-center space-x-2 text-xs text-gray-400">
                    <span>Connected User Profile:</span>
                    <a href="{{ route('users.edit', $video->user_id) }}" class="text-indigo-400 hover:text-indigo-300 font-semibold inline-flex items-center space-x-1">
                        <span>{{ $video->user->name }}</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>
                @endif
            </div>

            <!-- 6. Video Thumbnail Image -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                    Video Thumbnail Image
                </label>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <div class="border-2 border-dashed border-gray-800 hover:border-purple-500/50 rounded-2xl p-4 text-center bg-gray-900/50 transition-colors cursor-pointer"
                             @click="$refs.fileInput.click()">
                            <input type="file" 
                                   x-ref="fileInput"
                                   id="thumbnail_image" 
                                   name="thumbnail_image" 
                                   accept="image/*"
                                   @change="handleFileSelect($event)"
                                   class="hidden">
                            <i class="fa-solid fa-image text-purple-400 text-2xl mb-1"></i>
                            <p class="text-xs text-gray-300 font-medium">Click to select new image file</p>
                            <p class="text-[10px] text-gray-500 mt-0.5">Leave unchanged to keep current thumbnail</p>
                        </div>
                    </div>

                    <div>
                        <input type="text" 
                               name="thumbnail_url" 
                               value="{{ old('thumbnail_url') }}"
                               placeholder="Or paste new image URL (https://...)"
                               class="w-full px-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-white placeholder-gray-600 text-xs focus:outline-none focus:border-purple-500 transition-colors">
                    </div>
                </div>

                <!-- Current / Selected Thumbnail Preview -->
                <div class="mt-4 flex items-center space-x-4 bg-gray-950 p-3 rounded-2xl border border-gray-800">
                    <img :src="thumbnailPreview" class="w-24 h-16 object-cover rounded-xl border border-gray-700 shadow-md">
                    <div>
                        <span class="text-xs font-semibold text-white">Active Thumbnail Image Preview</span>
                        <p class="text-[10px] text-gray-400 mt-0.5">Currently assigned to this video record</p>
                    </div>
                </div>
            </div>

            <!-- 7. Save Button -->
            <div class="pt-6 border-t border-gray-800 flex items-center justify-end space-x-4">
                <a href="{{ route('videos.edit-list') }}" class="px-5 py-3 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm font-semibold transition-colors">
                    Cancel
                </a>
                
                <button type="submit" 
                        class="px-7 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-heading font-bold text-sm shadow-xl shadow-purple-600/30 flex items-center space-x-2 transition-all transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-floppy-disk text-sm"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
