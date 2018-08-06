<?php

use Illuminate\Database\Seeder;
use App\JenisTarif;

class JenisTarifTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis_tarif = ['Rawat Inap', 'Laboratorium'];

        foreach($jenis_tarif as $jenis_tarif) {
            JenisTarif::create([
                'nama' => $jenis_tarif
            ]);
        }
    }
}
