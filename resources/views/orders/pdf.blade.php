<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Order - {{ $order->kode_order }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111;
            font-size: 12px;
        }
        .container {
            width: 100%;
            margin: auto;
        }
        .header, .footer {
            text-align: center;
        }
        .header img {
            height: 70px;
        }
        .info {
            margin-top: 10px;
        }
        .info table {
            width: 100%;
            font-size: 12px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .table th, .table td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }
        .table th {
            background-color: #f0f8ff;
        }
        .right {
            text-align: right;
        }
        .center {
            text-align: center;
        }
        .text-green {
            color: green;
        }
        .text-red {
            color: red;
        }
        .footer {
            margin-top: 20px;
            font-size: 11px;
        }
    </style>
</head>
<body>
<div class="container">

    <!-- Header -->
    <div class="header">
        <table width="100%">
            <tr>
                <td width="25%" class="center">
                    @if (!empty($global_pengaturan->logo))
                        <img src="{{ public_path('logo/' . $global_pengaturan->logo) }}" alt="Logo">
                    @endif
                </td>
                <td width="50%" class="center">
                    <h2 style="margin:0;">{{ strtoupper($global_pengaturan->nama_perusahaan ?? 'Nama Perusahaan') }}</h2>
                    <p style="margin:0;">{{ $global_pengaturan->alamat_1 ?? '' }}</p>
                    <p style="margin:0;">{{ $global_pengaturan->alamat_2 ?? '' }}</p>
                </td>
                <td width="25%" class="center">
                    @if (!empty($global_pengaturan->logo))
                        <img src="{{ public_path('logo/' . $global_pengaturan->logo) }}" alt="Logo">
                    @endif
                </td>
            </tr>
        </table>
        <hr>
    </div>

    <!-- Info Order -->
    <div class="info">
        <table>
            <tr><td><strong>No. Invoice</strong></td><td>: INV-{{ $order->id }}</td></tr>
            <tr><td><strong>Tanggal</strong></td><td>: {{ \Carbon\Carbon::parse($order->tanggal)->translatedFormat('l, d F Y') }}</td></tr>
            <tr><td><strong>Nama Pelanggan</strong></td><td>: {{ $order->nama_pelanggan }}</td></tr>
            <tr><td><strong>Tanggal Selesai</strong></td><td>: {{ \Carbon\Carbon::parse($order->tanggal_selesai)->translatedFormat('d F Y') }}</td></tr>
            <tr><td><strong>Status Bayar</strong></td>
                <td>:
                    <strong class="{{ $order->status_bayar === 'lunas' ? 'text-green' : 'text-red' }}">
                        {{ strtoupper($order->status_bayar) }}
                    </strong>
                </td>
            </tr>
            @if($order->status_bayar === 'piutang' && $order->pembayaran->where('jenis_pembayaran', 'dp')->first())
                <tr><td><strong>Jatuh Tempo</strong></td>
                    <td>: {{ \Carbon\Carbon::parse($order->pembayaran->where('jenis_pembayaran', 'dp')->first()->jatuh_tempo)->translatedFormat('d F Y') }}</td>
                </tr>
            @endif
            @if ($order->member)
                <tr><td><strong>Poin Member</strong></td><td>: {{ $order->member->point->total_point ?? 0 }}</td></tr>
            @endif
        </table>
    </div>

    <!-- Detail Order -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Item</th>
                <th class="center">Qty</th>
                <th class="right">Harga</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalOrder = 0;
                $no = 1;
            @endphp

            <!-- Barang -->
            @foreach ($order->details as $detail)
                @php
                    $subtotalBarang = $detail->harga_satuan * $detail->jumlah;
                    $totalOrder += $subtotalBarang;
                @endphp
                <tr>
                    <td class="center">{{ $no++ }}</td>
                    <td>
                        {{ $detail->barang->nama_barang ?? '-' }}
                        {{ $detail->barang->jenis_kaos ?? '' }}
                        Ukuran {{ $detail->sizeDewasa->nama ?? '-' }}
                    </td>
                    <td class="center">{{ $detail->jumlah }}</td>
                    <td class="right">Rp{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td class="right">Rp{{ number_format($subtotalBarang, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            <!-- Tambahan tinta & warna -->
            @foreach ($order->details as $detail)
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
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="right"><strong>TOTAL ORDER</strong></td>
                <td class="right"><strong>Rp{{ number_format($totalOrder, 0, ',', '.') }}</strong></td>
            </tr>

            @if($order->diskon > 0)
                <tr>
                    <td colspan="4" class="right">DISKON</td>
                    <td class="right text-red">- Rp{{ number_format($order->diskon, 0, ',', '.') }}</td>
                </tr>
            @endif

            <tr>
                <td colspan="4" class="right">TOTAL SETELAH DISKON</td>
                <td class="right">Rp{{ number_format($totalOrder - $order->diskon, 0, ',', '.') }}</td>
            </tr>

            <tr>
                <td colspan="4" class="right">TOTAL DP</td>
                <td class="right">- Rp{{ number_format($order->dp, 0, ',', '.') }}</td>
            </tr>

            @php
                $sisaPembayaran = $totalOrder - $order->diskon - $order->dp;
            @endphp

            @if(strtolower($order->status_bayar) === 'lunas')
                <tr style="background-color:#d4edda;">
                    <td colspan="4" class="right"><strong>PEMBAYARAN (LUNAS)</strong></td>
                    <td class="right text-green"><strong>Rp{{ number_format($totalOrder - $order->diskon, 0, ',', '.') }}</strong></td>
                </tr>
            @else
                <tr style="background-color:#fff3cd;">
                    <td colspan="4" class="right"><strong>SISA PEMBAYARAN (BELUM LUNAS)</strong></td>
                    <td class="right text-red"><strong>Rp{{ number_format($sisaPembayaran, 0, ',', '.') }}</strong></td>
                </tr>
            @endif
        </tfoot>
    </table>

    <!-- Catatan -->
    <p style="margin-top: 15px; color: red;">
        <strong>NB:</strong>
        @if($order->status_bayar === 'piutang')
            Pembayaran selanjutnya jatuh tempo pada
            {{ \Carbon\Carbon::parse($order->pembayaran->where('jenis_pembayaran', 'dp')->first()->jatuh_tempo)->translatedFormat('d F Y') }}.
        @else
            Terima kasih telah melakukan pembayaran lunas.
        @endif
    </p>

    <!-- Info Bank -->
    <div class="footer">
        <p><strong>Terima kasih telah berbelanja di {{ $global_pengaturan->nama_perusahaan ?? 'SFINATE INDUSTRIES' }}</strong></p>
        <p>Anda sudah ikut berdonasi sebesar Rp2.000!</p>
        <br>
        <img src="{{ public_path('images/bca.png') }}" alt="BCA" height="50">
        <p><strong>BCA</strong> - 725 506 3383 a.n SYAHRIAL HAMDANI AULIA</p>
    </div>
</div>
</body>
</html>
