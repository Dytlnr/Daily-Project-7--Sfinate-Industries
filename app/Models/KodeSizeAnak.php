<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeAnak newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeAnak newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeAnak query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeAnak whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeAnak whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeAnak whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class KodeSizeAnak extends Model
{
    protected $table = 'kode_size_anak';
}
