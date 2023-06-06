<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\PengantarPkl;

use App\Http\Requests\PengantarPklRequest;
use Illuminate\Support\Facades\Crypt;

class PengantarPklController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengantarPkl = PengantarPkl::get();

        return view ('admin.pengajuan.pengantar-pkl.index',[
            'pengantarPkl' => $pengantarPkl,
            'title'     => 'Pengantar PKL'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::whereHas('roles', function ($q)
        {
            $q->whereIn('name', ['mahasiswa']);
        })
        ->get();
        
        return view ('user.pengajuan.pengantar-pkl.form', [
            'user'      => $user,
            'title'     => 'Pengantar PKL'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PengantarPklRequest $request)
    {
        $user = auth()->user();

        $alumni       = Mahasiswa::whereUserId($user->id)->first();

       $data = ([
            'mahasiswa_id'     => $alumni->id,
            'nama_perusahaan'  => $request->nama_perusahaan,
            'alamat'           => $request->alamat,
            'mulai'            => $request->mulai,
            'selesai'          => $request->selesai,
            'web'              => $request->web,
            'telepon'          => $request->telepon,
            'kepada'           => $request->web,
            'nama_mahasiswa'   => $request->nama_mahasiswa
        ]);

        PengantarPkl::create($data);

        return redirect()->back()->with('success', 'Pengajuan Berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            abort(404);
        }

        $pengantarPkl = PengantarPkl::find($id);
        // dd($pengantarPkl['nama_mahasiswa']);
        // $user = User::whereIn('id', $pengantarPkl['nama_mahasiswa'])->get();
        // dd($data);
        $data = Mahasiswa::whereIn('user_id', $pengantarPkl['nama_mahasiswa'])->get();
        // dd($mahasiswa);
        return view ('admin.pengajuan.pengantar-pkl.detail', [
            'pengantarPkl'    =>  $pengantarPkl,
            'data'          => $data,
            'title'         =>  'Detail Pengajuan Pengantar PKL'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
