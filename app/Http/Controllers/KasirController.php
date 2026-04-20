<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Member;
use App\Models\Orderan;
use App\Models\OrderanDetail;
use App\Models\Pembayaran;
use App\Models\PointMember;
use App\Models\PointSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Keuangan;
use Auth;
use PDF;

class KasirController extends Controller
{
    public function index()
    {
        $keranjang = Session::get('keranjang', []);
        $barangs = Barang::all();
        $gramasi = DB::table('kode_gramasi')->get();
        $tinta = DB::table('kode_tinta_sablon')->get();
        $ukuranDewasa = DB::table('kode_size_dewasa')->get();
        $ukuranAnak = DB::table('kode_size_anak')->get();
        $members = Member::all();
        $jenisWarna = DB::table('kode_jenis_warna')->get();

        return view('kasir.index', compact(
            'keranjang', 'barangs', 'gramasi', 'tinta', 'ukuranDewasa', 'ukuranAnak', 'members', 'jenisWarna'
        ));
    }

    public function tambahBarang(Request $request)
    {
        $namaPelanggan = trim((string) $request->input('nama_pelanggan', ''));
        if ($namaPelanggan !== '') {
            Session::put('kasir_nama_pelanggan', $namaPelanggan);
        }

        if (empty(Session::get('kasir_nama_pelanggan'))) {
            return back()->with('error', 'Isi nama pelanggan sekali dulu sebelum tambah barang.');
        }

        $barang = Barang::find($request->barang_id);
        if (!$barang) {
            return back()->with('error', 'Barang tidak ditemukan.');
        }

        if ($request->jumlah > $barang->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia: ' . $barang->stok);
        }

        $tinta = DB::table('kode_tinta_sablon')->find($request->kd_tinta);
        $hargaTinta = $tinta ? $tinta->harga : 0;

        $warnaIds = [];
        if ($request->filled('warna')) {
            $warnaInput = $request->input('warna');
            if (is_string($warnaInput)) {
                $warnaIds = explode(',', $warnaInput);
            } elseif (is_array($warnaInput)) {
                $warnaIds = $warnaInput;
            }
        }

        $warnaData = DB::table('kode_jenis_warna')
            ->whereIn('id', $warnaIds)
            ->get();

        $hargaWarna = $warnaData->sum('harga');

        $subtotal = ($barang->harga_satuan * $request->jumlah) + $hargaTinta + $hargaWarna;

        $keranjang = Session::get('keranjang', []);
        $exists = false;
        foreach ($keranjang as $index => $item) {
            if ($item['id'] == $barang->id) {
                $keranjang[$index]['jumlah'] += $request->jumlah;
                $keranjang[$index]['subtotal'] = ($barang->harga_satuan * $keranjang[$index]['jumlah']) + $item['tinta_harga'] + $item['warna_harga'];
                $exists = true;
                break;
            }
        }
        if (!$exists) {
            $keranjang[] = [
                'id' => $barang->id,
                'nama' => $barang->nama_barang,
                'jumlah' => $request->jumlah,
                'harga' => $barang->harga_satuan,
                'subtotal' => $subtotal,
                'tinta' => $tinta ? $tinta->nama : null,
                'tinta_id' => $tinta ? $tinta->id : null,
                'tinta_harga' => $hargaTinta,
                'warna' => $warnaData->pluck('nama')->toArray(),
                'warna_ids' => $warnaData->pluck('id')->toArray(),
                'warna_harga' => $hargaWarna,
                'gramasi' => DB::table('kode_gramasi')->where('id', $request->kd_gramasi)->value('nama'),
                'gramasi_id' => $request->kd_gramasi,
                'size_dewasa' => DB::table('kode_size_dewasa')->where('id', $request->kd_size_dewasa)->value('nama'),
                'size_dewasa_id' => $request->kd_size_dewasa,
                'size_anak' => DB::table('kode_size_anak')->where('id', $request->kd_size_anak)->value('nama'),
                'size_anak_id' => $request->kd_size_anak,
                'dp' => $request->dp ?? 0,
                'diskon' => $request->diskon ?? 0,
            ];
        }

        Session::put('keranjang', $keranjang);
        Session::put('tanggal_selesai', $request->tanggal_selesai);

        $barang->stok -= $request->jumlah;
        $barang->stok = max(0, $barang->stok);
        $barang->save();

        return back()->with('success', 'Barang ditambahkan ke keranjang.');
    }


