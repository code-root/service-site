<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'name',
        'email',
        'phone',
        'message',
        'ip_address',
        'serial',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}

