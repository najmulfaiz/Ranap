<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pendaftaran;
use App\Pembayaran;

class LaboratoriumController extends Controller
{
    public function index()
    {
        return view('laboratorium.index');
    }

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
                '<a href="' . route('laboratorium.show', $pendaftaran->id) . '" class="btn btn-info btn-sm" data-id="' . $pendaftaran->id . '">Riwayat</a>
                &nbsp; <a href="' . route('laboratorium.tindakan', $pendaftaran->id) . '" class="btn btn-info btn-sm" data-id="' . $pendaftaran->id . '">Proses</a>'
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

    public function tindakan($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        return view('laboratorium.tindakan', compact('pendaftaran'));
    }

    public function show($id)
    {
        $pendaftaran = \App\Pendaftaran::findOrFail($id);

        return view('laboratorium.show', compact('pendaftaran'));
    }

    public function datatableShow($id)
    {
        $find = $_GET['search']['value'] ? $_GET['search']['value'] : '';
        $pembayaran = Pembayaran::where('pendaftaran_id', $id)
                        ->where('jenis_tarif_id', 2)
                        ->whereHas('tarif', function($q) use($find){
                            $q->where('nama', 'like', '%' . $find . '%');
                        })
                        ->offset($_GET['start'])
                        ->limit($_GET['length'])
                        ->orderBy('pembayaran.id')
                        ->get();
        
        $recordsTotal = Pembayaran::count();
        $recordsFiltered = count($pembayaran);

        $data = [];
        foreach($pembayaran as $index => $pembayaran) {
            $data[] = [
                ($index + 1),
                $pembayaran->tarif->nama,
                $pembayaran->tarif->jenis_tarif->nama,
                date('d-m-Y h:i:s', strtotime($pembayaran->created_at)),
                $pembayaran->tarifrs
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
}
