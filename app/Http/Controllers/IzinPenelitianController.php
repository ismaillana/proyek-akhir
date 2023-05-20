<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\IzinPenelitian;

use App\Http\Requests\IzinPenelitianRequest;

class IzinPenelitianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $izinPenelitian = IzinPenelitian::latest()->get();
        return view ('admin.pengajuan.izin-penelitian.index', [
            'izinPenelitian'   => $izinPenelitian
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::whereUserId($user->id)->first();

        return view ('user.pengajuan.izin-penelitian.form',[
            'mahasiswa' => $mahasiswa
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IzinPenelitianRequest $request)
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::whereUserId($user->id)->first();

        IzinPenelitian::create([
            'mahasiswa_id'      => $mahasiswa->id,
            'nama_tempat'       => $request->nama_tempat,
            'alamat_penelitian' => $request->alamat_penelitian,
            'tujuan_surat'      => $request->tujuan_surat,
            'perihal'           => $request->perihal,
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
