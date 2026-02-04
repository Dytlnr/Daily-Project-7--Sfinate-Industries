@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white dark:bg-gray-900 p-6 shadow-md text-gray-800 dark:text-gray-100">
    <!-- Tombol aksi -->
    <div class="flex justify-end mb-4 space-x-2">
        <!-- Tombol Export PDF -->
        <a href="{{ route('orders.export-pdf', $order->id) }}"
           class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Export PDF
        </a>

        <!-- Tombol Kirim WhatsApp -->
        <a href="#" onclick="kirimWhatsApp()"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20.52 3.48a12.36 12.36 0 00-17.46 0 12.36 12.36 0 000 17.46l1.82 1.82a1 1 0 001.41 0l3.47-3.47a1 1 0 011.41 0 8.59 8.59 0 1012.14-12.14 1 1 0 000-1.41zm-6.34 11.13a6.57 6.57 0 01-3.62 1.36c-.9 0-1.78-.16-2.65-.48a.6.6 0 01-.31-.85l.64-1.25a.59.59 0 01.83-.28 5.23 5.23 0 003.64.54.59.59 0 01.74.57v1.25a.59.59 0 01-.27.49z"/>
            </svg>
            Kirim WhatsApp
        </a>
    </div>

    <!-- Header perusahaan -->
    <div class="flex justify-between items-center mb-4">
        @if (!empty($global_pengaturan->logo))
            <img src="{{ asset('logo/' . $global_pengaturan->logo) }}" alt="Logo Perusahaan" class="h-16">
        @else
            <span class="text-sm text-gray-500">[Logo Tidak Tersedia]</span>
        @endif

        <div class="text-center">
            <h1 class="text-lg font-bold uppercase">
                {{ $global_pengaturan->nama_perusahaan ?? 'Nama Perusahaan' }}
            </h1>
            <p class="text-sm">
                {{ $global_pengaturan->alamat_1 ?? '' }}
            </p>
            <p class="text-sm">
                {{ $global_pengaturan->alamat_2 ?? '' }}
            </p>
        </div>

        @if (!empty($global_pengaturan->logo))
            <img src="{{ asset('logo/' . $global_pengaturan->logo) }}" alt="Logo Perusahaan" class="h-16">
        @else
            <span class="text-sm text-gray-500">[Logo Tidak Tersedia]</span>
        @endif
    </div>

    <hr>

    <!-- Informasi order -->
    <div class="mb-4">
        <div class="grid grid-cols-[auto_1fr] gap-x-2 gap-y-1 text-sm">
            <p class="font-semibold">NO. INVOICE</p>
            <p>: INV-{{ $order->id }}</p>

            <p class="font-semibold">Tanggal</p>
            <p>: {{ \Carbon\Carbon::parse($order->tanggal)->translatedFormat('l, d F Y') }}</p>
            <p class="font-semibold">Nama Pelanggan</p>
            <p>: {{ $order->nama_pelanggan }}</p>

            <p class="font-semibold">Nama Orderan</p>
            <div>
                @foreach ($order->pembayaran as $pembayaran)
                    <p>: {{ $pembayaran->nama_orderan ?? '-' }}</p>
                @endforeach
            </div>

            <p class="font-semibold">Tanggal Selesai</p>
            <p>: {{ \Carbon\Carbon::parse($order->tanggal_selesai)->translatedFormat('d F Y') }}</p>

            <p class="font-semibold">Status Bayar</p>
            <p class="flex items-start">
                : <span class="font-semibold {{ $order->status_bayar === 'lunas' ? 'text-green-600' : 'text-red-600' }} ml-1">
                    {{ strtoupper($order->status_bayar) }}
                </span>
            </p>

            @if($order->status_bayar === 'piutang' && $order->pembayaran->where('jenis_pembayaran', 'dp')->first())
                <p class="font-semibold">Jatuh Tempo</p>
                <p>: {{ \Carbon\Carbon::parse($order->pembayaran->where('jenis_pembayaran', 'dp')->first()->jatuh_tempo)->translatedFormat('d F Y') }}</p>
            @endif

            @if ($order->member)
                <p class="font-semibold">Poin Member</p>
                <p>: {{ $order->member->point->total_point ?? 0 }}</p>
            @endif
        </div>
    </div>


    <!-- Tabel detail order -->
    <table class="w-full text-sm border border-black mb-4">
        <thead class="bg-blue-100 text-black">
            <tr>
                <th class="border border-black px-2 py-1 w-8">No</th>
                <th class="border border-black px-2 py-1 text-left">Item</th>
                <th class="border border-black px-2 py-1 w-20">Qty</th>
                <th class="border border-black px-2 py-1 w-24 text-right">Harga</th>
                <th class="border border-black px-2 py-1 w-24 text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalOrder = 0;
                $counter = 1;
            @endphp

            <!-- Barang -->
            @foreach ($order->details as $detail)
                @php
                    $subtotalBarang = $detail->harga_satuan * $detail->jumlah;
                    $totalOrder += $subtotalBarang;
                @endphp
                <tr>
                    <td class="border border-black dark:border-gray-300 px-2 py-1 text-center">{{ $counter++ }}</td>
                    <td class="border border-black dark:border-gray-300 px-2 py-1">
                        {{ $detail->barang->nama_barang ?? '-' }}
                        {{ $detail->barang->jenis_kaos ?? '' }}
                        Ukuran {{ $detail->sizeDewasa->nama ?? '-' }}
                    </td>
                    <td class="border border-black dark:border-gray-300 px-2 py-1 text-center">{{ $detail->jumlah ?? 0 }}</td>
                    <td class="border border-black dark:border-gray-300 px-2 py-1 text-right">
                        Rp{{ number_format($detail->harga_satuan ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="border border-black dark:border-gray-300 px-2 py-1 text-right">
                        Rp{{ number_format($subtotalBarang ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach

            <!-- Tinta -->
            @foreach ($order->details as $detail)
                {{-- Harga tinta + warna dikalikan jumlah --}}
                @php
                    $hargaTinta = $detail->tinta->harga ?? 0;

                    $hargaWarna = 0;
                    if ($detail->warna) {
                        $warnaIds = explode(',', $detail->warna);
                        foreach ($warnaIds as $warnaId) {
                            $warna = \App\Models\Warna::find($warnaId);
                            if ($warna) {
                                $hargaWarna += $warna->harga;
                            }
                        }
                    }

                    $totalTambahan = ($hargaTinta + $hargaWarna) * $detail->jumlah;
                    $totalOrder += $totalTambahan;
                @endphp
            @endforeach
            <tr>
                <td colspan="5" class="px-2 py-1">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5" class="px-2 py-1">&nbsp;</td>
            </tr>

        </tbody>
        <tfoot>
            <tr class="font-bold bg-gray-100">
                <td colspan="4" class="border border-black px-2 py-1 text-right text-gray-700">TOTAL ORDER</td>
                <td class="border border-black px-2 py-1 text-right text-gray-700">
                    Rp{{ number_format($totalOrder, 0, ',', '.') }}
                </td>
            </tr>

            @if($order->diskon > 0)
            <tr>
                <td colspan="4" class="border border-black dark:border-gray-300 px-2 py-1 text-right">DISKON</td>
                <td class="border border-black dark:border-gray-300 px-2 py-1 text-right text-red-600">
                    - Rp{{ number_format($order->diskon, 0, ',', '.') }}
                </td>
            </tr>
            @endif

            <tr>
                <td colspan="4" class="border border-black dark:border-gray-300 px-2 py-1 text-right">
                    TOTAL SETELAH DISKON
                </td>
                <td class="border border-black dark:border-gray-300 px-2 py-1 text-right">
                    Rp{{ number_format($totalOrder - $order->diskon, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td colspan="4" class="border border-black dark:border-gray-300 px-2 py-1 text-right">
                    TOTAL DP
                </td>
                <td class="border border-black dark:border-gray-300 px-2 py-1 text-right">
                    - Rp{{ number_format($order->dp, 0, ',', '.') }}
                </td>
            </tr>

            {{-- LOGIKA PEMBAYARAN BERDASARKAN STATUS --}}
            @php
                $sisaPembayaran = $totalOrder - $order->diskon - $order->dp;
            @endphp

            @if(strtolower($order->status_bayar) === 'lunas')
                <tr class="font-bold bg-green-100">
                    <td colspan="4" class="border border-black dark:border-gray-300 px-2 py-1 text-right">
                        PEMBAYARAN (LUNAS)
                    </td>
                    <td class="border border-black px-2 py-1 text-right text-green-700">
                        Rp{{ number_format($totalOrder - $order->diskon, 0, ',', '.') }}
                    </td>
                </tr>
            @else
                <tr class="font-bold bg-yellow-100">
                    <td colspan="4" class="border border-black dark:border-gray-300 px-2 py-1 text-right">
                        SISA PEMBAYARAN (BELUM LUNAS)
                    </td>
                    <td class="border border-black dark:border-gray-300 px-2 py-1 text-right text-red-700">
                        Rp{{ number_format($sisaPembayaran, 0, ',', '.') }}
                    </td>
                </tr>
            @endif
        </tfoot>
    </table>

    <!-- Riwayat pembayaran -->
    {{-- @php
    // Filter pembayaran yang bukan hari ini
    $riwayatPembayaran = $order->pembayaran->filter(function($item) {
        return !\Carbon\Carbon::parse($item->tanggal_pembayaran)->isToday();
    });
    @endphp

    @if($riwayatPembayaran->count() > 0)
        <div class="border border-black dark:border-gray-300 p-4 mb-4">
            <h3 class="font-bold text-lg mb-2">RIWAYAT PEMBAYARAN SEBELUMNYA</h3>
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 text-center text-gray-700">
                        <th class="px-2 py-1">Tanggal</th>
                        <th class="px-2 py-1">No. Nota</th>
                        <th class="px-2 py-1">Jumlah</th>
                        <th class="px-2 py-1">Metode</th>
                        <th class="px-2 py-1">Jenis</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayatPembayaran as $pembayaran)
                    <tr class="border-b border-gray-200 text-center">
                        <td class="px-2 py-1">{{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d/m/Y') }}</td>
                        <td class="px-2 py-1">{{ $pembayaran->no_nota }}</td>
                        <td class="px-2 py-1">Rp{{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                        <td class="px-2 py-1">{{ ucfirst($pembayaran->metode) }}</td>
                        <td class="px-2 py-1">{{ $pembayaran->jenis_pembayaran == 'dp' ? 'DP' : 'Pelunasan' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif --}}

    <!-- Catatan dan informasi bank -->
    <div class="text-sm text-red-600 mb-6">
        <strong>NB:</strong>
        @if($order->status_bayar === 'piutang')
            Pembayaran selanjutnya jatuh tempo pada {{ \Carbon\Carbon::parse($order->pembayaran->where('jenis_pembayaran', 'dp')->first()->jatuh_tempo)->translatedFormat('d F Y') }}.
        @else
            Terima Kasih Telah Melakukan Pembayaran lunas.
        @endif
    </div>

    <div class="flex items-center space-x-4">
        <div class="text-sm">
            <p><strong>Terima Kasih Dengan Anda Berbelanja Disini, Anda Sudah Ikut Berdonasi Sebesar Rp2.000 !!</strong></p>
            <br>
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <img src="{{ asset('images/bca.png') }}" alt="Logo BCA" class="h-20">
        <div class="text-sm">
            <p><strong>BCA</strong></p>
            <p>725 506 3383</p>
            <p>a.n SYAHRIAL HAMDANI AULIA</p>
        </div>
    </div>
</div>

<script>
    function kirimWhatsApp() {
        const noWa = "{{ $order->pembayaran->last()->no_telepon ?? '' }}".replace(/^0/, "62");
        if (!noWa) {
            alert('Nomor WhatsApp tidak tersedia.');
            return;
        }

        const nama = "{{ $order->nama_pelanggan }}";
        const invoice = "INV-{{ $order->id }}";
        const totalBelanja = {{ $totalOrder ?? 0 }};
        const dp = {{ $order->dp ?? 0 }};
        const diskon = {{ $order->diskon ?? 0 }};
        const sisaTagihan = totalBelanja - dp - diskon;
        const status = "{{ strtoupper($order->status_bayar) }}";
        const jatuhTempo = "{{ \Carbon\Carbon::parse($order->jatuh_tempo)->translatedFormat('d F Y') }}";
        const pdfLink = "{{ route('orders.export-pdf', $order->id) }}";

        let pesan = `Halo *${nama}*,\n`;
        pesan += `Berikut rincian pesanan Anda:\n\n`;
        pesan += `*No. Invoice:* ${invoice}\n`;
        pesan += `*Total Belanja:* Rp${number_format(totalBelanja)}\n`;
        pesan += `*Diskon:* Rp${number_format(diskon)}\n`;
        pesan += `*DP Dibayarkan:* Rp${number_format(dp)}\n`;
        pesan += `*Sisa Tagihan:* Rp${number_format(sisaTagihan)}\n`;
        pesan += `*Yang Harus Dibayarkan:* Rp${number_format(sisaTagihan)}\n`;
        pesan += `*Status Bayar:* ${status}\n`;
        pesan += `*Jatuh Tempo:* ${jatuhTempo}\n\n`;
        pesan += `Terima kasih telah berbelanja di *SFINATE INDUSTRIES - PROFESIONAL CLOTHING MAKER*.\n\n`;
        pesan += `Link nota PDF: ${pdfLink}`;

        const waLink = `https://wa.me/${noWa}?text=${encodeURIComponent(pesan)}`;
        window.open(waLink, '_blank');
    }

    // Helper untuk format rupiah
    function number_format(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }
    </script>

@endsection