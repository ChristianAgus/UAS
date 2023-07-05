<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrandLaptop extends Model
{
    protected $fillable = ['nama_brand', 'description', 'status'];

    public function produkLaptop()
    {
        return $this->hasMany(ProdukLaptop::class, 'brand_laptop_id');
    }
}