<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dispensasi;
use App\Models\Pengajuan;
use App\Models\JenisPengajuan;
use App\Models\Riwayat;

use App\Http\Requests\DispensasiRequest;
use App\Http\Requests\KonfirmasiRequest;
use Illuminate\Support\Facades\Crypt;

class DispensasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $dispensasi = Pengajuan::where('jenis_pengajuan_id', 4)
            ->whereNot('status', 'Selesai')
            ->latest()
            ->get();

        if ($user->hasRole('admin-jurusan')) {
              
            return view ('admin.pengajuan.dispensasi.index-admin-jurusan', [
                'dispensasi' => $dispensasi,
                'user'       => $user,
                'title'      => 'Dispensasi Perkuliahan'
            ]);
        } else {
            return view ('admin.pengajuan.dispensasi.index', [
                'dispensasi'    => $dispensasi,
                'title'         => 'Dispensasi Perkuliahan'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengaju = auth()->user();

        $mahasiswa       = Mahasiswa::with(['pengajuan'])->whereUserId($pengaju->id)->first();

        $pengajuan = Pengajuan::where('mahasiswa_id', $mahasiswa->id)
            ->where('jenis_pengajuan_id', 4)
            ->latest()
            ->first();

        $user = User::whereHas('roles', function ($q)
        {
            $q->whereIn('name', ['mahasiswa']);
        })->get();

        return view ('user.pengajuan.dispensasi.form', [
            'user'      => $user,
            'pengajuan' => $pengajuan,
            'title'     => 'Dispensasi Perkuliahan'
        ]);
        

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DispensasiRequest $request)
    {
        $user = auth()->user();

        $mahasiswa  = Mahasiswa::whereUserId($user->id)
            ->first();
        
        $dokumen = Pengajuan::saveDokumen($request);

        $data = ([
            'jenis_pengajuan_id'    => 4,
            'mahasiswa_id'          => $mahasiswa->id,
            'kegiatan'              => $request->kegiatan,
            'nama_tempat'           => $request->nama_tempat,
            'tgl_mulai'             => $request->tgl_mulai,
            'tgl_selesai'           => $request->tgl_selesai,
            'dokumen'               => $dokumen,
            'nama_mahasiswa'        => $request->nama_mahasiswa
        ]);


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

        $dispensasi = Pengajuan::find($id);

        $data = Mahasiswa::whereIn('user_id', $dispensasi['nama_mahasiswa'])->get();
        
        return view ('admin.pengajuan.dispensasi.detail', [
            'dispensasi'    =>  $dispensasi,
            'data'          =>  $data,
            'title'         =>  'Detail Pengajuan Dispensasi'
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
        $dispensasi = Pengajuan::where('status', 'Tolak')
            ->orWhere('status', 'Selesai')
            ->where('jenis_pengajuan_id', 4)
            ->get();

        return view ('admin.riwayat.dispensasi.index', [
            'dispensasi'   => $dispensasi,
            'title'         => 'Surat Izin Dispensasi'
        ]);
    }
}
