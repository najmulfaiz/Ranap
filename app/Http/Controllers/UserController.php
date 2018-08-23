<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $level = [1 => 'Super Admin', 'Pendaftaran', 'Ruang', 'Laboratorium', 'Apotek', 'Pembayaran'];

        return view('user.create', compact('level'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'level' => 'required',
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'level' => $request['level']
        ]);

        return redirect()->route('user.index')->with('pesan', 'User ' . $user->name . ' berhasil ditambahkan!');
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
        $user = User::findOrFail($id);
        $level = [1 => 'Super Admin', 'Pendaftaran', 'Ruang', 'Laboratorium', 'Apotek', 'Pembayaran'];

        return view('user.edit', compact('user', 'level'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'required|string|min:6|confirmed',
            'level' => 'required',
        ]);

        $user = User::findOrFail($id);
        
        $user->name     = $request['name'];
        $user->email    = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->level    = $request['level'];
        $user->update();

        return redirect()->route('user.index')->with('pesan', 'User ' . $user->name . ' berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        User::destroy($id);
        $request->session()->flash('pesan', 'User berhasil dihapus!');

        return response()->json([
            'error' => false
        ]);
    }

    public function datatable()
    {
        $level = [1 => 'Super Admin', 'Pendaftaran', 'Ruang', 'Laboratorium', 'Apotek', 'Pembayaran'];
        $find = $_GET['search']['value'] ? $_GET['search']['value'] : '';
        $users = User::where('email', 'like', '%' . $find . '%')
                        ->where('name', 'like', '%' . $find . '%')
                        ->offset($_GET['start'])
                        ->limit($_GET['length'])
                        ->get();
        
        $recordsTotal = User::count();          
        $recordsFiltered = count($users);

        $data = [];
        foreach($users as $index => $user) {
            $data[] = [
                ($index + 1),
                $user->name,
                $user->email,
                $level[$user->level],
                '<a href="' . route('user.edit', $user->id) . '" class="btn bg-slate-600 btn-sm" data-id="' . $user->id . '">Ubah</a>'
                .'&nbsp; <button class="btn btn-danger btn-sm btn-hapus" data-id="' . $user->id . '">Hapus</button>'
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
