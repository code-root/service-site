<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class License extends Model
{

    use HasFactory;

        /**
        * Fields that can be filled (Mass Assignment).

        *
        * @var array<string>
        */
    protected $fillable = [
    'activation_code',
    'serial_number',
    'client_id',
    'program_id',
    'is_active',
    'user_id',
    'purchase_date',
    'expiry_date',
    ];

        /**
        * Fields that should be hidden when converting the model to JSON.
        *
        * @var array<string>
        */
        protected $hidden = [
        'created_at',
        'updated_at',
        ];

        /**
        * Fields that need to be converted to specific data types.

        * @var array<string, string>
        */
        protected $casts = [
        'is_active' => 'boolean',
        'purchase_date' => 'date',
        'expiry_date' => 'date',
        ];

        /**
        * Relationship to Client model.

        * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
        */
        public function client()
        {
        return $this->belongsTo(Client::class);
        }

        /**
        * Relationship to Program model.
        *
        * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
        */
        public function program()
        {
        return $this->belongsTo(Program::class);
        }

}
