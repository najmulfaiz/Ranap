<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pendaftaran;

class RanapController extends Controller
{
    public function datatable()
    {
        $find = $_GET['search']['value'] ? $_GET['search']['value'] : '';
        $pendaftaran = Pendaftaran::where('nomr', 'like', '%' . $find . '%')
                        ->whereNull('tanggal_keluar')
                        ->whereHas('pasien', function($q) use($find){
                            $q->where('nama', 'like', '%' . $find . '%');
                        })
                        ->offset($_GET['start'])
                        ->limit($_GET['length'])
                        ->orderBy('pendaftaran.id')
                        ->get();
        
        $recordsTotal = Pendaftaran::count();
        $recordsFiltered = count($pendaftaran);

        $data = [];
        foreach($pendaftaran as $index => $pendaftaran) {
            $data[] = [
                ($index + 1),
                $pendaftaran->pasien->nomr . ' - ' . $pendaftaran->pasien->nama,
                $pendaftaran->ruang->nama,
                date('d-m-Y h:i:s', strtotime($pendaftaran->tanggal_masuk)),
                '<a href="' . route('ranap.show', $pendaftaran->id) . '" class="btn btn-info btn-sm" data-id="' . $pendaftaran->id . '">Proses</a>'
            ];
        }

        $res = [
            'draw' => $_GET['draw'],
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ];

        return response()->json($res);
    }

    public function index()
    {
        return view('ranap.index');
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        return view('ranap.show', compact('pendaftaran'));
    }

    public function tindakan($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        return view('ranap.tindakan', compact('pendaftaran'));
    }
}
