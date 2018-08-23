<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class obat extends Model
{
    protected $table = 'obat';
    protected $fillable = [
        'nama',
        'hna'
    ];
}
