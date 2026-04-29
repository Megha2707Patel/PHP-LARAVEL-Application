<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Recipe Share') }} — @yield('title', 'Home')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,700|inter:400,500,600&display=swap" rel="stylesheet">

    <!-- Tailwind + App CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --brand: #e67e22;
            --brand-dark: #ca6f1e;
        }
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-stone-50 text-stone-800 min-h-screen flex flex-col">

    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-stone-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="font-display text-2xl font-bold text-orange-500">
                    🍽️ Recipe Share
                </a>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('recipes.index') }}" class="text-stone-600 hover:text-orange-500 font-medium transition">
                        Browse Recipes
                    </a>
                    @auth
                        <a href="{{ route('recipes.dashboard') }}" class="text-stone-600 hover:text-orange-500 font-medium transition">
                            My Recipes
                        </a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.users.index') }}" class="text-stone-600 hover:text-orange-500 font-medium transition">
                                Admin
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('recipes.create') }}"
                           class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-600 transition">
                            + New Recipe
                        </a>
                        <!-- User Menu -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                                     class="w-9 h-9 rounded-full object-cover border-2 border-orange-300">
                                <span class="hidden md:block text-sm font-medium">{{ auth()->user()->name }}</span>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                 class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg border border-stone-100 py-1 z-50">
                                <a href="{{ route('profile.show', auth()->user()) }}"
                                   class="block px-4 py-2 text-sm text-stone-700 hover:bg-stone-50">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-stone-600 hover:text-orange-500 font-medium text-sm transition">Login</a>
                        <a href="{{ route('register') }}"
                           class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-600 transition">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             class="fixed top-20 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 transition">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-stone-800 text-stone-400 py-10 mt-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="font-display text-xl text-white mb-2">🍽️ Recipe Share</p>
            <p class="text-sm">Share the joy of cooking, one recipe at a time.</p>
        </div>
    </footer>

</body>
</html>
