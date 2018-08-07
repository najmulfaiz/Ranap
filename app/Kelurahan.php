<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'villages';

    public function kecamatan()
    {
        return $this->belongsTo('App\Kecamatan');
    }
}
