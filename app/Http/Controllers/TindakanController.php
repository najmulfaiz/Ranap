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
            if($tarif->kelas) {
                $nama = $tarif->nama . ' (' . $tarif->kelas . ')';
            } else {
                $nama = $tarif->nama;
            }
            
            $res [] = [
                'id' => $tarif->id,
                'nama' => $nama,
                'value' => $nama,
                'tarif' => $tarif->tarif
            ];
        }

        return response()->json($res);
    }

    public function api($id, $kelas = null)
    {
        if($kelas) {
            $records = Tarif::where('jenis_tarif_id', $id)
                            ->where('kelas', $kelas)
                            ->orderBy('nama')
                            ->get();
        } else {
            $records = Tarif::where('jenis_tarif_id', $id)
                            ->orderBy('nama')
                            ->get();
        }

        return response()->json($records);
    }
}
