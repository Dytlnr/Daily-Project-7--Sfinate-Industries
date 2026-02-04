<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index()
    {
        $keuangans = Keuangan::latest()->paginate(10);
        $totalMasuk = Keuangan::where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = Keuangan::where('jenis', 'keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        return view('keuangan.index', compact('keuangans', 'totalMasuk', 'totalKeluar', 'saldo'));
    }
}
