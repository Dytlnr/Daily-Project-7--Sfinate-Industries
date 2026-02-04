@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4 text-gray-700 dark:text-white">📜 Riwayat Poin - {{ $member->nama }}</h2>

<div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
    <table class="w-full table-auto text-sm text-left text-gray-700 dark:text-gray-200">
        <thead class="bg-gray-100 dark:bg-gray-700 text-center">
            <tr>
                <th class="border px-4 py-2 dark:border-gray-600">Tanggal</th>
                <th class="border px-4 py-2 dark:border-gray-600">Tipe</th>
                <th class="border px-4 py-2 dark:border-gray-600">Poin</th>
                <th class="border px-4 py-2 dark:border-gray-600">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($riwayat as $item)
                <tr class="text-center border-t border-gray-300 dark:border-gray-600">
                    <td class="px-4 py-2">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-2">{{ ucfirst($item->tipe) }}</td>
                    <td class="px-4 py-2">{{ $item->poin }}</td>
                    <td class="px-4 py-2">{{ $item->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500 dark:text-gray-400">Belum ada riwayat poin.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $riwayat->links() }}
</div>
@endsection
