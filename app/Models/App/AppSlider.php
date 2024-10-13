<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSlider extends Model
{
    protected $table = 'app_sliders';
        
    use HasFactory ;
        public $fillable = ['name_ar', 'name_en',  'image', 'details' , 'status'];

   
}
