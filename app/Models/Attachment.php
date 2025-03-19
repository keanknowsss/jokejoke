<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory;

    public function attachable() {
        return $this->morphTo();
    }

    public function title() {
        return basename($this->path);
    }

    public function size() {
        // bytes
        $size = Storage::disk('public')->size($this->path);

        // check if converted MB value is less than 1, only then convert to KB
        if (($size / (1024 * 1024)) < 1) {
            $size = number_format($size / 1024, 2);
            return "{$size} KB";
        } else {
            $size = number_format($size / (1024 * 1024), 2);
            return "{$size} MB" ;
        }
    }

    protected $fillable = [
        'attachable_id',
        'attachable_type',  // post, comment
        'path',
        'file_type'         // file, image
    ];
}
