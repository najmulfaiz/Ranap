<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use App\PenjualanDetail;
use App\Pembayaran;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('penjualan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penjualan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pendaftaran_id = $request['pendaftaran_id'];
        $total = $request['total'];
        
        $pembayaran = Pembayaran::create([
            'pendaftaran_id' => $pendaftaran_id,
            'jenis_tarif_id' => 3,
            'tarifrs' => $total
        ]);

        $penjualan = Penjualan::create([
            'tanggal' => date('Y-m-d h:i:s'),
            'pendaftaran_id' => $pendaftaran_id,
            'total' => $total,
            'pembayaran_id' => $pembayaran->id
        ]);

        foreach($request['obat_id'] as $index => $obat) {
            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'obat_id' => $obat,
                'harga' => $request['hna'][$index],
                'jumlah' => $request['jumlah'][$index]
            ]);
        }

        return redirect()->route('penjualan.index')->with('pesan', 'Penjualan Berhasil');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        return view('penjualan.show', compact('penjualan'));
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
    public function destroy(Request $request, $id)
    {
        $pembayaran_id = $request['pembayaran_id'];

        Pembayaran::destroy($pembayaran_id);
        Penjualan::destroy($id);
        PenjualanDetail::where('penjualan_id', $id)->delete();

        $request->session()->flash('pesan', 'Penjualan berhasil dihapus!');

        return response()->json([
            'error' => false
        ]);
    }

    public function datatable()
    {
        $find = $_GET['search']['value'] ? $_GET['search']['value'] : '';
        $penjualan = Penjualan::whereHas('pendaftaran', function($q) use($find){
                            $q->where('nomr', 'like', '%' . $find . '%');
                        })
                        ->offset($_GET['start'])
                        ->limit($_GET['length'])
                        ->orderBy('tanggal', 'desc')
                        ->get();
        
        $recordsTotal = Penjualan::count();          
        $recordsFiltered = count($penjualan);

        $data = [];
        foreach($penjualan as $index => $penjualan) {
            $data[] = [
                ($index + 1),
                $penjualan->pendaftaran->nomr . ' - ' . $penjualan->pendaftaran->pasien->nama,
                $penjualan->pendaftaran->ruang->nama,
                $penjualan->total,
                '<a class="btn btn-info btn-sm btn-detail" href="' . route('penjualan.show', $penjualan->id) . '">Detail</a>
                &nbsp; <button class="btn btn-danger btn-sm btn-hapus" data-pembayaran="' . $penjualan->pembayaran_id . '" data-id="' . $penjualan->id . '">Hapus</button>'
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

    public function datatableShow($id)
    {
        $find = $_GET['search']['value'] ? $_GET['search']['value'] : '';
        $penjualan_detail = PenjualanDetail::where('penjualan_id', $id)
                        // ->where('jenis_tarif_id', 2)
                        ->offset($_GET['start'])
                        ->limit($_GET['length'])
                        ->orderBy('penjualan_detail.id')
                        ->get();
        
        $recordsTotal = PenjualanDetail::count();
        $recordsFiltered = count($penjualan_detail);

        $data = [];
        foreach($penjualan_detail as $index => $penjualan_detail) {
            $data[] = [
                ($index + 1),
                $penjualan_detail->obat->nama,
                $penjualan_detail->harga,
                $penjualan_detail->jumlah,
                ($penjualan_detail->harga * $penjualan_detail->jumlah)
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
