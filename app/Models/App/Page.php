<?php

namespace App\Models\App;

use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model {

    use HasFactory , LanguageTrait;
    public $fillable = [
        'meta_ar',
        'meta_en' ,
        'name_ar' ,
        'name_en',
        'status',
        'description_ar',
        'description_en'
    ];

}
