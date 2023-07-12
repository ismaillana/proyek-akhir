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

        if ($user->hasRole('admin-jurusan')) {
            $pengantarPkl = Pengajuan::latest()
                ->where('jenis_pengajuan_id', 2)
                ->whereNot('status', 'Selesai')
                ->whereNot('status', 'Tolak')
                ->whereNot('status', 'Diterima Perusahaan')
                ->whereNot('status', 'Ditolak Perusahaan')
                ->get();

            return view ('admin.pengajuan.pengantar-pkl.index-admin-jurusan',[
                'pengantarPkl' => $pengantarPkl,
                'user' => $user,
                'title'     => 'Pengantar PKL'
            ]);

        } elseif ($user->hasRole('koor-pkl')) {
            $pengantarPkl = Pengajuan::latest()
                ->where('jenis_pengajuan_id', 2)
                ->where('status', 'Review')
                ->get();

            return view ('admin.pengajuan.pengantar-pkl.index-koor-pkl',[
                'pengantarPkl' => $pengantarPkl,
                'user'      => $user,
                'title'        => 'Pengantar PKL'
            ]);
        } else {
            $pengantarPkl = Pengajuan::latest()
                ->where('jenis_pengajuan_id', 2)
                ->whereNot('status', 'Selesai')
                ->whereNot('status', 'Tolak')
                ->whereNot('status', 'Diterima Perusahaan')
                ->whereNot('status', 'Ditolak Perusahaan')
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
    public function store(PengantarPklRequest $request)
    {
        $user = auth()->user();

        $mahasiswa  = Mahasiswa::whereUserId($user->id)->first();
        $waGateway = $user->wa; //get no wa

        $adminJurusan = User::role('admin-jurusan')
            ->where('jurusan_id', $mahasiswa->programStudi->jurusan->id)
            ->get();
        $numbers = $adminJurusan->pluck('wa')->toArray();

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
        
        $data = ([
            'jenis_pengajuan_id' => '2',
            'mahasiswa_id'     => $mahasiswa->id,
            'tempat_pkl_id'    => $tempat_pkl_id,
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

        WhatsappGatewayService::sendMessage($waGateway, 
            'Hai, ' . $user->name . PHP_EOL .
                PHP_EOL .
                'Pengajuan Pembuatan Surat Pengantar PKL yang kamu lakukan Berhasil! ' . PHP_EOL .
                'Harap tunggu Konfirmasi dari bagian akademik.' . PHP_EOL .
                PHP_EOL .
                'Terima Kasih'
        ); //->Kirim Chat

        foreach ($numbers as $number) {
            WhatsappGatewayService::sendMessage($number, 
                'Hai, Admin Jurusan!' . PHP_EOL .
                    PHP_EOL .
                    'Ada pengajuan baru dari '. $user->name . PHP_EOL .
                    'Segera lakukan pengecekan data pengajuan!'
            ); //->Kirim Chat
        }

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
                'Pengajuan Pembuatan Surat Pengantar PKL yang kamu lakukan telah dikonfirmasi oleh Bagian Akademik! ' . PHP_EOL .
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
    public function setuju(Request $request, string $id)
    {
        $data = [
            'status'  =>  'Setuju'
        ];

        Pengajuan::where('id', $id)->update($data);

        Riwayat::create([
            'pengajuan_id'  => $id,
            'status'        => 'Disetujui Koor.Pkl',
            'catatan'       => 'Pengajuan Anda Telah Disetujui oleh koordinator Pkls. Tunggu pemberitahuan selanjutnya'
        ]);

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
                'Pengajuan Pembuatan Surat Pengantar PKL yang kamu lakukan Ditolak oleh Bagian Akademik dengan alasan/catatan ' . PHP_EOL .
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
                    'Pengajuan Pembuatan Surat Pengantar PKL yang kamu lakukan sedang Diproses oleh Bagian Akademik!' . PHP_EOL .
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
                    'Pengajuan Pembuatan Surat Pengantar PKL yang kamu lakukan sedang Dalam Kendala!' . PHP_EOL .
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
                    'Pengajuan Pembuatan Surat Pengantar PKL yang kamu lakukan Telah Selesai!' . PHP_EOL .
                    'Surat Pengantar PKL dapat diambil diruangan akademik dengan nomor surat ' . @$pengajuan->no_surat . PHP_EOL .
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

        $pengantarPkl = Pengajuan::where('jenis_pengajuan_id',2)
            ->where('status', 'Tolak')
            ->orWhere('jenis_pengajuan_id',2)
            ->where('status', 'Selesai')
            ->orWhere('jenis_pengajuan_id',2)
            ->where('status', 'Diterima Perusahaan')
            ->orWhere('jenis_pengajuan_id',2)
            ->where('status', 'Ditolak Perusahaan')
            ->get();

        if ($user->hasRole('admin-jurusan')) {
            return view ('admin.riwayat.pengantar-pkl.index-admin-jurusan', [
                'pengantarPkl'  => $pengantarPkl,
                'user'          => $user,
                'title'         => 'Surat Pengantar PKL'
            ]);
        } elseif ($user->hasRole('koor-pkl')) {
            return view ('admin.riwayat.pengantar-pkl.index-koor-pkl', [
                'pengantarPkl'  => $pengantarPkl,
                'user'          => $user,
                'title'         => 'Surat Pengantar PKL'
            ]);
        } else {
            return view ('admin.riwayat.pengantar-pkl.index', [
                'pengantarPkl'   => $pengantarPkl,
                'title'         => 'Surat Pengantar PKL'
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

        $pengantarPkl = Pengajuan::find($id);

        $data = Mahasiswa::whereIn('user_id', $pengantarPkl['nama_mahasiswa'])->get();

        return view ('admin.riwayat.pengantar-pkl.detail', [
            'pengantarPkl'  =>  $pengantarPkl,
            'data'          =>  $data,
            'title'         =>  'Detail Pengajuan Pengantar Pkl'
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
            ->where('jenis_pengajuan_id', 5)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return Excel::download(new PengantarPklExport($data), 'Pengantar-Pkl-Export.xlsx');
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
        
        $pengantarPkl = Pengajuan::find($id);
        $mahasiswa = Mahasiswa::whereIn('user_id', $pengantarPkl['nama_mahasiswa'])->get();

        if ($pengantarPkl->tanggal_surat == null) {
            $now   = Carbon::now()->locale('id');
            $currentDate =  $now->translatedFormat('l, d F Y'); // Mendapatkan tanggal saat ini dengan nama hari dalam bahasa Indonesia
            
            $pengantarPkl->update([
                'tanggal_surat'            => $currentDate,
            ]);
        } 
        //mengambil data dan tampilan dari halaman laporan_pdf
        $data = PDF::loadview('admin.pengajuan.pengantar-pkl.print', [
            'pengantarPkl'=> $pengantarPkl,
            'mahasiswa'   => $mahasiswa
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
