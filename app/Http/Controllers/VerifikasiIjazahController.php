<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instansi;
use App\Models\Riwayat;
use App\Models\Pengajuan;

use App\Http\Requests\VerifikasiIjazahRequest;
use App\Http\Requests\KonfirmasiRequest;

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
        $verifikasiIjazah = Pengajuan::where('jenis_pengajuan_id', 6)
            ->whereNot('status', 'Selesai')
            ->get();

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
        $pengaju = auth()->user();

        $instansi       = Instansi::with(['pengajuan'])->whereUserId($pengaju->id)->first();

        $pengajuan = Pengajuan::where('instansi_id', $instansi->id)
            ->where('jenis_pengajuan_id', 6)
            ->latest()
            ->first();

        return view('user.pengajuan.verifikasi-ijazah.form', [
            'pengajuan' => $pengajuan,
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
            'jenis_pengajuan_id' => 6,
            'instansi_id'      => $instansi->id,
            'nama'             => $request->nama,
            'nim'              => $request->nim,
            'no_ijazah'        => $request->no_ijazah,
            'tahun_lulus'      => $request->tahun_lulus,
            'dokumen'          => $request->dokumen,
        ]);

        $dokumen = Pengajuan::saveDokumen($request);

        $data['dokumen'] = $dokumen;

        $pengajuan = Pengajuan::create($data);

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

        $verifikasiIjazah = Pengajuan::find($id);
        return view ('admin.pengajuan.verifikasi-ijazah.detail', [
            'verifikasiIjazah'    =>  $verifikasiIjazah,
            'title'         =>  'Detail Pengajuan Verifikasi Ijazah'
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
        $verifikasiIjazah = Pengajuan::where('status', 'Tolak')
            ->orWhere('status', 'Selesai')
            ->where('jenis_pengajuan_id', 6)
            ->get();

        return view ('admin.riwayat.verifikasi-ijazah.index', [
            'verifikasiIjazah'   => $verifikasiIjazah,
            'title'         => 'Verifikasi Ijazah'
        ]);
    }

}
