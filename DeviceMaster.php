<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class DeviceMaster extends Model
{

    protected $table = 'device_master';

    protected $fillable = [
        'nama_device',
        'status',
        'totalassetdevice',
    ];

    public function deviceProduks()
    {
        return $this->hasMany(DeviceProduk::class, 'master_device_id');
    }
}
