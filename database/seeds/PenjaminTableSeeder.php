<?php

use Illuminate\Database\Seeder;
use App\Penjamin;

class PenjaminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $penjamin = ['UMUM', 'BPJS PBI', 'BPJS NON PBI', 'JAMKESDA'];
        
        foreach($penjamin as $penjamin) {
            Penjamin::create([
                'nama' => $penjamin
            ]);
        }
    }
}
