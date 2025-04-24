<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model
{
    protected $table = 'banners';

    protected $fillable = [
        'title',
        'image',
        'description',
    ];

    // Define any relationships or additional methods here
}
