<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    public function attachable() {
        return $this->morphTo();
    }

    protected $fillable = [
        'attachable_id',
        'attachable_type',  // post, comment
        'path',
        'file_type'         // file, image
    ];
}
