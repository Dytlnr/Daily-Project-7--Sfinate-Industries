@extends('layouts.app')

@section('content')
<div class="p-6 bg-white dark:bg-gray-900 rounded shadow">
    <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">💰 Laporan Keuangan</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="p-4 bg-green-100 dark:bg-green-800 rounded">
            <p class="text-sm text-green-800 dark:text-green-200">Total Pemasukan</p>
            <h3 class="text-lg font-bold text-green-900 dark:text-white">Rp{{ number_format($totalMasuk, 0, ',', '.') }}</h3>
        </div>
        <div class="p-4 bg-red-100 dark:bg-red-800 rounded">
            <p class="text-sm text-red-800 dark:text-red-200">Total Pengeluaran</p>
            <h3 class="text-lg font-bold text-red-900 dark:text-white">Rp{{ number_format($totalKeluar, 0, ',', '.') }}</h3>
        </div>
        <div class="p-4 bg-blue-100 dark:bg-blue-800 rounded">
            <p class="text-sm text-blue-800 dark:text-blue-200">Saldo Saat Ini</p>
            <h3 class="text-lg font-bold text-blue-900 dark:text-white">Rp{{ number_format($saldo, 0, ',', '.') }}</h3>
        </div>
    </div>

    <table class="w-full text-sm border dark:border-gray-700">
        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
            <tr>
                <th class="border px-2 py-1">Tanggal</th>
                <th class="border px-2 py-1">Keterangan</th>
                <th class="border px-2 py-1">Jenis</th>
                <th class="border px-2 py-1 text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody class="text-gray-800 dark:text-gray-100">
            @forelse ($keuangans as $item)
                <tr>
                    <td class="border px-2 py-1">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td class="border px-2 py-1">{{ $item->keterangan }}</td>
                    <td class="border px-2 py-1 capitalize">{{ $item->jenis }}</td>
                    <td class="border px-2 py-1 text-right">Rp{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500 dark:text-gray-400">Belum ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $keuangans->links() }}
    </div>
</div>
@endsection
