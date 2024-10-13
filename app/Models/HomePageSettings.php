<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageSettings extends Model
{
    use HasFactory;

    protected $table = 'home_page_settings';

    protected $fillable = [
        'title1',
        'title2',
        'title3',
        'image_description',
        'title_description',
        'description',
    ];
}
