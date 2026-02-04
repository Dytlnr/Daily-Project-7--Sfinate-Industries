<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuks = BarangMasuk::with('barang')->latest()->get();
        return view('barang_masuk.index', compact('barangMasuks'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('barang_masuk.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'    => 'required|string|max:255',
            'jumlah'         => 'required|numeric|min:1',
            'harga_modal'    => 'nullable|numeric',
            'supplier'       => 'nullable|string|max:255',
            'tanggal_masuk'  => 'required|date',
            'keterangan'     => 'nullable|string',
        ]);

        // Cari barang berdasarkan nama_barang
        $barang = Barang::where('nama_barang', $request->nama_barang)->first();

        if (!$barang) {
            // Kalau belum ada → buat barang baru otomatis
            $barang = Barang::create([
                'kode_barang'   => 'BRG-' . mt_rand(100000, 999999),
                'nama_barang'   => $request->nama_barang,
                'stok'          => 0,
                'satuan'        => 'pcs',
                'harga_modal'   => $request->harga_modal ?? 0,
                'harga_satuan'  => 0,
                'harga_jual'    => 0,
                'harga_diskon'  => 0,
            ]);
        }

        // Tambahkan ke tabel barang_masuk (tanpa update stok barang)
        BarangMasuk::create([
            'barang_id'     => $barang->id,
            'kode_masuk'    => 'BM-' . mt_rand(100000, 999999),
            'nama_barang'   => $request->nama_barang,
            'jumlah'        => $request->jumlah,
            'harga_modal'   => $request->harga_modal,
            'supplier'      => $request->supplier,
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan'    => $request->keterangan,
        ]);

        return redirect()->route('barang_masuk.index')->with('success', 'Data barang masuk berhasil disimpan tanpa mengubah stok.');
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        $barangMasuk->delete();

        return redirect()->route('barang_masuk.index')->with('success', 'Data barang masuk berhasil dihapus broo!');
    }
}
