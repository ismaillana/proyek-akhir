<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use App\Models\Riwayat;
use App\Models\TempatPkl;
use App\Models\JenisPengajuan;

use App\Http\Requests\PengantarPklRequest;
use App\Http\Requests\KonfirmasiRequest;
use App\Exports\PengantarPklExport;
use App\Services\WhatsappGatewayService;

use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use File;
use Repsonse;
use PDF;
use setasign\Fpdi\Fpdi;


class PengantarPklController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $adminJurusan = $user->jurusan_id;
        $oneDayAgo = Carbon::now()->subDay();
        if ($user->hasRole('super-admin')){
            $pengantarPkl = Pengajuan::latest()
                ->select('kode_pkl', 'tempat_pkl_id', \DB::raw('MAX(created_at) as created_at'), \DB::raw('MAX(status) as status'))
                ->where('jenis_pengajuan_id', 2)
                ->where(function ($query) {
                    $query->where('status', 'Menunggu Konfirmasi');
                })
                ->where('created_at', '<=', $oneDayAgo)
                ->groupBy('kode_pkl', 'tempat_pkl_id')
                ->get();

            $pengantar = Pengajuan::latest()
                ->where('jenis_pengajuan_id', 2)
                ->whereIn('kode_pkl', $pengantarPkl->pluck('kode_pkl'))
                ->get();

            return view ('admin.pengajuan.pengantar-pkl.index',[
                'pengantarPkl' => $pengantarPkl,
                'user' => $user,
                'pengantar' => $pengantar,
                'title'     => 'Pengantar PKL'
            ]);
        } elseif($user->hasRole('admin-jurusan')) {
            $pengantarPkl = Pengajuan::latest()
                ->select('kode_pkl', 'tempat_pkl_id', \DB::raw('MAX(created_at) as created_at'), 'status')
                ->where('jenis_pengajuan_id', 2)
                ->where(function ($query) {
                    $query->where('status', 'Menunggu Konfirmasi')
                        ->orWhere('status', 'Review')
                        ->orWhere('status', 'Setuju');
                })
                ->whereHas('mahasiswa', function ($query) use ($adminJurusan) {
                    $query->whereHas('programStudi', function ($query) use ($adminJurusan) {
                        $query->where('jurusan_id', $adminJurusan);
                    });
                })
                ->groupBy('kode_pkl', 'tempat_pkl_id', 'status')
                ->get();

            $pengantar = Pengajuan::latest()
                ->where('jenis_pengajuan_id', 2)
                ->whereIn('kode_pkl', $pengantarPkl->pluck('kode_pkl'))
                ->get();

            return view ('admin.pengajuan.pengantar-pkl.index-admin-jurusan',[
                'pengantarPkl' => $pengantarPkl,
                'user' => $user,
                'pengantar' => $pengantar,
                'title'     => 'Pengantar PKL'
            ]);

        } elseif ($user->hasRole('koor-pkl')) {
            $pengantarPkl = Pengajuan::latest()
                ->select('kode_pkl', 'tempat_pkl_id', \DB::raw('MAX(created_at) as created_at'), 'status')
                ->where('jenis_pengajuan_id', 2)
                ->where('status', 'Review')
                ->whereHas('mahasiswa', function ($query) use ($adminJurusan) {
                    $query->whereHas('programStudi', function ($query) use ($adminJurusan) {
                        $query->where('jurusan_id', $adminJurusan);
                    });
                })
                ->groupBy('kode_pkl', 'tempat_pkl_id', 'status')
                ->get();

            $pengantar = Pengajuan::latest()
                ->where('jenis_pengajuan_id', 2)
                ->whereIn('kode_pkl', $pengantarPkl->pluck('kode_pkl'))
                ->get();

            return view ('admin.pengajuan.pengantar-pkl.index-koor-pkl',[
                'pengantarPkl' => $pengantarPkl,
                'user' => $user,
                'pengantar' => $pengantar,
                'title'     => 'Pengantar PKL'
            ]);
        } elseif($user->hasRole('bagian-akademik')) {
            $pengantarPkl = Pengajuan::latest()
                ->select('kode_pkl', 'tempat_pkl_id', \DB::raw('MAX(created_at) as created_at'), 'status')
                ->where('jenis_pengajuan_id', 2)
                ->where(function ($query) {
                    $query->where('status', 'Dikonfirmasi')
                        ->orWhere('status', 'Kendala');
                })
                ->groupBy('kode_pkl', 'tempat_pkl_id', 'created_at', 'status')
                ->get();

            $pengantar = Pengajuan::latest()
                ->where('jenis_pengajuan_id', 2)
                ->whereIn('kode_pkl', $pengantarPkl->pluck('kode_pkl'))
                ->get();

            return view ('admin.pengajuan.pengantar-pkl.index',[
                'pengantarPkl' => $pengantarPkl,
                'user' => $user,
                'pengantar' => $pengantar,
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

        $pengajuan = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 2)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->first();

        $tempatPkl = TempatPkl::get();

        return view ('user.pengajuan.pengantar-pkl.form', [
            'pengajuan' => $pengajuan,
            'tempatPkl' => $tempatPkl,
            'pengaju' => $pengaju,
            'mahasiswa' => $mahasiswa,
            'title'     => 'Pengantar PKL'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PengantarPklRequest $request)
    {
        $user = auth()->user();

        $mahasiswa  = Mahasiswa::whereUserId($user->id)->first();
        $waGateway = $user->wa; //get no wa

        $adminJurusan = User::role('admin-jurusan')
            ->where('jurusan_id', $mahasiswa->programStudi->jurusan->id)
            ->get();
        $numbers = $adminJurusan->pluck('wa')->toArray();

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            $mahasiswaId = $request->input('nama_mahasiswa');
            // Generate kode pengajuan
            $latestPengajuan = Pengajuan::latest()->first();
            $angkaUrut = $latestPengajuan ? intval(substr($latestPengajuan->kode_pkl, 4)) + 1 : 1;
            $kodePengajuan = 'PKL_' . str_pad($angkaUrut, 2, '0', STR_PAD_LEFT);

            $tempat_pkl_id = $request->tempat_pkl_id;
            if ($request->tempat_pkl_id == 'perusahaan_lainnya') {
                $tempatPkl = TempatPkl::create([
                    'name'      => $request->name,
                    'alamat'    => $request->alamat,
                    'telepon'   => $request->telepon,
                    'web'       => $request->web
                ]);

                $tempat_pkl_id = $tempatPkl->id;
            }

            foreach ($mahasiswaId as $item) {
                $pengajuan = Pengajuan::create([
                    'jenis_pengajuan_id' => '2',
                    'mahasiswa_id' => $item,
                    'kode_pkl' => $kodePengajuan, // Gunakan kode yang sama untuk setiap pengajuan
                    'mahasiswa_id' => $item,
                    'tempat_pkl_id'    => $tempat_pkl_id,
                    'tgl_mulai'        => $request->tgl_mulai,
                    'tgl_selesai'      => $request->tgl_selesai,
                    'tujuan_surat'     => $request->tujuan_surat,
                    'link_pendukung'   => $request->link_pendukung,
                ]);

                Riwayat::create([
                    'pengajuan_id'  => $pengajuan->id,
                    'status'        => 'Menunggu Konfirmasi',
                    'catatan'       => 'Pengajuan Berhasil Dibuat. Tunggu pemberitahuan selanjutnya'
                ]);
            }
            // Commit transaksi database
            DB::commit();
    
            WhatsappGatewayService::sendMessage($waGateway, 
                'Hai, ' . $user->name . PHP_EOL .
                    PHP_EOL .
                    'Pengajuan Pembuatan Surat Pengantar PKL yang kamu lakukan Berhasil! ' . PHP_EOL .
                    'Harap tunggu Konfirmasi dari Admin Jurusan.' . PHP_EOL .
                    PHP_EOL .
                    'Terima Kasih' . PHP_EOL .
                    PHP_EOL .
                    '[Politeknik Negeri Subang]'
            ); //->Kirim Chat
    
            foreach ($numbers as $number) {
                WhatsappGatewayService::sendMessage($number, 
                    'Hai, Admin Jurusan!' . PHP_EOL .
                        PHP_EOL .
                        'Ada pengajuan Surat Pengantar PKL baru dari '. $user->name . PHP_EOL .
                        'Segera lakukan pengecekan data pengajuan!' . PHP_EOL .
                        PHP_EOL .
                        '[Politeknik Negeri Subang]'
                ); //->Kirim Chat
            }
    
            return redirect()->back()->with('success', 'Pengajuan Berhasil');

        } catch (\Exception $e) {
            // Jika terjadi error, rollback transaksi database
            DB::rollback();

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan pengajuan PKL.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function detail($kodePkl)
    {
        $user = auth()->user();

        $pengantarPkl = Pengajuan::where('kode_pkl', $kodePkl)
        ->get();
        
        return view ('admin.pengajuan.pengantar-pkl.show', [
            'pengantarPkl'    =>  $pengantarPkl,
            'user'          => $user,
            'title'         =>  'Detail Pengajuan Pengantar PKL'
        ]);
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
        
        return view ('admin.pengajuan.pengantar-pkl.detail', [
            'pengantarPkl'    =>  $pengantarPkl,
            'user'          => $user,
            'title'         =>  'Detail Pengajuan Pengantar PKL'
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

        $pengajuan = Pengajuan::where('kode_pkl',$id)->get();

        $waGateway = [];

        foreach ($pengajuan as $item) {
            $waGateway[] = $item->mahasiswa->user->wa;

            $dokumen = Pengajuan::saveDokumenPermohonan($request);

            $data = [
                'status'  =>  'Konfirmasi',
                'dokumen_permohonan' => $dokumen
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
                'Pengajuan Pembuatan Surat Pengantar PKL yang kamu lakukan telah dikonfirmasi oleh Admin Jurusan! ' . PHP_EOL .
                'Harap tunggu pemberitahuan selanjutnya.' . PHP_EOL .
                PHP_EOL .
                'Terima Kasih' . PHP_EOL .
                PHP_EOL .
                '[Politeknik Negeri Subang]'
            ); //->Kirim Chat
        }

        foreach ($numbers as $number) {
            WhatsappGatewayService::sendMessage($number, 
                'Hai, Bagian Akademik!' . PHP_EOL .
                    PHP_EOL .
                    'Ada pengajuan Surat Pengantar PKL baru Yang Telah Dikonfirmasi Admin Jurusan ' . PHP_EOL .
                    'Segera lakukan pengecekan data pengajuan!' . PHP_EOL .
                    PHP_EOL .
                    '[Politeknik Negeri Subang]'
            ); //->Kirim Chat
        }

        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

    /**
     * Update the specified resource in storage.
     */
    public function review(Request $request, string $id)
    {
        // $pengajuan = Pengajuan::where('id',$id)->first();

        // $waGateway = $pengajuan->mahasiswa->user->wa; //get no wa

        // $koorPKL = User::role('koor-pkl')
        //     ->where('jurusan_id', $pengajuan->mahasiswa->programStudi->jurusan->id)
        //     ->get();
        // $numbers = $koorPKL->pluck('wa')->toArray();

        $data = [
            'status'  =>  'Review'
        ];

        Pengajuan::where('kode_pkl', $id)->update($data);

        Riwayat::create([
            'pengajuan_id'  => $id,
            'status'        => 'Direview',
            'catatan'       => 'Pengajuan Anda Sedang di review oleh Koordinator Pkl. Tunggu pemberitahuan selanjutnya'
        ]);

        // WhatsappGatewayService::sendMessage($waGateway, 
        // 'Hai, ' . $pengajuan->mahasiswa->user->name . ',' . PHP_EOL .
        //         PHP_EOL .
        //         'Pengajuan Pembuatan Surat Pengantar PKL yang kamu lakukan telah sedang direview oleh Koordinator PKL! ' . PHP_EOL .
        //         'Harap tunggu pemberitahuan selanjutnya.' . PHP_EOL .
        //         PHP_EOL .
        //         'Terima Kasih' . PHP_EOL .
        //         PHP_EOL .
        //         '[Politeknik Negeri Subang]'
        // ); //->Kirim Chat

        // foreach ($numbers as $number) {
        //     WhatsappGatewayService::sendMessage($number, 
        //         'Hai, Koordinator PKL!' . PHP_EOL .
        //             PHP_EOL .
        //             'Ada pengajuan Surat Pengantar PKL baru Yang Telah Diajukan Admin Jurusan dari '. $pengajuan->mahasiswa->user->name . PHP_EOL .
        //             'Segera lakukan pengecekan data pengajuan!' . PHP_EOL .
        //             PHP_EOL .
        //             '[Politeknik Negeri Subang]'
        //     ); //->Kirim Chat
        // }

        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

    /**
     * Update the specified resource in storage.
     */
    public function setuju(Request $request, string $id)
    {
        // $pengajuan = Pengajuan::where('id',$id)->first();

        // $waGateway = $pengajuan->mahasiswa->user->wa; //get no wa

        // $adminJurusan = User::role('admin-jurusan')
        //     ->where('jurusan_id', $pengajuan->mahasiswa->programStudi->jurusan->id)
        //     ->get();
        // $numbers = $adminJurusan->pluck('wa')->toArray();

        $data = [
            'status'  =>  'Setuju'
        ];

        Pengajuan::where('kode_pkl', $id)->update($data);

        Riwayat::create([
            'pengajuan_id'  => $id,
            'status'        => 'Disetujui Koor.Pkl',
            'catatan'       => 'Pengajuan Anda Telah Disetujui oleh koordinator Pkls. Tunggu pemberitahuan selanjutnya'
        ]);

        // WhatsappGatewayService::sendMessage($waGateway, 
        // 'Hai, ' . $pengajuan->mahasiswa->user->name . ',' . PHP_EOL .
        //         PHP_EOL .
        //         'Pengajuan Pembuatan Surat Pengantar PKL yang kamu lakukan telah sedang Disetujui oleh Koordinator PKL! ' . PHP_EOL .
        //         'Harap tunggu pemberitahuan selanjutnya.' . PHP_EOL .
        //         PHP_EOL .
        //         'Terima Kasih' . PHP_EOL .
        //         PHP_EOL .
        //         '[Politeknik Negeri Subang]'
        // ); //->Kirim Chat

        // foreach ($numbers as $number) {
        //     WhatsappGatewayService::sendMessage($number, 
        //         'Hai, Admin Jurusan!' . PHP_EOL .
        //             PHP_EOL .
        //             'Ada pengajuan Surat Pengantar PKL baru Yang Telah Disetujui Koordinator PKL dari '. $pengajuan->mahasiswa->user->name . PHP_EOL .
        //             'Segera lakukan pengecekan data pengajuan!' . PHP_EOL .
        //             PHP_EOL .
        //             '[Politeknik Negeri Subang]'
        //     ); //->Kirim Chat
        // }

        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

    /**
     * Update the specified resource in storage.
     */
    public function tolak(KonfirmasiRequest $request, string $id)
    {
        // $pengajuan = Pengajuan::where('id',$id)->first();
        
        // $waGateway = $pengajuan->mahasiswa->user->wa; //get no wa

        $data = [
            'status'  =>  'Tolak',
            'catatan' =>  $request->catatan
        ];
        
        Pengajuan::where('kode_pkl', $id)->update($data);

        Riwayat::create([
            'pengajuan_id'  => $id,
            'status'        => 'Ditolak',
            'catatan'       => $request->catatan
        ]);


        // WhatsappGatewayService::sendMessage($waGateway, 
        // 'Hai, ' . $pengajuan->mahasiswa->user->name . ',' . PHP_EOL .
        //         PHP_EOL .
        //         'Pengajuan Pembuatan Surat Pengantar PKL yang kamu lakukan Ditolak oleh Admin Jurusan atau Koordinator PKL dengan alasan/catatan ' . PHP_EOL .
        //         PHP_EOL .
        //         '**' . $request->catatan . PHP_EOL .
        //         PHP_EOL .
        //         'Terima Kasih' . PHP_EOL .
        //         PHP_EOL .
        //         '[Politeknik Negeri Subang]'
        // ); //->Kirim Chat

        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, string $id)
    {
        
        $pengajuanPklItems = pengajuan::where('kode_pkl', $id)->get();

        // Update the status for each pengajuan pkl item
        foreach ($pengajuanPklItems as $pengajuanPklItem) {
            $pengajuanPklItem->update([
                'status' => $request->input('status'),
            ]);
        }
        // $data = [
        //     'status'  =>  $request->status
        // ];
        // Find the pengajuan pkl items with the same kode_pkl
        // Pengajuan::where('kode_pkl', $id)->update($data);

        // $pengajuan = Pengajuan::where('id',$id)->first();
        
        // $waGateway = $pengajuan->mahasiswa->user->wa; //get no wa

        // if ($request->status == 'Proses' ) {
        //     Riwayat::create([
        //         'pengajuan_id'  => $id,
        //         'status'        => 'Diproses',
        //         'catatan'       => 'Pengajuan Anda Sedang Diproses. Tunggu pemberitahuan selanjutnya'
        //     ]);

        //     WhatsappGatewayService::sendMessage($waGateway, 
        //         'Hai, ' . $pengajuan->mahasiswa->user->name . ',' . PHP_EOL .
        //             PHP_EOL .
        //             'Pengajuan Pembuatan Surat Pengantar PKL yang kamu lakukan sedang Diproses oleh Bagian Akademik!' . PHP_EOL .
        //             'Proses dilakukan selama 3-5 hari kerja, namun bisa saja kurang atau melebihi waktu tersebut. Harap tunggu informasi selanjutnya' . PHP_EOL .
        //             PHP_EOL .
        //             'Terima Kasih' . PHP_EOL .
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
        //         'Hai, ' . $pengajuan->mahasiswa->user->name . ',' . PHP_EOL .
        //             PHP_EOL .
        //             'Pengajuan Pembuatan Surat Pengantar PKL yang kamu lakukan sedang Dalam Kendala!' . PHP_EOL .
        //             'Harap menunggu pemberitahuan selanjutnya dikarenakan di lingkungan kampus sedang terdapat kegiatan yang melibatkan Bagian Akademik!' . PHP_EOL .
        //             PHP_EOL .
        //             'Terima Kasih' . PHP_EOL .
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
        //         'Hai, ' . $pengajuan->mahasiswa->user->name . ',' . PHP_EOL .
        //             PHP_EOL .
        //             'Pengajuan Pembuatan Surat Pengantar PKL yang kamu lakukan Telah Selesai!' . PHP_EOL .
        //             'Surat Pengantar PKL dapat diambil diruangan akademik dengan nomor surat ' . @$pengajuan->no_surat . PHP_EOL .
        //             PHP_EOL .
        //             'Terima Kasih' . PHP_EOL .
        //             PHP_EOL .
        //             '[Politeknik Negeri Subang]'
        //     ); //->Kirim Chat
        // }
        return redirect()->back()->with('success', 'Status Berhasil Diubah');
    }

    /**
     * Display a listing of the resource.
     */
    public function riwayat()
    {
        // $user = auth()->user();

        // $pengantarPkl = Pengajuan::latest()
        //     ->where('jenis_pengajuan_id',2)
        //     ->get();
       
        // if ($user->hasRole('admin-jurusan')) {
        //     return view ('admin.riwayat.pengantar-pkl.index-admin-jurusan', [
        //         'pengantarPkl'  => $pengantarPkl,
        //         'user'          => $user,
        //         'title'         => 'Surat Pengantar PKL'
        //     ]);
        // } elseif ($user->hasRole('koor-pkl')) {
        //     return view ('admin.riwayat.pengantar-pkl.index-koor-pkl', [
        //         'pengantarPkl'  => $pengantarPkl,
        //         'user'          => $user,
        //         'title'         => 'Surat Pengantar PKL'
        //     ]);
        // } else {
        //     return view ('admin.riwayat.pengantar-pkl.index', [
        //         'pengantarPkl'   => $pengantarPkl,
        //         'user'          => $user,
        //         'title'         => 'Surat Pengantar PKL'
        //     ]);
        // }

        $user = auth()->user();
        $adminJurusan = $user->jurusan_id;
        
        if ($user->hasRole('admin-jurusan')) {
            $pengantarPkl = Pengajuan::latest()
                ->select('kode_pkl', 'tempat_pkl_id', \DB::raw('MAX(created_at) as created_at'), \DB::raw('MAX(status) as status'))
                ->where('jenis_pengajuan_id', 2)
                ->whereHas('mahasiswa', function ($query) use ($adminJurusan) {
                    $query->whereHas('programStudi', function ($query) use ($adminJurusan) {
                        $query->where('jurusan_id', $adminJurusan);
                    });
                })
                ->groupBy('kode_pkl', 'tempat_pkl_id')
                ->get();

            $pengantar = Pengajuan::latest()
                ->where('jenis_pengajuan_id', 2)
                ->whereIn('kode_pkl', $pengantarPkl->pluck('kode_pkl'))
                ->get();

            return view ('admin.riwayat.pengantar-pkl.index-admin-jurusan',[
                'pengantarPkl' => $pengantarPkl,
                'user' => $user,
                'pengantar' => $pengantar,
                'title'     => 'Pengantar PKL'
            ]);

        } elseif ($user->hasRole('koor-pkl')) {
            $pengantarPkl = Pengajuan::latest()
                ->select('kode_pkl', 'tempat_pkl_id', \DB::raw('MAX(created_at) as created_at'), \DB::raw('MAX(status) as status'))
                ->where('jenis_pengajuan_id', 2)
                ->whereHas('mahasiswa', function ($query) use ($adminJurusan) {
                    $query->whereHas('programStudi', function ($query) use ($adminJurusan) {
                        $query->where('jurusan_id', $adminJurusan);
                    });
                })
                ->groupBy('kode_pkl', 'tempat_pkl_id')
                ->get();

            $pengantar = Pengajuan::latest()
                ->where('jenis_pengajuan_id', 2)
                ->whereIn('kode_pkl', $pengantarPkl->pluck('kode_pkl'))
                ->get();

            return view ('admin.riwayat.pengantar-pkl.index-koor-pkl',[
                'pengantarPkl' => $pengantarPkl,
                'user' => $user,
                'pengantar' => $pengantar,
                'title'     => 'Pengantar PKL'
            ]);
        } elseif($user->hasRole('bagian-akademik')) {
            $pengantarPkl = Pengajuan::latest()
                ->select('kode_pkl', 'tempat_pkl_id', \DB::raw('MAX(created_at) as created_at'), \DB::raw('MAX(status) as status'))
                ->where('jenis_pengajuan_id', 2)
                ->groupBy('kode_pkl', 'tempat_pkl_id')
                ->get();

            $pengantar = Pengajuan::latest()
                ->where('jenis_pengajuan_id', 2)
                ->whereIn('kode_pkl', $pengantarPkl->pluck('kode_pkl'))
                ->get();

            return view ('admin.riwayat.pengantar-pkl.index',[
                'pengantarPkl' => $pengantarPkl,
                'user' => $user,
                'pengantar' => $pengantar,
                'title'     => 'Pengantar PKL'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function detailRiwayat($kodePkl)
    {
        $user = auth()->user();

        $pengantarPkl = Pengajuan::where('kode_pkl', $kodePkl)
        ->get();
        
        return view ('admin.riwayat.pengantar-pkl.show', [
            'pengantarPkl'    =>  $pengantarPkl,
            'user'          => $user,
            'title'         =>  'Detail Pengajuan Pengantar PKL'
        ]);
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

        $pengantarPkl = Pengajuan::find($id);

        // $data = Mahasiswa::whereIn('user_id', $pengantarPkl['nama_mahasiswa'])->get();

        return view ('admin.riwayat.pengantar-pkl.detail', [
            'pengantarPkl'  =>  $pengantarPkl,
            // 'data'          =>  $data,
            'title'         =>  'Detail Pengajuan Pengantar Pkl'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function export(Request $request)
    {
        $user = auth()->user();

        $adminJurusan = auth()->user()->jurusan_id;

        $koorPkl = auth()->user()->jurusan_id;

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

        $data = collect(); // Membuat koleksi kosong untuk menyimpan pengajuan


        if ($user->hasRole('admin-jurusan')) {

            // Mendapatkan pengajuan dari mahasiswa dengan ID jurusan yang sama dengan admin jurusan
            $mahasiswa = Mahasiswa::whereHas('programStudi', function ($query) use ($koorPkl) {
                $query->where('jurusan_id', $koorPkl);
            })->get();  

            $id = $mahasiswa->pluck('id')->toArray();

            foreach ($id as $id) {
                
                $pengajuan = Pengajuan::with(['mahasiswa'])
                ->where('jenis_pengajuan_id', 2)
                ->where('mahasiswa_id', $id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

                $data = $data->concat($pengajuan);
            }
        }elseif ($user->hasRole('koor-pkl')) {
            // Mendapatkan pengajuan dari mahasiswa dengan ID jurusan yang sama dengan admin jurusan
            $mahasiswa = Mahasiswa::whereHas('programStudi', function ($query) use ($adminJurusan) {
                $query->where('jurusan_id', $adminJurusan);
            })->get();  

            $id = $mahasiswa->pluck('id')->toArray();

            foreach ($id as $id) {
                
                $pengajuan = Pengajuan::with(['mahasiswa'])
                ->where('jenis_pengajuan_id', 2)
                ->where('mahasiswa_id', $id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

                $data = $data->concat($pengajuan);
            }
        }else {
            $data = Pengajuan::with(['mahasiswa'])
                ->where('jenis_pengajuan_id', 2)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
        }

        return Excel::download(new PengantarPklExport($data), 'Pengantar-Pkl-Export.xlsx');
    }

    /**
     * Display the specified resource.
     */
    public function print($id)
    {
        $pengantarPkl = Pengajuan::where('kode_pkl', $id)->get();

        // Cek apakah ada entri data yang memiliki no_surat kosong
        $hasEmptyNoSurat = $pengantarPkl->contains(function ($item) {
            return empty($item->no_surat);
        });

        // Jika ada entri data dengan no_surat kosong, langsung kembalikan pesan "Nomor Surat Kosong"
        if ($hasEmptyNoSurat) {
            return redirect()->back()->with('error', 'Nomor Surat Belum Diisi!');
        }

        // Cek apakah ada entri data yang memiliki tanggal_surat kosong
        $hasNullTanggalSurat = $pengantarPkl->contains(function ($item) {
            return $item->tanggal_surat === null;
        });

        // Jika ada entri data dengan tanggal_surat kosong, perbarui tanggal_surat dengan tanggal saat ini
        if ($hasNullTanggalSurat) {
            $now = Carbon::now()->locale('id');
            $currentDate = $now->translatedFormat('l, d F Y'); // Mendapatkan tanggal saat ini dengan nama hari dalam bahasa Indonesia

            foreach ($pengantarPkl as $item) {
                if ($item->tanggal_surat === null) {
                    $item->update([
                        'tanggal_surat' => $currentDate,
                    ]);
                }
            }
        }
    
        //mengambil data dan tampilan dari halaman laporan_pdf
        $data = PDF::loadview('admin.pengajuan.pengantar-pkl.print', [
            'pengantarPkl' => $pengantarPkl,
        ]);
        
        //mendownload laporan.pdf
        return $data->stream('Surat-pengantar-pkl.pdf');
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
        
        // $data = [
        //     'no_surat'  =>  $request->no_surat
        // ];

        // Get the data with the same kode_pkl
        $pengajuanPkl = Pengajuan::where('kode_pkl', $id)->get();

        // Update the "No Surat" for each data entry
        foreach ($pengajuanPkl as $item) {
            $item->update(['no_surat' => $request->no_surat]);
        }

        return redirect()->back()->with('success', 'No Surat Berhasil Diubah');
    }
}
