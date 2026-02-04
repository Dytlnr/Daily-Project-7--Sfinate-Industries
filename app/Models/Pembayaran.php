<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $orderan_id
 * @property string $no_nota
 * @property string $tanggal_pembayaran
 * @property string $jumlah_bayar
 * @property string $metode
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Orderan $orderan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereJumlahBayar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereMetode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereNoNota($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereOrderanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereTanggalPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pembayaran whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';

    protected $casts = [
        'is_dp' => 'boolean',
        'tanggal_pembayaran' => 'datetime',
        'jatuh_tempo' => 'datetime'
    ];

    protected $fillable = [
        'orderan_id',
        'no_nota',
        'jumlah_bayar',
        'tanggal_pembayaran',
        'metode',
        'keterangan',
        'is_dp',
        'jenis_pembayaran',
        'jatuh_tempo',
        'no_telepon',
        'nama_orderan'
    ];

    public function orderan()
    {
        return $this->belongsTo(Orderan::class, 'orderan_id');
    }

}
