<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisTarif extends Model
{
    protected $table = 'jenis_tarif';
    protected $fillable = [
        'nama'
    ];

    public function tarif()
    {
        return $this->hasMany('App\Tarif');
    }
}
