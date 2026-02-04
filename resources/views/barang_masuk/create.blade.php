@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            Tambah Barang Masuk
        </h1>
        <a href="{{ route('barang_masuk.index') }}"
           class="px-3 py-2 text-sm rounded-lg bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 transition">
            ← Kembali
        </a>
    </div>

    <form action="{{ route('barang_masuk.store') }}" method="POST"
          class="space-y-4 bg-white dark:bg-gray-900/70 rounded-2xl shadow border border-gray-100 dark:border-gray-700 p-6">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Nama Barang</label>
            <input type="text" name="nama_barang" required
                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-700 dark:text-gray-200"
                   placeholder="Contoh: Kaos Polos Hitam">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Jumlah Masuk</label>
                <input type="number" name="jumlah" min="1" required
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Harga Modal</label>
                <input type="number" step="0.01" name="harga_modal"
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Supplier</label>
                <input type="text" name="supplier"
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" required
                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Keterangan</label>
            <textarea name="keterangan" rows="3"
                      class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-gray-700 dark:text-gray-200"
                      placeholder="Opsional..."></textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-5 py-2 rounded-lg shadow hover:scale-105 transition-transform">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
