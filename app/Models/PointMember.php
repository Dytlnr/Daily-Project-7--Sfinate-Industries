<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointMember extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'total_point'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
