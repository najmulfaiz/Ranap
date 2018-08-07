<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ruang;

class RuangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ruang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = ['I', 'II', 'III', 'VIP', 'VVIP'];

        return view('ruang.create', compact('kelas'));
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
            'nama' => 'required|max:50',
            'kelas' => 'required'
        ]);

        $ruang = Ruang::create($request->all());

        return redirect()->route('ruang.index')->with('pesan', 'Ruang "' . $ruang->nama . '" berhasil ditambahkan.');
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
        $ruang = Ruang::findOrFail($id);
        $kelas = ['I', 'II', 'III', 'VIP', 'VVIP'];

        return view('ruang.edit', compact('ruang', 'kelas'));
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
            'nama' => 'required|max:50',
            'kelas' => 'required'
        ]);
        
        $ruang = Ruang::findOrFail($id);
        $ruang->nama = $request['nama'];
        $ruang->kelas = $request['kelas'];
        $ruang->update();

        return redirect()->route('ruang.index')->with('pesan', 'Ruang "' . $ruang->nama . '" berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Ruang::destroy($id);
        $request->session()->flash('pesan', 'Ruang berhasil dihapus!');

        return response()->json([
            'error' => false
        ]);
    }

    public function datatable()
    {
        $find = $_GET['search']['value'] ? $_GET['search']['value'] : '';
        $ruang = Ruang::where('nama', 'like', '%' . $find . '%')
                        ->offset($_GET['start'])
                        ->limit($_GET['length'])
                        ->orderBy('nama')
                        ->get();
        
        $recordsTotal = Ruang::count();          
        $recordsFiltered = count($ruang);

        $data = [];
        foreach($ruang as $index => $ruang) {
            $data[] = [
                ($index + 1),
                $ruang->nama,
                $ruang->kelas,
                '<a href="' . route('ruang.edit', $ruang->id) . '" class="btn bg-slate-600 btn-sm" data-id="' . $ruang->id . '">Ubah</a>'
                .'&nbsp; <button class="btn btn-danger btn-sm btn-hapus" data-id="' . $ruang->id . '">Hapus</button>'
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

    public function api($kelas = null)
    {
        if($kelas == null) {
            $ruang = Ruang::orderBy('nama')->get();
        } else {
            $ruang = Ruang::where('kelas', $kelas)->orderBy('nama')->get();
        }

        return response()->json($ruang);
    }
}
