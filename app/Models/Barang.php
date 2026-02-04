<?php

namespace App\Models;

use App\Enums\SatuanEnum as EnumsSatuanEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $kode_barang
 * @property string $nama_barang
 * @property EnumsSatuanEnum $satuan
 * @property int $stok
 * @property string $harga_satuan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereHargaSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereKodeBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereNamaBarang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereSatuan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereStok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Barang extends Model
{
    use HasFactory;

    protected $casts = [
        'satuan' => EnumsSatuanEnum::class,
        'harga_satuan' => 'float',
        'harga_modal' => 'float',
        'harga_jual' => 'float',
        'harga_diskon' => 'float',
    ];

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'warna',
        'ukuran',
        'jenis_kaos',
        'satuan',
        'stok',
        'harga_modal',
        'harga_jual',
        'harga_diskon',
        'harga_satuan',
        'lokasi'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
