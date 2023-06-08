<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Legalisir;
use App\Models\AktifKuliah;
use App\Models\PengantarPkl;
use App\Models\IzinPenelitian;
use App\Models\Dispensasi;
use App\Models\VerifikasiIjazah;
use App\Models\Instansi;

use App\Models\Log;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::with(['legalisir'])->whereUserId($user->id)->first();

        $title          = "Data Pengajuan Legalisir";

        $legalisir = Legalisir::where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->get();

        return view('user.riwayat.legalisir.index', [
            'legalisir'   => $legalisir,
            'title'            => $title,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function tracking(string $id)
    {
        $jumlah = Log::where('legalisir_id', $id)->count();
        
        $log = Log::where('legalisir_id', $id)->latest()
            ->get();

        return view ('user.riwayat.legalisir.tracking', [
            'log'   =>  $log,
            'jumlah'=>  $jumlah
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function indexAktifKuliah(Request $request)
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::with(['aktifKuliah'])->whereUserId($user->id)->first();

        $title          = "Data Pengajuan Surat Aktif Kuliah";

        $aktifKuliah = AktifKuliah::where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->get();

        return view('user.riwayat.aktif-kuliah.index', [
            'aktifKuliah'   => $aktifKuliah,
            'title'            => $title,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function trackingAktifKuliah(string $id)
    {
        $jumlah = Log::where('aktif_kuliah_id', $id)->count();
        
        $log = Log::where('aktif_kuliah_id', $id)->latest()
            ->get();

        return view ('user.riwayat.aktif-kuliah.tracking', [
            'log'   =>  $log,
            'jumlah'=>  $jumlah
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function indexPengantarPkl(Request $request)
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::with(['pengantarPkl'])->whereUserId($user->id)->first();

        $title          = "Data Pengajuan Surat Pengantar PKL";

        $pengantarPkl = PengantarPkl::where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->get();

        return view('user.riwayat.pengantar-pkl.index', [
            'pengantarPkl'   => $pengantarPkl,
            'title'            => $title,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function trackingPengantarPkl(string $id)
    {
        $jumlah = Log::where('pengantar_pkl_id', $id)->count();
        
        $log = Log::where('pengantar_pkl_id', $id)->latest()
            ->get();

        return view ('user.riwayat.pengantar-pkl.tracking', [
            'log'   =>  $log,
            'jumlah'=>  $jumlah
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function indexIzinPenelitian(Request $request)
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::with(['izinPenelitian'])->whereUserId($user->id)->first();

        $title          = "Data Pengajuan Izin Penelitian";

        $izinPenelitian = IzinPenelitian::where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->get();

        return view('user.riwayat.izin-penelitian.index', [
            'izinPenelitian'   => $izinPenelitian,
            'title'            => $title,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function trackingIzinPenelitian(string $id)
    {
        $jumlah = Log::where('izin_penelitian_id', $id)->count();
        
        $log = Log::where('izin_penelitian_id', $id)->latest()
            ->get();

        return view ('user.riwayat.izin-penelitian.tracking', [
            'log'   =>  $log,
            'jumlah'=>  $jumlah
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function indexDispensasi(Request $request)
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::with(['dispensasi'])->whereUserId($user->id)->first();

        $title          = "Data Pengajuan Dispensasi";

        $dispensasi = Dispensasi::where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->get();

        return view('user.riwayat.dispensasi.index', [
            'dispensasi'   => $dispensasi,
            'title'            => $title,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function trackingDispensasi(string $id)
    {
        $jumlah = Log::where('dispensasi_id', $id)->count();
        
        $log = Log::where('dispensasi_id', $id)->latest()
            ->get();

        return view ('user.riwayat.dispensasi.tracking', [
            'log'   =>  $log,
            'jumlah'=>  $jumlah
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function indexVerifikasiIjazah(Request $request)
    {
        $user = auth()->user();

        $instansi       = Instansi::with(['verifikasiIjazah'])->whereUserId($user->id)->first();

        $title          = "Data Pengajuan VerifikasiIjazah";

        $verifikasiIjazah = VerifikasiIjazah::where('instansi_id', $instansi->id)
            ->latest()
            ->get();

        return view('user.riwayat.verifikasi-ijazah.index', [
            'verifikasiIjazah'   => $verifikasiIjazah,
            'title'            => $title,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function trackingVerifikasiIjazah(string $id)
    {
        $jumlah = Log::where('verifikasi_ijazah_id', $id)->count();
        
        $log = Log::where('verifikasi_ijazah_id', $id)->latest()
            ->get();

        return view ('user.riwayat.verifikasi-ijazah.tracking', [
            'log'   =>  $log,
            'jumlah'=>  $jumlah
        ]);
    }

}
