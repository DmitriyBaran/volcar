<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'file_name',
        'path'
    ];

    /**
     * Відношення зображення до відгуку.
     */
    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
