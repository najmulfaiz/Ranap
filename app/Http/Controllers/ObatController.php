<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Obat;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('obat.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('obat.create');
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
            'nama' => 'required|max:100',
            'hna' => 'required|numeric'
        ]);

        $obat = Obat::create($request->all());

        return redirect()->route('obat.index')->with('pesan', 'Obat "' . $obat->nama . '" berhasil ditambahkan.');
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
        $obat = Obat::findOrFail($id);
        return view('obat.edit', compact('obat'));
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
            'nama' => 'required|max:100',
            'hna' => 'required|numeric'
        ]);
        
        $obat = Obat::findOrFail($id);
        $obat->nama = $request['nama'];
        $obat->hna = $request['hna'];
        $obat->update();

        return redirect()->route('obat.index')->with('pesan', 'Obat "' . $obat->nama . '" berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Obat::destroy($id);
        $request->session()->flash('pesan', 'Obat berhasil dihapus!');

        return response()->json([
            'error' => false
        ]);
    }

    public function datatable()
    {
        $find = $_GET['search']['value'] ? $_GET['search']['value'] : '';
        $obat = Obat::where('nama', 'like', '%' . $find . '%')
                        ->offset($_GET['start'])
                        ->limit($_GET['length'])
                        ->orderBy('nama')
                        ->get();
        
        $recordsTotal = Obat::count();          
        $recordsFiltered = count($obat);

        $data = [];
        foreach($obat as $index => $obat) {
            $data[] = [
                ($index + 1),
                $obat->nama,
                $obat->hna,
                '<a href="' . route('obat.edit', $obat->id) . '" class="btn bg-slate-600 btn-sm" data-id="' . $obat->id . '">Ubah</a>'
                .'&nbsp; <button class="btn btn-danger btn-sm btn-hapus" data-id="' . $obat->id . '">Hapus</button>'
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

    public function autocomplete()
    {
        $find = $_GET['term'];
        $obat = Obat::where('nama', 'like', '%' . $find . '%')
                        ->get();
        
        $res = [];
        foreach($obat as $obat) {
            $res [] = [
                'id' => $obat->id,
                'nama' => $obat->nama,
                'value' => $obat->nama,
                'nama' => $obat->nama,
                'hna' => $obat->hna
            ];
        }

        return response()->json($res);
    }
}
