<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarif;

class TindakanController extends Controller
{
    public function autocomplete($id, $kelas = null)
    {
        if($kelas) {
            $tarif = Tarif::where('jenis_tarif_id', $id)
                        ->where('nama', 'like', '%' . $_GET['term'] . '%')
                        ->where('kelas', '=', $kelas)
                        ->get();
        } else {
            $tarif = Tarif::where('jenis_tarif_id', $id)
                        ->where('nama', 'like', '%' . $_GET['term'] . '%')
                        ->get();
        }
        
        $res = [];
        foreach($tarif as $tarif) {
            $res [] = [
                'id' => $tarif->id,
                'nama' => $tarif->nama . ' (' . $tarif->kelas . ')',
                'value' => $tarif->nama . ' (' . $tarif->kelas . ')',
                'tarif' => $tarif->tarif
            ];
        }

        return response()->json($res);
    }
}
