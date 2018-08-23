<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $fillable = [
        'tanggal',
        'pendaftaran_id',
        'total',
        'pembayaran_id'
    ];

    public function penjualan_detail()
    {
        return $this->hasMany('App\PenjualanDetail');
    }

    public function pendaftaran()
    {
        return $this->belongsTo('App\Pendaftaran');
    }
}
