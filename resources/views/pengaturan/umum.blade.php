@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">⚙️ Pengaturan Umum</h2>

@if(session('success'))
    <div class="mb-4 text-green-600 dark:text-green-400">{{ session('success') }}</div>
@endif

<form action="{{ route('pengaturan.umum.simpan') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 p-6 rounded shadow space-y-4">
    @csrf

    <div>
        <label class="block text-sm text-gray-700 dark:text-gray-200">Nama Perusahaan</label>
        <input type="text" name="nama_perusahaan" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            value="{{ old('nama_perusahaan', $data->nama_perusahaan ?? '') }}" required>
    </div>

    <div>
        <label class="block text-sm text-gray-700 dark:text-gray-200">Alamat 1</label>
        <input type="text" name="alamat_1" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            value="{{ old('alamat_1', $data->alamat_1 ?? '') }}">
    </div>

    <div>
        <label class="block text-sm text-gray-700 dark:text-gray-200">Alamat 2</label>
        <input type="text" name="alamat_2" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            value="{{ old('alamat_2', $data->alamat_2 ?? '') }}">
    </div>

    <div>
        <label class="block text-sm text-gray-700 dark:text-gray-200">Logo</label>
        @if (!empty($data->logo))
            <img src="{{ asset('logo/' . $data->logo) }}" alt="Logo" class="w-24 h-24 mb-2">
        @endif
        <input type="file" name="logo" accept="image/*" class="block dark:text-white">
    </div>

    <div>
        <label class="block text-sm text-gray-700 dark:text-gray-200">Logo Bank</label>
        @if (!empty($data->logo_bank))
            <img src="{{ asset('logo/' . $data->logo_bank) }}" alt="Logo Bank" class="w-24 h-24 mb-2">
        @endif
        <input type="file" name="logo_bank" accept="image/*" class="block dark:text-white">
    </div>

    <div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
    </div>
</form>
@endsection
