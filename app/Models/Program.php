<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    /**
     * الحقول التي يمكن تعبئتها (Mass Assignment).
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
    ];

    /**
     * الحقول التي يجب إخفاؤها عند تحويل النموذج إلى JSON.
     *
     * @var array<string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * الحقول التي يجب تحويلها إلى أنواع بيانات محددة.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
    ];
}
