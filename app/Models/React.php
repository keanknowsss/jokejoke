<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class React extends Model
{
    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $fillable = [
        'post_id',
        'user_id',
        'is_active'
    ];


    public function scopeAllActive($query)
    {
        return $query->where('is_active', true);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
