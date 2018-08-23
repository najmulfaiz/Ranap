<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $fillable = [
        'pendaftaran_id',
        'tarif_id',
        'jenis_tarif_id',
        'tarifrs',
        'tanggal_bayar'
    ];

    public function tarif()
    {
        return $this->belongsTo('App\Tarif');
    }

    public function jenis_tarif()
    {
        return $this->belongsTo('App\JenisTarif');
    }
}
