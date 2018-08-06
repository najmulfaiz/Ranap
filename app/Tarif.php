<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $table = 'tarif';
    protected $fillable = [
        'nama',
        'jenis_tarif_id',
        'kelas',
        'tarif'
    ];

    public function jenis_tarif()
    {
        return $this->belongsTo('App\JenisTarif');
    }
}
