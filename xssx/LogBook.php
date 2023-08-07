<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class LogBook extends Model
{
protected $table = 'logbooks';

    protected $fillable = [
        'name', 'company', 'name_visitee', 'division_visitee', 'tujuan_kunjungan',
        'relation_type', 'no_telp', 'email', 'jam',
    ];

    public function visitdivisi()
    {
        return $this->belongsTo('App\User', 'name_visitee');
    }

}