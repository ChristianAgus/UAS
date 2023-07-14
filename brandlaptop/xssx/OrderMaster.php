<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMaster extends Model
{
    protected $table = 'order_master';

    protected $fillable = [
        'customer_name',
        'customer_address',
        'file_bukti_bayar',
        'total_price',
    ];
}