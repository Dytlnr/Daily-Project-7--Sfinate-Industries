@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4 text-gray-700 dark:text-white">💸 Laporan Piutang (Tagihan Belum Lunas)</h2>

<div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
    <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
        <thead class="bg-gray-100 dark:bg-gray-700 text-center">
            <tr>
                <th class="px-4 py-2">Tanggal</th>
                <th class="px-4 py-2">Pelanggan</th>
                <th class="px-4 py-2">Total</th>
                <th class="px-4 py-2">Status Bayar</th>
                <th class="px-4 py-2">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $order)
            <tr class="border-t border-gray-300 dark:border-gray-600 text-center">
                <td class="px-4 py-2">{{ date('d-m-Y', strtotime($order->tanggal)) }}</td>
                <td class="px-4 py-2">{{ $order->nama_pelanggan }}</td>
                <td class="px-4 py-2">Rp{{ number_format($order->total_bayar) }}</td>
                <td class="px-4 py-2">
                    <span class="font-semibold text-red-500">Belum Lunas</span>
                </td>
                <td class="px-4 py-2">{{ $order->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada tagihan piutang.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $data->links() }}
    </div>
</div>
@endsection
