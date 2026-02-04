<?php

namespace App\Exports;

use App\Models\Orderan;
use Maatwebsite\Excel\Concerns\FromQuery;

class LaporanExport implements FromQuery
{
    protected $status_bayar;

    public function __construct($status_bayar = null)
    {
        $this->status_bayar = $status_bayar;
    }

    public function query()
    {
        $query = Orderan::query()->select('tanggal', 'status_bayar', 'harga_total');

        if ($this->status_bayar == 'lunas') {
            $query->where('status_bayar', 'lunas');
        } elseif ($this->status_bayar == 'belum') {
            $query->where('status_bayar', 'belum');
        }

        return $query;
    }

    public function headings(): array
    {
        return ['Tanggal', 'Status Bayar', 'Total Harga'];
    }
}
