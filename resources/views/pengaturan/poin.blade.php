@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold text-gray-700 mb-4 dark:text-white">⚙️ Pengaturan Poin Member</h2>

<form action="{{ route('pengaturan.poin.update') }}" method="POST" class="bg-white p-4 rounded shadow dark:bg-gray-800 dark:text-white">
    @csrf
    <div class="mb-4">
        <label for="nominal" class="block text-sm font-medium">Setiap nominal belanja (Rp)</label>
        <input type="number" name="nominal" id="nominal" class="mt-1 w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600"
            value="{{ old('nominal', $setting->nominal ?? 10000) }}">
    </div>
    <div class="mb-4">
        <label for="point" class="block text-sm font-medium">Mendapatkan poin</label>
        <input type="number" name="point" id="point" class="mt-1 w-full rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600"
            value="{{ old('point', $setting->point ?? 1) }}">
    </div>
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
        Simpan Pengaturan
    </button>
</form>
@endsection
