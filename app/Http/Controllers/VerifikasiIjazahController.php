<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VerifikasiIjazah;
use App\Models\Instansi;
use App\Models\Log;

use App\Http\Requests\VerifikasiIjazahRequest;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
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
            'verifikasiIjazah'  => $verifikasiIjazah,
            'title'             => 'Verifikasi Ijazah'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.pengajuan.verifikasi-ijazah.form', [
            'title' => 'Verifikasi Ijazah' 
        ]);
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

        $verifikasiIjazah = VerifikasiIjazah::find($id);
        return view ('admin.pengajuan.verifikasi-ijazah.detail', [
            'verifikasiIjazah'    =>  $verifikasiIjazah,
            'title'         =>  'Detail Pengajuan Verifikasi Ijazah'
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
    public function konfirmasi(Request $request, string $id)
    {
        $data = [
            'status'  =>  'Konfirmasi'
        ];

        VerifikasiIjazah::where('id', $id)->update($data);

        Log::create([
            'verifikasi_ijazah_id'  => $id,
            'status'        => 'Dikonfirmasi',
            'catatan'       => 'Pengajuan Anda Telah Dikonfirmasi. Tunggu pemberitahuan selanjutnya'
        ]);

        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

    /**
     * Update the specified resource in storage.
     */
    public function tolak(Request $request, string $id)
    {
        $data = [
            'status'  =>  'Tolak',
            'catatan' =>  $request->catatan
        ];

        Log::create([
            'verifikasi_ijazah_id'  => $id,
            'status'        => 'Ditolak',
            'catatan'       => $request->catatan
        ]);

        VerifikasiIjazah::where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, string $id)
    {
        $data = [
            'status'  =>  $request->status
        ];

        VerifikasiIjazah::where('id', $id)->update($data);

        if ($request->status == 'Proses' ) {
            Log::create([
                'verifikasi_ijazah_id'  => $id,
                'status'        => 'Diproses',
                'catatan'       => 'Pengajuan Anda Sedang Diproses. Tunggu pemberitahuan selanjutnya'
            ]);
        }elseif ($request->status == 'Kendala' ) {
            Log::create([
                'verifikasi_ijazah_id'  => $id,
                'status'        => 'Ada Kendala',
                'catatan'       => 'Pengajuan Anda Sedang Dalam Kendala. Tunggu pemberitahuan selanjutnya'
            ]);
        }elseif ($request->status == 'Selesai' ) {
            Log::create([
                'verifikasi_ijazah_id'  => $id,
                'status'        => 'Selesai',
                'catatan'       => 'Pengajuan Anda Sudah Selesai. Ambil Dokumen Di Ruangan AKademik'
            ]);
        }
        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

}
