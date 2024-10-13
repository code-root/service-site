<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LanguageTrait;

class AppVersion extends Model {
    use HasFactory , LanguageTrait;

    protected $table = 'app_versions';
    public $fillable = ['version_number', 'additional_field', 'description', 'status'];

}
