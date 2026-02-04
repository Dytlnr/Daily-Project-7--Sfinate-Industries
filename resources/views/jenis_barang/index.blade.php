@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <h2 class="text-2xl font-bold mb-6 text-gray-700 dark:text-gray-200">Manajemen Jenis Barang</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">

        {{-- Gramasi (tanpa harga) --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5 transition-colors duration-300">
            <h4 class="text-lg font-semibold mb-4 text-gray-700 dark:text-white">Jenis Gramasi</h4>
            <form method="POST" action="{{ route('jenis-barang.store') }}" class="flex items-end gap-2 mb-3">
                @csrf
                <input type="hidden" name="jenis" value="gramasi">
                <input type="text" name="kode" class="w-1/3 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200" placeholder="Kode" required>
                <input type="text" name="nama" class="w-2/3 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring focus:ring-indigo-200" placeholder="Nama Gramasi" required>
                <button class="px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Tambah</button>
            </form>

            <table class="w-full text-sm text-left border dark:border-gray-700 text-gray-700 dark:text-gray-300">
                @foreach($gramasi as $item)
                    <tr class="border-t border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-2 py-1">{{ $item->kode }}</td>
                        <td class="px-2 py-1">{{ $item->nama }}</td>
                        <td class="text-right space-x-1">
                            <button @click="$dispatch('open-edit-modal', { jenis:'gramasi', id:{{ $item->id }}, kode:'{{ $item->kode }}', nama:'{{ $item->nama }}' })"
                                    class="text-yellow-500 hover:underline">Edit</button>
                            <form method="POST" action="{{ route('jenis-barang.delete') }}" class="inline">
                                @csrf
                                <input type="hidden" name="jenis" value="gramasi">
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button onclick="return confirm('Yakin hapus?')" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        {{-- Tinta --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5 transition-colors duration-300">
            <h4 class="text-lg font-semibold mb-4 text-gray-700 dark:text-white">Jenis Tinta</h4>
            <form method="POST" action="{{ route('jenis-barang.store') }}" class="flex items-end gap-2 mb-3">
                @csrf
                <input type="hidden" name="jenis" value="tinta">
                <input type="text" name="kode" class="w-1/4 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Kode" required>
                <input type="text" name="nama" class="w-1/3 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Nama Tinta" required>
                <input type="number" name="harga" class="w-1/4 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Harga" min="0" required>
                <button class="px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Tambah</button>
            </form>

            <table class="w-full text-sm text-left border dark:border-gray-700 text-gray-700 dark:text-gray-300">
                @foreach($tinta as $item)
                    <tr class="border-t border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-2 py-1">{{ $item->kode }}</td>
                        <td class="px-2 py-1">{{ $item->nama }}</td>
                        <td class="px-2 py-1">Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="text-right space-x-1">
                            <button @click="$dispatch('open-edit-modal', { jenis:'tinta', id:{{ $item->id }}, kode:'{{ $item->kode }}', nama:'{{ $item->nama }}', harga:{{ $item->harga }} })"
                                    class="text-yellow-500 hover:underline">Edit</button>
                            <form method="POST" action="{{ route('jenis-barang.delete') }}" class="inline">
                                @csrf
                                <input type="hidden" name="jenis" value="tinta">
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button onclick="return confirm('Yakin hapus?')" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        {{-- Size Dewasa --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5 transition-colors duration-300">
            <h4 class="text-lg font-semibold mb-4 text-gray-700 dark:text-white">Ukuran Dewasa</h4>
            <form method="POST" action="{{ route('jenis-barang.store') }}" class="flex items-end gap-2 mb-3">
                @csrf
                <input type="hidden" name="jenis" value="size_dewasa">
                <input type="text" name="kode" class="w-1/3 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Kode" required>
                <input type="text" name="nama" class="w-2/3 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Ukuran Dewasa" required>
                <button class="px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Tambah</button>
            </form>

            <table class="w-full text-sm text-left border dark:border-gray-700 text-gray-700 dark:text-gray-300">
                @foreach($sizeDewasa as $item)
                    <tr class="border-t border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-2 py-1">{{ $item->kode }}</td>
                        <td class="px-2 py-1">{{ $item->nama }}</td>
                        <td class="text-right space-x-1">
                            <button @click="$dispatch('open-edit-modal', { jenis:'size_dewasa', id:{{ $item->id }}, kode:'{{ $item->kode }}', nama:'{{ $item->nama }}' })"
                                    class="text-yellow-500 hover:underline">Edit</button>
                            <form method="POST" action="{{ route('jenis-barang.delete') }}" class="inline">
                                @csrf
                                <input type="hidden" name="jenis" value="size_dewasa">
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button onclick="return confirm('Yakin hapus?')" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        {{-- Size Anak --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5 transition-colors duration-300">
            <h4 class="text-lg font-semibold mb-4 text-gray-700 dark:text-white">Ukuran Anak</h4>
            <form method="POST" action="{{ route('jenis-barang.store') }}" class="flex items-end gap-2 mb-3">
                @csrf
                <input type="hidden" name="jenis" value="size_anak">
                <input type="text" name="kode" class="w-1/3 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Kode" required>
                <input type="text" name="nama" class="w-2/3 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Ukuran Anak" required>
                <button class="px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Tambah</button>
            </form>

            <table class="w-full text-sm text-left border dark:border-gray-700 text-gray-700 dark:text-gray-300">
                @foreach($sizeAnak as $item)
                    <tr class="border-t border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-2 py-1">{{ $item->kode }}</td>
                        <td class="px-2 py-1">{{ $item->nama }}</td>
                        <td class="text-right space-x-1">
                            <button @click="$dispatch('open-edit-modal', { jenis:'size_anak', id:{{ $item->id }}, kode:'{{ $item->kode }}', nama:'{{ $item->nama }}' })"
                                    class="text-yellow-500 hover:underline">Edit</button>
                            <form method="POST" action="{{ route('jenis-barang.delete') }}" class="inline">
                                @csrf
                                <input type="hidden" name="jenis" value="size_anak">
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button onclick="return confirm('Yakin hapus?')" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        {{-- Warna --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5 transition-colors duration-300">
            <h4 class="text-lg font-semibold mb-4 text-gray-700 dark:text-white">Jenis Warna</h4>
            <form method="POST" action="{{ route('jenis-barang.store') }}" class="flex items-end gap-2 mb-3">
                @csrf
                <input type="hidden" name="jenis" value="warna">
                <input type="text" name="kode" class="w-1/4 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Kode" required>
                <input type="text" name="nama" class="w-1/3 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Nama Warna" required>
                <input type="number" name="harga" class="w-1/4 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Harga" min="0" required>
                <button class="px-3 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Tambah</button>
            </form>

            <table class="w-full text-sm text-left border dark:border-gray-700 text-gray-700 dark:text-gray-300">
                @foreach($warna as $item)
                    <tr class="border-t border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-2 py-1">{{ $item->kode }}</td>
                        <td class="px-2 py-1">{{ $item->nama }}</td>
                        <td class="px-2 py-1">Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="text-right space-x-1">
                            <button @click="$dispatch('open-edit-modal', { jenis:'warna', id:{{ $item->id }}, kode:'{{ $item->kode }}', nama:'{{ $item->nama }}', harga:{{ $item->harga }} })"
                                    class="text-yellow-500 hover:underline">Edit</button>
                            <form method="POST" action="{{ route('jenis-barang.delete') }}" class="inline">
                                @csrf
                                <input type="hidden" name="jenis" value="warna">
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <button onclick="return confirm('Yakin hapus?')" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

{{-- Modal Edit Global --}}
<div x-data="{ open:false, data:{} }"
     @open-edit-modal.window="data=$event.detail;open=true"
     x-show="open" x-transition x-cloak
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-sm shadow-lg transition">
        <h3 class="text-lg font-semibold mb-3 text-gray-700 dark:text-white">Edit Data</h3>
        <form :action="'{{ route('jenis-barang.update') }}'" method="POST">
            @csrf
            <input type="hidden" name="jenis" x-model="data.jenis">
            <input type="hidden" name="id" x-model="data.id">

            <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Kode</label>
            <input type="text" name="kode" x-model="data.kode" required
                   class="w-full mb-2 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">

            <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Nama</label>
            <input type="text" name="nama" x-model="data.nama" required
                   class="w-full mb-2 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">

            <template x-if="data.jenis === 'tinta' || data.jenis === 'warna'">
                <div>
                    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-200">Harga</label>
                    <input type="number" name="harga" x-model="data.harga" min="0"
                           class="w-full mb-3 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                </div>
            </template>

            <div class="flex justify-end space-x-2">
                <button type="button" @click="open=false" class="px-3 py-1 bg-gray-500 text-white rounded-md hover:bg-gray-600">Batal</button>
                <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
