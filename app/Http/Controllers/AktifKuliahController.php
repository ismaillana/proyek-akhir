<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AktifKuliah;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Log;

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
    public function konfirmasi(Request $request, string $id)
    {
        $data = [
            'status'  =>  'Konfirmasi'
        ];

        AktifKuliah::where('id', $id)->update($data);

        Log::create([
            'aktif_kuliah_id'  => $id,
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
        
        AktifKuliah::where('id', $id)->update($data);

        Log::create([
            'aktif_kuliah_id'  => $id,
            'status'        => 'Ditolak',
            'catatan'       => $request->catatan
        ]);


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

        AktifKuliah::where('id', $id)->update($data);

        if ($request->status == 'Proses' ) {
            Log::create([
                'legalisir_id'  => $id,
                'status'        => 'Diproses',
                'catatan'       => 'Pengajuan Anda Sedang Diproses. Tunggu pemberitahuan selanjutnya'
            ]);
        }elseif ($request->status == 'Kendala' ) {
            Log::create([
                'legalisir_id'  => $id,
                'status'        => 'Ada Kendala',
                'catatan'       => 'Pengajuan Anda Sedang Dalam Kendala. Tunggu pemberitahuan selanjutnya'
            ]);
        }elseif ($request->status == 'Selesai' ) {
            Log::create([
                'legalisir_id'  => $id,
                'status'        => 'Selesai',
                'catatan'       => 'Pengajuan Anda Sudah Selesai. Ambil Dokumen Di Ruangan AKademik'
            ]);
        }
        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }
}
