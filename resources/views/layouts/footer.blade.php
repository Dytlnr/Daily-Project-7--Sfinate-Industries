<footer class="bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 text-sm text-center py-3 shadow-inner">
    <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row justify-center sm:justify-between items-center gap-2">
        <div>
            © {{ date('Y') }} UMADEV. All rights reserved.
        </div>
        <div class="text-gray-500 dark:text-gray-400 flex items-center gap-2">
            <span>Version</span>
            <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ config('app.version') }}</span>
            <span class="text-xs bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300 px-2 py-0.5 rounded-full">
                Updated
            </span>
        </div>
    </div>
</footer>
