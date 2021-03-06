<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    protected $table = 'ruang';
    protected $fillable = [
        'nama',
        'kelas'
    ];

    public function pendaftaran()
    {
        return $this->hasMany('App\Pendaftaran');
    }
}