    public function simpanTransaksi(Request $request)
    {
        $keranjang = Session::get('keranjang', []);
        if (empty($keranjang)) {
            return back()->with('error', 'Keranjang kosong.');
        }

        $namaPelanggan = trim((string) $request->input('nama_pelanggan', Session::get('kasir_nama_pelanggan', '')));
        if ($namaPelanggan === '') {
            return back()->with('error', 'Nama pelanggan wajib diisi.');
        }
        Session::put('kasir_nama_pelanggan', $namaPelanggan);

        $tanggalSelesaiRaw = Session::get('tanggal_selesai');
        if (!$tanggalSelesaiRaw) {
            return back()->with('error', 'Tanggal selesai tidak tersedia. Silakan isi ulang.');
        }

        try {
            $tanggalSelesai = Carbon::createFromFormat('d/m/Y', $tanggalSelesaiRaw)->format('Y-m-d');
        } catch (\Exception $e) {
            return back()->with('error', 'Format tanggal selesai tidak valid.');
        }

        $totalKotor = collect($keranjang)->sum(function($item) {
            $harga = $item['harga'] ?? 0;
            $tinta = $item['tinta_harga'] ?? 0;
            $warna = $item['warna_harga'] ?? 0;
            $jumlah = $item['jumlah'] ?? 0;

            return ($harga + $tinta + $warna) * $jumlah;
        });

        $totalDiskon = collect($keranjang)->sum('diskon');
        $totalDP = collect($keranjang)->sum('dp');
        $totalSetelahDiskon = $totalKotor - $totalDiskon - $totalDP;

        // Simpan ke tabel orderans
        $order = Orderan::create([
            'kode_order'        => 'ORD-' . strtoupper(Str::random(6)),
            'nama_pelanggan'    => $namaPelanggan,
            'member_id'         => $request->member_id,
            'harga_total'       => $totalSetelahDiskon,
            'diskon'            => $totalDiskon,
            'dp'                => $totalDP,
            'status_bayar'      => 'belum',
            'tanggal'           => now(),
            'tanggal_selesai'   => $tanggalSelesai,
        ]);

        // Simpan detail order
        foreach ($keranjang as $item) {
            // Hitung subtotal kotor (harga barang + tinta + warna)
            $subtotalKotor = (
                ($item['harga'] ?? 0)
                + ($item['tinta_harga'] ?? 0)
                + ($item['warna_harga'] ?? 0)
            ) * ($item['jumlah'] ?? 0);

            // Subtotal setelah diskon
            // $subtotal = $subtotalKotor - ($item['diskon'] ?? 0);

            $subtotal = ($item['harga'] * $item['jumlah'] ?? 0);

            OrderanDetail::create([
                'orderan_id' => $order->id,
                'barang_id' => $item['id'],
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $item['harga'],
                'subtotal_kotor' => $subtotalKotor,
                'subtotal' => $subtotal,
                'dp' => $item['dp'] ?? 0,
                'diskon' => $item['diskon'] ?? 0,
                'kd_gramasi' => $item['gramasi_id'] ?? null,
                'kd_tinta' => $item['tinta_id'] ?? null,
                'kd_size_dewasa' => $item['size_dewasa_id'] ?? null,
                'kd_size_anak' => $item['size_anak_id'] ?? null,
                'warna' => implode(',', $item['warna_ids'] ?? []),
                'harga_tinta' => $item['tinta_harga'] ?? 0,  // tambahkan kolom ini jika ada
                'harga_warna' => $item['warna_harga'] ?? 0,  // tambahkan kolom ini jika ada
            ]);

            // // Kurangi stok
            // $barang = Barang::find($item['id']);
            // if ($barang) {
            //     $barang->stok -= $item['jumlah'];
            //     $barang->stok = max(0, $barang->stok);
            //     $barang->save();
            // }
        }

        // Bersihkan session
        Session::forget(['keranjang', 'tanggal_selesai', 'kasir_nama_pelanggan']);

        return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil disimpan.');
    }


