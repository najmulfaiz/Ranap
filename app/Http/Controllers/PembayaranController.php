<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembayaran;
use App\Pendaftaran;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pembayaran.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pendaftaran = \App\Pendaftaran::findOrFail($id);
        $total_tagihan = Pembayaran::where('pendaftaran_id', $id)->sum('tarifrs');
        $pembayaran = Pembayaran::where('pendaftaran_id', $id)
                                ->orderBy('created_at')
                                ->get();

        return view('pembayaran.show', compact('pendaftaran', 'pembayaran', 'total_tagihan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function tindakan(Request $request)
    {
        foreach($request['tarif_id'] as $index => $tarif_id) {
            Pembayaran::create([
                'pendaftaran_id' => $request['pendaftaran_id'],
                'tarif_id' => $tarif_id,
                'jenis_tarif_id' => $request['jenis_tarif_id'],
                'tarifrs' => $request['tarif'][$index]
            ]);
        }

        if($request['jenis_tarif_id'] == 1) {
            return redirect()->route('ranap.show', $request['pendaftaran_id'])->with('pesan', 'Tindakan berhasil di input.');
        } else {
            return redirect()->route('laboratorium.index', $request['pendaftaran_id'])->with('pesan', 'Tindakan berhasil di input.');
        }
    }

    public function datatableShow($id)
    {
        $find = $_GET['search']['value'] ? $_GET['search']['value'] : '';
        $pembayaran = Pembayaran::where('pendaftaran_id', $id)
                        ->offset($_GET['start'])
                        ->limit($_GET['length'])
                        ->orderBy('pembayaran.id')
                        ->get();
        
        $recordsTotal = Pembayaran::count();
        $recordsFiltered = count($pembayaran);

        $data = [];
        foreach($pembayaran as $index => $pembayaran) {
            if(isset($pembayaran->tarif->nama)) {
                $nama = $pembayaran->tarif->nama;
            } else {
                $nama = 'Pelayanan Farmasi';
            }

            $data[] = [
                ($index + 1),
                $nama,
                $pembayaran->jenis_tarif->nama,
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
                '<a href="' . route('pembayaran.show', $pendaftaran->id) . '" class="btn btn-info btn-sm" data-id="' . $pendaftaran->id . '">Proses</a>'
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

    public function pulang(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        $pendaftaran->tanggal_keluar = date('Y-m-d h:i:s');
        $pendaftaran->update();

        $request->session()->flash('pesan', 'Pasien berhasil dipulangkan!');

        return response()->json([
            'error' => false
        ]);
    }

    public function nota($id)
    {
        $pendaftaran = Pendaftaran::where('id', $id)->first();
        $pembayaran = Pembayaran::where('pendaftaran_id', $id)->get();
        
        return view('pembayaran.nota', compact('pembayaran', 'pendaftaran'));
    }

}