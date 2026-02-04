@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
    <h2 class="text-xl font-bold text-gray-700 dark:text-white mb-4">🎁 Form Penukaran Poin</h2>

    <div class="mb-4 text-gray-800 dark:text-gray-200">
        <p>Nama Member: <strong>{{ $member->nama }}</strong></p>
        <p>Total Poin Saat Ini: <strong>{{ $totalPoin }}</strong></p>
    </div>

    <form action="{{ route('member.tukar.proses', $member->id) }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="poin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Poin yang Ditukar</label>
            <input type="number" name="poin" id="poin" min="1" max="{{ $totalPoin }}"
                   class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                   required>
        </div>

        <div>
            <label for="keterangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan / Hadiah</label>
            <input type="text" name="keterangan" id="keterangan"
                   class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                   placeholder="Contoh: Potongan belanja, Voucher, dll">
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition-colors">
                Tukarkan Poin
            </button>
        </div>
    </form>
</div>
@endsection
