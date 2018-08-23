<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinces';

    public function kabupaten()
    {
        return $this->hasMany('App\Kabupaten');
    }
}
