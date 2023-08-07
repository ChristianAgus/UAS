<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'core_group_id', 'ms_plan_id', 'name', 'username', 'email','password', 'title',
        'isActive', 'isApproval', 'approvalOrder', 'coreHeadApp', 'nik', 'isHead',
        'avatar', 'doc_old', 'plantMan', 'phone', 'address', 'ext', 'background', 'user_sig', 'dashboard_thema',
        'company', 'job_position', 'first_name', 'last_name', 'custom_ca_company', 'available_ca_request', 'default_ca_request', 'no_ktp',
        'no_passport', 'tgl_berlaku', 'tgl_lahir', 'tahun_lahir'
    ];
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function group()
    {
        return $this->belongsTo('App\CoreGroup', 'core_group_id');
    }

    public function MsPlan()
    {
        return $this->belongsTo('App\MsPlan', 'ms_plan_id');
    }

    public function assetRequestPeserta()
    {
        return $this->hasMany('App\AssetRequestPeserta');
    }

    public function assetRequestRequestor()
    {
        return $this->hasMany('App\AssetRequest');
    }

    public function QaProcedure()
    {
        return $this->hasMany('App\QaProcedure');
    }

    public function QaProcedureUserApprove()
    {
        return $this->hasMany('App\QaProcedureUserApprove');
    }

    public function Tiketing()
    {
        return $this->hasMany('App\Ticketing');
    }

    public function GaStokUser()
    {
        return $this->hasMany('App\GaStokUser');
    }

    public function userTiket()
    {
        return $this->hasMany('App\TicketingUser');
    }

    public function usermaps()
    {
    	return $this->hasMany('App\UserMap', 'user_id');
    }
}
