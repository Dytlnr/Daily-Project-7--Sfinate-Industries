<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaturan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaturan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaturan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaturan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaturan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaturan whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaturan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pengaturan whereValue($value)
 * @mixin \Eloquent
 */
class Pengaturan extends Model
{
    protected $fillable = ['nama_perusahaan', 'alamat_1', 'alamat_2', 'logo', 'logo_bank'];
}
