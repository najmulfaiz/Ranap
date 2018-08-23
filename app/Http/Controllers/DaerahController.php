<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provinsi;
use App\Kabupaten;
use App\Kecamatan;
use App\Kelurahan;

class DaerahController extends Controller
{
    public function provinsi()
    {
        $provinsi = Provinsi::orderBy('name')->get();

        return response()->json($provinsi);
    }

    public function kabupaten($id = null)
    {
        if($id) {
            $kabupaten = Kabupaten::where('province_id', $id)->orderBy('name')->get();
        } else {
            $kabupaten = Kabupaten::orderBy('name')->get();
        }

        return response()->json($kabupaten);
    }

    public function kecamatan($id = null)
    {
        if($id) {
            $kecamatan = Kecamatan::where('regency_id', $id)->orderBy('name')->get();
        } else {
            $kecamatan = Kecamatan::orderBy('name')->get();
        }

        return response()->json($kecamatan);
    }

    public function kelurahan($id = null)
    {
        if($id) {
            $kelurahan = Kelurahan::where('district_id', $id)->orderBy('name')->get();
        } else {
            $kelurahan = Kelurahan::orderBy('name')->get();
        }

        return response()->json($kelurahan);
    }
}
