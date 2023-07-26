<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pengajuan;
use App\Models\TempatPkl;
use App\Models\Instansi;
use App\Models\Mahasiswa;
use App\Services\WhatsappGatewayService;

use Carbon\Carbon;


class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $akun = auth()->user();
        $jurusanId = $akun->jurusan_id;
        $akun = auth()->user();
        //Bagian Akademik & Super Admin
        $bagianAkademik = User::role('bagian-akademik') 
            ->get();

        $adminJurusan = User::role('admin-jurusan') 
            ->get();

        $oneDayAgo = Carbon::now()->subDay();
        //cek pengajuan lebih dari 1 hari 
        $pengajuans = Pengajuan::where('status', 'Menunggu Konfirmasi')
        ->whereIn('jenis_pengajuan_id', [1,5,6])
        ->where('created_at', '<=', $oneDayAgo)
        ->get();

        $pengajuanJurusan = Pengajuan::where('status', 'Menunggu Konfirmasi')
        ->whereIn('jenis_pengajuan_id', [3,4])
        ->whereHas('mahasiswa', function ($query) use ($jurusanId) {
            $query->whereHas('programStudi', function ($query) use ($jurusanId) {
                $query->where('jurusan_id', $jurusanId);
            });
        })
        ->where('created_at', '<=', $oneDayAgo)
        ->get();

        $pengantarPklll = Pengajuan::select('kode_pkl', 'tempat_pkl_id', 'status')
            ->where('jenis_pengajuan_id', 2)
            ->where(function ($query) {
                $query->where('status', 'Menunggu Konfirmasi');
            })
            ->whereHas('mahasiswa', function ($query) use ($jurusanId) {
                $query->whereHas('programStudi', function ($query) use ($jurusanId) {
                    $query->where('jurusan_id', $jurusanId);
                });
            })
            ->where('created_at', '<=', $oneDayAgo)
            ->groupBy('kode_pkl', 'tempat_pkl_id', 'status')
            ->get();

        $total = count($pengantarPklll) +  count($pengajuanJurusan);

        //Jumlah pengajuanPkl KoorPKL
        $pengantarPkllll = Pengajuan::select('kode_pkl', 'tempat_pkl_id', 'status')
            ->where('jenis_pengajuan_id', 2)
            ->where(function ($query) {
                $query->where('status', 'Review');
            })
            ->whereHas('mahasiswa', function ($query) use ($jurusanId) {
                $query->whereHas('programStudi', function ($query) use ($jurusanId) {
                    $query->where('jurusan_id', $jurusanId);
                });
            })
            ->where('updated_at', '<=', $oneDayAgo)
            ->groupBy('kode_pkl', 'tempat_pkl_id', 'status')
            ->get();

        //jumlah pengajuan pengantarPkl admin jurusan
        $pengantarPkll = Pengajuan::select('kode_pkl', 'tempat_pkl_id')
            ->where('jenis_pengajuan_id', 2)
            // ->where(function ($query) {
            //     $query->where('status', 'Menunggu Konfirmasi');
            // })
            ->whereHas('mahasiswa', function ($query) use ($jurusanId) {
                $query->whereHas('programStudi', function ($query) use ($jurusanId) {
                    $query->where('jurusan_id', $jurusanId);
                });
            })
            ->groupBy('kode_pkl', 'tempat_pkl_id')
            ->get();
        
        //jumlah pengajuan izinPenelitian admin jurusan
        $izinPenelitiann = Pengajuan::where('jenis_pengajuan_id', 3)
            ->whereHas('mahasiswa', function ($query) use ($jurusanId) {
                $query->whereHas('programStudi', function ($query) use ($jurusanId) {
                    $query->where('jurusan_id', $jurusanId);
                });
            })
            ->get();
        
        //jumlah pengajuan dispensasi admin jurusan
        $dispensasii = Pengajuan::where('jenis_pengajuan_id', 4)
            ->whereHas('mahasiswa', function ($query) use ($jurusanId) {
                $query->whereHas('programStudi', function ($query) use ($jurusanId) {
                    $query->where('jurusan_id', $jurusanId);
                });
            })
            ->get();

        $pengajuanPkls = Pengajuan::where('status', 'Menunggu Konfirmasi')
        ->where('jenis_pengajuan_id', 2)
        ->where('created_at', '<=', $oneDayAgo)
        ->get();

        //cek user
        $user = User::count();

        $mahasiswa = Mahasiswa::where('status', 'Mahasiswa Aktif')->count();

        $alumni = Mahasiswa::where('status', 'Alumni')->count();

        $instansi = Instansi::count();

        //Admin Jurusan
        $pengajuanIzinPenelitian = Pengajuan::where('jenis_pengajuan_id', 3)
            ->count();
        
        $pengajuanIzinDispensasi = Pengajuan::where('jenis_pengajuan_id', 4)
            ->count();
        
        $pengajuanPengantarPkl = Pengajuan::where('jenis_pengajuan_id', 2)
            ->count();


        $riwayat = Pengajuan::where('status', 'Selesai')
            ->orWhere('status', 'Tolak')
            ->count();

        //cek pengajuan
        $pengajuan = Pengajuan::count();

        $tempatPkl = TempatPkl::count();

        $aktifKuliah = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 1)
            ->whereNot('status', 'Selesai')
            ->whereNot('status', 'Tolak')
            ->get()
            ->take(3);

        $pengantarPkl = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 2)
            ->get()
            ->take(3);

        $izinPenelitian = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 3)
            ->get()
            ->take(3);
        
        $dispensasi = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 4)
            ->get()
            ->take(3);

        $verifikasiIjazah = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 6)
            ->whereNot('status', 'Selesai')
            ->whereNot('status', 'Tolak')
            ->get()
            ->take(3);

        $legalisir = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 5)
            ->whereNot('status', 'Selesai')
            ->whereNot('status', 'Tolak')
            ->get()
            ->take(3);

        return view('admin.dashboard', [
            'user'          => $user,
            'riwayat'       => $riwayat,
            'aktifKuliah'   => $aktifKuliah,
            'pengantarPkl'  => $pengantarPkl,
            'izinPenelitian'=> $izinPenelitian,
            'dispensasi'    => $dispensasi,
            'legalisir'     => $legalisir,
            'verifikasiIjazah' => $verifikasiIjazah,
            'pengajuan' => $pengajuan,
            'pengajuans' => $pengajuans,
            'pengajuanJurusan' => $pengajuanJurusan,
            'pengajuanPkls' => $pengajuanPkls,
            'tempatPkl' => $tempatPkl,
            'instansi' => $instansi,
            'alumni' => $alumni,
            'mahasiswa' => $mahasiswa,
            'pengajuanIzinDispensasi' => $pengajuanIzinDispensasi,
            'pengajuanPengantarPkl' => $pengajuanPengantarPkl,
            'pengajuanIzinPenelitian' => $pengajuanIzinPenelitian,
            'akun' => $akun,
            'bagianAkademik' => $bagianAkademik,
            'adminJurusan' => $adminJurusan,
            'pengantarPkll' => $pengantarPkll,
            'pengantarPkllll' => $pengantarPkllll,
            'izinPenelitiann' => $izinPenelitiann,
            'dispensasii' => $dispensasii,
            'total' => $total,
            'title'         => 'Dashboard'
        ]);
    }
}
