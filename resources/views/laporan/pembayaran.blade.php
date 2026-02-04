@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4 text-gray-700 dark:text-white">💰 Laporan Pembayaran</h2>

<form action="{{ route('laporan.pembayaran') }}" method="GET" class="flex flex-wrap gap-2 mb-4 bg-white dark:bg-gray-800 p-4 rounded shadow">
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
                <th class="px-4 py-2">Tanggal</th>
                <th class="px-4 py-2">Pelanggan</th>
                <th class="px-4 py-2">Total Order</th>
                <th class="px-4 py-2">Dibayar</th>
                <th class="px-4 py-2">Sisa</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
            <tr class="border-t border-gray-300 dark:border-gray-600 text-center">
                <td class="px-4 py-2">{{ date('d/m/Y', strtotime($row->tanggal)) }}</td>
                <td class="px-4 py-2">{{ $row->nama_pelanggan }}</td>
                <td class="px-4 py-2">Rp{{ number_format($row->harga_total) }}</td>
                <td class="px-4 py-2">Rp{{ number_format($row->jumlah_bayar) }}</td>
                <td class="px-4 py-2 text-red-600">Rp{{ number_format($row->harga_total - $row->jumlah_bayar) }}</td>
                <td class="px-4 py-2">
                    <span class="font-semibold {{ $row->status_bayar === 'lunas' ? 'text-green-600' : 'text-red-500' }}">
                        {{ ucfirst($row->status_bayar) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data pembayaran.</td>
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
