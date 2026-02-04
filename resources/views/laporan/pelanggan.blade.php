@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4 text-gray-700 dark:text-white">👥 Laporan Pelanggan</h2>

<form action="{{ route('laporan.pelanggan') }}" method="GET" class="flex flex-wrap gap-2 mb-4 bg-white dark:bg-gray-800 p-4 rounded shadow">
    <div>
        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Tanggal Awal</label>
        <input type="text" name="start_date" id="start_date" value="{{ request('start_date') }}"
            class="w-full border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            placeholder="01/07/2025">
    </div>
    <div>
        <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Tanggal Akhir</label>
        <input type="text" name="end_date" id="end_date" value="{{ request('end_date') }}"
            class="w-full border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            placeholder="07/07/2025">
    </div>
    <div class="flex items-end">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Filter</button>
    </div>
</form>

<div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
    <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
        <thead class="bg-gray-100 dark:bg-gray-700 text-center">
            <tr>
                <th class="px-4 py-2">Nama Pelanggan</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Total Order</th>
                <th class="px-4 py-2">Total Barang</th>
                <th class="px-4 py-2">Total Omzet</th>
                <th class="px-4 py-2">Total Poin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
            <tr class="border-t border-gray-300 dark:border-gray-600 text-center">
                <td class="px-4 py-2">{{ $item->nama_pelanggan }}</td>
                <td class="px-4 py-2">
                    @if($item->member_id)
                        <span class="text-green-600 font-semibold">Member</span>
                    @else
                        <span class="text-gray-400 italic">Non-member</span>
                    @endif
                </td>
                <td class="px-4 py-2">{{ $item->total_order }}</td>
                <td class="px-4 py-2">{{ $item->total_barang }}</td>
                <td class="px-4 py-2">Rp{{ number_format($item->total_omzet) }}</td>
                <td class="px-4 py-2">
                    {{ $item->member_id ? $item->total_point . ' poin' : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data pelanggan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $data->links() }}
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#start_date", { dateFormat: "d/m/Y", allowInput: true });
    flatpickr("#end_date", { dateFormat: "d/m/Y", allowInput: true });
</script>
@endsection
