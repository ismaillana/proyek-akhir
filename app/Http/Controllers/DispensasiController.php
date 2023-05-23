<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dispensasi;

use App\Http\Requests\DispensasiRequest;

class DispensasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dispensasi = Dispensasi::get();
        // $jenisId = dispensasi::get('jenis_legalisir_id');
        // $result = json_decode($jenisId);
        // dd($result);
        // $jenisDokumen = JenisLegalisir::whereIn('id',$result)->get();
        // dd($dispensasi);
        return view ('admin.pengajuan.dispensasi.index', [
            'dispensasi' => $dispensasi
            // 'jenisDokumen' => $jenisDokumen
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::where('status', 'Mahasiswa Aktif')
        ->get();
        return view ('user.pengajuan.dispensasi.form', [
            'mahasiswa' => $mahasiswa
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DispensasiRequest $request)
    {
        $user = auth()->user();

        $mahasiswa  = Mahasiswa::whereUserId($user->id)->first();

       $data = ([
            'mahasiswa_id'  => $mahasiswa->id,
            'kegiatan'      => $request->kegiatan,
            'tempat'        => $request->tempat,
            'mulai'         => $request->mulai,
            'selesai'       => $request->selesai,
            'mulai'         => $request->mulai,
            'dokumen'       => $request->dokumen,
        ]);

        $data['nama_mahasiswa'] =json_encode($request->nama_mahasiswa);

        $dokumen = Dispensasi::saveDokumen($request);

        $data['dokumen'] = $dokumen;

        Dispensasi::create($data);

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
