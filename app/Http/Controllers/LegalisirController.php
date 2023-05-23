<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Ijazah;
use App\Models\Legalisir;
use App\Models\JenisLegalisir;

use App\Http\Requests\LegalisirRequest;

class LegalisirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $legalisir = Legalisir::get();
        $jenisId = Legalisir::get('jenis_legalisir_id');
        $result = json_decode($jenisId);
        dd($result);
        $jenisDokumen = JenisLegalisir::whereIn('id',$result)->get();

        return view ('admin.pengajuan.legalisir.index', [
            'legalisir' => $legalisir,
            'jenisDokumen' => $jenisDokumen
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisDokumen = JenisLegalisir::get();

        return view ('user.pengajuan.legalisir.form',[
            'jenisDokumen' => $jenisDokumen
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LegalisirRequest $request)
    {
        $user = auth()->user();

        $alumni       = Mahasiswa::whereUserId($user->id)->first();

        $ijazah       = Ijazah::whereMahasiswaId($alumni->id)->first();

       $data = ([
            'mahasiswa_id'              => $alumni->id,
            'ijazah_id'                 => $ijazah->id,
            'keperluan'                 => $request->keperluan,
            'pekerjaan_terakhir'        => $request->pekerjaan_terakhir,
            'tempat_pekerjaan_terakhir' => $request->tempat_pekerjaan_terakhir,
            'dokumen'                   => $request->dokumen,
        ]);

        $data['jenis_legalisir_id'] =json_encode($request->jenis_legalisir_id);

        $dokumen = Legalisir::saveDokumen($request);

        $data['dokumen'] = $dokumen;

        Legalisir::create($data);

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

    /**
     * getData the specified resource in storage.
     */
    // public function jenisDokumen(Request $request)
    // {
    //     $legalisir = [];
    //     if ($search=$request->name) {
    //         $legalisir = JenisLegalisir::where('name', 'LIKE', "%$search%")->get();
    //     }

    //     return response()->json($legalisir);
    // }
}
