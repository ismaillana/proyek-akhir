<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\IzinPenelitian;
use App\Models\Pengajuan;
use App\Models\Riwayat;
use App\Models\JenisPengajuan;

use App\Http\Requests\IzinPenelitianRequest;
use App\Http\Requests\KonfirmasiRequest;

use Illuminate\Support\Facades\Crypt;

class IzinPenelitianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $izinPenelitian = Pengajuan::where('jenis_pengajuan_id', 3)
            ->whereNot('status', 'Selesai')
            ->latest()
            ->get();

        if ($user->hasRole('admin-jurusan')) {
            return view ('admin.pengajuan.izin-penelitian.index-admin-jurusan', [
                'izinPenelitian'   => $izinPenelitian,
                'user'     => $user,
                'title'    => 'Izin Penelitian'
            ]);
        } else {
            return view ('admin.pengajuan.izin-penelitian.index', [
                'izinPenelitian'   => $izinPenelitian,
                'title'    => 'Izin Penelitian'
            ]);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
    
        $mahasiswa       = Mahasiswa::with(['pengajuan'])->whereUserId($user->id)
            ->first();

        $pengajuan = Pengajuan::where('mahasiswa_id', $mahasiswa->id)
            ->where('jenis_pengajuan_id', 3)
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

        $pengajuan = Pengajuan::create([
            'jenis_pengajuan_id'=> 3,
            'mahasiswa_id'      => $mahasiswa->id,
            'nama_tempat'       => $request->nama_tempat,
            'alamat_tempat'     => $request->alamat_tempat,
            'tujuan_surat'      => $request->tujuan_surat,
            'perihal'           => $request->perihal,
        ]);

        Riwayat::create([
            'pengajuan_id'  => $pengajuan->id,
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

        $izinPenelitian = Pengajuan::find($id);
        return view ('admin.pengajuan.izin-penelitian.detail', [
            'izinPenelitian'    =>  $izinPenelitian,
            'title'         =>  'Detail Pengajuan Izin Penelitian'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function konfirmasi(Request $request, string $id)
    {
        $data = [
            'status'  =>  'Konfirmasi'
        ];

        Pengajuan::where('id', $id)->update($data);

        Riwayat::create([
            'pengajuan_id'  => $id,
            'status'        => 'Dikonfirmasi',
            'catatan'       => 'Pengajuan Anda Telah Dikonfirmasi. Tunggu pemberitahuan selanjutnya'
        ]);

        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

    /**
     * Update the specified resource in storage.
     */
    public function tolak(KonfirmasiRequest $request, string $id)
    {
        $data = [
            'status'  =>  'Tolak',
            'catatan' =>  $request->catatan
        ];

        Riwayat::create([
            'pengajuan_id'  => $id,
            'status'        => 'Ditolak',
            'catatan'       => $request->catatan
        ]);

        Pengajuan::where('id', $id)->update($data);

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

        Pengajuan::where('id', $id)->update($data);

        if ($request->status == 'Proses' ) {
            Riwayat::create([
                'pengajuan_id'  => $id,
                'status'        => 'Diproses',
                'catatan'       => 'Pengajuan Anda Sedang Diproses. Tunggu pemberitahuan selanjutnya'
            ]);
        }elseif ($request->status == 'Kendala' ) {
            Riwayat::create([
                'pengajuan_id'  => $id,
                'status'        => 'Ada Kendala',
                'catatan'       => 'Pengajuan Anda Sedang Dalam Kendala. Tunggu pemberitahuan selanjutnya'
            ]);
        }elseif ($request->status == 'Selesai' ) {
            Riwayat::create([
                'pengajuan_id'  => $id,
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
        $izinPenelitian = Pengajuan::where('jenis_pengajuan_id', 3)
            ->where('status', 'Selesai')
            ->orWhere('status', 'Tolak')
            ->get();

        return view ('admin.riwayat.izin-penelitian.index', [
            'izinPenelitian'   => $izinPenelitian,
            'title'         => 'Surat Izin Penelitian'
        ]);
    }
}
