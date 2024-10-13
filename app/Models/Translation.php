<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        'translatable_type',
        'translatable_id',
        'language_id',
        'key',
        'value',
    ];

    /**
     * Get the language associated with the translation.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the owning translatable model.
     */
    public function translatable()
    {
        return $this->morphTo();
    }
}