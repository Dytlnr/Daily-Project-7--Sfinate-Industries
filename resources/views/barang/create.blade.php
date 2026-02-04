@extends('layouts.app')

@section('content')
@php
    use App\Enums\SatuanEnum;
    $jenisKaosOptions = ['Lengan Pendek', 'Lengan Panjang', 'Tunik', 'Reglan', 'Kombinasi', 'Lengan 3/4', 'Lengan 7/8'];
@endphp

<div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 shadow rounded-lg p-6 transition-colors duration-300">
    <h3 class="text-2xl font-bold mb-6 text-gray-700 dark:text-gray-300">Tambah Data Barang</h3>

    <form action="{{ route('barang.store') }}" method="POST" class="space-y-5">
        @csrf

        {{-- NAMA BARANG --}}
        <div>
            <label for="nama_barang" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                Nama Barang
            </label>
            <select name="nama_barang" id="nama_barang"
                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200"
                required>
                <option value="" disabled selected>-- Pilih Nama Barang --</option>
                @foreach ($namaBarangs as $item)
                    <option value="{{ $item->nama_barang }}">{{ $item->nama_barang }}</option>
                @endforeach
            </select>
        </div>

        {{-- FIELD DETAIL --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="warna" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Warna</label>
                <input type="text" name="warna" id="warna"
                       class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200"
                       placeholder="Contoh: Hitam">
            </div>

            <div>
                <label for="ukuran" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Ukuran</label>
                <input type="text" name="ukuran" id="ukuran"
                       class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200"
                       placeholder="Contoh: M, L, XL">
            </div>

            <div>
                <label for="lokasi" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Lokasi Barang</label>
                <select name="lokasi" id="lokasi"
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200">
                    <option value="" disabled selected>-- Pilih Lokasi --</option>
                    <option value="Gudang">Gudang</option>
                    <option value="Toko Pancor">Toko Pancor</option>
                    <option value="Toko Produksi">Toko Produksi</option>
                </select>
            </div>

            <div>
                <label for="jenis_kaos" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Jenis Kaos</label>
                <select name="jenis_kaos" id="jenis_kaos"
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200">
                    <option value="" disabled selected>-- Pilih Jenis Kaos --</option>
                    @foreach ($jenisKaosOptions as $jenis)
                        <option value="{{ $jenis }}">{{ $jenis }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- STOK DAN SATUAN --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="stok" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Stok</label>
                <input type="number" name="stok" id="stok"
                       class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200"
                       min="0" required>
                <div id="stok_lama" class="text-xs text-gray-500 dark:text-gray-400 mt-1"></div>
            </div>

            <div>
                <label for="satuan" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Satuan</label>
                <select name="satuan" id="satuan"
                    class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200"
                    required>
                    <option value="" disabled selected>-- Pilih Satuan --</option>
                    @foreach (SatuanEnum::cases() as $satuan)
                        <option value="{{ $satuan->value }}">{{ $satuan->label() }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- HARGA --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
                <label for="harga_modal" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Harga Dasar</label>
                <input type="number" name="harga_modal" id="harga_modal" min="0"
                       class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200">
            </div>
            <div>
                <label for="harga_jual" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Harga Jual</label>
                <input type="number" name="harga_jual" id="harga_jual" min="0"
                       class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200">
            </div>
            <div>
                <label for="harga_diskon" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Harga Diskon</label>
                <input type="number" name="harga_diskon" id="harga_diskon" min="0"
                       class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200">
            </div>
        </div>

        {{-- HARGA SATUAN --}}
        <div>
            <label for="harga_satuan" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Harga Satuan</label>
            <input type="number" name="harga_satuan" id="harga_satuan" min="0"
                   class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200" required>
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('barang.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-white hover:bg-gray-600">
                Kembali
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700">
                Simpan
            </button>
        </div>
    </form>
</div>

{{-- Data untuk JS --}}
<script>
    const dataBarang = @json($dataBarang);
</script>

{{-- Auto Isi Data --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const namaBarangSelect = document.getElementById('nama_barang');

        const fields = {
            warna: document.getElementById('warna'),
            ukuran: document.getElementById('ukuran'),
            stok: document.getElementById('stok'),
            satuan: document.getElementById('satuan'),
            harga_modal: document.getElementById('harga_modal'),
            harga_jual: document.getElementById('harga_jual'),
            harga_diskon: document.getElementById('harga_diskon'),
            harga_satuan: document.getElementById('harga_satuan'),
            jenis_kaos: document.getElementById('jenis_kaos'),
            lokasi: document.getElementById('lokasi'),
        };

        const dataBarang = @json($dataBarang);

        namaBarangSelect.addEventListener('change', function() {
            const namaBarang = this.value;
            const barang = dataBarang.find(b => b.nama_barang === namaBarang);

            if (barang) {
                // isi field dari dataBarang
                for (let key in fields) {
                    if (fields[key]) fields[key].value = barang[key] ?? '';
                }

                // highlight efek hijau sementara
                Object.values(fields).forEach(f => {
                    f.classList.add('bg-green-100', 'dark:bg-green-800');
                    setTimeout(() => f.classList.remove('bg-green-100', 'dark:bg-green-800'), 1500);
                });
            } else {
                // kalau gak nemu datanya, kosongkan
                Object.values(fields).forEach(f => f.value = '');
            }
        });
    });
    </script>

@endsection
