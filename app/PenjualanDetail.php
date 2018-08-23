<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    protected $table = 'penjualan_detail';
    protected $fillable = [
        'penjualan_id',
        'obat_id',
        'harga',
        'jumlah',
    ];

    public function penjualan()
    {
        return $this->belongsTo('App\Penjualan');
    }

    public function obat()
    {
        return $this->belongsTo('App\Obat');
    }
}
