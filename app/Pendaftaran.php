<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';
    protected $fillable = [
        'nomr',
        'kelas_id',
        'ruang_id',
        'dokter_id',
        'penjamin_id',
        'diagnosis_masuk',
        'diagnosis_keluar',
        'tanggal_masuk',
        'tanggal_keluar',
        'resume'
    ];

    public function pasien()
    {
        return $this->belongsTo('App\Pasien', 'nomr', 'nomr');
    }

    public function ruang()
    {
        return $this->belongsTo('App\Ruang');
    }

    public function penjamin()
    {
        return $this->belongsTo('App\Penjamin');
    }

    public function dokter()
    {
        return $this->belongsTo('App\Dokter');
    }
}
