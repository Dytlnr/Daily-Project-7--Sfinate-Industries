<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisBarangController extends Controller
{
    public function index()
    {
        $gramasi    = DB::table('kode_gramasi')->get();
        $tinta      = DB::table('kode_tinta_sablon')->get();
        $sizeDewasa = DB::table('kode_size_dewasa')->get();
        $sizeAnak   = DB::table('kode_size_anak')->get();
        $warna      = DB::table('kode_jenis_warna')->get();

        return view('jenis_barang.index', compact(
            'gramasi', 'tinta', 'sizeDewasa', 'sizeAnak', 'warna'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:gramasi,tinta,size_dewasa,size_anak,warna',
            'kode' => 'required|unique:' . $this->getTableName($request->jenis) . ',kode',
            'nama' => 'required',
        ]);

        $data = [
            'kode' => $request->kode,
            'nama' => $request->nama,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if (in_array($request->jenis, ['tinta', 'warna'])) {
            $request->validate([
                'harga' => 'required|numeric|min:0',
            ]);
            $data['harga'] = $request->harga;
        }

        DB::table($this->getTableName($request->jenis))->insert($data);

        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:gramasi,tinta,size_dewasa,size_anak,warna',
            'id' => 'required|integer',
        ]);

        DB::table($this->getTableName($request->jenis))->where('id', $request->id)->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }

    private function getTableName($jenis)
    {
        return match ($jenis) {
            'gramasi'       => 'kode_gramasi',
            'tinta'         => 'kode_tinta_sablon',
            'size_dewasa'   => 'kode_size_dewasa',
            'size_anak'     => 'kode_size_anak',
            'warna'         => 'kode_jenis_warna',
            default         => abort(400, 'Jenis tidak valid.'),
        };
    }

    public function update(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:gramasi,tinta,size_dewasa,size_anak,warna',
            'id' => 'required|integer',
            'kode' => 'required',
            'nama' => 'required',
        ]);

        $table = $this->getTableName($request->jenis);

        $exists = DB::table($table)
                    ->where('kode', $request->kode)
                    ->where('id', '!=', $request->id)
                    ->exists();
        if ($exists) {
            return back()->withErrors(['kode' => 'Kode sudah dipakai.']);
        }

        $data = [
            'kode' => $request->kode,
            'nama' => $request->nama,
            'updated_at' => now(),
        ];

        if (in_array($request->jenis, ['tinta', 'warna'])) {
            $request->validate([
                'harga' => 'required|numeric|min:0',
            ]);
            $data['harga'] = $request->harga;
        }

        DB::table($table)
        ->where('id', $request->id)
        ->update($data);

        return back()->with('success', 'Data berhasil diperbarui.');
    }
}
