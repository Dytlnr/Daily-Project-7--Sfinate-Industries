@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4 text-gray-700 dark:text-white">➕ Tambah Member Poin</h2>

@if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('poin.store') }}" method="POST" class="bg-white dark:bg-gray-800 p-6 rounded shadow w-full max-w-md">
    @csrf
    <div class="mb-4">
        <label for="member_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Member</label>
        <select name="member_id" id="member_id" class="w-full mt-1 rounded dark:bg-gray-700 dark:text-white">
            @foreach($members as $member)
                <option value="{{ $member->id }}">{{ $member->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-4">
        <label for="total_point" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total Poin</label>
        <input type="number" name="total_point" id="total_point" min="0"
            class="w-full mt-1 rounded dark:bg-gray-700 dark:text-white"
            value="0">
    </div>
    <div class="flex gap-2">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('pengaturan.poin.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
    </div>
</form>
@endsection
