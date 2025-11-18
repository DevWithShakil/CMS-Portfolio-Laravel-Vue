<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $fillable = [
        'site_title',
        'hero_title',
        'hero_subtitle',
        'about',
        'profile_image',
        'facebook',
        'youtube',
        'github',
        'linkedin',
        'resume_file'
    ];
}
