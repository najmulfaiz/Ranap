<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimulasiController extends Controller
{
    function index()
    {
        return view('simulasi.index');
    }
}
