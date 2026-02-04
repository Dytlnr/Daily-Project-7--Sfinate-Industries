<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $orderan_id
 * @property int $barang_id
 * @property int $jumlah
 * @property string $harga_satuan
 * @property string $subtotal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barang $barang
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail whereBarangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail whereHargaSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail whereOrderanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderanDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'orderan_id',
        'barang_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'dp',
        'diskon',
        'subtotal_kotor',
        'kd_gramasi',
        'kd_tinta',
        'kd_size_dewasa',
        'kd_size_anak',
        'warna',
        'jasa_sablon',
    ];

    public function barang()
    {
        return $this->belongsTo(\App\Models\Barang::class, 'barang_id');
    }

    public function gramasi()
    {
        return $this->belongsTo(KodeGramasi::class, 'kd_gramasi');
    }

    public function tinta()
    {
        return $this->belongsTo(KodeTintaSablon::class, 'kd_tinta');
    }

    public function sizeDewasa()
    {
        return $this->belongsTo(KodeSizeDewasa::class, 'kd_size_dewasa');
    }

    public function sizeAnak()
    {
        return $this->belongsTo(KodeSizeAnak::class, 'kd_size_anak');
    }
    public function jenisWarna()
    {
        return $this->belongsTo(KodeJenisWarna::class, 'warna');
    }

    public function details()
    {
        return $this->hasMany(OrderanDetail::class, 'orderan_id');
    }
}
