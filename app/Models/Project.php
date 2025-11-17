<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
   protected $fillable = [
    'title',
    'slug',
    'description',
    'tech_stack',
    'thumbnail',
    'github_link',
    'live_link',
    'status',
];

}
