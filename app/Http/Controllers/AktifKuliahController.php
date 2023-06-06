<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AktifKuliah;
use App\Models\Mahasiswa;
use App\Models\User;

use App\Http\Requests\AktifKuliahRequest;
use App\Http\Requests\KonfirmasiRequest;
use Illuminate\Support\Facades\Crypt;

class AktifKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aktifKuliah = AktifKuliah::get();
        return view ('admin.pengajuan.surat-aktif-kuliah.index', [
            'aktifKuliah'   => $aktifKuliah,
            'title'         => 'Surat Keterangan Aktif Kuliah'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::whereUserId($user->id)->first();        

        return view ('user.pengajuan.aktifKuliah.form', [
            'mahasiswa' => $mahasiswa,
            'title'         => 'Surat Keterangan Aktif Kuliah'
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
            'keperluan'     => $request->keperluan,
        ]);

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

        $aktifKuliah = AktifKuliah::find($id);
        return view ('admin.pengajuan.surat-aktif-kuliah.detail', [
            'aktifKuliah'    =>  $aktifKuliah,
            'title'         =>  'Detail Pengajuan Keterangan Aktif Kuliah'
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

    /**
     * Update the specified resource in storage.
     */
    public function konfirmasi(KonfirmasiRequest $request, string $id)
    {
        $data = [
            'status'  => $request->status,
            'catatan' => $request->catatan,
        ];

        AktifKuliah::where('id', $id)->update($data);

        return redirect()->route('pengajuan-aktif-kuliah.index')->with('success', 'Data Berhasil Diubah');
    }
}
