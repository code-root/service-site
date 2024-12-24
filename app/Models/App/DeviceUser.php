<?php

namespace App\Models\App;

use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceUser extends Model
{
    use HasFactory ;

        protected $fillable = [
            'device_type' ,
            'device_token',
            'device_name' ,
            'device_os' ,
            'device_version' ,
            'device_browser' ,
            'device_browser_version' ,
            'device_ip' ,
            'is_mobile' ,
            'is_tablet' ,
            'is_desktop' ,
            'is_bot' ,
            'order_id'
    ];

    public function order()
    {
        return $this->hasOne(ServiceOrder::class);
    }
}
