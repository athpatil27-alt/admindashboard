<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#090d16] text-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Dashboard - Video & User Management' }}</title>

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS CDN Fallback & Theme Configuration -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        dark: {
                            950: '#070a10',
                            900: '#0b0f19',
                            850: '#111726',
                            800: '#161f33',
                            700: '#232f48',
                        },
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                        }
                    }
                }
            }
        }
    </script>

    <!-- AlpineJS for Interactive State -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #090d16;
            color: #f3f4f6;
        }
        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Outfit', sans-serif;
        }
        [x-cloak] { display: none !important; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }
        ::-webkit-scrollbar-track {
            background: #0b0f19;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #334155;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full antialiased flex bg-[#090d16]" x-data="globalAppState()">

    @auth
    <!-- MOBILE SIDEBAR BACKDROP -->
    <div x-cloak 
         x-show="mobileSidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileSidebarOpen = false"
         class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 lg:hidden"></div>

    <!-- SIDEBAR COMPONENT -->
    <aside :class="{
                'translate-x-0': mobileSidebarOpen,
                '-translate-x-full': !mobileSidebarOpen,
                'lg:w-64': !sidebarCollapsed,
                'lg:w-20': sidebarCollapsed
            }"
           class="fixed inset-y-0 left-0 z-50 flex flex-col bg-[#0b0f19] border-r border-gray-800/80 transition-all duration-300 ease-in-out lg:static lg:translate-x-0 shrink-0 select-none">
        
        <!-- Sidebar Brand Header -->
        <div class="h-16 flex items-center justify-between px-4 border-b border-gray-800/80 bg-[#070a10]">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 overflow-hidden group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/25 shrink-0 group-hover:scale-105 transition-transform duration-200">
                    <i class="fa-solid fa-play text-white text-base"></i>
                </div>
                <div class="flex flex-col whitespace-nowrap" x-show="!sidebarCollapsed" x-transition>
                    <span class="font-heading font-bold text-lg tracking-tight text-white group-hover:text-indigo-400 transition-colors">VideoAdmin</span>
                    <span class="text-[10px] text-gray-400 font-medium tracking-wide flex items-center space-x-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        <span>v2.0 • Pro Panel</span>
                    </span>
                </div>
            </a>

            <!-- Mobile Close Button -->
            <button @click="mobileSidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white p-1">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Sidebar Navigation Menu -->
        <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-6">
            
            <!-- SECTION 1: OVERVIEW -->
            <div>
                <div class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-gray-500" x-show="!sidebarCollapsed">
                    Overview
                </div>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('dashboard') ? 'bg-indigo-600/15 text-indigo-400 border border-indigo-500/30 shadow-sm shadow-indigo-500/10' : 'text-gray-400 hover:text-gray-100 hover:bg-gray-800/60' }}"
                           title="Dashboard Overview">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-400 group-hover:text-white' }} shrink-0">
                                <i class="fa-solid fa-chart-pie text-sm"></i>
                            </div>
                            <span class="truncate" x-show="!sidebarCollapsed">Dashboard</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- SECTION 2: VIDEO MANAGEMENT (Requirement 3, 4, 6) -->
            <div>
                <div class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-gray-500" x-show="!sidebarCollapsed">
                    Video Management
                </div>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('videos.edit-list') }}" 
                           class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('videos.edit-list') || request()->routeIs('videos.edit') || request()->routeIs('videos.index') ? 'bg-purple-600/15 text-purple-400 border border-purple-500/30 shadow-sm shadow-purple-500/10' : 'text-gray-400 hover:text-gray-100 hover:bg-gray-800/60' }}"
                           title="All Videos Table">
                            <div class="flex items-center space-x-3 truncate">
                                <div class="w-7 h-7 rounded-lg flex items-center justify-center {{ request()->routeIs('videos.edit-list') || request()->routeIs('videos.edit') || request()->routeIs('videos.index') ? 'bg-purple-600 text-white' : 'text-gray-400 group-hover:text-white' }} shrink-0">
                                    <i class="fa-solid fa-video text-sm"></i>
                                </div>
                                <span class="truncate" x-show="!sidebarCollapsed">Videos Catalog</span>
                            </div>
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-purple-500/20 text-purple-300" x-show="!sidebarCollapsed">
                                {{ \App\Models\Video::count() }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('videos.add') }}" 
                           class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('videos.add') ? 'bg-indigo-600/15 text-indigo-400 border border-indigo-500/30 shadow-sm' : 'text-gray-400 hover:text-gray-100 hover:bg-gray-800/60' }}"
                           title="Add New Video">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center {{ request()->routeIs('videos.add') ? 'bg-indigo-600 text-white' : 'text-gray-400 group-hover:text-white' }} shrink-0">
                                <i class="fa-solid fa-circle-plus text-sm"></i>
                            </div>
                            <span class="truncate" x-show="!sidebarCollapsed">Add Video</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- SECTION 3: USER MANAGEMENT & RELATIONS (Connected via FK) -->
            <div>
                <div class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-gray-500" x-show="!sidebarCollapsed">
                    User Management
                </div>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('users.index') }}" 
                           class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('users.index') ? 'bg-emerald-600/15 text-emerald-400 border border-emerald-500/30 shadow-sm shadow-emerald-500/10' : 'text-gray-400 hover:text-gray-100 hover:bg-gray-800/60' }}"
                           title="User Display & Table">
                            <div class="flex items-center space-x-3 truncate">
                                <div class="w-7 h-7 rounded-lg flex items-center justify-center {{ request()->routeIs('users.index') ? 'bg-emerald-600 text-white' : 'text-gray-400 group-hover:text-white' }} shrink-0">
                                    <i class="fa-solid fa-users text-sm"></i>
                                </div>
                                <span class="truncate" x-show="!sidebarCollapsed">All Users Table</span>
                            </div>
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-500/20 text-emerald-300" x-show="!sidebarCollapsed">
                                {{ \App\Models\User::count() }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.create') }}" 
                           class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all group {{ request()->routeIs('users.create') ? 'bg-emerald-600/15 text-emerald-400 border border-emerald-500/30 shadow-sm' : 'text-gray-400 hover:text-gray-100 hover:bg-gray-800/60' }}"
                           title="Add New User">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center {{ request()->routeIs('users.create') ? 'bg-emerald-600 text-white' : 'text-gray-400 group-hover:text-white' }} shrink-0">
                                <i class="fa-solid fa-user-plus text-sm"></i>
                            </div>
                            <span class="truncate" x-show="!sidebarCollapsed">Add New User</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- SECTION 4: SYSTEM INFO -->
            <div>
                <div class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-gray-500" x-show="!sidebarCollapsed">
                    System
                </div>
                <div class="p-3 rounded-xl bg-gray-900/80 border border-gray-800/80 text-xs text-gray-400 space-y-2" x-show="!sidebarCollapsed">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-gray-300 font-medium">Relational DB</span>
                        </span>
                        <span class="text-[10px] font-mono bg-gray-800 px-1.5 py-0.5 rounded text-emerald-300">FK Active</span>
                    </div>
                    <p class="text-[11px] text-gray-500 leading-relaxed">
                        Users connected with videos via <code class="text-indigo-400">user_id</code> foreign key.
                    </p>
                </div>
            </div>

        </nav>

        <!-- Sidebar Footer: Logged-in User Profile & Collapse Toggle -->
        <div class="p-3 border-t border-gray-800/80 bg-[#070a10] space-y-2">
            <div class="flex items-center justify-between p-2 rounded-xl bg-gray-900/60 border border-gray-800/60">
                <a href="{{ route('users.edit', auth()->id()) }}" class="flex items-center space-x-2.5 truncate group" title="Edit My Profile">
                    <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=6366f1&color=fff' }}" 
                         alt="{{ auth()->user()->name }}" 
                         class="w-8 h-8 rounded-lg object-cover ring-1 ring-indigo-500/40 shrink-0">
                    <div class="truncate text-left" x-show="!sidebarCollapsed">
                        <p class="text-xs font-semibold text-gray-200 group-hover:text-indigo-400 transition-colors truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-gray-500 truncate capitalize">{{ auth()->user()->role ?? 'Admin' }}</p>
                    </div>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" x-show="!sidebarCollapsed">
                    @csrf
                    <button type="submit" 
                            title="Sign out" 
                            class="p-1.5 text-gray-400 hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                    </button>
                </form>
            </div>

            <!-- Desktop Collapse Toggle Button -->
            <button @click="sidebarCollapsed = !sidebarCollapsed" 
                    class="hidden lg:flex w-full items-center justify-center py-1.5 text-xs text-gray-500 hover:text-gray-300 hover:bg-gray-800/50 rounded-lg transition-colors"
                    title="Toggle Sidebar Width">
                <i class="fa-solid" :class="sidebarCollapsed ? 'fa-angles-right' : 'fa-angles-left'"></i>
                <span class="ml-2 text-[11px]" x-show="!sidebarCollapsed">Collapse Menu</span>
            </button>
        </div>
    </aside>
    @endauth

    <!-- MAIN WRAPPER (Header + Page Content + Footer) -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen overflow-x-hidden">
        
        <!-- HEADER COMPONENT -->
        <header class="h-16 bg-[#0b0f19]/90 backdrop-blur-md border-b border-gray-800/80 sticky top-0 z-40 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            
            <!-- Left: Mobile Toggle & Page Title / Breadcrumbs -->
            <div class="flex items-center space-x-3 sm:space-x-4">
                @auth
                <!-- Mobile Menu Button -->
                <button @click="mobileSidebarOpen = !mobileSidebarOpen" 
                        class="lg:hidden p-2 rounded-xl bg-gray-800 text-gray-400 hover:text-white hover:bg-gray-700 transition-colors">
                    <i class="fa-solid fa-bars text-sm"></i>
                </button>
                @endauth

                <!-- Breadcrumb Title -->
                <div class="flex items-center space-x-2 text-xs sm:text-sm">
                    <span class="text-gray-500 hidden sm:inline"><i class="fa-solid fa-shield-halved mr-1 text-indigo-400"></i> Admin</span>
                    <span class="text-gray-600 hidden sm:inline">/</span>
                    <span class="font-heading font-semibold text-gray-200">
                        @if(request()->routeIs('dashboard'))
                            Dashboard Overview
                        @elseif(request()->routeIs('videos.*'))
                            Video Catalog
                        @elseif(request()->routeIs('users.*'))
                            User Directory
                        @else
                            Control Panel
                        @endif
                    </span>
                </div>
            </div>

            <!-- Right: Search, Quick Actions, Notifications, User Menu -->
            <div class="flex items-center space-x-2 sm:space-x-4">
                
                @auth
                <!-- Quick Create Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            @click.outside="open = false"
                            class="px-3 py-1.5 sm:px-3.5 sm:py-2 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-500 hover:to-indigo-400 text-white font-medium text-xs sm:text-sm shadow-md shadow-indigo-600/20 flex items-center space-x-1.5 transition-all">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span class="hidden sm:inline">New Action</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-cloak 
                         x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-52 rounded-2xl bg-gray-900 border border-gray-800 shadow-2xl py-2 z-50">
                        <div class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-gray-400">Create New</div>
                        <a href="{{ route('videos.add') }}" class="flex items-center space-x-2.5 px-4 py-2 text-xs text-gray-300 hover:text-white hover:bg-gray-800 transition-colors">
                            <i class="fa-solid fa-video text-indigo-400 w-4"></i>
                            <span>Add Video</span>
                        </a>
                        <a href="{{ route('users.create') }}" class="flex items-center space-x-2.5 px-4 py-2 text-xs text-gray-300 hover:text-white hover:bg-gray-800 transition-colors">
                            <i class="fa-solid fa-user-plus text-emerald-400 w-4"></i>
                            <span>Add New User</span>
                        </a>
                        <div class="my-1 border-t border-gray-800"></div>
                        <div class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-gray-400">Manage Tables</div>
                        <a href="{{ route('videos.edit-list') }}" class="flex items-center space-x-2.5 px-4 py-2 text-xs text-gray-300 hover:text-white hover:bg-gray-800 transition-colors">
                            <i class="fa-solid fa-table-list text-purple-400 w-4"></i>
                            <span>Edit Videos Table</span>
                        </a>
                        <a href="{{ route('users.index') }}" class="flex items-center space-x-2.5 px-4 py-2 text-xs text-gray-300 hover:text-white hover:bg-gray-800 transition-colors">
                            <i class="fa-solid fa-users text-emerald-400 w-4"></i>
                            <span>Users Data Table</span>
                        </a>
                    </div>
                </div>

                <!-- Notification Bell Tray -->
                <div class="relative" x-data="{ notifOpen: false }">
                    <button @click="notifOpen = !notifOpen" 
                            @click.outside="notifOpen = false"
                            class="relative p-2 rounded-xl bg-gray-900 border border-gray-800 text-gray-400 hover:text-white hover:border-gray-700 transition-colors">
                        <i class="fa-regular fa-bell text-sm"></i>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-indigo-500 animate-ping"></span>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-indigo-500"></span>
                    </button>

                    <!-- Notifications Dropdown -->
                    <div x-cloak 
                         x-show="notifOpen" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-80 rounded-2xl bg-gray-900 border border-gray-800 shadow-2xl p-4 z-50">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-800">
                            <h4 class="text-xs font-heading font-bold text-white uppercase tracking-wider">System Notifications</h4>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-indigo-500/20 text-indigo-300 font-semibold">2 New</span>
                        </div>
                        <div class="mt-3 space-y-2.5">
                            <div class="p-2.5 rounded-xl bg-gray-800/50 border border-gray-700/40 flex items-start space-x-3">
                                <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0 text-xs">
                                    <i class="fa-solid fa-link"></i>
                                </div>
                                <div class="text-xs">
                                    <p class="font-medium text-gray-200">Foreign Key Relations</p>
                                    <p class="text-[11px] text-gray-400 mt-0.5">Users & Videos connected via database foreign key.</p>
                                </div>
                            </div>
                            <div class="p-2.5 rounded-xl bg-gray-800/50 border border-gray-700/40 flex items-start space-x-3">
                                <div class="w-7 h-7 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center shrink-0 text-xs">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <div class="text-xs">
                                    <p class="font-medium text-gray-200">User Module Active</p>
                                    <p class="text-[11px] text-gray-400 mt-0.5">User display & edit tables are ready for management.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Profile Dropdown -->
                <div class="relative" x-data="{ userMenuOpen: false }">
                    <button @click="userMenuOpen = !userMenuOpen" 
                            @click.outside="userMenuOpen = false"
                            class="flex items-center space-x-2.5 p-1 sm:px-2.5 sm:py-1.5 rounded-xl bg-gray-900 border border-gray-800 hover:border-gray-700 transition-colors">
                        <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=6366f1&color=fff' }}" 
                             alt="{{ auth()->user()->name }}" 
                             class="w-7 h-7 rounded-lg object-cover ring-1 ring-indigo-500/50">
                        <div class="hidden md:flex flex-col text-left">
                            <span class="text-xs font-semibold text-gray-200 leading-tight">{{ auth()->user()->name }}</span>
                            <span class="text-[10px] text-gray-500 capitalize">{{ auth()->user()->role ?? 'Admin' }}</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] text-gray-500 hidden sm:inline"></i>
                    </button>

                    <!-- User Menu Dropdown -->
                    <div x-cloak 
                         x-show="userMenuOpen" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-56 rounded-2xl bg-gray-900 border border-gray-800 shadow-2xl py-2 z-50">
                        
                        <div class="px-4 py-2 border-b border-gray-800">
                            <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[11px] text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            <span class="mt-1 inline-block px-2 py-0.5 text-[10px] font-bold rounded-full bg-indigo-500/20 text-indigo-300 capitalize">
                                {{ auth()->user()->role ?? 'Admin' }}
                            </span>
                        </div>

                        <a href="{{ route('users.edit', auth()->id()) }}" class="flex items-center space-x-2 px-4 py-2 text-xs text-gray-300 hover:text-white hover:bg-gray-800 transition-colors">
                            <i class="fa-solid fa-user-pen text-indigo-400 w-4"></i>
                            <span>Edit My Profile</span>
                        </a>
                        <a href="{{ route('users.index') }}" class="flex items-center space-x-2 px-4 py-2 text-xs text-gray-300 hover:text-white hover:bg-gray-800 transition-colors">
                            <i class="fa-solid fa-users text-emerald-400 w-4"></i>
                            <span>Manage All Users</span>
                        </a>

                        <div class="my-1 border-t border-gray-800"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center space-x-2 px-4 py-2 text-xs text-rose-400 hover:bg-rose-500/10 transition-colors">
                                <i class="fa-solid fa-arrow-right-from-bracket w-4"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-xs font-semibold hover:bg-indigo-500 transition-colors">
                    Sign In
                </a>
                @endauth
            </div>
        </header>

        <!-- TOASTER NOTIFICATION BANNER (Requirement 11 & 12) -->
        <div x-data="{ show: false, message: '', type: 'success' }"
             x-init="
                @if(session('toaster_success'))
                    message = @js(session('toaster_success'));
                    type = 'success';
                    show = true;
                    setTimeout(() => { show = false }, 5000);
                @elseif(session('success'))
                    message = @js(session('success'));
                    type = 'success';
                    show = true;
                    setTimeout(() => { show = false }, 5000);
                @elseif(session('error'))
                    message = @js(session('error'));
                    type = 'error';
                    show = true;
                    setTimeout(() => { show = false }, 6000);
                @endif
             "
             x-cloak
             x-show="show"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-[-20px] scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-[-20px] scale-95"
             class="fixed top-20 right-4 sm:right-6 z-50 max-w-md w-full rounded-2xl p-4 shadow-2xl backdrop-blur-xl flex items-start space-x-3 border"
             :class="type === 'success' ? 'bg-emerald-950/95 border-emerald-500/40 text-emerald-100' : 'bg-rose-950/95 border-rose-500/40 text-rose-100'">
            
            <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                 :class="type === 'success' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400'">
                <i class="fa-solid" :class="type === 'success' ? 'fa-circle-check text-lg' : 'fa-circle-exclamation text-lg'"></i>
            </div>
            
            <div class="flex-1">
                <h4 class="font-heading font-semibold text-sm text-white" x-text="type === 'success' ? 'Action Completed' : 'Operation Alert'"></h4>
                <p class="text-xs opacity-90 mt-0.5 leading-relaxed" x-text="message"></p>
            </div>

            <button @click="show = false" class="opacity-70 hover:opacity-100 p-1 transition-opacity">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- MAIN CONTENT CONTAINER -->
        <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </main>

        <!-- GLOBAL VIDEO POP-UP MODAL (Requirement 8) -->
        <div x-cloak
             x-show="modalOpen"
             @keydown.escape.window="closeModal()"
             class="fixed inset-0 z-50 overflow-y-auto"
             role="dialog" aria-modal="true">
            
            <!-- Backdrop blur -->
            <div x-show="modalOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="closeModal()"
                 class="fixed inset-0 bg-black/85 backdrop-blur-md"></div>

            <!-- Modal Dialog Box -->
            <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
                <div x-show="modalOpen"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                     class="relative w-full max-w-4xl transform overflow-hidden rounded-3xl bg-gray-900 border border-gray-800 p-6 text-left shadow-2xl transition-all">
                    
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-800">
                        <div class="flex items-center space-x-3">
                            <span class="w-3 h-3 rounded-full bg-indigo-500 animate-pulse"></span>
                            <h3 class="text-lg font-heading font-bold text-white truncate" x-text="modalTitle">Video Player</h3>
                        </div>
                        <button @click="closeModal()" class="w-8 h-8 rounded-xl bg-gray-800 text-gray-400 hover:text-white hover:bg-gray-700 flex items-center justify-center transition-colors">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>

                    <!-- Video iFrame Player -->
                    <div class="relative w-full aspect-video bg-black rounded-2xl overflow-hidden shadow-inner border border-gray-800">
                        <template x-if="modalEmbedUrl">
                            <iframe :src="modalEmbedUrl" 
                                    class="w-full h-full border-0" 
                                    allow="autoplay; fullscreen; picture-in-picture" 
                                    allowfullscreen></iframe>
                        </template>
                    </div>

                    <!-- Modal Footer -->
                    <div class="mt-4 flex items-center justify-between text-xs text-gray-400">
                        <span class="flex items-center space-x-2">
                            <i class="fa-solid fa-chalkboard-user text-indigo-400"></i>
                            <span x-text="'Teacher/Creator: ' + modalTeacher"></span>
                        </span>
                        <button @click="closeModal()" class="px-4 py-2 rounded-xl bg-gray-800 text-gray-200 hover:bg-gray-700 hover:text-white font-medium transition-colors">
                            Close Player
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER COMPONENT -->
        <footer class="bg-[#070a10] border-t border-gray-800/80 py-6 text-xs text-gray-500">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                
                <!-- Left Info -->
                <div class="flex items-center space-x-3">
                    <div class="w-6 h-6 rounded-lg bg-indigo-600/20 text-indigo-400 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-cube"></i>
                    </div>
                    <span>&copy; {{ date('Y') }} <strong>VideoAdmin Dashboard</strong> • Enterprise Video & User Management</span>
                </div>

                <!-- Center Status indicator -->
                <div class="flex items-center space-x-2 px-3 py-1 rounded-full bg-gray-900/80 border border-gray-800 text-[11px]">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-gray-300">Foreign Key Connected (Users &harr; Videos)</span>
                </div>

                <!-- Right Quick Links -->
                <div class="flex items-center space-x-4 text-gray-400">
                    <a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Overview</a>
                    <a href="{{ route('videos.edit-list') }}" class="hover:text-white transition-colors">Videos</a>
                    <a href="{{ route('users.index') }}" class="hover:text-white transition-colors">Users</a>
                </div>
            </div>
        </footer>

    </div>

    <script>
        function globalAppState() {
            return {
                sidebarCollapsed: false,
                mobileSidebarOpen: false,
                modalOpen: false,
                modalTitle: '',
                modalEmbedUrl: '',
                modalTeacher: '',
                openVideoModal(title, embedUrl, teacher) {
                    this.modalTitle = title || 'Video Player';
                    this.modalEmbedUrl = embedUrl;
                    this.modalTeacher = teacher || 'Unassigned';
                    this.modalOpen = true;
                },
                closeModal() {
                    this.modalOpen = false;
                    this.modalEmbedUrl = '';
                }
            }
        }
    </script>
</body>
</html>
