<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use App\Models\JenisPengajuan;
use App\Models\Riwayat;

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
        $legalisir = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 5)
            ->whereNot('status', 'Selesai')
            ->whereNot('status', 'Tolak')
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

        $mahasiswa       = Mahasiswa::with(['pengajuan'])->whereUserId($pengaju->id)->first();

        $pengajuan = Pengajuan::where('mahasiswa_id', $mahasiswa->id)
            ->where('jenis_pengajuan_id', 5)
            ->latest()
            ->first();

        return view ('user.pengajuan.legalisir.form',[
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
        
        $dokumen = Pengajuan::saveDokumen($request);
        
        $data = ([
            'jenis_pengajuan_id'        => 5,
            'mahasiswa_id'              => $alumni->id,
            'no_ijazah'                 => $request->no_ijazah,
            'keperluan'                 => $request->keperluan,
            'pekerjaan_terakhir'        => $request->pekerjaan_terakhir,
            'nama_tempat'               => $request->nama_tempat,                       
            'dokumen'                   => $dokumen,
            'jenis_legalisir'           => $request->jenis_legalisir
        ]);
        
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

        $legalisir = Pengajuan::find($id);

        return view ('admin.pengajuan.legalisir.detail', [
            'legalisir'    =>  $legalisir,
            'title'         =>  'Detail Pengajuan Legalisir'
        ]);
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
     * Update the specified resource in storage.
     */
    public function konfirmasi(Request $request, string $id)
    {
        $data = [
            'status'  =>  'Konfirmasi'
        ];

        Pengajuan::where('id', $id)->update($data);

        Riwayat::create([
            'pengajuanid'  => $id,
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
     * Display a listing of the resource.
     */
    public function riwayat()
    {
        $legalisir = Pengajuan::where('jenis_pengajuan_id', 5)
            ->where('status', 'Selesai')
            ->orWhere('jenis_pengajuan_id', 5)
            ->where('status', 'Tolak')
            ->get();
            
        return view ('admin.riwayat.legalisir.index', [
            'legalisir'   => $legalisir,
            'title'         => 'Legalisir'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showRiwayat(string $id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            abort(404);
        }

        $legalisir = Pengajuan::find($id);
        return view ('admin.riwayat.legalisir.detail', [
            'legalisir'    =>  $legalisir,
            'title'        =>  'Detail Pengajuan Legalisir'
        ]);
    }

}
