<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeGramasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeGramasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeGramasi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeGramasi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeGramasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KodeGramasi whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class KodeGramasi extends Model
{
    protected $table = 'kode_gramasi';
}
