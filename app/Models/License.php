<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    /**
     * الحقول التي يمكن تعبئتها (Mass Assignment).
     *
     * @var array<string>
     */
    protected $fillable = [
        'activation_code',
        'serial_number',
        'client_id',
        'program_id',
        'is_active',
        'purchase_date',
        'expiry_date',
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
        'is_active' => 'boolean',
        'purchase_date' => 'date',
        'expiry_date' => 'date',
    ];

    /**
     * العلاقة مع نموذج العميل (Client).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * العلاقة مع نموذج البرنامج (Program).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

}
