<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use App\Models\Riwayat;
use App\Models\TempatPkl;
use App\Models\JenisPengajuan;

use App\Http\Requests\PengantarPklRequest;
use App\Http\Requests\KonfirmasiRequest;
use Illuminate\Support\Facades\Crypt;

class PengantarPklController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin-jurusan')) {
            $pengantarPkl = Pengajuan::where('jenis_pengajuan_id', 2)
                ->whereNot('status', 'Selesai')
                ->get();

            return view ('admin.pengajuan.pengantar-pkl.index-admin-jurusan',[
                'pengantarPkl' => $pengantarPkl,
                'user' => $user,
                'title'     => 'Pengantar PKL'
            ]);

        } elseif ($user->hasRole('koor-pkl')) {
            $pengantarPkl = Pengajuan::where('jenis_pengajuan_id', 2)
                ->where('status', 'Review')
                ->get();

            return view ('admin.pengajuan.pengantar-pkl.index-koor-pkl',[
                'pengantarPkl' => $pengantarPkl,
                'user'      => $user,
                'title'        => 'Pengantar PKL'
            ]);
        } else {
            $pengantarPkl = Pengajuan::where('jenis_pengajuan_id', 2)
            ->whereNot('status', 'Selesai')
            ->get();

            return view ('admin.pengajuan.pengantar-pkl.index',[
                'pengantarPkl' => $pengantarPkl,
                'title'     => 'Pengantar PKL'
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
            ->where('jenis_pengajuan_id', 2)
            ->latest()
            ->first();

        $tempatPkl = TempatPkl::get();

        $user = User::whereHas('roles', function ($q)
        {
            $q->whereIn('name', ['mahasiswa']);
        })
        ->get();
        
        return view ('user.pengajuan.pengantar-pkl.form', [
            'user'      => $user,
            'pengajuan' => $pengajuan,
            'tempatPkl' => $tempatPkl,
            'title'     => 'Pengantar PKL'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $alumni       = Mahasiswa::whereUserId($user->id)->first();

        $data = ([
            'jenis_pengajuan_id' => '2',
            'mahasiswa_id'     => $alumni->id,
            'tempat_pkl_id'    => $request->tempat_pkl_id,
            'tgl_mulai'        => $request->tgl_mulai,
            'tgl_selesai'      => $request->tgl_selesai,
            'tujuan_surat'     => $request->tujuan_surat,
            'nama_mahasiswa'   => $request->nama_mahasiswa
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
        $user = auth()->user();

        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            abort(404);
        }

        $pengantarPkl = Pengajuan::find($id);
        $data = Mahasiswa::whereIn('user_id', $pengantarPkl['nama_mahasiswa'])->get();
        
        return view ('admin.pengajuan.pengantar-pkl.detail', [
            'pengantarPkl'    =>  $pengantarPkl,
            'data'          => $data,
            'user'          => $user,
            'title'         =>  'Detail Pengajuan Pengantar PKL'
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
    public function review(Request $request, string $id)
    {
        $data = [
            'status'  =>  'Review'
        ];

        Pengajuan::where('id', $id)->update($data);

        Riwayat::create([
            'pengajuan_id'  => $id,
            'status'        => 'Direview',
            'catatan'       => 'Pengajuan Anda Sedang di review oleh Koordinator Pkl. Tunggu pemberitahuan selanjutnya'
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

        Log::create([
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
        $pengantarPkl = Pengajuan::where('status', 'Tolak')
            ->orWhere('status', 'Selesai')
            ->where('jenis_pengajuan_id',2)
            ->get();

        return view ('admin.riwayat.pengantar-pkl.index', [
            'pengantarPkl'   => $pengantarPkl,
            'title'         => 'Surat Pengantar PKL'
        ]);
    }
}
