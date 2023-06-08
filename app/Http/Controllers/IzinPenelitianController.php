<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\IzinPenelitian;
use App\Models\Log;

use App\Http\Requests\IzinPenelitianRequest;
use Illuminate\Support\Facades\Crypt;

class IzinPenelitianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $izinPenelitian = IzinPenelitian::latest()->get();
        return view ('admin.pengajuan.izin-penelitian.index', [
            'izinPenelitian'   => $izinPenelitian,
            'title'    => 'Izin Penelitian'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
    
        $mahasiswa       = Mahasiswa::with(['dispensasi'])->whereUserId($user->id)
            ->first();

        $pengajuan = IzinPenelitian::where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->first();

        return view ('user.pengajuan.izin-penelitian.form',[
            'mahasiswa' => $mahasiswa,
            'pengajuan' => $pengajuan,
            'title'    => 'Izin Penelitian'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IzinPenelitianRequest $request)
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::whereUserId($user->id)
        ->first();

        $izinPenelitian = IzinPenelitian::create([
            'mahasiswa_id'      => $mahasiswa->id,
            'nama_tempat'       => $request->nama_tempat,
            'alamat_penelitian' => $request->alamat_penelitian,
            'tujuan_surat'      => $request->tujuan_surat,
            'perihal'           => $request->perihal,
        ]);

        Log::create([
            'izin_penelitian_id'  => $izinPenelitian->id,
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

        $izinPenelitian = IzinPenelitian::find($id);
        return view ('admin.pengajuan.izin-penelitian.detail', [
            'izinPenelitian'    =>  $izinPenelitian,
            'title'         =>  'Detail Pengajuan Izin Penelitian'
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

        IzinPenelitian::where('id', $id)->update($data);

        Log::create([
            'izin_penelitian_id_id'  => $id,
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
            'izin_penelitian_id'  => $id,
            'status'        => 'Ditolak',
            'catatan'       => $request->catatan
        ]);

        IzinPenelitian::where('id', $id)->update($data);

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

        IzinPenelitian::where('id', $id)->update($data);

        if ($request->status == 'Proses' ) {
            Log::create([
                'izin_penelitian_id'  => $id,
                'status'        => 'Diproses',
                'catatan'       => 'Pengajuan Anda Sedang Diproses. Tunggu pemberitahuan selanjutnya'
            ]);
        }elseif ($request->status == 'Kendala' ) {
            Log::create([
                'izin_penelitian_id'  => $id,
                'status'        => 'Ada Kendala',
                'catatan'       => 'Pengajuan Anda Sedang Dalam Kendala. Tunggu pemberitahuan selanjutnya'
            ]);
        }elseif ($request->status == 'Selesai' ) {
            Log::create([
                'izin_penelitian_id'  => $id,
                'status'        => 'Selesai',
                'catatan'       => 'Pengajuan Anda Sudah Selesai. Ambil Dokumen Di Ruangan AKademik'
            ]);
        }
        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

    /**
     * Display a listing of the resource.
     */
    public function riwayat()
    {
        $izinPenelitian = IzinPenelitian::where('status', 'Tolak')
            ->orWhere('status', 'Selesai')
            ->get();
        return view ('admin.riwayat.izin-penelitian.index', [
            'izinPenelitian'   => $izinPenelitian,
            'title'         => 'Surat Izin Penelitian'
        ]);
    }
}
