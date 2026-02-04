<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ sidebarOpen: false, showToggle: window.innerWidth < 768 }"
      x-init="
        window.addEventListener('resize', () => {
            showToggle = window.innerWidth < 768;
        });
      ">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts & Favicon -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Tailwind & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Dark Mode & Auto-hide Alert -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tema gelap (dark mode)
            const html = document.documentElement;
            const icon = document.getElementById('themeIcon');
            const isDark = localStorage.getItem('theme') === 'dark';

            if (isDark) {
                html.classList.add('dark');
                if (icon) icon.innerText = '☀️';
            } else {
                html.classList.remove('dark');
                if (icon) icon.innerText = '🌙';
            }

            // Auto-hide alert dalam 5 detik
            setTimeout(() => {
                document.querySelectorAll('#alert-success, #alert-error').forEach(el => {
                    el.style.display = 'none';
                });
            }, 5000); // 5000ms = 5 detik
        });

        function toggleDarkMode() {
            const html = document.documentElement;
            const icon = document.getElementById('themeIcon');

            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                if (icon) icon.innerText = '🌙';
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                if (icon) icon.innerText = '☀️';
            }
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">

    {{-- Toggle Button: hanya muncul saat layar < 768px --}}
    <div
        x-show="showToggle"
        x-transition
        class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between bg-white dark:bg-gray-900 p-4 shadow md:hidden"
    >
        <button @click="sidebarOpen = true" class="text-gray-800 dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <div class="text-lg font-semibold text-gray-800 dark:text-white">SFINATE INDUSTRIES</div>
    </div>


    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="flex flex-col flex-1 w-full overflow-hidden">
            @include('layouts.navbar')

            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-x-hidden pt-16 md:pt-0">
                @if(session('success'))
                    <div id="alert-success" class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                        ✅ {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div id="alert-error" class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                        ❌ {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>

            @include('layouts.footer')
        </div>
    </div>
</body>
</html>
