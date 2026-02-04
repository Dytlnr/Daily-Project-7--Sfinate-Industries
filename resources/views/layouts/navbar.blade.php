<nav class="bg-gradient-to-r from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 shadow-sm border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <div class="text-lg font-semibold bg-gradient-to-r from-gray-700 to-gray-900 dark:from-gray-200 dark:to-white bg-clip-text text-transparent">
                        Selamat datang, <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ Auth::user()->name }}</span>!
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Toggle Dark Mode -->
                <button id="toggleDark" onclick="toggleDarkMode()"
                        class="relative p-2 rounded-xl bg-white dark:bg-gray-700 shadow-sm border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all duration-200 group">
                    <span id="themeIcon" class="text-xl transition-transform duration-200 group-hover:scale-110">🌙</span>
                    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/20 dark:to-purple-900/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200 -z-10"></div>
                </button>

                <!-- Profile Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white transition-colors duration-200 group">
                            <div class="px-3 py-1.5 rounded-lg bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 group-hover:from-indigo-50 group-hover:to-purple-50 dark:group-hover:from-gray-600 transition-all duration-200 border border-gray-200 dark:border-gray-600 group-hover:border-indigo-200 dark:group-hover:border-gray-500">
                                <div class="font-semibold">{{ Auth::user()->name }}</div>
                            </div>
                            <div class="ml-2 transition-transform duration-200 group-hover:translate-y-0.5">
                                <svg class="fill-current h-4 w-4 text-gray-400 group-hover:text-indigo-500 transition-colors duration-200" viewBox="0 0 20 20">
                                    <path d="M5.516 7.548L10 12.032l4.484-4.484L15.9 8.964 10 14.864 4.1 8.964z"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link href="{{ route('profile.edit') }}"
                                         class="flex items-center gap-2 transition-colors duration-200 hover:bg-indigo-50 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profile
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="flex items-center gap-2 transition-colors duration-200 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>