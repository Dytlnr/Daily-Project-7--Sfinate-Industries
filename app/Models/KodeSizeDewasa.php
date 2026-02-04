<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeDewasa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeDewasa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeDewasa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeDewasa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeDewasa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeSizeDewasa whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class KodeSizeDewasa extends Model
{
    protected $table = 'kode_size_dewasa';
}
