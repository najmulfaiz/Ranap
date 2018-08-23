<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dokter;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dokter = Dokter::orderBy('nama')->get();

        return view('dokter.index', compact('dokter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dokter.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|max:75'
        ]);

        $dokter = Dokter::create($request->all());

        return redirect()->route('dokter.index')->with('pesan', 'Dokter "' . $dokter->nama . '" berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dokter = Dokter::findOrFail($id);

        return view('dokter.edit', compact('dokter'));
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
        $this->validate($request, [
            'nama' => 'required|max:75'
        ]);

        $dokter = Dokter::findOrFail($id);

        $dokter->nama = $request['nama'];
        $dokter->update();

        return redirect()->route('dokter.index')->with('pesan', 'Dokter "' . $dokter->nama . '" berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Dokter::destroy($id);
        $request->session()->flash('pesan', 'Dokter berhasil dihapus!');

        return response()->json([
            'error' => false
        ]);
    }

    public function api()
    {
        $dokter = Dokter::orderBy('nama')->get();

        return response()->json($dokter);
    }

    public function datatable()
    {
        $find = $_GET['search']['value'] ? $_GET['search']['value'] : '';
        $dokter = Dokter::where('nama', 'like', '%' . $find . '%')
                        ->offset($_GET['start'])
                        ->limit($_GET['length'])
                        ->orderBy('nama')
                        ->get();
        
        $recordsTotal = Dokter::count();          
        $recordsFiltered = count($dokter);

        $data = [];
        foreach($dokter as $index => $dokter) {
            $data[] = [
                ($index + 1),
                $dokter->nama,
                '<a href="' . route('dokter.edit', $dokter->id) . '" class="btn bg-slate-600 btn-sm" data-id="' . $dokter->id . '">Ubah</a>'
                .'&nbsp; <button class="btn btn-danger btn-sm btn-hapus" data-id="' . $dokter->id . '">Hapus</button>'
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
