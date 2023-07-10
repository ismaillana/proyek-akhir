<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\IzinPenelitian;
use App\Models\Pengajuan;
use App\Models\Riwayat;
use App\Models\JenisPengajuan;

use App\Http\Requests\IzinPenelitianRequest;
use App\Http\Requests\KonfirmasiRequest;
use App\Exports\IzinPenelitianExport;
use App\Services\WhatsappGatewayService;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use File;
use Repsonse;
use PDF;
use setasign\Fpdi\Fpdi;


class IzinPenelitianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $izinPenelitian = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 3)
            ->whereNot('status', 'Selesai')
            ->whereNot('status', 'Tolak')
            ->get();

        if ($user->hasRole('admin-jurusan')) {
            return view ('admin.pengajuan.izin-penelitian.index-admin-jurusan', [
                'izinPenelitian'   => $izinPenelitian,
                'user'     => $user,
                'title'    => 'Izin Penelitian'
            ]);
        } else {
            return view ('admin.pengajuan.izin-penelitian.index', [
                'izinPenelitian'   => $izinPenelitian,
                'title'    => 'Izin Penelitian'
            ]);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
    
        $mahasiswa       = Mahasiswa::with(['pengajuan'])->whereUserId($user->id)
            ->first();

        $pengajuan = Pengajuan::where('mahasiswa_id', $mahasiswa->id)
            ->where('jenis_pengajuan_id', 3)
            ->latest()
            ->first();

        return view ('user.pengajuan.izin-penelitian.form',[
            'mahasiswa' => $mahasiswa,
            'pengajuan' => $pengajuan,
            'title'    => 'Izin Penelitian'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IzinPenelitianRequest $request)
    {
        $user = auth()->user();

        $mahasiswa  = Mahasiswa::whereUserId($user->id)->first();
        $waGateway = $user->wa; //get no wa

        $adminJurusan = User::role('admin-jurusan')
            ->where('jurusan_id', $mahasiswa->programStudi->jurusan->id)
            ->get();
        $numbers = $adminJurusan->pluck('wa')->toArray();

        $pengajuan = Pengajuan::create([
            'jenis_pengajuan_id'=> 3,
            'mahasiswa_id'      => $mahasiswa->id,
            'nama_tempat'       => $request->nama_tempat,
            'alamat_tempat'     => $request->alamat_tempat,
            'tujuan_surat'      => $request->tujuan_surat,
            'perihal'           => $request->perihal,
        ]);

        Riwayat::create([
            'pengajuan_id'  => $pengajuan->id,
            'status'        => 'Menunggu Konfirmasi',
            'catatan'       => 'Pengajuan Berhasil Dibuat. Tunggu pemberitahuan selanjutnya'
        ]);

        // WhatsappGatewayService::sendMessage($waGateway, 
        //     'Hai, ' . $user->name . PHP_EOL .
        //         PHP_EOL .
        //         'Pengajuan Pembuatan Surat Izin Penelitian yang kamu lakukan Berhasil! ' . PHP_EOL .
        //         'Harap tunggu Konfirmasi dari bagian akademik.' . PHP_EOL .
        //         PHP_EOL .
        //         'Terima Kasih'
        // ); //->Kirim Chat

        // foreach ($numbers as $number) {
        //     WhatsappGatewayService::sendMessage($number, 
        //         'Hai, Admin Jurusan!' . PHP_EOL .
        //             PHP_EOL .
        //             'Ada pengajuan baru dari '. $user->name . PHP_EOL .
        //             'Segera lakukan pengecekan data pengajuan!'
        //     ); //->Kirim Chat
        // }

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

        $user = auth()->user();

        $izinPenelitian = Pengajuan::find($id);
        return view ('admin.pengajuan.izin-penelitian.detail', [
            'izinPenelitian'    =>  $izinPenelitian,
            'user'              =>  $user,
            'title'             =>  'Detail Pengajuan Izin Penelitian'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function konfirmasi(Request $request, string $id)
    {
        $request->validate([
            'dokumen_permohonan' => 'required',
        ], [
            'dokumen_permohonan.required' => 'Masukkan Dokumen Permohonan',
        ]);

        $bagianAkademik = User::role('bagian-akademik') 
            ->get();
        $numbers = $bagianAkademik->pluck('wa')->toArray();

        $pengajuan = Pengajuan::where('id',$id)->first();

        $waGateway = $pengajuan->mahasiswa->user->wa; //get no wa

        $dokumen = Pengajuan::saveDokumenPermohonan($request);

        $data = [
            'status'  =>  'Konfirmasi',
            'dokumen_permohonan' => $dokumen
        ];

        Pengajuan::where('id', $id)->update($data);

        Riwayat::create([
            'pengajuan_id'  => $id,
            'status'        => 'Dikonfirmasi',
            'catatan'       => 'Pengajuan Anda Telah Dikonfirmasi. Tunggu pemberitahuan selanjutnya'
        ]);

        WhatsappGatewayService::sendMessage($waGateway, 
        'Hai, ' . $pengajuan->mahasiswa->user->name . ',' . PHP_EOL .
                PHP_EOL .
                'Pengajuan Pembuatan Surat Izin Penelitian yang kamu lakukan telah dikonfirmasi oleh Bagian Akademik! ' . PHP_EOL .
                'Harap tunggu pemberitahuan selanjutnya.' . PHP_EOL .
                PHP_EOL .
                'Terima Kasih'
        ); //->Kirim Chat

        foreach ($numbers as $number) {
            WhatsappGatewayService::sendMessage($number, 
                'Hai, Admin Jurusan!' . PHP_EOL .
                    PHP_EOL .
                    'Ada pengajuan baru dari '. $pengajuan->mahasiswa->user->name . PHP_EOL .
                    'Segera lakukan pengecekan data pengajuan!'
            ); //->Kirim Chat
        }

        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

    /**
     * Update the specified resource in storage.
     */
    public function tolak(KonfirmasiRequest $request, string $id)
    {
        $pengajuan = Pengajuan::where('id',$id)->first();
        
        $waGateway = $pengajuan->mahasiswa->user->wa; //get no wa

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

        WhatsappGatewayService::sendMessage($waGateway, 
        'Hai, ' . $pengajuan->mahasiswa->user->name . ',' . PHP_EOL .
                PHP_EOL .
                'Pengajuan Pembuatan Surat Izin Penelitian yang kamu lakukan Ditolak oleh Bagian Akademik dengan alasan/catatan ' . PHP_EOL .
                PHP_EOL .
                '**' . $request->catatan . PHP_EOL .
                PHP_EOL .
                'Terima Kasih'
        ); //->Kirim Chat

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

        $pengajuan = Pengajuan::where('id',$id)->first();
        
        $waGateway = $pengajuan->mahasiswa->user->wa; //get no wa

        if ($request->status == 'Proses' ) {
            Riwayat::create([
                'pengajuan_id'  => $id,
                'status'        => 'Diproses',
                'catatan'       => 'Pengajuan Anda Sedang Diproses. Tunggu pemberitahuan selanjutnya'
            ]);

            WhatsappGatewayService::sendMessage($waGateway, 
                'Hai, ' . $pengajuan->mahasiswa->user->name . ',' . PHP_EOL .
                    PHP_EOL .
                    'Pengajuan Pembuatan Surat Izin Penelitian yang kamu lakukan sedang Diproses oleh Bagian Akademik!' . PHP_EOL .
                    'Proses dilakukan selama 3-5 hari kerja, namun bisa saja kurang atau melebihi waktu tersebut. Harap tunggu informasi selanjutnya' . PHP_EOL .
                    PHP_EOL .
                    'Terima Kasih'
            ); //->Kirim Chat
        }elseif ($request->status == 'Kendala' ) {
            Riwayat::create([
                'pengajuan_id'  => $id,
                'status'        => 'Ada Kendala',
                'catatan'       => 'Pengajuan Anda Sedang Dalam Kendala. Tunggu pemberitahuan selanjutnya'
            ]);

            WhatsappGatewayService::sendMessage($waGateway, 
                'Hai, ' . $pengajuan->mahasiswa->user->name . ',' . PHP_EOL .
                    PHP_EOL .
                    'Pengajuan Pembuatan Surat Izin Penelitian yang kamu lakukan sedang Dalam Kendala!' . PHP_EOL .
                    'Harap menunggu pemberitahuan selanjutnya dikarenakan di lingkungan kampus sedang terdapat kegiatan yang melibatkan Bagian Akademik!' . PHP_EOL .
                    PHP_EOL .
                    'Terima Kasih'
            ); //->Kirim Chat
        }elseif ($request->status == 'Selesai' ) {
            Riwayat::create([
                'pengajuan_id'  => $id,
                'status'        => 'Selesai',
                'catatan'       => 'Pengajuan Anda Sudah Selesai. Ambil Dokumen Di Ruangan AKademik'
            ]);

            WhatsappGatewayService::sendMessage($waGateway, 
                'Hai, ' . $pengajuan->mahasiswa->user->name . ',' . PHP_EOL .
                    PHP_EOL .
                    'Pengajuan Pembuatan Surat Izin Penelitian yang kamu lakukan Telah Selesa!' . PHP_EOL .
                    'Surat Keterangan Aktif Kuliah dapat diambil diruangan akademik dengan nomor surat ' . @$pengajuan->nomor_surat . PHP_EOL .
                    PHP_EOL .
                    'Terima Kasih'
            ); //->Kirim Chat
        }
        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

    /**
     * Display a listing of the resource.
     */
    public function riwayat()
    {
        $user = auth()->user();

        $izinPenelitian = Pengajuan::where('jenis_pengajuan_id', 3)
            ->where('status', 'Tolak')
            ->orWhere('jenis_pengajuan_id', 3)
            ->where('status', 'Selesai')
            ->latest()
            ->get();

        if ($user->hasRole('admin-jurusan')) {
            return view ('admin.riwayat.izin-penelitian.index-admin-jurusan', [
                'izinPenelitian'   => $izinPenelitian,
                'user'             => $user,
                'title'         => 'Surat Izin Penelitian'
            ]);
        } else {
            return view ('admin.riwayat.izin-penelitian.index', [
                'izinPenelitian'   => $izinPenelitian,
                'title'         => 'Surat Izin Penelitian'
            ]);
        }
        
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

        $izinPenelitian = Pengajuan::find($id);
        return view ('admin.riwayat.izin-penelitian.detail', [
            'izinPenelitian'    =>  $izinPenelitian,
            'title'             =>  'Detail Pengajuan Izin Penelitian'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date'   => 'required',
        ], [
            'start_date.required' => 'Masukkan Tanggal Mulai',
            'end_date.required'   => 'Masukkan Tanggal Selesai',
        ]);
        
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

        $data = Pengajuan::with(['mahasiswa'])
            ->where('jenis_pengajuan_id', 3)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return Excel::download(new IzinPenelitianExport($data), 'Izin-Penelitian-Export.xlsx');
    }

    /**
     * Display the specified resource.
     */
    public function print($id)
    {
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            abort(404);
        }
        
        $izinPenelitian = Pengajuan::find($id);

        if ($izinPenelitian->tanggal_surat == null) {
            $now   = Carbon::now()->locale('id');
            $currentDate =  $now->translatedFormat('l, d F Y'); // Mendapatkan tanggal saat ini dengan nama hari dalam bahasa Indonesia
            
            $izinPenelitian->update([
                'tanggal_surat'            => $currentDate,
            ]);
        } // Mendapatkan tanggal saat ini dengan nama hari dalam bahasa Indonesia
            // Mendapatkan tanggal saat ini dengan nama hari
        
        //mengambil data dan tampilan dari halaman laporan_pdf
        //data di bawah ini bisa kalian ganti nantinya dengan data dari database
        $data = PDF::loadview('admin.pengajuan.izin-penelitian.print', [
            'izinPenelitian'=> $izinPenelitian
        ]);
        //mendownload laporan.pdf
    	return $data->stream('Surat-izin-penelitian.pdf');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateNoSurat(Request $request, string $id)
    {
        $request->validate([
            'no_surat' => 'required',
        ], [
            'no_surat.required' => 'Masukkan Nomor Surat',
        ]);
        
        $data = [
            'no_surat'  =>  $request->no_surat
        ];

        Pengajuan::where('id', $id)->update($data);

        return redirect()->back()->with('success', 'No Surat Berhasil Diubah');
    }
}
