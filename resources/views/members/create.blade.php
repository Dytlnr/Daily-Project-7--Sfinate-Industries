@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
    <h2 class="text-xl font-semibold text-gray-700 dark:text-white mb-4">Tambah Member</h2>

    <form action="{{ route('members.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-gray-700 dark:text-gray-300">Nama</label>
            <input type="text" name="nama" class="w-full mt-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" required>
        </div>

        <div>
            <label class="block text-gray-700 dark:text-gray-300">Telepon</label>
            <input type="text" name="telepon" class="w-full mt-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label class="block text-gray-700 dark:text-gray-300">Alamat</label>
            <textarea name="alamat" class="w-full mt-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"></textarea>
        </div>

        <div class="text-right">
            <a href="{{ route('members.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
