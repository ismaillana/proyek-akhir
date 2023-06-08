<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Ijazah;
use App\Models\Legalisir;
use App\Models\JenisLegalisir;
use App\Models\Log;

use App\Http\Requests\LegalisirRequest;
use App\Http\Requests\KonfirmasiRequest;

use Illuminate\Support\Facades\Crypt;

class LegalisirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $legalisir = Legalisir::latest()
            ->get();
        
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

        $pengaju = auth()->user();

        $mahasiswa       = Mahasiswa::with(['legalisir'])->whereUserId($pengaju->id)->first();

        $pengajuan = Legalisir::where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->first();

        $jenisDokumen = JenisLegalisir::get();

        return view ('user.pengajuan.legalisir.form',[
            'jenisDokumen' => $jenisDokumen,
            'pengajuan'    => $pengajuan,
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
            'no_ijazah'                 => $request->no_ijazah,
            'keperluan'                 => $request->keperluan,
            'pekerjaan_terakhir'        => $request->pekerjaan_terakhir,
            'tempat_pekerjaan_terakhir' => $request->tempat_pekerjaan_terakhir,
            'dokumen'                   => $dokumen,
            'jenis_legalisir_id'        => $request->jenis_legalisir_id
        ]);
        
        $legalisir = Legalisir::create($data);

        Log::create([
            'legalisir_id'  => $legalisir->id,
            'status'        => 'Menunggu Konfirmasi',
            'catatan'       => 'Pengajuan Berhasil Dibuat. Tunggu pemberitahuan selanjutnya'
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
        $data = [
            'status'  =>  $request->status
        ];

        Legalisir::where('id', $id)->update($data);

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

    /**
     * Update the specified resource in storage.
     */
    public function konfirmasi(Request $request, string $id)
    {
        $data = [
            'status'  =>  'Konfirmasi'
        ];

        Legalisir::where('id', $id)->update($data);

        Log::create([
            'legalisir_id'  => $id,
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
            'legalisir_id'  => $id,
            'status'        => 'Ditolak',
            'catatan'       => $request->catatan
        ]);

        Legalisir::where('id', $id)->update($data);

        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

    /**
     * Display a listing of the resource.
     */
    public function riwayat()
    {
        $legalisir = Legalisir::where('status', 'Tolak')
            ->orWhere('status', 'Selesai')
            ->get();
        return view ('admin.riwayat.legalisir.index', [
            'legalisir'   => $legalisir,
            'title'         => 'Legalisir'
        ]);
    }

}
