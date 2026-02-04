@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                Data Barang
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Daftar seluruh barang yang tersedia di gudang dan toko</p>
        </div>

        <a href="{{ route('barang.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200">
            + Tambah Barang
        </a>
    </div>

    {{-- Form Pencarian --}}
    <div class="mt-4 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
        <form action="{{ route('barang.index') }}" method="GET" class="flex items-center w-full sm:w-auto">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama barang..."
                   class="border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-200 rounded-l-lg px-3 py-2 w-full sm:w-72 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
            <button type="submit"
                    class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 rounded-r-lg hover:opacity-90 transition-all">
                Cari
            </button>
        </form>
    </div>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="p-3 rounded-lg bg-green-100 dark:bg-green-800/40 text-green-700 dark:text-green-300 border border-green-300 dark:border-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Barang --}}
    <div class="overflow-x-auto bg-white dark:bg-gray-900/70 backdrop-blur-sm rounded-2xl shadow border border-gray-100 dark:border-gray-700">
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
            <thead class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-gray-800 dark:to-gray-700/70">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">No</th>
                    <th class="px-4 py-3 text-left font-semibold">Kode</th>
                    <th class="px-4 py-3 text-left font-semibold">Nama</th>
                    <th class="px-4 py-3 text-left font-semibold">Warna</th>
                    <th class="px-4 py-3 text-left font-semibold">Ukuran</th>
                    <th class="px-4 py-3 text-left font-semibold">Jenis Kaos</th>
                    <th class="px-4 py-3 text-left font-semibold">Satuan</th>
                    <th class="px-4 py-3 text-center font-semibold">Stok</th>
                    <th class="px-4 py-3 text-left font-semibold">Lokasi</th>
                    <th class="px-4 py-3 text-right font-semibold">Harga Modal</th>
                    <th class="px-4 py-3 text-right font-semibold">Harga Jual</th>
                    <th class="px-4 py-3 text-right font-semibold">Harga Diskon</th>
                    <th class="px-4 py-3 text-right font-semibold">Harga Satuan</th>
                    <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse ($barangs as $index => $barang)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all">
                        <td class="px-4 py-3">
                            {{ $barangs->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3 font-medium">{{ $barang->kode_barang }}</td>
                        <td class="px-4 py-3">{{ $barang->nama_barang }}</td>
                        <td class="px-4 py-3">{{ $barang->warna ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $barang->ukuran ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $barang->jenis_kaos ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $barang->satuan }}</td>
                        <td class="px-4 py-3 text-center font-semibold">{{ $barang->stok }}</td>
                        <td class="px-4 py-3">{{ $barang->lokasi }}</td>
                        <td class="px-4 py-3 text-right">Rp{{ number_format($barang->harga_modal ?? 0, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right">Rp{{ number_format($barang->harga_jual ?? 0, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right">Rp{{ number_format($barang->harga_diskon ?? 0, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-indigo-600 dark:text-indigo-400">
                            Rp{{ number_format($barang->harga_satuan ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('barang.edit', $barang->id) }}"
                                   class="inline-flex items-center px-3 py-1 text-sm rounded-lg bg-yellow-500/80 text-white hover:bg-yellow-600 transition-all">
                                    Edit
                                </a>
                                <form action="{{ route('barang.destroy', $barang->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini broo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1 text-sm rounded-lg bg-red-500/80 text-white hover:bg-red-600 transition-all">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="text-center py-6 text-gray-500 dark:text-gray-400">
                            Belum ada data barang
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            {{ $barangs->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
@endsection
