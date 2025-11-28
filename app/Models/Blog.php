<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;
     protected $fillable = [
        'category_id',
        'title',
        'slug',
        'content',
        'thumbnail',
        'status',
        'is_published',
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }
}
