<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';
    protected $fillable = [
        'nomr',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'kelurahan_id',
        'golongan_darah'
    ];

    public function pendaftaran()
    {
        return $this->hasMany('App\Pendaftaran', 'nomr', 'nomr');
    }
}