    public function resetKeranjang()
    {
        $keranjang = Session::get('keranjang', []);

        foreach ($keranjang as $item) {
            $barang = Barang::find($item['id']);

            if ($barang) {
                $barang->stok += $item['jumlah'];
                $barang->stok = max(0, $barang->stok);
                $barang->save();
            }
        }

        Session::forget(['keranjang', 'kasir_nama_pelanggan']);

        return back()->with('success', 'Keranjang dikosongkan.');
    }

    public function dataOrderan(Request $request)
    {
        $search = $request->input('search');

        $orderans = Orderan::with([
            'details.barang',
            'details.tinta',    // ← tambahkan ini
            'details.gramasi',  // (opsional jika ingin tampil)
            'pembayaran',
        ])
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_order', 'like', '%' . $search . '%')
                    ->orWhere('nama_pelanggan', 'like', '%' . $search . '%')
                    ->orWhere('status_bayar', 'like', '%' . $search . '%')
                    ->orWhereHas('pembayaran', function ($p) use ($search) {
                        $p->where('no_nota', 'like', '%' . $search . '%')
                            ->orWhere('nama_orderan', 'like', '%' . $search . '%')
                            ->orWhere('no_telepon', 'like', '%' . $search . '%');
                    });
            });
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('kasir.data-orderan', compact('orderans'));
    }

    public function bayarOrderan(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $order = Orderan::with(['member', 'details', 'pembayaran'])->findOrFail($id);

            $request->validate([
                'jumlah_bayar' => 'required|numeric|min:1',
                'metode' => 'required|string|in:cash,transfer,qris',
                'keterangan' => 'nullable|string',
                'is_dp' => 'nullable|in:0,1',
                'jatuh_tempo' => 'nullable|date|required_if:is_dp,1',
                'no_whatsapp' => 'nullable|string',
                'nama_orderan' => 'nullable|string',
            ]);

            $isDp = $request->boolean('is_dp');

            // Hitung total yang harus dibayar
            $totalHarga = $order->harga_total;
            $sudahDibayar = $order->pembayaran->sum('jumlah_bayar');
            $sisaBayar = $totalHarga - $sudahDibayar;

            if ($sisaBayar <= 0) {
                DB::rollBack();
                return back()->with('success', 'Order ini sudah lunas, tidak ada sisa pembayaran.');
            }

            // Validasi jumlah pembayaran
            if ($request->jumlah_bayar <= 0) {
                throw new \Exception('Jumlah pembayaran harus lebih dari 0');
            }

            // Tentukan jenis pembayaran
            // Jika user centang DP tapi nominal sudah menutup sisa bayar, anggap lunas.
            if ($isDp && $request->jumlah_bayar >= $sisaBayar) {
                $isDp = false;
            }
            $isPelunasan = !$isDp && ($request->jumlah_bayar >= $sisaBayar);

            // Validasi untuk DP
            if ($isDp && empty($request->jatuh_tempo)) {
                throw new \Exception('Jatuh tempo harus diisi untuk pembayaran DP');
            }

            // Simpan pembayaran
            $pembayaran = Pembayaran::create([
                'orderan_id' => $order->id,
                'no_nota' => 'INV-' . strtoupper(Str::random(6)),
                'jumlah_bayar' => $request->jumlah_bayar,
                'jenis_pembayaran' => $isDp ? 'dp' : ($isPelunasan ? 'lunas' : 'dp'),
                'tanggal_pembayaran' => now(),
                'jatuh_tempo' => $isDp ? $request->jatuh_tempo : null,
                'metode' => $request->metode,
                'keterangan' => $request->keterangan,
                'no_telepon' => $request->filled('no_whatsapp') ? $request->no_whatsapp : null,
                'nama_orderan' => $request->filled('nama_orderan') ? $request->nama_orderan : $order->nama_pelanggan,
            ]);

            // Catat keuangan
            Keuangan::create([
                'tanggal' => now(),
                'keterangan' => 'Pembayaran Orderan #' . $order->id . ($isDp ? ' (DP)' : ''),
                'jenis' => 'masuk',
                'jumlah' => $request->jumlah_bayar,
                'sumber' => 'orderan',
                'sumber_id' => $order->id,
            ]);

            // Update status order
            $statusMessage = '';
            if ($isPelunasan) {
                $order->update(['status_bayar' => 'lunas']);
                $statusMessage = 'Pembayaran lunas berhasil dicatat';
            } else {
                $order->update(['status_bayar' => 'piutang']);
                $statusMessage = 'Pembayaran DP berhasil dicatat';
            }

            // Hitung poin member jika pelunasan
            $poinMessage = '';
            if ($isPelunasan && $order->member_id) {
                $setting = PointSetting::first();
                if ($setting && $order->harga_total > 0) {
                    $poinDidapat = floor($order->harga_total / $setting->nominal) * $setting->point;
                    if ($poinDidapat > 0) {
                        $point = PointMember::firstOrNew(['member_id' => $order->member_id]);
                        $point->total_point = ($point->total_point ?? 0) + $poinDidapat;
                        $point->save();
                        $poinMessage = ' dan mendapatkan ' . $poinDidapat . ' poin';
                    }
                }
            }

            DB::commit();

            return back()
                ->with('success', $statusMessage . $poinMessage)
                ->with('poin_didapat', $poinMessage ? $poinDidapat : null);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan pembayaran: ' . $e->getMessage());
        }
    }


    public function hapus($id)
    {
        $order = Orderan::findOrFail($id);

        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa menghapus orderan.');
        }

        // Kembalikan stok barang berdasarkan order detail
        foreach ($order->details as $detail) {
            $barang = Barang::where('kode_barang', $detail->barang->kode_barang)->first();

            if ($barang) {
                $barang->stok += $detail->jumlah;
                $barang->save();
            }
        }

        // Hapus order detail terlebih dahulu
        $order->details()->delete();
        $order->pembayaran()->delete();
        $order->delete();

        return back()->with('success', 'Orderan berhasil dihapus dan stok barang dikembalikan.');
    }

    public function edit($id)
    {
        $order = Orderan::with('details')->findOrFail($id);
        // (opsional: logika edit)
        return view('kasir.edit-orderan', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Orderan::with('details')->findOrFail($id);

        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'tanggal_selesai' => 'required|date',
            'barang_id.*' => 'required|exists:barangs,id',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        // Update order utama
        $order->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        // Hapus detail lama
        $order->details()->delete();

        $total = 0;

        foreach ($request->barang_id as $index => $barangId) {
            $barang = Barang::findOrFail($barangId);
            $jumlah = $request->jumlah[$index];
            $hargaSatuan = $barang->harga_satuan;

            // Ambil data tambahan (pastikan input ini dikirim dari form)
            $dp     = $request->dp[$index] ?? 0;
            $diskon = $request->diskon[$index] ?? 0;

            $subtotalKotor = $hargaSatuan * $jumlah;
            $subtotal = $subtotalKotor - $diskon;

            OrderanDetail::create([
                'orderan_id'      => $order->id,
                'barang_id'       => $barangId,
                'jumlah'          => $jumlah,
                'harga_satuan'    => $hargaSatuan,
                'subtotal_kotor'  => $subtotalKotor,
                'subtotal'        => $subtotal,
                'dp'              => $dp,
                'diskon'          => $diskon,
            ]);

            $total += $subtotal;
        }

        // Update total harga
        $order->update([
            'harga_total' => $total,
        ]);

        return redirect()->route('kasir.data')->with('success', 'Orderan berhasil diperbarui.');
    }

    public function notaPembayaran($id)
    {
        $order = Orderan::with([
            'details.barang',
            'pembayaran',
            'member.point', // ← tambah ini
        ])->findOrFail($id);

        return view('kasir.nota', compact('order'));
    }

    public function exportPdf($id)
    {
        $order = Orderan::with([
            'details.barang',
            'details.tinta',
            'details.sizeDewasa',
            'pembayaran',
            'member.point'
        ])->findOrFail($id);

        $global_pengaturan = \App\Models\Pengaturan::first();

        // ✅ Hitung total persis sama kayak nota web
        $totalOrder = 0;

        foreach ($order->details as $detail) {
            // harga barang
            $subtotalBarang = $detail->harga_satuan * $detail->jumlah;
            $totalOrder += $subtotalBarang;

            // harga tinta
            $hargaTinta = $detail->tinta->harga ?? 0;

            // harga warna
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

            $totalOrder += ($hargaTinta + $hargaWarna) * $detail->jumlah;
        }

        $subtotal = $totalOrder - $order->diskon;
        $sisaPembayaran = $subtotal - $order->dp;

        // ✅ kirim variabel tambahan ke view
        $pdf = \PDF::loadView('orders.pdf', compact(
            'order',
            'global_pengaturan',
            'totalOrder',
            'subtotal',
            'sisaPembayaran'
        ))->setPaper('a4', 'portrait');

        return $pdf->stream('invoice-' . $order->id . '.pdf');
    }

    public function tambahJasaSablon(Request $request)
    {
        $request->validate([
            'jenis_jasa' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|integer|min:0',
            'tanggal_selesai_jasa' => 'required|string',
        ]);

        $subtotal = $request->harga * $request->jumlah;

        $keranjangJasa = Session::get('keranjang_jasa', []);
        $keranjangJasa[] = [
            'jenis_jasa' => $request->jenis_jasa,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'subtotal' => $subtotal,
        ];

        Session::put('keranjang_jasa', $keranjangJasa);
        Session::put('tanggal_selesai_jasa', $request->tanggal_selesai_jasa);

        return back()->with('success', 'Jasa sablon ditambahkan ke keranjang khusus jasa.');
    }

    public function simpanJasaSablon(Request $request)
    {
        $keranjangJasa = Session::get('keranjang_jasa', []);
        if (empty($keranjangJasa)) {
            return back()->with('error', 'Keranjang jasa kosong.');
        }

        $tanggalSelesaiRaw = Session::get('tanggal_selesai_jasa');
        try {
            $tanggalSelesai = Carbon::createFromFormat('d/m/Y', $tanggalSelesaiRaw)->format('Y-m-d');
        } catch (\Exception $e) {
            return back()->with('error', 'Format tanggal selesai tidak valid.');
        }

        $total = collect($keranjangJasa)->sum('subtotal');

        $order = Orderan::create([
            'kode_order' => 'JASA-' . strtoupper(Str::random(6)),
            'nama_pelanggan' => $request->nama_pelanggan,
            'harga_total' => $total,
            'status_bayar' => 'belum',
            'tanggal' => now(),
            'tanggal_selesai' => $tanggalSelesai,
            'is_jasa' => true, // flag untuk bedain transaksi jasa
        ]);

        // 🔑 Cari barang dummy "Jasa Sablon"
        $jasaBarang = Barang::where('nama_barang', 'Jasa Sablon')->first();
        if (!$jasaBarang) {
            return back()->with('error', 'Barang "Jasa Sablon" belum dibuat di database.');
        }

        foreach ($keranjangJasa as $item) {
            OrderanDetail::create([
                'orderan_id'   => $order->id,
                'barang_id'    => $jasaBarang->id, // pakai barang dummy Jasa Sablon
                'nama_produk'  => $item['jenis_jasa'], // tetap simpan jenis jasa yang dipilih
                'jumlah'       => $item['jumlah'],
                'harga_satuan' => $item['harga'],
                'subtotal'     => $item['subtotal'],
                'nama_pelanggan'=> $request->nama_pelanggan,
                'subtotal_kotor' => $item['subtotal'],
            ]);
        }

        Session::forget('keranjang_jasa');
        Session::forget('tanggal_selesai_jasa');

        return redirect()->route('kasir.index')->with('success', 'Transaksi jasa berhasil disimpan.');
    }

    public function resetKeranjangJasa()
    {
        // Hapus session keranjang jasa dan tanggal selesai jasa
        Session::forget('keranjang_jasa');
        Session::forget('tanggal_selesai_jasa');

        return back()->with('success', 'Keranjang jasa sablon dikosongkan.');
    }

}
