<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AktifKuliah;
use App\Models\Mahasiswa;
use App\Models\User;

use App\Http\Requests\AktifKuliahRequest;

class AktifKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aktifKuliah = AktifKuliah::get();
        return view ('admin.pengajuan.surat-aktif-kuliah.index', [
            'aktifKuliah'   => $aktifKuliah
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::whereUserId($user->id)->first();
        // $mahasiswa = Mahasiswa::where('status', 'Mahasiswa Aktif')
        // ->get();
        // $user = User::where($alumni)->get();
        // $user = User::get();
        

        return view ('user.pengajuan.aktifKuliah.form', [
            'mahasiswa' => $mahasiswa,
            // 'user'   => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AktifKuliahRequest $request)
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::whereUserId($user->id)->first();

        AktifKuliah::create([
            'mahasiswa_id'  => $mahasiswa->id,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'semester'      => $request->semester,
            'tahun_ajaran'  => $request->tahun_ajaran,
            'orang_tua'     => $request->orang_tua,
            'pekerjaan'     => $request->pekerjaan,
            'nip_nrp'       => $request->nip_nrp,
            'pangkat'       => $request->pangkat,
            'jabatan'       => $request->jabatan,
            'instansi'      => $request->instansi,
            'keperluan'     => $request->keperluan,
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
