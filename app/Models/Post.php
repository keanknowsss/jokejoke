<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'like_count',
        'comment_count',
        'share_count'
    ];

    protected $casts = [
        'attachments' => 'array'
    ];

    public function attachments() {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
