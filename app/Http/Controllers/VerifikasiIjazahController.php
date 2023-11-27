<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instansi;
use App\Models\Riwayat;
use App\Models\Pengajuan;
use App\Models\User;

use App\Http\Requests\VerifikasiIjazahRequest;
use App\Http\Requests\KonfirmasiRequest;
use App\Exports\VerifikasiIjazahExport;
use App\Services\WhatsappGatewayService;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use File;
use Repsonse;
use PDF;
use Carbon\Carbon;
use setasign\Fpdi\Fpdi;

class VerifikasiIjazahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $user = auth()->user();
    //     $oneDayAgo = Carbon::now()->subDay();
    //     if ($user->hasRole('super-admin')) {
    //         $verifikasiIjazah = Pengajuan::latest()
    //             ->where('jenis_pengajuan_id', 6)
    //             ->where('status', 'Menunggu Konfirmasi')
    //             ->where('created_at', '<=', $oneDayAgo)
    //             ->get();

    //         return view ('admin.pengajuan.verifikasi-ijazah.index', [
    //             'verifikasiIjazah'  => $verifikasiIjazah,
    //             'title'             => 'Verifikasi Ijazah'
    //         ]);
    //     }else {
    //         $verifikasiIjazah = Pengajuan::latest()
    //             ->where('jenis_pengajuan_id', 6)
    //             ->whereNotIn('status', ['Selesai', 'Tolak'])
    //             ->get();
    
    //         return view ('admin.pengajuan.verifikasi-ijazah.index', [
    //             'verifikasiIjazah'  => $verifikasiIjazah,
    //             'title'             => 'Verifikasi Ijazah'
    //         ]);
    //     }
    // }
    public function index()
{
    $user = auth()->user();
    $oneDayAgo = Carbon::now()->subDay();
    if ($user->hasRole('super-admin')) {
        $verifikasiIjazah = Pengajuan::latest()
            ->select('kode_verifikasi', 'instansi_id', \DB::raw('MAX(created_at) as created_at'), 'status') // Memilih kolom kode_verifikasi
            ->where('jenis_pengajuan_id', 6)
            ->where('status', 'Menunggu Konfirmasi')
            ->where('created_at', '<=', $oneDayAgo)
            ->distinct() // Menampilkan data yang unik berdasarkan kode_verifikasi
            ->get();

        return view('admin.pengajuan.verifikasi-ijazah.index', [
            'verifikasiIjazah' => $verifikasiIjazah,
            'title' => 'Verifikasi Ijazah'
        ]);
    } else {
        $verifikasiIjazah = Pengajuan::latest()
            ->select('kode_verifikasi', 'instansi_id', \DB::raw('MAX(created_at) as created_at'), \DB::raw('MAX(status) as status')) // Memilih kolom kode_verifikasi
            ->where('jenis_pengajuan_id', 6)
            ->whereNotIn('status', ['Selesai', 'Tolak'])
            ->groupBy('kode_verifikasi', 'instansi_id', 'status')
            ->get();
        // dd($verifikasiIjazah);
            

        $verifikasi = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 6)
            ->whereIn('kode_verifikasi', $verifikasiIjazah->pluck('kode_verifikasi'))
            ->get();
        // return dd($verifikasiIjazah);
        return view('admin.pengajuan.verifikasi-ijazah.index', [
            'verifikasiIjazah' => $verifikasiIjazah,
            'verifikasi'       => $verifikasi,
            'title' => 'Verifikasi Ijazah'
        ]);
    }
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengaju = auth()->user();

        $instansi       = Instansi::with(['pengajuan'])->whereUserId($pengaju->id)->first();

        $pengajuan = Pengajuan::where('instansi_id', $instansi->id)
            ->where('jenis_pengajuan_id', 6)
            ->latest()
            ->first();

        return view('user.pengajuan.verifikasi-ijazah.form', [
            'pengajuan' => $pengajuan,
            'title' => 'Verifikasi Ijazah' 
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(VerifikasiIjazahRequest $request)
    // {
    //     $user = auth()->user();

    //     $bagianAkademik = User::role('bagian-akademik') 
    //         ->get();
    //     $numbers = $bagianAkademik->pluck('wa')->toArray();
    //     // dd($numbers);

    //     $instansi       = Instansi::whereUserId($user->id)->first();

    //     $waGateway = $user->wa; //get no wa

    //     $data = ([
    //         'jenis_pengajuan_id' => 6,
    //         'instansi_id'      => $instansi->id,
    //         'nama'             => $request->nama,
    //         'nim'              => $request->nim,
    //         'no_ijazah'        => $request->no_ijazah,
    //         'tahun_lulus'      => $request->tahun_lulus,
    //         'dokumen'          => $request->dokumen,
    //     ]);

    //     $dokumen = Pengajuan::saveDokumen($request);

    //     $data['dokumen'] = $dokumen;

    //     $pengajuan = Pengajuan::create($data);

    //     Riwayat::create([
    //         'pengajuan_id'  => $pengajuan->id,
    //         'status'        => 'Menunggu Konfirmasi',
    //         'catatan'       => 'Pengajuan Berhasil Dibuat. Tunggu pemberitahuan selanjutnya'
    //     ]);

    //     WhatsappGatewayService::sendMessage($waGateway, 
    //         'Hai, ' . $user->name . PHP_EOL .
    //             PHP_EOL .
    //             'Pengajuan Pengecekan keaslian ijazah yang kamu lakukan Berhasil! ' . PHP_EOL .
    //             'Harap tunggu Konfirmasi dari bagian akademik.' . PHP_EOL .
    //             PHP_EOL .
    //             'Terima Kasih'. PHP_EOL .
    //             PHP_EOL .
    //             '[Politeknik Negeri Subang]'
    //     ); //->Kirim Chat

    //     foreach ($numbers as $number) {
    //         WhatsappGatewayService::sendMessage($number, 
    //             'Hai, Bagian Akademik!' . PHP_EOL .
    //                 PHP_EOL .
    //                 'Ada pengajuan Verifikasi Ijazah baru dari '. $user->name . PHP_EOL .
    //                 'Segera lakukan pengecekan data pengajuan!'. PHP_EOL .
    //                 PHP_EOL .
    //                 '[Politeknik Negeri Subang]'
    //         ); //->Kirim Chat
    //     }

    //     return redirect()->back()->with('success', 'Pengajuan Berhasil');
    // }

    public function store(VerifikasiIjazahRequest $request)
    {
        $user = auth()->user();
        $bagianAkademik = User::role('bagian-akademik')->get();
        $numbers = $bagianAkademik->pluck('wa')->toArray();
        $instansi = Instansi::whereUserId($user->id)->first();
        // Logika untuk menghasilkan kode verifikasi otomatis
        $latestPengajuan = Pengajuan::where('jenis_pengajuan_id', '6') // Sesuaikan dengan jenis pengajuan Anda
            ->latest('kode_verifikasi')
            ->first();
        $angkaUrut = $latestPengajuan ? intval(substr($latestPengajuan->kode_verifikasi, 4)) + 1 : 1;
        $kodeVerifikasi = 'VEI_' . str_pad($angkaUrut, 2, '0', STR_PAD_LEFT);
        // Ambil data dari elemen input yang ada dalam repeater
        $namaMahasiswa = $request->input('nama');
        $nimMahasiswa = $request->input('nim');
        $noIjazah = $request->input('no_ijazah');
        $tahunLulus = $request->input('tahun_lulus');

        // Loop melalui data-data mahasiswa yang diinputkan
        foreach ($namaMahasiswa as $key => $nama) {
            $data = [
                'jenis_pengajuan_id' => 6,
                'instansi_id'      => $instansi->id,
                'nama'             => $nama,
                'nim'              => $nimMahasiswa[$key],
                'no_ijazah'        => $noIjazah[$key],
                'tahun_lulus'      => $tahunLulus[$key],
                'kode_verifikasi'  => $kodeVerifikasi,
            ];

            // Simpan dokumen terkait pengajuan
            $dokumen = Pengajuan::saveDokumen($request);
            $data['dokumen'] = $dokumen;

            // Buat pengajuan untuk setiap mahasiswa
            $pengajuan = Pengajuan::create($data);

            // Tambahkan riwayat pengajuan
            Riwayat::create([
                'pengajuan_id'  => $pengajuan->id,
                'status'        => 'Menunggu Konfirmasi',
                'catatan'       => 'Pengajuan Berhasil Dibuat. Tunggu pemberitahuan selanjutnya'
            ]);
        }

        // ... Sisanya tetap sama seperti kode sebelumnya

        return redirect()->back()->with('success', 'Pengajuan Berhasil');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $kodeVerifikasi)
    {
        // try {
        //     $id = Crypt::decryptString($id);
        // } catch (DecryptException $e) {
        //     abort(404);
        // }

        // $verifikasiIjazah = Pengajuan::find($id);
        $verifikasiIjazah = Pengajuan::where('kode_verifikasi', $kodeVerifikasi)
        ->get();

        // return dd($verifikasiIjazah);
        return view ('admin.pengajuan.verifikasi-ijazah.detail', [
            'verifikasiIjazah'    =>  $verifikasiIjazah,
            'title'         =>  'Detail Pengajuan Verifikasi Ijazah'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function konfirmasi(Request $request, string $id)
    // {
    //     $pengajuan = Pengajuan::where('id',$id)->first();
        
    //     $waGateway = $pengajuan->instansi->user->wa; //get no wa

    //     if ($pengajuan->no_surat == null) {
    //         return redirect()->back()->with('error', 'Nomor Surat Belum Diisi!');
    //     }

    //     $data = [
    //         'status'  =>  'Konfirmasi'
    //     ];

    //     Pengajuan::where('id', $id)->update($data);

    //     Riwayat::create([
    //         'pengajuan_id'  => $id,
    //         'status'        => 'Dikonfirmasi',
    //         'catatan'       => 'Pengajuan Anda Telah Dikonfirmasi. Tunggu pemberitahuan selanjutnya'
    //     ]);

    //     WhatsappGatewayService::sendMessage($waGateway, 
    //     'Hai, ' . $pengajuan->instansi->user->name . ',' . PHP_EOL .
    //             PHP_EOL .
    //             'Pengajuan Pengecekan keaslian ijazah yang kamu lakukan telah dikonfirmasi oleh Bagian Akademik! ' . PHP_EOL .
    //             'Harap tunggu pemberitahuan selanjutnya.' . PHP_EOL .
    //             PHP_EOL .
    //             'Terima Kasih'. PHP_EOL .
    //             PHP_EOL .
    //             '[Politeknik Negeri Subang]'
    //     ); //->Kirim Chat

    //     return redirect()->back()->with('success', 'Status Berhasil Diubah');
    // }

    /**
     * Update the specified resource in storage.
     */
    public function konfirmasi(Request $request, string $id)
    {

        $pengajuan = Pengajuan::where('kode_verifikasi',$id)->get();

        $waGateway = [];

        foreach ($pengajuan as $item) {

            if ($item->no_surat == null) {
                return redirect()->back()->with('error', 'Nomor Surat Belum Diisi!');
            }

            $waGateway[] = $item->instansi->user->wa;

            $data = [
                'status'  =>  'Konfirmasi',
            ];

            //Update pengajuan sesuai id
            Pengajuan::where('id', $item->id)->update($data);

            Riwayat::create([
                'pengajuan_id'  => $item->id,
                'status'        => 'Dikonfirmasi',
                'catatan'       => 'Pengajuan Anda Telah Dikonfirmasi. Tunggu pemberitahuan selanjutnya'
            ]);
        }

        foreach ($waGateway as $wa) {
            WhatsappGatewayService::sendMessage($wa, 
                // 'Hai, ' . $pengajuan[0]->mahasiswa->user->name. ',' . PHP_EOL .
                'Hai, '. PHP_EOL .
                PHP_EOL .
                'Pengajuan Pembuatan Surat Verifikasi ijazah yang kamu lakukan telah dikonfirmasi oleh Bagian Akademik! ' . PHP_EOL .
                'Harap tunggu pemberitahuan selanjutnya.' . PHP_EOL .
                PHP_EOL .
                'Terima Kasih' . PHP_EOL .
                PHP_EOL .
                '[Politeknik Negeri Subang]'
            ); //->Kirim Chat
        }

        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

    /**
     * Update the specified resource in storage.
     */
    // public function tolak(KonfirmasiRequest $request, string $id)
    // {
    //     $pengajuan = Pengajuan::where('id',$id)->first();
        
    //     $waGateway = $pengajuan->instansi->user->wa; //get no wa

    //     $data = [
    //         'status'  =>  'Tolak',
    //         'catatan' =>  $request->catatan
    //     ];

    //     Riwayat::create([
    //         'pengajuan_id'  => $id,
    //         'status'        => 'Ditolak',
    //         'catatan'       => $request->catatan
    //     ]);

    //     Pengajuan::where('id', $id)->update($data);

    //     WhatsappGatewayService::sendMessage($waGateway, 
    //     'Hai, ' . $pengajuan->instansi->user->name . ',' . PHP_EOL .
    //             PHP_EOL .
    //             'Pengajuan Pengecekan keaslian ijazah yang kamu lakukan Ditolak oleh Bagian Akademik dengan alasan/catatan ' . PHP_EOL .
    //             PHP_EOL .
    //             '**' . $request->catatan . PHP_EOL .
    //             PHP_EOL .
    //             'Terima Kasih'. PHP_EOL .
    //             PHP_EOL .
    //             '[Politeknik Negeri Subang]'
    //     ); //->Kirim Chat

    //     return redirect()->back()->with('success', 'Status Berhasil Diubah');
    // }

    /**
     * Update the specified resource in storage.
     */
    public function tolak(Request $request, string $id)
    {
        $request->validate([
            'catatan' => 'required',
        ], [
            'catatan.required' => 'Masukkan Catatan',
        ]);

        $pengajuan = Pengajuan::where('kode_verifikasi',$id)->get();

        $waGateway = [];

        foreach ($pengajuan as $item) {

            $waGateway[] = $item->instansi->user->wa;

            $data = [
                'status'  =>  'Tolak',
                'catatan' =>  $request->catatan
            ];
            
            Pengajuan::where('id', $item->id)->update($data);
    
            Riwayat::create([
                'pengajuan_id'  => $item->id,
                'status'        => 'Ditolak',
                'catatan'       => $request->catatan
            ]);
        }
        foreach ($waGateway as $wa) {
            WhatsappGatewayService::sendMessage($wa, 
            'Hai, ' . PHP_EOL .
                    PHP_EOL .
                    'Pengajuan Pembuatan Surat Verifikasi Ijazah yang kamu lakukan Ditolak oleh Admin Jurusan atau Koordinator PKL dengan alasan/catatan ' . PHP_EOL .
                    PHP_EOL .
                    '**' . $request->catatan . PHP_EOL .
                    PHP_EOL .
                    'Terima Kasih' . PHP_EOL .
                    PHP_EOL .
                    '[Politeknik Negeri Subang]'
            ); //->Kirim Chat
        }

        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, string $id)
    {
        // $request->validate([
        //     'status' => 'required',
        //     'dokumen_hasil' => 'required_if:status,Selesai',
        // ], [
        //     'status.required' => 'Pilih Status',
        //     'dokumen_hasil.required_if' => 'Masukkan Dokumen Hasil',
        // ]);

        // $verifikasiIjazah = Pengajuan::where('kode_verifikasi', $id)->get();

        // $waGateway = [];
        // foreach ($verifikasiIjazah as $item) {
        //     $waGateway[] = $item->instansi->user->wa;
            
        //     if ($request->status == 'Selesai') {
    
        //         // $dokumen = Pengajuan::saveDokumenHasil($request);
    
        //         $data = [
        //             'status'  =>  $request->status,
        //             // 'dokumen_hasil' => $dokumen
        //         ];
        //     } else {
        //         $data = [
        //             'status'  =>  $request->status
        //         ];
        //     }

        //     Pengajuan::where('kode_verifikasi', $id)->update($data);
        // }


        // $pengajuan = Pengajuan::where('kode_verifikasi',$id)->get();
        
        // $waGateway = $pengajuan->instansi->user->wa; //get no wa

        // if ($request->status == 'Proses' ) {
        //     Riwayat::create([
        //         'pengajuan_id'  => $id,
        //         'status'        => 'Diproses',
        //         'catatan'       => 'Pengajuan Anda Sedang Diproses. Tunggu pemberitahuan selanjutnya'
        //     ]);

        //     WhatsappGatewayService::sendMessage($waGateway, 
        //         'Hai, ' . $pengajuan->instansi->user->name . ',' . PHP_EOL .
        //             PHP_EOL .
        //             'Pengajuan Pengecekan keaslian ijazah yang kamu lakukan sedang Diproses oleh Bagian Akademik!' . PHP_EOL .
        //             'Proses dilakukan selama 3-5 hari kerja, namun bisa saja kurang atau melebihi waktu tersebut. Harap tunggu informasi selanjutnya' . PHP_EOL .
        //             PHP_EOL .
        //             'Terima Kasih'. PHP_EOL .
        //             PHP_EOL .
        //             '[Politeknik Negeri Subang]'
        //     ); //->Kirim Chat
        // }elseif ($request->status == 'Kendala' ) {
        //     Riwayat::create([
        //         'pengajuan_id'  => $id,
        //         'status'        => 'Ada Kendala',
        //         'catatan'       => 'Pengajuan Anda Sedang Dalam Kendala. Tunggu pemberitahuan selanjutnya'
        //     ]);

        //     WhatsappGatewayService::sendMessage($waGateway, 
        //         'Hai, ' . $pengajuan->instansi->user->name . ',' . PHP_EOL .
        //             PHP_EOL .
        //             'Pengajuan Pengecekan keaslian ijazah yang kamu lakukan sedang Dalam Kendala!' . PHP_EOL .
        //             'Harap menunggu pemberitahuan selanjutnya dikarenakan di lingkungan kampus sedang terdapat kegiatan yang melibatkan Bagian Akademik!' . PHP_EOL .
        //             PHP_EOL .
        //             'Terima Kasih'. PHP_EOL .
        //             PHP_EOL .
        //             '[Politeknik Negeri Subang]'
        //     ); //->Kirim Chat
        // }elseif ($request->status == 'Selesai' ) {
        //     Riwayat::create([
        //         'pengajuan_id'  => $id,
        //         'status'        => 'Selesai',
        //         'catatan'       => 'Pengajuan Anda Sudah Selesai. Ambil Dokumen Di Ruangan AKademik'
        //     ]);

        //     WhatsappGatewayService::sendMessage($waGateway, 
        //         'Hai, ' . $pengajuan->instansi->user->name . ',' . PHP_EOL .
        //             PHP_EOL .
        //             'Pengajuan Pengecekan keaslian ijazah yang kamu lakukan Telah Selesai!' . PHP_EOL .
        //             'Silahkan login kembali ke website pengajuan kemudian buka menu Riwayat Pengajuan untuk mengunduh hasil pengajuan.' . PHP_EOL .
        //             PHP_EOL .
        //             'Terima Kasih'. PHP_EOL .
        //             PHP_EOL .
        //             '[Politeknik Negeri Subang]'
        //     ); //->Kirim Chat
        // }

        $verifikasiIjazahItem = pengajuan::where('kode_verifikasi', $id)->get();
        
        // $waGateway = [];
        foreach ($verifikasiIjazahItem as $item) {
            // $waGateway[] = $item->mahasiswa->user->wa;
            $nomor_surat = $item->no_surat;
            if ($request->status == 'Selesai') {
    
                $dokumen = Pengajuan::saveDokumenHasil($request);
    
                $item->update([
                    'status'  =>  $request->input('status'),
                    'dokumen_hasil' => $dokumen
                ]);
            } else {
                $item->update([
                    'status'  =>  $request->input('status')
                ]);
            }

            // $item->update([
            //     'status' => $request->input('status'),
            // ]);

            if ($request->status == 'Proses' ) {
                Riwayat::create([
                    'pengajuan_id'  => $item->id,
                    'status'        => 'Diproses',
                    'catatan'       => 'Pengajuan Anda Sedang Diproses. Tunggu pemberitahuan selanjutnya'
                ]);
            }elseif ($request->status == 'Kendala' ) {
                Riwayat::create([
                    'pengajuan_id'  => $item->id,
                    'status'        => 'Ada Kendala',
                    'catatan'       => 'Pengajuan Anda Sedang Dalam Kendala. Tunggu pemberitahuan selanjutnya'
                ]);
            }elseif ($request->status == 'Selesai' ) {
                Riwayat::create([
                    'pengajuan_id'  => $item->id,
                    'status'        => 'Selesai',
                    'catatan'       => 'Pengajuan Anda Sudah Selesai. Ambil Dokumen Di Ruangan AKademik'
                ]);
            }
        }

        // if ($request->status == 'Proses' ) {
        //     foreach ($waGateway as $wa) {
        //         WhatsappGatewayService::sendMessage($wa, 
        //             'Hai, '. PHP_EOL .
        //                 PHP_EOL .
        //                 'Pengajuan Pembuatan Surat Pengantar PKL yang kamu lakukan sedang Diproses oleh Bagian Akademik!' . PHP_EOL .
        //                 'Proses dilakukan selama 3-5 hari kerja, namun bisa saja kurang atau melebihi waktu tersebut. Harap tunggu informasi selanjutnya' . PHP_EOL .
        //                 PHP_EOL .
        //                 'Terima Kasih' . PHP_EOL .
        //                 PHP_EOL .
        //                 '[Politeknik Negeri Subang]'
        //         ); 
        //     }
        // }elseif ($request->status == 'Kendala' ) {
        //     foreach ($waGateway as $wa) {
        //         WhatsappGatewayService::sendMessage($wa, 
        //             'Hai, ' . PHP_EOL .
        //                 PHP_EOL .
        //                 'Pengajuan Pembuatan Surat Pengantar PKL yang kamu lakukan sedang Dalam Kendala!' . PHP_EOL .
        //                 'Harap menunggu pemberitahuan selanjutnya dikarenakan di lingkungan kampus sedang terdapat kegiatan yang melibatkan Bagian Akademik!' . PHP_EOL .
        //                 PHP_EOL .
        //                 'Terima Kasih' . PHP_EOL .
        //                 PHP_EOL .
        //                 '[Politeknik Negeri Subang]'
        //         ); 
        //     }
        // }elseif ($request->status == 'Selesai' ) {
        //     foreach ($waGateway as $wa) {
        //         WhatsappGatewayService::sendMessage($wa, 
        //             'Hai, ' . PHP_EOL .
        //                 PHP_EOL .
        //                 'Pengajuan Pembuatan Surat Pengantar PKL yang kamu lakukan Telah Selesai!' . PHP_EOL .
        //                 'Surat Pengantar PKL dapat diambil diruangan akademik dengan nomor surat ' . $nomor_surat . PHP_EOL .
        //                 PHP_EOL .
        //                 'Terima Kasih' . PHP_EOL .
        //                 PHP_EOL .
        //                 '[Politeknik Negeri Subang]'
        //         ); 
        //     }
        // }

        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

    /**
     * Display a listing of the resource.
     */
    public function riwayat()
    {
        $verifikasiIjazah = Pengajuan::latest()
            ->select('kode_verifikasi', 'instansi_id', \DB::raw('MAX(created_at) as created_at'), \DB::raw('MAX(status) as status')) // Memilih kolom kode_verifikasi
            ->where('jenis_pengajuan_id', 6)
            // ->whereNotIn('status', ['Selesai', 'Tolak'])
            ->groupBy('kode_verifikasi', 'instansi_id', 'status')
            ->get();
        // dd($verifikasiIjazah);

        $verifikasi = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 6)
            ->whereIn('kode_verifikasi', $verifikasiIjazah->pluck('kode_verifikasi'))
            ->get();

        return view ('admin.riwayat.verifikasi-ijazah.index', [
            'verifikasiIjazah'   => $verifikasiIjazah,
            'verifikasi'         => $verifikasi,
            'title'         => 'Verifikasi Ijazah'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showRiwayat(string $kodeVerifikasi)
    {
        // try {
        //     $id = Crypt::decryptString($id);
        // } catch (DecryptException $e) {
        //     abort(404);
        // }

        $verifikasiIjazah = Pengajuan::where('kode_verifikasi', $kodeVerifikasi)
        ->get();

        return view ('admin.riwayat.verifikasi-ijazah.detail', [
            'verifikasiIjazah'    =>  $verifikasiIjazah,
            'title'        =>  'Detail Pengajuan verifikasi Ijazah'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function print($id)
    {
        
        $verifikasiIjazah = Pengajuan::where('kode_verifikasi', $id)->get();
        
        foreach ($verifikasiIjazah as $item) {
            if ($item->no_surat == null) {
                return redirect()->back()->with('error', 'Nomor Surat Belum Diisi!');
            }

            if ($item->tanggal_surat == null) {
                $now   = Carbon::now()->locale('id');
                $currentDate =  $now->translatedFormat('l, d F Y'); // Mendapatkan tanggal saat ini dengan nama hari dalam bahasa Indonesia
                
                $item->update([
                    'tanggal_surat'            => $currentDate,
                ]);
            }
        }

        //mengambil data dan tampilan dari halaman laporan_pdf
        $data = PDF::loadview('admin.pengajuan.verifikasi-ijazah.print', [
            'verifikasiIjazah' => $verifikasiIjazah,
        ]);
        //mendownload laporan.pdf
    	return $data->stream('Surat-Verifikasi-Ijazah.pdf');
    }

    /**
     * Display the specified resource.
     */
    public function export(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date'   => 'required|after_or_equal:start_date',
        ], [
            'start_date.required' => 'Masukkan Tanggal Mulai!',
            'end_date.required'   => 'Masukkan Tanggal Selesai!',
            'end_date.after_or_equal'   => 'Pilih Tanggal Setelah Atau Sama Dengan Tanggal Mulai!',
        ]);
        
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'))->endOfDay();

        $data = Pengajuan::with(['instansi'])
            ->select('kode_verifikasi', DB::raw('GROUP_CONCAT(nama SEPARATOR " - ") as nama_concat'), 'instansi_id', 'status', 'created_at')
            ->where('jenis_pengajuan_id', 6)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('kode_verifikasi')
            ->get();
            // dd($data);

        return Excel::download(new VerifikasiIjazahExport($data), 'Verifikasi-Ijazah-Export.xlsx');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateNoSurat(Request $request, string $id)
    {
        $request->validate([
            'no_surat' => 'required|unique:pengajuans,no_surat,' . $id,
        ], [
            'no_surat.required' => 'Masukkan Nomor Surat',
            'no_surat.unique' => 'Nomor Surat Sudah Digunakan',
        ]);
        
        // Get the data with the same kode_verifikasi
        $verifikasiIjazah = Pengajuan::where('kode_verifikasi', $id)->get();
        // dd($verifikasiIjazah);

        // Update the "No Surat" for each data entry
        foreach ($verifikasiIjazah as $item) {
            $item->update(['no_surat' => $request->no_surat]);
        }

        return redirect()->back()->with('success', 'No Surat Berhasil Diubah');
    }

}
