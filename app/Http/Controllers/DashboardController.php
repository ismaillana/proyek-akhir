<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pengajuan;
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
        $oneDayAgo = Carbon::now()->subDay();

        $pengajuans = Pengajuan::where('status', 'Menunggu Konfirmasi')
        ->where('created_at', '<=', $oneDayAgo)
        ->get();

        $pengajuanJurusan = Pengajuan::where('status', 'Menunggu Konfirmasi')
        ->whereIn('jenis_pengajuan_id', [2,3,4])
        ->where('created_at', '<=', $oneDayAgo)
        ->get();

        $pengajuanPkls = Pengajuan::where('status', 'Menunggu Konfirmasi')
        ->where('jenis_pengajuan_id', 2)
        ->where('created_at', '<=', $oneDayAgo)
        ->get();

        $user = User::count();
        $riwayat = Pengajuan::where('status', 'Selesai')
            ->orWhere('status', 'Tolak')
            ->count();
        $pengajuan = Pengajuan::whereNot('status', 'Selesai')
            ->WhereNot('status', 'Tolak')
            ->count();
        $aktifKuliah = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 1)
            ->whereNot('status', 'Selesai')
            ->whereNot('status', 'Tolak')
            ->get()
            ->take(3);
        $pengantarPkl = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 2)
            ->whereNot('status', 'Selesai')
            ->whereNot('status', 'Tolak')
            ->get()
            ->take(3);
        $izinPenelitian = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 3)
            ->whereNot('status', 'Selesai')
            ->whereNot('status', 'Tolak')
            ->get()
            ->take(3);
        $dispensasi = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 4)
            ->whereNot('status', 'Selesai')
            ->whereNot('status', 'Tolak')
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
            'title'         => 'Dashboard'
        ]);
    }
}
