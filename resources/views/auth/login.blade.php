<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-950 text-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - Video Management Panel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full flex items-center justify-center p-4 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-indigo-950/40 via-gray-950 to-black">

    <div class="w-full max-w-md">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-600 shadow-xl shadow-indigo-500/20 mb-4">
                <i class="fa-solid fa-user-shield text-white text-2xl"></i>
            </div>
            <h1 class="font-heading font-extrabold text-3xl text-white tracking-tight">Admin Portal</h1>
            <p class="text-sm text-gray-400 mt-1">Sign in to manage videos and teacher assignments</p>
        </div>

        <!-- Login Card -->
        <div class="bg-gray-900/90 backdrop-blur-xl border border-gray-800 rounded-2xl p-8 shadow-2xl">
            
            <!-- Quick Fill Credentials Banner -->
            <div class="mb-6 p-4 rounded-xl bg-indigo-950/50 border border-indigo-500/30 text-indigo-200 text-xs">
                <div class="flex items-center justify-between font-semibold text-indigo-300 mb-1">
                    <span class="flex items-center space-x-1.5">
                        <i class="fa-solid fa-key text-xs"></i>
                        <span>Default Demo Credentials</span>
                    </span>
                    <button type="button" 
                            onclick="fillCredentials()"
                            class="px-2 py-0.5 rounded bg-indigo-600 hover:bg-indigo-500 text-white font-medium transition-colors">
                        Auto-fill
                    </button>
                </div>
                <div class="font-mono text-[11px] text-gray-300 space-y-0.5 mt-2">
                    <p>Email: <span class="text-white font-bold">admin@example.com</span></p>
                    <p>Password: <span class="text-white font-bold">password123</span></p>
                </div>
            </div>

            <!-- Error alert -->
            @if ($errors->any())
                <div class="mb-6 p-3.5 rounded-xl bg-rose-950/60 border border-rose-500/40 text-rose-200 text-xs flex items-center space-x-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-400 text-sm"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email field -->
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', 'admin@example.com') }}" 
                               required 
                               autofocus
                               placeholder="admin@example.com"
                               class="w-full pl-10 pr-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white placeholder-gray-600 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                    </div>
                </div>

                <!-- Password field -->
                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-gray-300 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               value="password123"
                               required 
                               placeholder="••••••••"
                               class="w-full pl-10 pr-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white placeholder-gray-600 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors">
                    </div>
                </div>

                <!-- Remember me checkbox (ensures persistent session on browser close) -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center space-x-2.5 cursor-pointer">
                        <input type="checkbox" 
                               name="remember" 
                               checked
                               class="w-4 h-4 rounded bg-gray-950 border-gray-700 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-gray-900">
                        <span class="text-gray-300">Keep me logged in (Persistent Session)</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-heading font-semibold text-sm shadow-lg shadow-indigo-600/30 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-200 flex items-center justify-center space-x-2">
                    <span>Sign In to Dashboard</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        function fillCredentials() {
            document.getElementById('email').value = 'admin@example.com';
            document.getElementById('password').value = 'password123';
        }
    </script>
</body>
</html>
