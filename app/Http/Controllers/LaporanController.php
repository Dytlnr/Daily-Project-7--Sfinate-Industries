<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\Orderan;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use PDF;

class LaporanController extends Controller
{
    public function index()
    {
        $data = Orderan::with('details.barang')
            ->orderBy('tanggal', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('laporan.index', compact('data'));
    }

    public function filter(Request $request)
    {
        $start = $request->start_date ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : null;
        $end   = $request->end_date ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : null;

        $query = Orderan::with(['details.barang']);

        if ($start && $end) {
            $query->whereBetween('tanggal', [$start, $end]);
        }

        if ($request->filled('nama_pelanggan')) {
            $query->where('nama_pelanggan', 'like', '%' . $request->nama_pelanggan . '%');
        }

        if ($request->filled('status_bayar')) {
            $query->where('status_bayar', $request->status_bayar);
        }

        $data = $query->orderBy('tanggal', 'desc')->paginate(10)->withQueryString();

        $rekap = [
            'total_qty' => $data->pluck('details')->flatten()->sum('jumlah'),
            'total_omzet' => $data->pluck('details')->flatten()->sum('subtotal'),
            'total_diskon' => $data->pluck('diskon')->sum(),
            'total_dp' => $data->pluck('dp')->sum(),
            'total_piutang' => $data->where('status_bayar', 'belum')->pluck('harga_total')->sum()
        ];

        return view('laporan.index', compact(
            'data',
            'rekap'
        ));
    }

    public function exportExcel(Request $request)
    {
        $status_bayar = $request->status_bayar;
        return Excel::download(new LaporanExport($status_bayar), 'laporan_penjualan.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $data = Orderan::with('details.barang')
            ->filterByRequest($request)
            ->get();

        $pdf = PDF::loadView('laporan.export-pdf', compact('data'));
        return $pdf->download('laporan_penjualan.pdf');
    }

    public function piutang()
    {
        $data = Orderan::where('status_bayar', 'belum')
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('laporan.piutang', compact('data'));
    }
    public function barangTerjual(Request $request)
    {
        $start = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : null;
        $end   = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : null;

        $query = DB::table('orderan_details')
            ->join('orderans', 'orderans.id', '=', 'orderan_details.orderan_id')
            ->join('barangs', 'barangs.id', '=', 'orderan_details.barang_id')
            ->select('barangs.nama_barang', DB::raw('SUM(orderan_details.jumlah) as total_jumlah'), DB::raw('SUM(orderan_details.subtotal) as total_omzet'))
            ->groupBy('barangs.nama_barang')
            ->orderBy('total_jumlah', 'desc');

        if ($start && $end) {
            $query->whereBetween('orderans.tanggal', [$start, $end]);
        }

        $data = $query->paginate(10)->withQueryString();

        return view('laporan.barang-terjual', compact('data'));
    }

    public function pelanggan(Request $request)
    {
        $start = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d') : null;
        $end   = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d') : null;

        $query = DB::table('orderans')
            ->join('orderan_details', 'orderans.id', '=', 'orderan_details.orderan_id')
            ->leftJoin('members', 'orderans.member_id', '=', 'members.id')
            ->leftJoin('point_members', 'members.id', '=', 'point_members.member_id')
            ->select(
                'orderans.nama_pelanggan',
                'orderans.member_id',
                DB::raw('COALESCE(point_members.total_point, 0) as total_point'),
                DB::raw('COUNT(DISTINCT orderans.id) as total_order'),
                DB::raw('SUM(orderan_details.jumlah) as total_barang'),
                DB::raw('SUM(orderan_details.subtotal) as total_omzet')
            )
            ->groupBy('orderans.nama_pelanggan', 'orderans.member_id', 'point_members.total_point')
            ->orderByDesc('total_omzet');

        if ($start && $end) {
            $query->whereBetween('orderans.tanggal', [$start, $end]);
        }

        $data = $query->paginate(10)->withQueryString();

        return view('laporan.pelanggan', compact('data'));
    }

}
