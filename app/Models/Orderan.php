<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $kode_order
 * @property string $nama_pelanggan
 * @property int $harga_total
 * @property int|null $member_id
 * @property string $status_bayar
 * @property string $tanggal
 * @property string|null $tanggal_selesai
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderanDetail> $details
 * @property-read int|null $details_count
 * @property-read \App\Models\Pembayaran|null $pembayaran
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereHargaTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereKodeOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereNamaPelanggan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereStatusBayar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Orderan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Orderan extends Model
{
    use HasFactory;

    protected $table = 'orderans';

    protected $fillable = [
        'kode_order',
        'nama_pelanggan',
        'harga_total',
        'status_bayar',
        'tanggal',
        'tanggal_selesai',
        'member_id',
        'dp',
        'diskon',
    ];

    public function details()
    {
        return $this->hasMany(OrderanDetail::class);
    }

    // 🔽 Relasi ke pembayaran
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

}
