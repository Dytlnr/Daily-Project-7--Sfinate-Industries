@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4 text-gray-700 dark:text-white">📊 Rekap Laporan Penjualan</h2>

<form action="{{ route('laporan.filter') }}" method="POST" class="flex flex-wrap gap-2 mb-4 bg-white dark:bg-gray-800 p-4 rounded shadow">
    @csrf
    <div>
        <label for="tanggal_awal" class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Tanggal Awal</label>
        <input type="text" name="start_date" id="start_date"
            value="{{ request('start_date', now()->format('d/m/Y')) }}"
            class="w-full mt-1 border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            placeholder="07/07/2025">
    </div>
    <div>
        <label for="tanggal_akhir" class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Tanggal Akhir</label>
        <input type="text" name="end_date" id="end_date"
            value="{{ request('end_date', now()->format('d/m/Y')) }}"
            class="w-full mt-1 border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            placeholder="07/07/2025">
    </div>
    <div>
        <label for="nama_pelanggan" class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Nama Pelanggan</label>
        <input type="text" name="nama_pelanggan" id="nama_pelanggan"
            value="{{ request('nama_pelanggan') }}"
            class="w-full mt-1 border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            placeholder="Nama Pelanggan">
    </div>
    <div>
        <label for="status_bayar" class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Status Bayar</label>
        <select name="status_bayar" id="status_bayar"
            class="w-full mt-1 border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <option value="">Semua</option>
            <option value="lunas" {{ request('status_bayar') == 'lunas' ? 'selected' : '' }}>Lunas</option>
            <option value="belum" {{ request('status_bayar') == 'belum' ? 'selected' : '' }}>Belum Lunas</option>
        </select>
    </div>
    <div>
        <label for="metode" class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Metode Bayar</label>
        <select name="metode" id="metode"
            class="w-full mt-1 border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <option value="">Semua</option>
            <option value="cash" {{ request('metode') == 'cash' ? 'selected' : '' }}>Cash</option>
            <option value="transfer" {{ request('metode') == 'transfer' ? 'selected' : '' }}>Transfer</option>
            <option value="qris" {{ request('metode') == 'qris' ? 'selected' : '' }}>QRIS</option>
        </select>
    </div>
    <div class="flex items-end">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Filter</button>
    </div>

    <div class="flex items-end">
        <a href="{{ route('laporan.export.excel') }}"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded flex items-center gap-2 mt-4">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
    </div>
</form>

@if(isset($data))
<div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
    <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
        <thead class="bg-gray-100 dark:bg-gray-700 text-center">
            <tr>
                <th class="px-4 py-2">Tanggal</th>
                <th class="px-4 py-2">Pelanggan</th>
                <th class="px-4 py-2">Barang</th>
                <th class="px-4 py-2">Qty</th>
                <th class="px-4 py-2">Total</th>
                <th class="px-4 py-2">Status Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $order)
                @foreach($order->details as $detail)
                <tr class="border-t border-gray-300 dark:border-gray-600 text-center">
                    <td class="px-4 py-2">{{ date('d-m-Y', strtotime($order->tanggal)) }}</td>
                    <td class="px-4 py-2">{{ $order->nama_pelanggan }}</td>
                    <td class="px-4 py-2">{{ $detail->barang->nama_barang }}</td>
                    <td class="px-4 py-2">{{ $detail->jumlah }}</td>
                    <td class="px-4 py-2">Rp{{ number_format($detail->subtotal) }}</td>
                    <td class="px-4 py-2">
                        <span class="font-semibold {{ $order->status_bayar === 'lunas' ? 'text-green-600' : 'text-red-500' }}">
                            {{ ucfirst($order->status_bayar) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    @if(isset($rekap))
    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded mt-4 text-gray-800 dark:text-gray-200">
        <p>Total Barang Terjual: <strong>{{ $rekap['total_qty'] }}</strong></p>
        <p>Total Omzet: <strong>Rp{{ number_format($rekap['total_omzet']) }}</strong></p>
        <p>Total Diskon: <strong>Rp{{ number_format($rekap['total_diskon']) }}</strong></p>
        <p>Total DP: <strong>Rp{{ number_format($rekap['total_dp']) }}</strong></p>
        <p>Total Piutang: <strong>Rp{{ number_format($rekap['total_piutang']) }}</strong></p>
    </div>
    @endif
    {{-- ini akan tampil selalu --}}
    @if($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-4 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                @if($data->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-400 bg-white dark:bg-gray-800 cursor-not-allowed">
                        Previous
                    </span>
                @else
                    <a href="{{ $data->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        Previous
                    </a>
                @endif

                @if($data->hasMorePages())
                    <a href="{{ $data->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        Next
                    </a>
                @else
                    <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-400 bg-white dark:bg-gray-800 cursor-not-allowed">
                        Next
                    </span>
                @endif
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        Showing
                        <span class="font-medium">{{ $data->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $data->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $data->total() }}</span>
                        results
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        @if($data->onFirstPage())
                            <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-400 cursor-not-allowed">
                                <span class="sr-only">Previous</span>
                                <!-- Heroicon name: solid/chevron-left -->
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $data->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <span class="sr-only">Previous</span>
                                <!-- Heroicon name: solid/chevron-left -->
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif

                        <!-- Pagination Elements -->
                        @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                            @if ($page == $data->currentPage())
                                <span aria-current="page" class="z-10 bg-blue-50 dark:bg-gray-600 border-blue-500 dark:border-gray-500 text-blue-600 dark:text-white relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        @if($data->hasMorePages())
                            <a href="{{ $data->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <span class="sr-only">Next</span>
                                <!-- Heroicon name: solid/chevron-right -->
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-400 cursor-not-allowed">
                                <span class="sr-only">Next</span>
                                <!-- Heroicon name: solid/chevron-right -->
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
        @endif

    @if(isset($data) && count($data))
    @php
        $totalQty = 0;
        $totalOmzet = 0;
        foreach ($data as $order) {
            foreach ($order->details as $detail) {
                $totalQty += $detail->jumlah;
                $totalOmzet += $detail->subtotal;
            }
        }
    @endphp

        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded mt-4 text-gray-800 dark:text-gray-200">
            <p>Total Barang Terjual: <strong>{{ $totalQty }}</strong></p>
            <p>Total Omzet: <strong>Rp{{ number_format($totalOmzet) }}</strong></p>
        </div>
    @endif
</div>
@endif
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#start_date", {
        dateFormat: "d/m/Y",
        allowInput: true,
        defaultDate: "{{ request('start_date', now()->format('d/m/Y')) }}"
    });

    flatpickr("#end_date", {
        dateFormat: "d/m/Y",
        allowInput: true,
        defaultDate: "{{ request('end_date', now()->format('d/m/Y')) }}"
    });
</script>

@endsection
