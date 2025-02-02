<?php

namespace App\Models;

use App\Models\site\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    /**
     * الحقول التي يمكن تعبئتها (Mass Assignment).
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'category_id', // تعديل من 'category' إلى 'category_id'
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

    /**
     * علاقة البرنامج مع الفئة (Category).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
