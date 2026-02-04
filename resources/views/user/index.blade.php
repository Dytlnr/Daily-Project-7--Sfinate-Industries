@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Data User</h1>
        <a href="{{ route('user.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Tambah User</a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-700 dark:bg-green-800 dark:text-white">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                <tr>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Role</th>
                    <th class="px-4 py-2 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-t hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2 capitalize">{{ $user->role }}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('user.edit', $user->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">Edit</a>
                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus user ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 dark:text-red-400 hover:underline ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center px-4 py-6 text-gray-500 dark:text-gray-300">Tidak ada data user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
