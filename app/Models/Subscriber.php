<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
     // تحديد الجدول إذا كان مختلفًا عن الاسم الافتراضي
    protected $table = 'subscribers';

    // تحديد الأعمدة القابلة للتعبئة
    protected $fillable = [
        'email',
    ];
    
}
