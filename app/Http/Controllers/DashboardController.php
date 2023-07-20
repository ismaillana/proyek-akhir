<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pengajuan;
use App\Models\TempatPkl;
use App\Models\Instansi;
use App\Models\Mahasiswa;

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
        //Bagian Akademik & Super Admin
        $bagianAkademik = User::role('bagian-akademik') 
            ->get();
        $numbers = $bagianAkademik->pluck('wa')->toArray();

        $oneDayAgo = Carbon::now()->subDay();

        $pengajuans = Pengajuan::where('status', 'Menunggu Konfirmasi')
        ->whereIn('jenis_pengajuan_id', [1,5,6])
        ->where('created_at', '<=', $oneDayAgo)
        ->get();

        foreach ($pengajuans as $pengajuan) {
            foreach ($numbers as $number) {
                WhatsappGatewayService::sendMessage($number, 
                    'Hai, Bagian Akademik!' . PHP_EOL .
                        PHP_EOL .
                        'Ada pengajuan Verifikasi Ijazah Yang Belum Diverifikasi Lebh Dari 1 hari'. PHP_EOL .
                        'Segera lakukan pengecekan data pengajuan!'. PHP_EOL .
                        PHP_EOL .
                        '[Politeknik Negeri Subang]'
                ); //->Kirim Chat
            }
        }

        $pengajuanJurusan = Pengajuan::where('status', 'Menunggu Konfirmasi')
        ->whereIn('jenis_pengajuan_id', [2,3,4])
        ->where('created_at', '<=', $oneDayAgo)
        ->get();

        $pengajuanPkls = Pengajuan::where('status', 'Menunggu Konfirmasi')
        ->where('jenis_pengajuan_id', 2)
        ->where('created_at', '<=', $oneDayAgo)
        ->get();

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
            'title'         => 'Dashboard'
        ]);
    }
}
