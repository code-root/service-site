<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * الحقول التي يمكن تعبئتها (Mass Assignment).
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'location',
        'phone',
        'email',
        'activation_code',
        'program_id',
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
        'activation_code' => 'string',
    ];

    /**
     * العلاقة مع نموذج البرنامج (Program).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * العلاقة مع نموذج الرخصة (License).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function licenses()
    {
        return $this->hasMany(License::class);
    }
}
