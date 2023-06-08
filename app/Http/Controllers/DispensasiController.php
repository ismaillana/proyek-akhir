<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dispensasi;
use App\Models\AdminJurusan;
use App\Models\Log;

use App\Http\Requests\DispensasiRequest;
use Illuminate\Support\Facades\Crypt;

class DispensasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        // dd($user);
        $adminJurusan = AdminJurusan::whereUserId($user->id)->first();
        // $mahasiswa    = Mahasiswa::with(['dispensasi'])->first();
        // dd($adminJurusan);b
        // $user = User::role('admin')->get();
        $dispensasi = Dispensasi::latest()
        ->get();
        if ($user->hasRole('admin-jurusan')) {
              
            return view ('admin.pengajuan.dispensasi.index-admin-jurusan', [
                'dispensasi' => $dispensasi,
                'adminJurusan'  => $adminJurusan,
                'title'         => 'Dispensasi Perkuliahan'
            ]);
        } else {
            return view ('admin.pengajuan.dispensasi.index', [
                'dispensasi' => $dispensasi,
                'adminJurusan'  => $adminJurusan,
                'title'         => 'Dispensasi Perkuliahan'
            ]);
        }

        
        // dd($dispensasi);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengaju = auth()->user();

        $mahasiswa       = Mahasiswa::with(['dispensasi'])->whereUserId($pengaju->id)->first();

        $pengajuan = Dispensasi::where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->first();

        $user = User::whereHas('roles', function ($q)
        {
            $q->whereIn('name', ['mahasiswa']);
        })
        ->get();

        return view ('user.pengajuan.dispensasi.form', [
            'user' => $user,
            'pengajuan' => $pengajuan,
            'title'         => 'Dispensasi Perkuliahan'
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
        
        $dokumen = Dispensasi::saveDokumen($request);

        $data = ([
            'mahasiswa_id'  => $mahasiswa->id,
            'kegiatan'      => $request->kegiatan,
            'tempat'        => $request->tempat,
            'mulai'         => $request->mulai,
            'selesai'       => $request->selesai,
            'mulai'         => $request->mulai,
            'dokumen'       => $dokumen,
            'nama_mahasiswa'=> $request->nama_mahasiswa
        ]);


        $data['dokumen'] = $dokumen;

        $dispensasi = Dispensasi::create($data);

        Log::create([
            'dispensasi_id'  => $dispensasi->id,
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

        $dispensasi = Dispensasi::find($id);

        $data = Mahasiswa::whereIn('user_id', $dispensasi['nama_mahasiswa'])->get();
        
        return view ('admin.pengajuan.dispensasi.detail', [
            'dispensasi'    =>  $dispensasi,
            'data'          =>  $data,
            'title'         =>  'Detail Pengajuan Dispensasi'
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

        Dispensasi::where('id', $id)->update($data);

        Log::create([
            'dispensasi_id'  => $id,
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
            'dispensasi_id'  => $id,
            'status'        => 'Ditolak',
            'catatan'       => $request->catatan
        ]);

        Dispensasi::where('id', $id)->update($data);

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

        Dispensasi::where('id', $id)->update($data);

        if ($request->status == 'Proses' ) {
            Log::create([
                'dispensasi_id'  => $id,
                'status'        => 'Diproses',
                'catatan'       => 'Pengajuan Anda Sedang Diproses. Tunggu pemberitahuan selanjutnya'
            ]);
        }elseif ($request->status == 'Kendala' ) {
            Log::create([
                'dispensasi_id'  => $id,
                'status'        => 'Ada Kendala',
                'catatan'       => 'Pengajuan Anda Sedang Dalam Kendala. Tunggu pemberitahuan selanjutnya'
            ]);
        }elseif ($request->status == 'Selesai' ) {
            Log::create([
                'dispensasi_id'  => $id,
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
        $dispensasi = Dispensasi::where('status', 'Tolak')
            ->orWhere('status', 'Selesai')
            ->get();
        return view ('admin.riwayat.dispensasi.index', [
            'dispensasi'   => $dispensasi,
            'title'         => 'Surat Izin Dispensasi'
        ]);
    }
}
