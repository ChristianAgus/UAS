<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderList extends Model
{
    protected $table = 'order_list';

    protected $fillable = [
        'order_id',
        'device_code',
        'device_name',
        'device_price',
        'qty',
        'discount',
        'sub_total',
    ];

    public function order()
    {
        return $this->belongsTo(OrderMaster::class, 'order_id');
    }
}



