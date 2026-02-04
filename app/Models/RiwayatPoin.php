<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPoin extends Model
{
    protected $table = 'riwayat_poin';
    
    protected $fillable = [
        'member_id',
        'orderan_id',
        'poin',
        'tipe',
        'keterangan',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function orderan()
    {
        return $this->belongsTo(Orderan::class);
    }
}
