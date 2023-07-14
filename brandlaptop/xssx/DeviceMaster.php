<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceMaster extends Model
{
    protected $table = 'device_master';
     protected $fillable = [
        'device_code',
        'device_name',
        'device_price',
        'device_description',
        'device_status',
    ];
}
