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
use App\Models\Pengajuan;
use App\Models\JenisPengajuan;
use App\Models\Riwayat;
use App\Models\Log;
use App\Models\TempatPkl;

use App\Http\Requests\KonfirmasiPklRequest;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::with(['pengajuan'])->whereUserId($user->id)->first();

        $title          = "Data Pengajuan Legalisir";

        $legalisir = Pengajuan::where('mahasiswa_id', $mahasiswa->id)
            ->where('jenis_pengajuan_id', 5)
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
        $jumlah = Riwayat::where('pengajuan_id', $id)->count();
        
        $riwayat = Riwayat::where('pengajuan_id', $id)
            ->latest()
            ->get();

        return view ('user.riwayat.legalisir.tracking', [
            'riwayat'   =>  $riwayat,
            'jumlah'=>  $jumlah
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function indexAktifKuliah(Request $request)
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::with(['pengajuan'])->whereUserId($user->id)->first();

        $title          = "Data Pengajuan Surat Aktif Kuliah";

        $aktifKuliah = Pengajuan::where('mahasiswa_id', $mahasiswa->id)
            ->Where('jenis_pengajuan_id', 1)
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
        $jumlah = Riwayat::where('pengajuan_id', $id)->count();
        
        $riwayat = Riwayat::where('pengajuan_id', $id)->latest()
            ->get();
        // dd($riwayat);

        return view ('user.riwayat.aktif-kuliah.tracking', [
            'riwayat'   =>  $riwayat,
            'jumlah'    =>  $jumlah
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function indexIzinPenelitian(Request $request)
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::with(['pengajuan'])->whereUserId($user->id)->first();

        $title          = "Data Pengajuan Izin Penelitian";

        $izinPenelitian = Pengajuan::where('mahasiswa_id', $mahasiswa->id)
            ->Where('jenis_pengajuan_id', 3)
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
        $jumlah = Riwayat::where('pengajuan_id', $id)->count();
        
        $riwayat = Riwayat::where('pengajuan_id', $id)->latest()
            ->get();

        return view ('user.riwayat.izin-penelitian.tracking', [
            'riwayat'   =>  $riwayat,
            'jumlah'    =>  $jumlah
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function indexDispensasi(Request $request)
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::with(['pengajuan'])->whereUserId($user->id)->first();

        $title          = "Data Pengajuan Dispensasi";

        $dispensasi = Pengajuan::where('mahasiswa_id', $mahasiswa->id)
            ->where('jenis_pengajuan_id', 4)
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
        $jumlah = Riwayat::where('pengajuan_id', $id)->count();
        
        $riwayat = Riwayat::where('pengajuan_id', $id)->latest()
            ->get();

        return view ('user.riwayat.dispensasi.tracking', [
            'riwayat'   =>  $riwayat,
            'jumlah'=>  $jumlah
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function indexVerifikasiIjazah(Request $request)
    {
        $user = auth()->user();

        $instansi       = Instansi::with(['pengajuan'])->whereUserId($user->id)->first();

        $title          = "Data Pengajuan VerifikasiIjazah";

        $verifikasiIjazah = Pengajuan::where('instansi_id', $instansi->id)
            ->where('jenis_pengajuan_id', 6)
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
        $jumlah = Riwayat::where('pengajuan_id', $id)->count();
        
        $riwayat = Riwayat::where('pengajuan_id', $id)->latest()
            ->get();

        return view ('user.riwayat.verifikasi-ijazah.tracking', [
            'riwayat'   =>  $riwayat,
            'jumlah'=>  $jumlah
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function indexPengantarPkl(Request $request)
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::with(['pengajuan'])->whereUserId($user->id)->first();

        $title          = "Data Pengajuan Surat Pengantar PKL";

        $pengantarPkl = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 2)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->get();
        
        return view('user.riwayat.pengantar-pkl.index', [
            'pengantarPkl'   => $pengantarPkl,
            'user'   => $user,
            'title'            => $title,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function konfirmasi(KonfirmasiPklRequest $request, string $id)
    {
        $image = Pengajuan::saveImage($request);

        $data = [
            'status'  =>  $request->status,
            'image'   =>  $image
        ];

        Pengajuan::where('id', $id)->update($data);

        Riwayat::create([
            'pengajuan_id'  => $id,
            'status'        => $request->status,
            'catatan'       => 'Status Pengajuan Anda Sedang Diproses. Tunggu pemberitahuan selanjutnya'
        ]);

        if ($request->status == 'Diterima Perusahaan') {
            Riwayat::create([
                'pengajuan_id'  => $id,
                'status'        => $request->status,
                'catatan'       => 'Selamat! Pengajuan Anda Diterima Perusahaan. Jika Ingin Melakukan Pengajuan Kembali Harap Konfirmasi Jika PKL Anda Telah Selesai'
            ]);
        }else {
            Riwayat::create([
                'pengajuan_id'  => $id,
                'status'        => $request->status,
                'catatan'       => 'Tetap Semangat! Walaupun Pengajuan Anda Ditolak Perusahaan. Jika Ingin Melakukan Pengajuan Kembali Harap Konfirmasi Penolakan Anda'
            ]);
        }

        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

    /**
     * Update the specified resource in storage.
     */
    public function konfirmasiSelesai(Request $request, string $id)
    {
        $request->validate([
            'bukti_selesai' => 'required',
        ], [
            'bukti_selesai.required' => 'Bukti Wajib Diisi',
        ]);

        $bukti = Pengajuan::saveBukti($request);

        $data = [
            'bukti_selesai'   =>  $bukti,
            'status'   =>  'Selesai PKL'
        ];

        Pengajuan::where('id', $id)->update($data);

        Riwayat::create([
            'pengajuan_id'  => $id,
            'status'        => 'Selesai PKL',
            'catatan'       => 'Kamu Hebat! PKL Kamu Telah Selesai, Sekarang Anda Dapat Melakukan Pengajuan Kembali'
        ]);

        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function trackingPengantarPkl(string $id)
    {
        $jumlah = Riwayat::where('pengajuan_id', $id)->count();
        
        $riwayat = Riwayat::where('pengajuan_id', $id)
            ->latest()
            ->get();

        return view ('user.riwayat.pengantar-pkl.tracking', [
            'riwayat'   =>  $riwayat,
            'jumlah'    =>  $jumlah,
            'title'     => 'Tracking Pengajuan PKL'
        ]);
    }

}
