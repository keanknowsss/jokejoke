<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSummary extends Model
{
    protected $fillable = [
        'user_id',
        'follower_count',
        'following_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
