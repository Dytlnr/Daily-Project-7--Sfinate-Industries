@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4 text-gray-700 dark:text-white">📋 Data Orderan</h2>
    <div class="bg-white dark:bg-gray-800 rounded shadow p-4 mb-6">
        <form action="{{ route('kasir.data') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari kode order, nama pelanggan, no invoice, nama orderan..."
                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Cari</button>
                @if(request('search'))
                    <a href="{{ route('kasir.data') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
                @endif
            </div>
        </form>
    </div>
    @if(session('success'))
        <div class="mb-4 p-4 rounded bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 rounded bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
            {{ session('error') }}
        </div>
    @endif
    @if(session('poin_didapat'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            🎉 Anda mendapatkan <strong>{{ session('poin_didapat') }}</strong> poin dari transaksi ini!
        </div>
    @endif
    @forelse ($orderans as $order)
        <div class="bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded shadow p-4 mb-6">
            <div class="flex justify-between items-center mb-2">
                <div>
                    <p class="font-semibold text-lg">{{ $order->nama_pelanggan }}</p>
                    <p class="text-sm text-gray-500">Kode: {{ $order->kode_order }} | Status:
                        <span class="font-semibold {{ $order->status_bayar === 'lunas' ? 'text-green-600' : 'text-red-600' }}">
                            {{ ucfirst($order->status_bayar) }}
                        </span>
                    </p>
                    <p class="text-sm text-gray-500">Tanggal: {{ $order->tanggal }} | Selesai: {{ $order->tanggal_selesai }}</p>
                </div>

                <div class="space-x-2">
                    {{-- Tombol Ubah --}}
                    {{-- <a href="{{ route('kasir.edit', $order->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                        ✏️ Ubah
                    </a> --}}
                    @php
                        $totalKotor = $order->details->sum('subtotal_kotor');
                        $totalDiskon = $order->details->sum('diskon');
                        $totalDp = $order->details->sum('dp');
                        $totalSetelahDiskon = $totalKotor - $totalDiskon;
                        $sisaBayar = $totalSetelahDiskon - $totalDp;
                        $daftarTinta = \DB::table('kode_tinta_sablon')->select('id', 'nama', 'harga')->get()->keyBy('id');
                        $daftarWarna = \DB::table('kode_jenis_warna')->select('id', 'nama', 'harga')->get()->keyBy('id');
                    @endphp

                    @if($order->status_bayar !== 'lunas')
                        <a href="{{ route('kasir.edit', $order->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                            ✏️ Ubah
                        </a>
                    @endif

                    {{-- Tombol Bayar (modal trigger) --}}
                    @if($order->status_bayar !== 'lunas')
                    <button onclick="openModal(
                        '{{ $order->id }}',
                        '{{ $totalKotor }}',
                        '{{ $totalDiskon }}',
                        '{{ $totalDp }}',
                        '{{ $sisaBayar }}'
                    )" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">
                        💰 Bayar
                    </button>
                    @endif

                    {{-- Tombol Hapus (hanya admin) --}}
                    @if(auth()->user()->role === 'admin')
                    <form action="{{ route('kasir.hapus', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus orderan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                            🗑️ Hapus
                        </button>
                    </form>
                    @endif

                    {{-- Tombol Cetak Nota --}}
                    @if($order->status_bayar === 'lunas' || $order->status_bayar === 'piutang')
                    <a href="{{ route('kasir.nota', $order->id) }}" target="_blank"
                        class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 text-sm inline-flex items-center">
                        🧾 Nota
                    </a>
                    @endif
                </div>
            </div>

            {{-- Detail Barang --}}
            <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300 mt-3 border border-gray-200 dark:border-gray-600">
                <thead class="bg-gray-100 dark:bg-gray-700 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-2">Barang</th>
                        <th class="px-4 py-2">Jumlah</th>
                        <th class="px-4 py-2">Harga Satuan</th>
                        <th class="px-4 py-2">Subtotal</th>
                        <th class="px-4 py-2">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $detail)
                        <tr class="border-t border-gray-200 dark:border-gray-600">
                            <td class="px-4 py-2 font-medium">{{ $detail->barang->nama_barang ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $detail->jumlah }}</td>
                            <td class="px-4 py-2">Rp{{ number_format($detail->harga_satuan) }}</td>
                            <td class="px-4 py-2">
                                Rp{{ number_format($detail->subtotal) }}

                                @if($detail->tinta)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Tinta: {{ $detail->tinta->nama }} - Rp{{ number_format($detail->tinta->harga) }}</div>
                                @endif

                                @php
                                    $hargaTinta = 0;
                                    $namaTinta = '';
                                    if (!empty($detail->kode_tinta) && isset($daftarTinta[$detail->kode_tinta])) {
                                        $hargaTinta = $daftarTinta[$detail->kode_tinta]->harga;
                                        $namaTinta = $daftarTinta[$detail->kode_tinta]->nama;
                                    }

                                    $hargaWarna = 0;
                                    $listWarna = [];
                                    if (!empty($detail->warna)) {
                                        $warnaIds = explode(',', $detail->warna);
                                        foreach ($warnaIds as $idWarna) {
                                            $idWarna = trim($idWarna);
                                            if (isset($daftarWarna[$idWarna])) {
                                                $warna = $daftarWarna[$idWarna];
                                                $hargaWarna += $warna->harga;
                                                $listWarna[] = "{$warna->nama} (Rp" . number_format($warna->harga) . ")";
                                            }
                                        }
                                    }

                                    $totalItem = $detail->subtotal + ($detail->tinta->harga ?? 0) + ($hargaWarna * $detail->jumlah);

                                @endphp

                                {{-- Tampilkan warna --}}
                                @if($hargaWarna)
                                    <div class="text-xs text-pink-600">Warna:</div>
                                    <ul class="text-xs text-gray-600 dark:text-gray-400 list-disc list-inside">
                                        @foreach ($listWarna as $warna)
                                            <li>{{ $warna }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                {{-- Total Keseluruhan --}}
                                <div class="text-sm font-semibold text-black dark:text-gray-300 mt-2 border-t pt-1">
                                    Total: Rp{{ number_format($totalItem) }}
                                </div>
                            </td>


                            <td class="px-4 py-2 text-sm leading-5 space-y-1">
                                <div>Gramasi: <span class="font-medium">{{ $detail->gramasi->nama ?? '-' }}</span></div>
                                <div>Tinta: <span class="font-medium">{{ $detail->tinta->nama ?? '-' }}</span></div>
                                <div>Uk. Dewasa: <span class="font-medium">{{ $detail->sizeDewasa->nama ?? '-' }}</span></div>
                                <div>Uk. Anak: <span class="font-medium">{{ $detail->sizeAnak->nama ?? '-' }}</span></div>
                                <div>
                                    Warna:
                                    @php
                                        $warnaIds = explode(',', $detail->warna ?? '');
                                        $warnaNames = \App\Models\Warna::whereIn('id', $warnaIds)->pluck('nama')->toArray();
                                    @endphp
                                    <span class="font-medium">{{ implode(', ', $warnaNames) ?: '-' }}</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>


                <tfoot>
                    <tr class="text-sm">
                        <td colspan="5" class="text-right px-3 py-1 text-gray-500 dark:text-gray-400">Total Barang:</td>
                        <td class="px-3 py-1 text-end text-gray-300 font-medium">
                            Rp{{ number_format($totalItem) }}
                        </td>
                    </tr>
                    <tr class="text-sm">
                        <td colspan="5" class="text-right px-3 py-1 text-gray-500 dark:text-gray-400">Total Diskon:</td>
                        <td class="px-3 py-1 text-end text-green-600 font-medium">
                            - Rp{{ number_format($totalDiskon) }}
                        </td>
                    </tr>
                    <tr class="text-sm">
                        <td colspan="5" class="text-right px-3 py-1 text-gray-500 dark:text-gray-400">Total DP:</td>
                        <td class="px-3 py-1 text-end text-blue-600 font-medium">
                            - Rp{{ number_format($totalDp) }}
                        </td>
                    </tr>

                    {{-- 🧾 Baris terakhir: kondisi status --}}
                    <tr class="text-sm font-bold border-t border-gray-200 dark:border-gray-600">
                        <td colspan="5" class="text-right px-3 py-2 text-gray-700 dark:text-gray-200">
                            @if($order->status_bayar === 'lunas')
                                Bayar:
                            @else
                                Sisa Bayar:
                            @endif
                        </td>
                        <td class="px-3 py-2 text-end {{ $order->status_bayar === 'lunas' ? 'text-green-600' : 'text-red-600' }}">
                            Rp{{ number_format(max($sisaBayar, 0)) }}
                        </td>
                    </tr>
                </tfoot>

            </table>
        </div>
    @empty
        <div class="bg-white dark:bg-gray-800 rounded shadow p-4 mb-6 text-gray-600 dark:text-gray-300">
            Data orderan tidak ditemukan.
        </div>
    @endforelse

    <div class="mt-4">
        {{ $orderans->links('vendor.pagination.tailwind') }}
    </div>
</div>

{{-- Modal Popup Pembayaran --}}
<div id="modalBayar"
     class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50 overflow-y-auto p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md shadow-lg my-8 relative">
        <button type="button" onclick="closeModal()"
                class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-lg">
            ✖
        </button>
        <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-100 text-center">💵 Pembayaran Order</h3>

        <form id="formBayar" method="POST">
            @csrf
            <input type="hidden" name="orderan_id" id="modal_orderan_id">

            <!-- Payment Summary -->
            <div class="mb-4 space-y-2 bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-300">Total Barang:</span>
                    <span class="font-medium text-gray-700 dark:text-gray-200" id="modal_total_kotor"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-300">Total Diskon:</span>
                    <span class="font-medium text-green-600 dark:text-green-400" id="modal_total_diskon"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-300">Total DP:</span>
                    <span class="font-medium text-blue-600 dark:text-blue-400" id="modal_total_dp"></span>
                </div>
                <div class="flex justify-between border-t border-gray-200 dark:border-gray-600 pt-2 mt-2">
                    <span class="text-gray-800 dark:text-gray-100 font-semibold">Total Harus Dibayar:</span>
                    <span class="font-bold text-lg text-gray-900 dark:text-white" id="modal_total_harga"></span>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="space-y-4 max-h-[70vh] overflow-y-auto pr-2">
                <div>
                    <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Nama Orderan</label>
                    <input type="text" name="nama_orderan" id="modal_nama_orderan"
                        placeholder="Masukkan nama orderan (opsional)..."
                        class="w-full border rounded-lg mt-1 p-2 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                    >
                </div>

                <div>
                    <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Jumlah Bayar</label>
                    <input type="number" name="jumlah_bayar" id="modal_jumlah_bayar"
                        class="w-full border rounded-lg mt-1 p-2 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                        readonly>
                </div>

                <div>
                    <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Metode</label>
                    <select name="metode"
                        class="w-full border rounded-lg mt-1 p-2 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" required>
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                        <option value="qris">QRIS</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Keterangan</label>
                    <input type="text" name="keterangan"
                        class="w-full border rounded-lg mt-1 p-2 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                </div>

                <div>
                    <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">No WhatsApp</label>
                    <input type="text" name="no_whatsapp" id="no_whatsapp"
                        placeholder="08xxxxxxxxxx (opsional)"
                        class="w-full border rounded-lg mt-1 p-2 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                    >
                </div>

                <div>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="is_dp" id="is_dp" value="1" class="rounded"
                               onchange="toggleJatuhTempo()">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Pembayaran DP</span>
                    </label>
                </div>

                <div class="hidden" id="jatuh_tempo_container">
                    <label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Jatuh Tempo</label>
                    <input type="date" name="jatuh_tempo"
                           class="w-full border rounded-lg mt-1 p-2 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="flex justify-end space-x-2 mt-6 border-t pt-3">
                <button type="button" onclick="closeModal()"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                    Bayar
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    function openModal(orderanId, totalKotor, totalDiskon, totalDp, sisaBayar) {
        document.getElementById('modal_orderan_id').value = orderanId;
        document.getElementById('formBayar').setAttribute('action', '{{ url('/bayar') }}/' + orderanId);

        document.getElementById('modal_total_kotor').textContent = 'Rp' + Number(totalKotor).toLocaleString('id-ID');
        document.getElementById('modal_total_diskon').textContent = '- Rp' + Number(totalDiskon).toLocaleString('id-ID');
        document.getElementById('modal_total_dp').textContent = '- Rp' + Number(totalDp).toLocaleString('id-ID');
        document.getElementById('modal_total_harga').textContent = 'Rp' + Number(sisaBayar).toLocaleString('id-ID');

        const sisa = Number(sisaBayar) || 0;
        document.getElementById('modal_jumlah_bayar').value = sisa > 0 ? sisa : 0;
        document.getElementById('modal_nama_orderan').value = '';
        document.getElementById('no_whatsapp').value = '';
        document.getElementById('is_dp').checked = false;
        document.getElementById('jatuh_tempo_container').classList.add('hidden');
        document.querySelector('input[name="jatuh_tempo"]').value = '';

        document.getElementById('modalBayar').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalBayar').classList.add('hidden');
    }

    function toggleJatuhTempo() {
        const checkbox = document.getElementById('is_dp');
        const container = document.getElementById('jatuh_tempo_container');

        if (checkbox.checked) {
            container.classList.remove('hidden');
            // Set default jatuh tempo 7 hari dari sekarang
            const today = new Date();
            today.setDate(today.getDate() + 7);
            document.querySelector('input[name="jatuh_tempo"]').valueAsDate = today;
        } else {
            container.classList.add('hidden');
        }
    }
</script>
@endsection
