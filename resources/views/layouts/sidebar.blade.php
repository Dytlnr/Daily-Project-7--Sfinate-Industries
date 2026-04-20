<aside
    x-show="sidebarOpen || window.innerWidth >= 768"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full opacity-0"
    x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="-translate-x-full opacity-0"
    x-cloak
    @click.outside="if (window.innerWidth < 768) sidebarOpen = false"
    class="fixed md:relative top-0 left-0 w-64 h-screen md:min-h-screen md:self-stretch bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-800 text-gray-700 dark:text-gray-200 shadow-lg z-40 md:z-auto transform transition-transform md:translate-x-0 border-r border-gray-100 dark:border-gray-700 flex flex-col overflow-y-auto overflow-x-hidden"
    :class="{ '-translate-x-full': !sidebarOpen && window.innerWidth < 768 }"
    style="z-index: 999;"
>
    {{-- Logo --}}
    <div class="p-6 flex flex-col items-center border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-white to-gray-50 dark:from-gray-900 dark:to-gray-800">
        <div class="relative mb-3">
            <div class="absolute -inset-1 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-full blur opacity-30"></div>
            @php
                $logoPath = $global_pengaturan?->logo;
            @endphp
            @if (!empty($logoPath))
                <img src="{{ asset('logo/' . $logoPath) }}" alt="Logo"
                     class="relative w-14 h-14 rounded-full shadow-md border-2 border-white dark:border-gray-800">
            @else
                <div class="relative w-14 h-14 rounded-full shadow-md border-2 border-white dark:border-gray-800 bg-gradient-to-br from-indigo-200 to-purple-200 dark:from-gray-700 dark:to-gray-800"></div>
            @endif
        </div>
        <div class="text-lg font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            SFINATE INDUSTRIES
        </div>
    </div>

    {{-- Menu --}}
    <nav class="mt-6 px-4 pb-6 space-y-1 text-sm flex-1" x-data="{ open: null }">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl transition-all duration-200 hover:bg-white hover:shadow-sm dark:hover:bg-gray-800/70 border border-transparent hover:border-gray-200 dark:hover:border-gray-700 group">
            <div class="p-1.5 rounded-lg bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-gray-700 dark:to-gray-800 group-hover:from-indigo-100 group-hover:to-purple-100 dark:group-hover:from-gray-600">
                <img src="{{ asset('icons/analysis.png') }}" class="w-5 h-5" alt="Dashboard">
            </div>
            <span class="font-medium">Dashboard</span>
        </a>

        @php
            $menus = [
                [
                    'label' => 'Data Barang',
                    'icon' => 'icons/procurement.png',
                    'key' => 'barang',
                    'items' => [
                        ['label' => 'Daftar Barang', 'route' => 'barang.index'],
                        ['label' => 'Jenis Barang', 'route' => 'jenis-barang.index'],
                    ],
                ],
                [
                    'label' => 'Kasir',
                    'icon' => 'icons/cash-machine.png',
                    'key' => 'kasir',
                    'items' => [
                        ['label' => 'Transaksi Kasir', 'route' => 'kasir.index'],
                        ['label' => 'Data Orderan', 'route' => 'kasir.data'],
                    ],
                ],
                [
                    'label' => 'Laporan',
                    'icon' => 'icons/folder.png',
                    'key' => 'laporan',
                    'items' => [
                        ['label' => 'Rekap Penjualan', 'route' => 'laporan.index'],
                        ['label' => 'Piutang', 'route' => 'laporan.piutang'],
                        ['label' => 'Barang Terjual', 'route' => 'laporan.barang'],
                        ['label' => 'Pelanggan', 'route' => 'laporan.pelanggan'],
                    ],
                ],
                [
                    'label' => 'User',
                    'icon' => 'icons/businessman.png',
                    'key' => 'user',
                    'items' => [
                        ['label' => 'Daftar User', 'route' => 'user.index'],
                    ],
                ],
                [
                    'label' => 'Member',
                    'icon' => 'icons/network.png',
                    'key' => 'member',
                    'items' => [
                        ['label' => 'Daftar Member', 'route' => 'members.index'],
                        ['label' => 'Tukar Poin', 'route' => 'member.tukar.form', 'params' => ['id' => 1]],
                        ['label' => 'Riwayat Poin', 'route' => 'member.poin.riwayat', 'params' => ['id' => 1]],
                    ],
                ],
                [
                    'label' => 'Keuangan',
                    'icon' => 'icons/finance.png',
                    'key' => 'keuangan',
                    'items' => [
                        ['label' => 'Laporan', 'route' => 'keuangan.index'],
                    ],
                ],
                [
                    'label' => 'Pengaturan',
                    'icon' => 'icons/process.png',
                    'key' => 'pengaturan',
                    'items' => [
                        ['label' => 'Manajemen Poin', 'route' => 'pengaturan.poin.index'],
                        ['label' => 'Umum', 'route' => 'pengaturan.umum.index'],
                    ],
                ],
            ];
        @endphp

        @foreach ($menus as $menu)
            @php
                $isMenuActive = collect($menu['items'])->pluck('route')->contains(fn($r) => request()->routeIs($r));
            @endphp
            <div x-data="{ isOpen: {{ $isMenuActive ? 'true' : 'false' }} }" x-init="isOpen = {{ $isMenuActive ? 'true' : 'false' }}">
                <button @click="isOpen = !isOpen"
                        class="w-full flex items-center justify-between py-3 px-4 rounded-xl transition-all duration-200 hover:bg-white hover:shadow-sm dark:hover:bg-gray-800/70 border border-transparent hover:border-gray-200 dark:hover:border-gray-700 group font-medium">
                    <div class="flex items-center gap-3">
                        <div class="p-1.5 rounded-lg bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 group-hover:from-indigo-50 group-hover:to-purple-50 dark:group-hover:from-gray-600">
                            <img src="{{ asset($menu['icon']) }}" alt="{{ $menu['label'] }}" class="w-5 h-5">
                        </div>
                        <span>{{ $menu['label'] }}</span>
                    </div>
                    <svg :class="{ 'rotate-180': isOpen, 'text-indigo-500': isOpen }" class="w-4 h-4 transform transition-transform duration-200 text-gray-400 group-hover:text-gray-600 dark:text-gray-500 dark:group-hover:text-gray-300"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="isOpen" x-cloak class="pl-10 mt-1 space-y-1 text-sm">
                    @foreach ($menu['items'] as $item)
                        @php
                            $isActive = request()->routeIs($item['route'] ?? '');
                            $url = isset($item['route']) ? (isset($item['params']) ? route($item['route'], $item['params']) : route($item['route'])) : '#';
                        @endphp
                        <a href="{{ $url }}"
                           class="block py-2 px-3 rounded-lg transition-all duration-200
                           {{ $isActive ? 'bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-600 dark:from-gray-700 dark:to-gray-800 dark:text-white font-medium shadow-sm' : 'hover:bg-gray-50 dark:hover:bg-gray-800/50' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </nav>
</aside>

{{-- Overlay untuk HP --}}
<div
    x-show="sidebarOpen && window.innerWidth < 768"
    x-transition.opacity
    @click="sidebarOpen = false"
    class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"
></div>
