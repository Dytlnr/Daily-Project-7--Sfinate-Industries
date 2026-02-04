@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                Data Barang Masuk
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Daftar riwayat stok masuk ke gudang</p>
        </div>
        <a href="{{ route('barang_masuk.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200">
            {{-- <img src="{{ asset('icons/plus.png') }}" alt="Tambah" class="w-4 h-4"> --}}
            + Tambah Barang Masuk
        </a>
    </div>

    {{-- Flash Message --}}
    @if (session('success'))
        <div class="p-3 rounded-lg bg-green-100 dark:bg-green-800/40 text-green-700 dark:text-green-300 border border-green-300 dark:border-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white dark:bg-gray-900/70 backdrop-blur-sm rounded-2xl shadow border border-gray-100 dark:border-gray-700">
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
            <thead class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-gray-800 dark:to-gray-700/70">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Kode Masuk</th>
                    <th class="px-4 py-3 text-left font-semibold">Nama Barang</th>
                    <th class="px-4 py-3 text-center font-semibold">Jumlah</th>
                    <th class="px-4 py-3 text-left font-semibold">Supplier</th>
                    <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                    <th class="px-4 py-3 text-left font-semibold">Keterangan</th>
                    <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse ($barangMasuks as $masuk)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all">
                        <td class="px-4 py-3">{{ $masuk->kode_masuk }}</td>
                        <td class="px-4 py-3 font-medium">{{ $masuk->nama_barang }}</td>
                        <td class="px-4 py-3 text-center">{{ $masuk->jumlah }}</td>
                        <td class="px-4 py-3">{{ $masuk->supplier ?? '-' }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($masuk->tanggal_masuk)->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $masuk->keterangan ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('barang_masuk.destroy', $masuk->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus data ini broo?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500 dark:text-gray-400">
                            Belum ada data barang masuk
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
