@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
    <h2 class="text-xl font-semibold text-gray-700 dark:text-white mb-4">Edit Member</h2>

    <form action="{{ route('members.update', $member) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="nama" class="block text-gray-700 dark:text-gray-300">Nama</label>
            <input type="text" name="nama" id="nama"
                   value="{{ old('nama', $member->nama) }}"
                   class="w-full mt-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                   required>
        </div>

        <div>
            <label for="telepon" class="block text-gray-700 dark:text-gray-300">Telepon</label>
            <input type="text" name="telepon" id="telepon"
                   value="{{ old('telepon', $member->telepon) }}"
                   class="w-full mt-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
        </div>

        <div>
            <label for="alamat" class="block text-gray-700 dark:text-gray-300">Alamat</label>
            <textarea name="alamat" id="alamat"
                      class="w-full mt-1 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                      rows="3">{{ old('alamat', $member->alamat) }}</textarea>
        </div>

        <div class="text-right">
            <a href="{{ route('members.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
