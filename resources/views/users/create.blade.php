<x-app-layout>
    <x-slot name="title">Add New User - User Directory</x-slot>

    <!-- HEADER & BACK BUTTON -->
    <div class="md:flex md:items-center md:justify-between mb-8 pb-6 border-b border-gray-800">
        <div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('users.index') }}" 
                   class="w-10 h-10 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white flex items-center justify-center transition-colors">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-white tracking-tight">Create New User Account</h1>
                    <p class="text-xs sm:text-sm text-gray-400 mt-0.5">Add a new instructor, administrator, or content creator to the system.</p>
                </div>
            </div>
        </div>

        <div class="mt-4 md:mt-0">
            <a href="{{ route('users.index') }}" 
               class="px-4 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs sm:text-sm font-semibold border border-gray-700 transition-colors flex items-center space-x-2">
                <i class="fa-solid fa-users text-emerald-400"></i>
                <span>Back to Users Table</span>
            </a>
        </div>
    </div>

    <!-- CREATE FORM CONTAINER -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-[#0b0f19] border border-gray-800 rounded-3xl p-6 sm:p-10 shadow-2xl space-y-8">
            
            <div class="border-b border-gray-800 pb-5">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <div>
                        <h2 class="font-heading font-bold text-lg text-white">New User Information</h2>
                        <p class="text-xs text-gray-400">All fields marked with an asterisk (<span class="text-rose-400">*</span>) are required.</p>
                    </div>
                </div>
            </div>

            @if($errors->any())
                <div class="p-4 rounded-2xl bg-rose-950/80 border border-rose-500/40 text-rose-200 text-xs space-y-1">
                    <div class="font-semibold flex items-center space-x-1.5 text-rose-300">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>Validation Errors:</span>
                    </div>
                    <ul class="list-disc list-inside pl-2 space-y-0.5 text-rose-300/90">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- SECTION 1: PERSONAL CREDENTIALS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    
                    <!-- Full Name -->
                    <div class="space-y-1.5">
                        <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                            Full Name <span class="text-rose-400">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required
                               placeholder="e.g. Alexa Rivera"
                               class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                    </div>

                    <!-- Email Address -->
                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                            Email Address <span class="text-rose-400">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required
                               placeholder="alexa@example.com"
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
                               value="{{ old('phone') }}" 
                               placeholder="+1 (555) 019-2834"
                               class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                    </div>

                    <!-- Role -->
                    <div class="space-y-1.5">
                        <label for="role" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                            Role Assignment <span class="text-rose-400">*</span>
                        </label>
                        <select id="role" 
                                name="role" 
                                required
                                class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                            <option value="teacher" {{ old('role') === 'teacher' || !old('role') ? 'selected' : '' }}>Teacher (Video Instructor)</option>
                            <option value="creator" {{ old('role') === 'creator' ? 'selected' : '' }}>Creator (Content Author)</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator (Full Access)</option>
                            <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>Editor (Reviewer)</option>
                        </select>
                    </div>

                    <!-- Password -->
                    <div class="space-y-1.5">
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                            Password <span class="text-rose-400">*</span>
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               placeholder="Minimum 6 characters"
                               class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                            Confirm Password <span class="text-rose-400">*</span>
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required
                               placeholder="Re-enter password"
                               class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                    </div>

                    <!-- Status -->
                    <div class="space-y-1.5 sm:col-span-2">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                            Account Status <span class="text-rose-400">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="flex items-center space-x-2.5 p-3 rounded-xl bg-gray-900 border border-gray-800 cursor-pointer hover:border-gray-700 transition-colors">
                                <input type="radio" name="status" value="active" {{ old('status', 'active') === 'active' ? 'checked' : '' }} class="text-emerald-500 focus:ring-emerald-500">
                                <span class="text-xs font-medium text-gray-200">Active</span>
                            </label>
                            <label class="flex items-center space-x-2.5 p-3 rounded-xl bg-gray-900 border border-gray-800 cursor-pointer hover:border-gray-700 transition-colors">
                                <input type="radio" name="status" value="inactive" {{ old('status') === 'inactive' ? 'checked' : '' }} class="text-rose-500 focus:ring-rose-500">
                                <span class="text-xs font-medium text-gray-200">Inactive</span>
                            </label>
                            <label class="flex items-center space-x-2.5 p-3 rounded-xl bg-gray-900 border border-gray-800 cursor-pointer hover:border-gray-700 transition-colors">
                                <input type="radio" name="status" value="suspended" {{ old('status') === 'suspended' ? 'checked' : '' }} class="text-amber-500 focus:ring-amber-500">
                                <span class="text-xs font-medium text-gray-200">Suspended</span>
                            </label>
                        </div>
                    </div>

                    <!-- Bio -->
                    <div class="space-y-1.5 sm:col-span-2">
                        <label for="bio" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                            Bio & Specialization
                        </label>
                        <textarea id="bio" 
                                  name="bio" 
                                  rows="3" 
                                  placeholder="e.g. Senior Frontend Architect specializing in Vue 3 and modern design systems..."
                                  class="w-full px-4 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">{{ old('bio') }}</textarea>
                    </div>

                    <!-- Avatar URL -->
                    <div class="space-y-1.5 sm:col-span-2">
                        <label for="avatar_url" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                            Avatar Image URL
                        </label>
                        <input type="text" 
                               id="avatar_url" 
                               name="avatar_url" 
                               value="{{ old('avatar_url') }}" 
                               placeholder="https://images.unsplash.com/... or leave blank for auto-generated avatar"
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
                               class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-gray-800 file:text-emerald-300 hover:file:bg-gray-700 transition-colors">
                    </div>

                </div>

                <!-- SUBMIT BUTTONS -->
                <div class="pt-6 border-t border-gray-800 flex items-center justify-between">
                    <a href="{{ route('users.index') }}" class="px-5 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs sm:text-sm font-semibold transition-colors">
                        Cancel
                    </a>

                    <button type="submit" 
                            class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white text-xs sm:text-sm font-heading font-semibold shadow-lg shadow-emerald-600/30 transition-all transform hover:-translate-y-0.5 flex items-center space-x-2">
                        <i class="fa-solid fa-user-check text-xs"></i>
                        <span>Create User Account</span>
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
