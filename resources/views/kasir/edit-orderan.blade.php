@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">Edit Orderan</h2>

    <form action="{{ route('kasir.update', $order->id) }}" method="POST" class="bg-white dark:bg-gray-800 p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama_pelanggan" class="block font-semibold text-gray-700 dark:text-gray-200">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" value="{{ $order->nama_pelanggan }}"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <div class="mb-4">
            <label for="tanggal_selesai" class="block font-semibold text-gray-700 dark:text-gray-200">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" value="{{ $order->tanggal_selesai }}"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100">
        </div>

        <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-100">Detail Barang</h3>
        <div class="overflow-x-auto">
            <table class="w-full table-auto border border-gray-300 dark:border-gray-600 text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="border px-2 py-1 text-gray-800 dark:text-gray-100">Barang</th>
                        <th class="border px-2 py-1 text-gray-800 dark:text-gray-100">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $index => $detail)
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="border px-2 py-1">
                                <select name="barang_id[]" class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100 rounded">
                                    @foreach (\App\Models\Barang::all() as $barang)
                                        <option value="{{ $barang->id }}" @selected($barang->id == $detail->barang_id)>
                                            {{ $barang->nama_barang }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="border px-2 py-1">
                                <input type="number" name="jumlah[]" value="{{ $detail->jumlah }}"
                                    class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100 px-2 py-1 rounded">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
                Update
            </button>
            <a href="{{ route('kasir.data') }}" class="ml-2 text-gray-600 dark:text-gray-300 hover:underline">Batal</a>
        </div>
    </form>
</div>
@endsection
