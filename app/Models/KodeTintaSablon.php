<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeTintaSablon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeTintaSablon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeTintaSablon query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeTintaSablon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeTintaSablon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeTintaSablon whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class KodeTintaSablon extends Model
{
    protected $table = 'kode_tinta_sablon';
}
