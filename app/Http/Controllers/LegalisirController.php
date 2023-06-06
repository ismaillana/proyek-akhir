<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Ijazah;
use App\Models\Legalisir;
use App\Models\JenisLegalisir;

use App\Http\Requests\LegalisirRequest;
use Illuminate\Support\Facades\Crypt;

class LegalisirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $legalisir = Legalisir::get();
        
        return view ('admin.pengajuan.legalisir.index', [
            'legalisir' => $legalisir,
            'title'     => 'Legalisir'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisDokumen = JenisLegalisir::get();

        return view ('user.pengajuan.legalisir.form',[
            'jenisDokumen' => $jenisDokumen,
            'title'     => 'Legalisir'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LegalisirRequest $request)
    {
        $user = auth()->user();

        $alumni       = Mahasiswa::whereUserId($user->id)->first();
        
        $dokumen = Legalisir::saveDokumen($request);
        
        $data = ([
            'mahasiswa_id'              => $alumni->id,
            'keperluan'                 => $request->keperluan,
            'pekerjaan_terakhir'        => $request->pekerjaan_terakhir,
            'tempat_pekerjaan_terakhir' => $request->tempat_pekerjaan_terakhir,
            'dokumen'                   => $dokumen,
            'jenis_legalisir_id'        => $request->jenis_legalisir_id
        ]);
        
        Legalisir::create($data);

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

        $legalisir = Legalisir::find($id);
        return view ('admin.pengajuan.legalisir.detail', [
            'legalisir'    =>  $legalisir,
            'title'         =>  'Detail Pengajuan Legalisir'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    
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
    public function updateStatus(Request $request, string $id)
    {

        $legalisir = Legalisir::find($id);

        $data = [
            'status'  =>  $request->status
        ];

        Legalisir::where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

}
