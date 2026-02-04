<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $barangs = Barang::when($search, function ($query, $search) {
            return $query->where('nama_barang', 'like', '%' . $search . '%');
        })
        ->orderBy('id', 'desc')
        ->paginate(10)
        ->withQueryString();

        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        $jenisKaosOptions = [
            'Lengan Pendek', 'Lengan Panjang', 'Tunik',
            'Reglan', 'Kombinasi', 'Lengan 3/4', 'Lengan 7/8'
        ];

        // Ambil nama barang dari barang_masuk (buat dropdown)
        $namaBarangs = \App\Models\BarangMasuk::select('nama_barang')
                        ->distinct()
                        ->orderBy('nama_barang', 'asc')
                        ->get();

        // Ambil semua data barang lengkap untuk autofill
        $dataBarang = \App\Models\Barang::select(
            'nama_barang',
            'warna',
            'ukuran',
            'stok',
            'satuan',
            'harga_modal',
            'harga_jual',
            'harga_diskon',
            'harga_satuan',
            'jenis_kaos',
            'lokasi'
        )
        ->get();

        return view('barang.create', compact('jenisKaosOptions', 'namaBarangs', 'dataBarang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'   => 'required',
            'satuan'        => 'required',
            'stok'          => 'required|numeric|min:1',
            'harga_satuan'  => 'required|numeric|min:0',
            'harga_modal'   => 'nullable|numeric',
            'harga_jual'    => 'nullable|numeric',
            'harga_diskon'  => 'nullable|numeric',
            'warna'         => 'nullable|string',
            'ukuran'        => 'nullable|string',
            'jenis_kaos'    => 'nullable|string',
            'lokasi'        => 'nullable|string',
        ]);

        // Cek apakah barang sudah ada
        $existing = Barang::where('nama_barang', $request->nama_barang)
            ->where('warna', $request->warna)
            ->where('ukuran', $request->ukuran)
            ->where('jenis_kaos', $request->jenis_kaos)
            ->first();

        if ($existing) {
            // Ambil stok dari barang_masuk
            $stokMasuk = BarangMasuk::where('nama_barang', $request->nama_barang)->sum('jumlah');

            $stokBaru = $request->stok ?? $stokMasuk;
            $existing->stok += $stokBaru;

            $existing->harga_satuan = $request->harga_satuan;
            $existing->harga_modal  = $request->harga_modal;
            $existing->harga_jual   = $request->harga_jual;
            $existing->harga_diskon = $request->harga_diskon;
            $existing->lokasi       = $request->lokasi;
            $existing->save();

            return redirect()->route('barang.index')->with('success', 'Stok barang diperbarui.');
        }

        // Simpan barang baru
        Barang::create([
            'kode_barang'    => 'BRG-' . mt_rand(100000, 999999),
            'nama_barang'    => $request->nama_barang,
            'satuan'         => $request->satuan,
            'stok'           => $request->stok,
            'harga_satuan'   => $request->harga_satuan,
            'harga_modal'    => $request->harga_modal,
            'harga_jual'     => $request->harga_jual,
            'harga_diskon'   => $request->harga_diskon,
            'warna'          => $request->warna,
            'ukuran'         => $request->ukuran,
            'jenis_kaos'     => $request->jenis_kaos,
            'lokasi'         => $request->lokasi,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang baru berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        $jenisKaosOptions = ['Lengan Pendek', 'Lengan Panjang', 'Tunik', 'Reglan', 'Kombinasi', 'Lengan 3/4', 'Lengan 7/8'];
        return view('barang.edit', compact('barang', 'jenisKaosOptions'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required',
            'satuan'      => 'required',
            'stok'        => 'required|numeric|min:0',
            'harga_satuan'=> 'required|numeric|min:0',
            'harga_modal' => 'nullable|numeric',
            'harga_jual'  => 'nullable|numeric',
            'harga_diskon'=> 'nullable|numeric',
            'warna'       => 'nullable|string',
            'ukuran'      => 'nullable|string',
            'jenis_kaos'  => 'nullable|string',
            'lokasi'      => 'nullable|string',
        ]);

        $barang->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
