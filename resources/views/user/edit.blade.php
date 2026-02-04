@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Edit User</h1>

    <form action="{{ route('user.update', $user->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <x-input label="Nama" name="name" value="{{ old('name', $user->name) }}" required />
        <x-input label="Email" name="email" type="email" value="{{ old('email', $user->email) }}" required />

        <x-input label="Password Baru (kosongkan jika tidak diubah)" name="password" type="password" />
        <x-input label="Konfirmasi Password" name="password_confirmation" type="password" />

        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
        <select name="role" required class="w-full border px-3 py-2 rounded dark:bg-gray-800 dark:text-white dark:border-gray-600">
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
            <option value="user"  {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
        </select>

        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('user.index') }}" class="text-sm text-gray-600 hover:text-indigo-600 dark:text-gray-300 dark:hover:text-indigo-400">
                ← Kembali
            </a>

            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
