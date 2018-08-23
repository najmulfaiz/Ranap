<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjamin;

class PenjaminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('penjamin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penjamin.create');
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
            'nama' => 'required|max:25'
        ]);

        $penjamin = Penjamin::create($request->all());

        return redirect()->route('penjamin.index')->with('pesan', 'Penjamin "' . $penjamin->nama . '" berhasil ditambahkan.');
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
        $penjamin = Penjamin::findOrFail($id);

        return view('penjamin.edit', compact('penjamin'));
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
            'nama' => 'required|max:25'
        ]);

        $penjamin = Penjamin::findOrFail($id);
        $penjamin->nama = $request['nama'];
        $penjamin->update();

        return redirect()->route('penjamin.index')->with('pesan', 'Penjamin "' . $penjamin->nama . '" berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Penjamin::destroy($id);

        $request->session()->flash('pesan', 'Dokter berhasil dihapus!');

        return response()->json([
            'error' => false
        ]);
    }

    public function datatable()
    {
        $find = $_GET['search']['value'] ? $_GET['search']['value'] : '';
        $penjamin = Penjamin::where('nama', 'like', '%' . $find . '%')
                        ->offset($_GET['start'])
                        ->limit($_GET['length'])
                        ->get();
        
        $recordsTotal = Penjamin::count();
        $recordsFiltered = count($penjamin);

        $data = [];
        foreach($penjamin as $index => $penjamin) {
            $data[] = [
                ($index + 1),
                $penjamin->nama,
                '<a href="' . route('penjamin.edit', $penjamin->id) . '" class="btn bg-slate-600 btn-sm" data-id="' . $penjamin->id . '">Ubah</a>'
                .'&nbsp; <button class="btn btn-danger btn-sm btn-hapus" data-id="' . $penjamin->id . '">Hapus</button>'
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
