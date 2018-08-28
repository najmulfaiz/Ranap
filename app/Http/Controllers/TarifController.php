<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarif;

class TarifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tarif.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenis_tarif = \App\JenisTarif::where('id', '!=', 3)
                        ->get();
        $kelas = ['I', 'II', 'III', 'VIP', 'VVIP'];

        return view('tarif.create', compact('jenis_tarif', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request['jenis_tarif_id'] == 1) {
            $rules = [
                'nama' => 'required',
                'jenis_tarif_id' => 'required',
                'kelas' => 'required',
                'tarif' => 'required|numeric'
            ];
        } else {
            $rules = [
                'nama' => 'required',
                'jenis_tarif_id' => 'required',
                'tarif' => 'required|numeric'
            ];
        }

        $this->validate($request, $rules);

        $tarif = Tarif::create($request->all());

        return redirect()->route('tarif.index')->with('pesan', 'Tarif "' . $tarif->nama . '" berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tarif = Tarif::findOrFail($id);
        $jenis_tarif = \App\JenisTarif::where('id', '!=', 3)
                        ->get();
        $kelas = ['I', 'II', 'III', 'VIP', 'VVIP'];

        return view('tarif.edit', compact('tarif', 'jenis_tarif', 'kelas'));
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
        if($request['jenis_tarif_id'] == 1) {
            $rules = [
                'nama' => 'required',
                'jenis_tarif_id' => 'required',
                'kelas' => 'required',
                'tarif' => 'required|numeric'
            ];
        } else {
            $rules = [
                'nama' => 'required',
                'jenis_tarif_id' => 'required',
                'tarif' => 'required|numeric'
            ];
        }

        $this->validate($request, $rules);
        
        $tarif = Tarif::findOrFail($id);
        $tarif->nama = $request['nama'];
        $tarif->jenis_tarif_id = $request['jenis_tarif_id'];
        $tarif->kelas = $request['kelas'];
        $tarif->tarif = $request['tarif'];
        $tarif->update();

        return redirect()->route('tarif.index')->with('pesan', 'Tarif "' . $tarif->nama . '" berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Tarif::destroy($id);
        $request->session()->flash('pesan', 'Tarif berhasil dihapus!');

        return response()->json([
            'error' => false
        ]);
    }

    public function datatable()
    {
        $find = $_GET['search']['value'] ? $_GET['search']['value'] : '';
        $tarif = Tarif::where('nama', 'like', '%' . $find . '%')
                        ->offset($_GET['start'])
                        ->limit($_GET['length'])
                        ->orderBy('nama')
                        ->get();
        
        $recordsTotal = Tarif::count();          
        $recordsFiltered = count($tarif);

        $data = [];
        foreach($tarif as $index => $tarif) {
            $data[] = [
                ($index + 1),
                $tarif->nama,
                $tarif->jenis_tarif->nama,
                $tarif->kelas,
                $tarif->tarif,
                '<a href="' . route('tarif.edit', $tarif->id) . '" class="btn bg-slate-600 btn-sm" data-id="' . $tarif->id . '">Ubah</a>'
                .'&nbsp; <button class="btn btn-danger btn-sm btn-hapus" data-id="' . $tarif->id . '">Hapus</button>'
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

    public function api($id)
    {
        $res = Tarif::where('id', $id)->first();

        return response()->json($res);
    }
}
