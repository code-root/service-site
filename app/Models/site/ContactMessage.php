<?php

namespace App\Models\site;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'tr_token',
        'email',
        'phone',
        'subject',
        'description',
        'ip',
        'user_agent',
        'platform',
        'location',
        'country',
    ];
}
