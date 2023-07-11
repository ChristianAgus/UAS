<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceProduk extends Model
{

    protected $table = 'device_produk';

    protected $fillable = [
        'master_device_id',
        'nama_device',
        'price',
        'discount',
        'quantity',
        'total',
        'file',
    ];

    public function masterDevice()
    {
        return $this->belongsTo(DeviceMaster::class, 'master_device_id');
    }
}
