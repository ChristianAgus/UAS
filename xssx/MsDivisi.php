<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MsDivisi extends Model
{
    protected $fillable = [
        'name', 'code', 'company'
    ];

    public function MsDepart()
    {
        return $this->hasMany('App\MsDepart');
    }

    public function mapUser()
    {
        return $this->hasMany('App\UserMap');
    }


    public function AssetReq()
    {
        return $this->hasMany('App\AssetRequest');
    }
}
