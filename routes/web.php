<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Menu 1. Data Barang
    // Route::resource('barang', BarangController::class);
    // Route::resource('barang', BarangController::class)->except(['edit','update','show']);
    Route::resource('barang', BarangController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::get('/jenis-barang', [JenisBarangController::class, 'index'])->name('jenis-barang.index');
    Route::post('/jenis-barang/store', [JenisBarangController::class, 'store'])->name('jenis-barang.store');
    Route::post('/jenis-barang/delete', [JenisBarangController::class, 'destroy'])->name('jenis-barang.delete');
    Route::post('/jenis-barang/update', [JenisBarangController::class, 'update'])->name('jenis-barang.update');

    Route::resource('barang-masuk', BarangMasukController::class)
        ->only(['index', 'create', 'store', 'destroy'])
        ->names([
            'index'   => 'barang_masuk.index',
            'create'  => 'barang_masuk.create',
            'store'   => 'barang_masuk.store',
            'destroy' => 'barang_masuk.destroy',
        ]);


    // Menu 2. Kasir
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
    Route::post('/kasir/tambah', [KasirController::class, 'tambahBarang'])->name('kasir.tambah');
    Route::post('/kasir/simpan', [KasirController::class, 'simpanTransaksi'])->name('kasir.simpan');
    Route::post('/kasir/reset', [KasirController::class, 'resetKeranjang'])->name('kasir.reset');
    Route::get('/data-orderan', [KasirController::class, 'dataOrderan'])->name('kasir.data-orderan');
    // Route::post('/bayar/{id}', [KasirController::class, 'bayarOrderan'])->name('kasir.bayar');
    Route::get('/kasir/data', [KasirController::class, 'dataOrderan'])->name('kasir.data');
    // Route::post('/kasir/bayar', [KasirController::class, 'bayar'])->name('kasir.bayar');
    Route::delete('/kasir/hapus/{id}', [KasirController::class, 'hapus'])->name('kasir.hapus');
    Route::get('/kasir/edit/{id}', [KasirController::class, 'edit'])->name('kasir.edit'); // opsional
    Route::put('/kasir/update/{id}', [KasirController::class, 'update'])->name('kasir.update');
    Route::post('/bayar/{id}', [KasirController::class, 'bayarOrderan'])->name('kasir.bayar');

    Route::get('/kasir/nota/{id}', [KasirController::class, 'notaPembayaran'])->name('kasir.nota');
    Route::get('/orders/{order}/export-pdf', [KasirController::class, 'exportPdf'])->name('orders.export-pdf');
    // Route::get('/orders/{order}/generate-pdf', [KasirController::class, 'generatePdf'])->name('orders.generate-pdf');

    Route::post('/kasir/tambah-jasa-sablon', [KasirController::class, 'tambahJasaSablon'])->name('kasir.tambahJasaSablon');
    Route::post('/kasir/simpan-jasa-sablon', [KasirController::class, 'simpanJasaSablon'])->name('kasir.simpanJasaSablon');
    Route::post('/kasir/reset-keranjang-jasa', [KasirController::class, 'resetKeranjangJasa'])->name('kasir.resetKeranjangJasa');







    // Menu 3. User (untuk admin)
    Route::resource('user', UserController::class);

    // Menu 4. Member
    Route::resource('members', MemberController::class);
    Route::get('/member/{id}/tukar-poin', [MemberController::class, 'formTukarPoin'])->name('member.tukar.form');
    Route::post('/member/{id}/tukar-poin', [MemberController::class, 'tukarPoin'])->name('member.tukar.proses');
    Route::get('/member/{id}/riwayat-poin', [MemberController::class, 'riwayatPoin'])->name('member.poin.riwayat');

    // Menu 5. Laporan
    Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/filter', [LaporanController::class, 'filter'])->name('laporan.filter');
    Route::get('/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');
    Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
    Route::get('/laporan/piutang', [LaporanController::class, 'piutang'])->name('laporan.piutang');
    Route::get('/laporan/barang-terjual', [LaporanController::class, 'barangTerjual'])->name('laporan.barang');
    Route::get('/laporan/pelanggan', [LaporanController::class, 'pelanggan'])->name('laporan.pelanggan');
    // Route::get('/laporan/pembayaran', [LaporanController::class, 'pembayaran'])->name('laporan.pembayaran');


    // Menu 6. Sistem Keuangan
    Route::get('keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
    Route::get('keuangan/create', [KeuanganController::class, 'create'])->name('keuangan.create');
    Route::post('keuangan', [KeuanganController::class, 'store'])->name('keuangan.store');

    // Menu 7. Pengaturan
    Route::get('pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('pengaturan/simpan', [PengaturanController::class, 'simpan'])->name('pengaturan.simpan');
    Route::get('/poin', [PengaturanController::class, 'poin'])->name('pengaturan.poin.index');
    Route::get('/poin/create', [PengaturanController::class, 'createPoin'])->name('poin.create');
    Route::post('/poin', [PengaturanController::class, 'storePoin'])->name('poin.store');
    Route::post('/poin/update', [PengaturanController::class, 'updatePoin'])->name('pengaturan.poin.update');
    Route::get('/pengaturan/umum', [PengaturanController::class, 'umum'])->name('pengaturan.umum.index');
    Route::post('/pengaturan/umum', [PengaturanController::class, 'simpanUmum'])->name('pengaturan.umum.simpan');




});

require __DIR__.'/auth.php';
