<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdukLaptop extends Model
{
    protected $fillable = ['brand_laptop_id', 'nama_laptop','price','discount', 'quantity', 'total', 'file'];

    public function brandLaptop()
    {
        return $this->belongsTo(BrandLaptop::class, 'brand_laptop_id');
    }
}