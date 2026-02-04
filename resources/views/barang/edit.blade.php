@extends('layouts.app')

@section('content')
@php
    use App\Enums\SatuanEnum;
    $jenisKaosOptions = ['Lengan Pendek', 'Lengan Panjang', 'Tunik', 'Reglan', 'Kombinasi', 'Lengan 3/4', 'Lengan 7/8'];
@endphp

<div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <h3 class="text-2xl font-bold mb-6 text-gray-700 dark:text-gray-300">Edit Data Barang</h3>

    <form action="{{ route('barang.update', $barang->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- nama barang --}}
        <div>
            <label for="nama_barang" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nama Barang</label>
            <input type="text" name="nama_barang" id="nama_barang"
                   class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200"
                   placeholder="Contoh: Kaos Polos"
                   value="{{ old('nama_barang', $barang->nama_barang) }}" required>
        </div>

        {{-- warna & ukuran --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="warna" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Warna</label>
                <input type="text" name="warna" id="warna"
                       class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200"
                       placeholder="Contoh: Hitam"
                       value="{{ old('warna', $barang->warna ?? '') }}">
            </div>

            <div>
                <label for="ukuran" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Ukuran</label>
                <input type="text" name="ukuran" id="ukuran"
                       class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200"
                       placeholder="Contoh: M, L, XL"
                       value="{{ old('ukuran', $barang->ukuran ?? '') }}">
            </div>
            {{-- Lokasi Barang --}}
            <div>
                <label for="lokasi" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Lokasi Barang</label>
                <select name="lokasi" id="lokasi"
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200">
                    <option value="" disabled selected>-- Pilih Lokasi --</option>
                    <option value="Gudang" {{ old('lokasi', $barang->lokasi) == 'Gudang' ? 'selected' : '' }}>Gudang</option>
                    <option value="Toko Pancor" {{ old('lokasi', $barang->lokasi) == 'Toko Pancor' ? 'selected' : '' }}>Toko Pancor</option>
                    <option value="Toko Produksi" {{ old('lokasi', $barang->lokasi) == 'Toko Produksi' ? 'selected' : '' }}>Toko Produksi</option>
                </select>
            </div>

            {{-- jenis kaos --}}
            <div>
                <label for="jenis_kaos" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Jenis Kaos</label>
                <select name="jenis_kaos" id="jenis_kaos"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200">
                    <option value="" disabled>-- Pilih Jenis Kaos --</option>
                    @foreach ($jenisKaosOptions as $jenis)
                        <option value="{{ $jenis }}" {{ old('jenis_kaos', $barang->jenis_kaos) == $jenis ? 'selected' : '' }}>
                            {{ $jenis }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- stok & satuan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="stok" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Stok</label>
                <input type="number" name="stok" id="stok"
                       class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200"
                       min="0" value="{{ old('stok', $barang->stok) }}" required>
            </div>

            <div>
                <label for="satuan" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Satuan</label>
                <select name="satuan" id="satuan"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200" required>
                    <option value="" disabled>-- Pilih Satuan --</option>
                    @foreach (SatuanEnum::cases() as $satuan)
                        <option value="{{ $satuan->value }}" {{ old('satuan', $barang->satuan) == $satuan->value ? 'selected' : '' }}>
                            {{ $satuan->label() }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- harga modal / jual / diskon --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label for="harga_modal" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Harga Dasar</label>
                <input type="number" name="harga_modal" id="harga_modal" min="0"
                       class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200"
                       value="{{ old('harga_modal', $barang->harga_modal ?? 0) }}">
            </div>
            <div>
                <label for="harga_jual" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Harga Jual</label>
                <input type="number" name="harga_jual" id="harga_jual" min="0"
                       class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200"
                       value="{{ old('harga_jual', $barang->harga_jual ?? 0) }}">
            </div>
            <div>
                <label for="harga_diskon" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Harga Diskon</label>
                <input type="number" name="harga_diskon" id="harga_diskon" min="0"
                       class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200"
                       value="{{ old('harga_diskon', $barang->harga_diskon ?? 0) }}">
            </div>
        </div>

        {{-- harga satuan --}}
        <div>
            <label for="harga_satuan" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Harga Satuan</label>
            <input type="number" name="harga_satuan" id="harga_satuan" min="0"
                   class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200"
                   value="{{ old('harga_satuan', $barang->harga_satuan) }}" required>
        </div>

        {{-- actions --}}
        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('barang.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-white hover:bg-gray-600">
                Kembali
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700">
                Update
            </button>
        </div>
    </form>
</div>
@endsection