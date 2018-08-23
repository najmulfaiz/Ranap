<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pasien;

class PasienController extends Controller
{
    public function api()
    {
        $nomr = isset($_GET['nomr']) ? $_GET['nomr'] : '';
        $pasien = Pasien::where('nomr', $nomr)->get();

        return response()->json($pasien);
    }
}
