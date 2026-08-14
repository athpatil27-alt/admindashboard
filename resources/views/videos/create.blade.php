<x-app-layout>
    <x-slot name="title">Add New Video - Admin Panel</x-slot>

    <!-- PAGE TITLE HEADER -->
    <div class="max-w-4xl mx-auto mb-8 pb-6 border-b border-gray-800 flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-2 text-xs text-indigo-400 font-semibold mb-1">
                <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
                <span>/</span>
                <span class="text-gray-400">Add Video</span>
            </div>
            <h1 class="font-heading font-extrabold text-3xl text-white tracking-tight">Add New Video</h1>
            <p class="text-sm text-gray-400 mt-1">Fill in details below to publish a video and connect it to an instructor account via foreign key.</p>
        </div>

        <a href="{{ route('videos.edit-list') }}" class="px-4 py-2 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white text-xs font-semibold flex items-center space-x-2 transition-colors">
            <i class="fa-solid fa-list-check"></i>
            <span>View Data Table</span>
        </a>
    </div>

    <!-- FORM CONTAINER -->
    <div class="max-w-4xl mx-auto bg-[#0b0f19] border border-gray-800 rounded-3xl p-6 sm:p-10 shadow-2xl" 
         x-data="{ 
            thumbnailPreview: null,
            videoLink: 'https://player.vimeo.com/video/76979871',
            get iframeSrc() {
                let val = this.videoLink.trim();
                if (!val) return '';
                let matchSrc = val.match(/src=[&quot;']([^&quot;']+) shadow-lg[&quot;']/);
                if (matchSrc) return matchSrc[1];
                let vimeoMatch = val.match(/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/[^\/]*\/videos\/|album\/\d+\/video\/|video\/|)(\d+)/);
                if (vimeoMatch) return 'https://player.vimeo.com/video/' + vimeoMatch[1];
                if (val.startsWith('http')) return val;
                return '';
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
        
        <!-- Validation Error List -->
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-950/70 border border-rose-500/40 text-rose-200 text-xs space-y-1">
                <div class="font-bold flex items-center space-x-2 text-rose-300">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Please fix the following validation errors:</span>
                </div>
                <ul class="list-disc pl-5 space-y-0.5 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('videos.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- 1. Title Field -->
            <div>
                <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                    Video Title <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}" 
                       required 
                       placeholder="e.g. Advanced Vue 3 Composition API & State Patterns"
                       class="w-full px-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-white placeholder-gray-600 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
            </div>

            <!-- 2. Description Field -->
            <div>
                <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                    Description <span class="text-rose-500">*</span>
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4" 
                          required 
                          placeholder="Provide a detailed description of the video content, lesson objectives, and prerequisites..."
                          class="w-full px-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-white placeholder-gray-600 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">{{ old('description') }}</textarea>
            </div>

            <!-- 3. Video Link Field (Vimeo Link / iframe Link) -->
            <div>
                <label for="video_url" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                    Video Link / iFrame Embed Code <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" 
                           id="video_url" 
                           name="video_url" 
                           x-model="videoLink"
                           value="{{ old('video_url', 'https://player.vimeo.com/video/76979871') }}" 
                           required 
                           placeholder="e.g. https://vimeo.com/76979871 or <iframe src='https://player.vimeo.com/video/76979871'></iframe>"
                           class="w-full pl-10 pr-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-white placeholder-gray-600 text-sm font-mono focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-indigo-400">
                        <i class="fa-brands fa-vimeo-v"></i>
                    </div>
                </div>
                <p class="text-[11px] text-gray-400 mt-1.5 flex items-center space-x-1">
                    <i class="fa-solid fa-circle-info text-indigo-400"></i>
                    <span>Accepts direct Vimeo links (e.g. <code>https://vimeo.com/76979871</code>) or full <code>&lt;iframe&gt;</code> embed codes.</span>
                </p>

                <!-- Live Embed Preview box if video link provided -->
                <div x-show="iframeSrc" class="mt-3 p-3 bg-gray-950 rounded-2xl border border-gray-800">
                    <span class="text-[10px] uppercase font-bold text-gray-400 block mb-2">Live Video Embed Preview:</span>
                    <div class="relative aspect-video max-h-60 rounded-xl overflow-hidden bg-black border border-gray-800">
                        <iframe :src="iframeSrc" class="w-full h-full border-0" allow="fullscreen"></iframe>
                    </div>
                </div>
            </div>

            <!-- 4. Select Teacher User (Foreign Key Section: user_id) -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="user_id" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                        Select Teacher / Instructor <span class="text-rose-500">*</span>
                    </label>
                    <span class="text-[11px] text-purple-400 font-medium">
                        <i class="fa-solid fa-chalkboard-user mr-1"></i> Teacher Foreign Key
                    </span>
                </div>
                <div class="relative">
                    <select id="user_id" 
                            name="user_id" 
                            required
                            class="w-full px-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-white text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 appearance-none transition-colors">
                        <option value="" disabled {{ old('user_id', request('user_id')) ? '' : 'selected' }}>-- Select a Teacher (Alexa, Jemini, Anna...) --</option>
                        @foreach($users as $userOption)
                            <option value="{{ $userOption->id }}" {{ (string) old('user_id', request('user_id')) === (string) $userOption->id ? 'selected' : '' }}>
                                {{ $userOption->name }} ({{ ucfirst($userOption->role) }} • {{ $userOption->email }})
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
                <p class="text-[11px] text-gray-400 mt-1">
                    Connects this video to the teaching instructor's account. Only users with the <strong>Teacher</strong> role appear here.
                </p>
            </div>

            <!-- 5. Upload Thumbnail Image Option -->
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">
                    Upload Thumbnail Image
                </label>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- File Upload Selector -->
                    <div>
                        <div class="border-2 border-dashed border-gray-800 hover:border-indigo-500/50 rounded-2xl p-4 text-center bg-gray-900/50 transition-colors cursor-pointer relative"
                             @click="$refs.fileInput.click()">
                            <input type="file" 
                                   x-ref="fileInput"
                                   id="thumbnail_image" 
                                   name="thumbnail_image" 
                                   accept="image/*"
                                   @change="handleFileSelect($event)"
                                   class="hidden">
                            <i class="fa-solid fa-cloud-arrow-up text-indigo-400 text-2xl mb-1"></i>
                            <p class="text-xs text-gray-300 font-medium">Click to select thumbnail image file</p>
                            <p class="text-[10px] text-gray-500 mt-0.5">JPG, PNG, WEBP up to 5MB</p>
                        </div>
                    </div>

                    <!-- Direct Image URL fallback -->
                    <div>
                        <input type="text" 
                               name="thumbnail_url" 
                               value="{{ old('thumbnail_url') }}"
                               placeholder="Or paste direct image URL (https://...)"
                               class="w-full px-4 py-3 bg-gray-900 border border-gray-800 rounded-xl text-white placeholder-gray-600 text-xs focus:outline-none focus:border-indigo-500 transition-colors">
                        <p class="text-[10px] text-gray-500 mt-1">If no image uploaded, default course thumbnail will be assigned.</p>
                    </div>
                </div>

                <!-- Instant Thumbnail Image Preview -->
                <div x-show="thumbnailPreview" class="mt-4 flex items-center space-x-3 bg-gray-950 p-3 rounded-2xl border border-gray-800">
                    <img :src="thumbnailPreview" class="w-20 h-14 object-cover rounded-lg border border-gray-700 shadow-md">
                    <div>
                        <span class="text-xs font-semibold text-white">Selected Thumbnail Preview</span>
                        <p class="text-[10px] text-emerald-400">Ready to save into database</p>
                    </div>
                </div>
            </div>

            <!-- 6. Save Button -->
            <div class="pt-6 border-t border-gray-800 flex items-center justify-end space-x-4">
                <a href="{{ route('videos.edit-list') }}" class="px-5 py-3 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm font-semibold transition-colors">
                    Cancel
                </a>
                
                <button type="submit" 
                        class="px-7 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-heading font-bold text-sm shadow-xl shadow-indigo-600/30 flex items-center space-x-2 transition-all transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-floppy-disk text-sm"></i>
                    <span>Save Video Record</span>
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
