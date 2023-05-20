<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VerifikasiIjazah;
use App\Models\Instansi;

use App\Http\Requests\VerifikasiIjazahRequest;

use Illuminate\Support\Facades\Storage;
use File;
use Repsonse;

class VerifikasiIjazahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $verifikasiIjazah = VerifikasiIjazah::get();

        return view ('admin.pengajuan.verifikasi-ijazah.index', [
            'verifikasiIjazah'  => $verifikasiIjazah
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.pengajuan.verifikasi-ijazah.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VerifikasiIjazahRequest $request)
    {
        $user = auth()->user();

        $instansi       = Instansi::whereUserId($user->id)->first();

       $data = ([
            'instansi_id'      => $instansi->id,
            'name'             => $request->name,
            'nim'              => $request->nim,
            'no_ijazah'        => $request->no_ijazah,
            'tahun_lulus'      => $request->tahun_lulus,
            'dokumen'          => $request->dokumen,
        ]);

        $dokumen = VerifikasiIjazah::saveDokumen($request);

        $data['dokumen'] = $dokumen;

        VerifikasiIjazah::create($data);

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
