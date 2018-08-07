<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pendaftaran;
use App\Pasien;
use App\Dokter;
use App\Penjamin;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pendaftaran.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = ['I', 'II', 'III', 'VIP', 'VVIP'];
        $goldar = ['A', 'B', 'AB', 'O'];
        $dokter = Dokter::orderBy('nama')->get();
        $penjamin = Penjamin::all();

        return view('pendaftaran.create', compact('kelas', 'dokter', 'penjamin', 'goldar'));
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
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'provinsi_id' => 'required',
            'kabupaten_id' => 'required',
            'kecamatan_id' => 'required',
            'kelurahan_id' => 'required',
            'golongan_darah' => 'required',
            'diagnosis_masuk' => 'required',
            'kelas_id' => 'required',
            'ruang_id' => 'required',
            'dokter_id' => 'required',
            'penjamin_id' => 'required'
        ]);

        if($request['jenis'] == 1) 
        {
            $nomr_terakhir = 0;
            $pasien_terakhir = Pasien::whereRaw('nomr = (select max(`nomr`) from pasien)')->get();
            if(count($pasien_terakhir)) {
                $nomr_terakhir = (Int) $pasien_terakhir[0]->nomr;
            }
            $nomr_baru = sprintf('%06s', ($nomr_terakhir + 1));

            $tanggal_lahir = date('Y-m-d', strtotime($request['tanggal_lahir']));
            $pasien = Pasien::create([
                'nomr'           => $nomr_baru,
                'nama'           => $request['nama'],
                'tempat_lahir'   => $request['tempat_lahir'],
                'tanggal_lahir'  => $tanggal_lahir,
                'jenis_kelamin'  => $request['jenis_kelamin'],
                'alamat'         => $request['alamat'],
                'provinsi_id'    => $request['provinsi_id'],
                'kabupaten_id'   => $request['kabupaten_id'],
                'kecamatan_id'   => $request['kecamatan_id'],
                'kelurahan_id'   => $request['kelurahan_id'],
                'golongan_darah' => $request['golongan_darah']
            ]);

            $nomr = $nomr_baru;
        } else {
            $nomr = $request['nomr'];
        }

        $pendaftaran = Pendaftaran::create([
            'nomr'           => $nomr,
            'diagnosis_masuk' => $request['diagnosis_masuk'],
            'kelas_id'       => $request['kelas_id'],
            'ruang_id'       => $request['ruang_id'],
            'dokter_id'           => $request['dokter_id'],
            'penjamin_id'       => $request['penjamin_id'],
            'tanggal_masuk' => \Carbon\Carbon::now()
        ]);

        return redirect()->route('pendaftaran.index')->with('pesan', 'Pendaftaran berhasil!');
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
        Pendaftaran::destroy($id);
        $request->session()->flash('pesan', 'Pendaftaran berhasil dihapus!');

        return response()->json([
            'error' => false
        ]);
    }

    public function datatable()
    {
        $find = $_GET['search']['value'] ? $_GET['search']['value'] : '';
        $pendaftaran = Pendaftaran::where('nomr', 'like', '%' . $find . '%')
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
                // '<a href="' . route('penjamin.edit', $pendaftaran->id) . '" class="btn bg-slate-600 btn-sm" data-id="' . $pendaftaran->id . '">Ubah</a>'.
                '&nbsp; <button class="btn btn-danger btn-sm btn-hapus" data-id="' . $pendaftaran->id . '">Hapus</button>'
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
