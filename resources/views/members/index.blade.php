@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-white">📋 Daftar Member</h2>
        <a href="{{ route('members.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">+ Tambah Member</a>
    </div>

    {{-- @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif --}}

    <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Telepon</th>
                <th class="px-4 py-2">Alamat</th>
                <th class="px-4 py-2 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $index => $member)
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <td class="px-4 py-2">{{ $index + 1 }}</td>
                <td class="px-4 py-2">{{ $member->nama }}</td>
                <td class="px-4 py-2">{{ $member->telepon }}</td>
                <td class="px-4 py-2">{{ $member->alamat }}</td>
                <td class="px-4 py-2 text-right space-x-2">
                    <a href="{{ route('members.edit', $member) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('members.destroy', $member) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus member ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
