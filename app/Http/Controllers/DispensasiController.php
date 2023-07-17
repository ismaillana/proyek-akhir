<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dispensasi;
use App\Models\Pengajuan;
use App\Models\JenisPengajuan;
use App\Models\Riwayat;

use App\Http\Requests\DispensasiRequest;
use App\Http\Requests\KonfirmasiRequest;
use App\Exports\DispensasiExport;
use App\Services\WhatsappGatewayService;

use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use File;
use Repsonse;
use PDF;
use setasign\Fpdi\Fpdi;


class DispensasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $dispensasi = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 4)
            ->whereNot('status', 'Selesai')
            ->whereNot('status', 'Tolak')
            ->get();

        if ($user->hasRole('admin-jurusan')) {
            return view ('admin.pengajuan.dispensasi.index-admin-jurusan', [
                'dispensasi' => $dispensasi,
                'user'       => $user,
                'title'      => 'Dispensasi Perkuliahan'
            ]);
        } else {
            return view ('admin.pengajuan.dispensasi.index', [
                'dispensasi'    => $dispensasi,
                'title'         => 'Dispensasi Perkuliahan'
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
            ->where('jenis_pengajuan_id', 4)
            ->latest()
            ->first();

        $user = User::whereIn('id', function ($query) use ($mahasiswa) {
            $query->select('user_id')
                ->from('mahasiswas')
                ->where('program_studi_id', $mahasiswa->program_studi_id);
        })
        ->whereHas('roles', function ($q) {
            $q->whereIn('name', ['mahasiswa']);
        })
        ->get();
        
        return view ('user.pengajuan.dispensasi.form', [
            'user'      => $user,
            'pengajuan' => $pengajuan,
            'title'     => 'Dispensasi Perkuliahan'
        ]);
        

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DispensasiRequest $request)
    {
        $user = auth()->user();

        $mahasiswa  = Mahasiswa::whereUserId($user->id)->first();
        $waGateway = $user->wa; //get no wa

        $adminJurusan = User::role('admin-jurusan')
            ->where('jurusan_id', $mahasiswa->programStudi->jurusan->id)
            ->get();
        $numbers = $adminJurusan->pluck('wa')->toArray();

        $dokumen = Pengajuan::saveDokumen($request);

        $data = ([
            'jenis_pengajuan_id'    => 4,
            'mahasiswa_id'          => $mahasiswa->id,
            'kegiatan'              => $request->kegiatan,
            'nama_tempat'           => $request->nama_tempat,
            'tgl_mulai'             => $request->tgl_mulai,
            'tgl_selesai'           => $request->tgl_selesai,
            'dokumen'               => $dokumen,
            'nama_mahasiswa'        => $request->nama_mahasiswa
        ]);

        $data['dokumen'] = $dokumen;

        $pengajuan = Pengajuan::create($data);

        Riwayat::create([
            'pengajuan_id'  => $pengajuan->id,
            'status'        => 'Menunggu Konfirmasi',
            'catatan'       => 'Pengajuan Berhasil Dibuat. Tunggu pemberitahuan selanjutnya'
        ]);

        WhatsappGatewayService::sendMessage($waGateway, 
            'Hai, ' . $user->name . PHP_EOL .
                PHP_EOL .
                'Pengajuan Pembuatan Surat Izin Dispensasi yang kamu lakukan Berhasil! ' . PHP_EOL .
                'Harap tunggu Konfirmasi dari Admin Jurusan.' . PHP_EOL .
                PHP_EOL .
                'Terima Kasih'. PHP_EOL .
                PHP_EOL .
                '[Politeknik Negeri Subang]'
        ); //->Kirim Chat

        foreach ($numbers as $number) {
            WhatsappGatewayService::sendMessage($number, 
                'Hai, Admin Jurusan!' . PHP_EOL .
                    PHP_EOL .
                    'Ada pengajuan Surat Izin Dispensasi baru dari '. $user->name . PHP_EOL .
                    'Segera lakukan pengecekan data pengajuan!'. PHP_EOL .
                    PHP_EOL .
                    '[Politeknik Negeri Subang]'
            ); //->Kirim Chat
        }

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

        $dispensasi = Pengajuan::find($id);

        $data = Mahasiswa::whereIn('user_id', $dispensasi['nama_mahasiswa'])->get();
        
        return view ('admin.pengajuan.dispensasi.detail', [
            'dispensasi'    =>  $dispensasi,
            'data'          =>  $data,
            'user'          =>  $user,
            'title'         =>  'Detail Pengajuan Dispensasi'
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
                'Pengajuan Pembuatan Surat Izin Dispensasi yang kamu lakukan telah dikonfirmasi oleh Admin Jurusan! ' . PHP_EOL .
                'Harap tunggu pemberitahuan selanjutnya.' . PHP_EOL .
                PHP_EOL .
                'Terima Kasih'. PHP_EOL .
                PHP_EOL .
                '[Politeknik Negeri Subang]'
        ); //->Kirim Chat

        foreach ($numbers as $number) {
            WhatsappGatewayService::sendMessage($number, 
                'Hai, Bagian Akademik!' . PHP_EOL .
                    PHP_EOL .
                    'Ada pengajuan Surat Dispensasi baru Yang telah dikonfirmasi Admin Jurusan dari '. $pengajuan->mahasiswa->user->name . PHP_EOL .
                    'Segera lakukan pengecekan data pengajuan!'. PHP_EOL .
                    PHP_EOL .
                    '[Politeknik Negeri Subang]'
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
                'Pengajuan Pembuatan Surat Izin Dispensasi yang kamu lakukan Ditolak oleh Admin Jurusan dengan alasan/catatan ' . PHP_EOL .
                PHP_EOL .
                '**' . $request->catatan . PHP_EOL .
                PHP_EOL .
                'Terima Kasih'. PHP_EOL .
                PHP_EOL .
                '[Politeknik Negeri Subang]'
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
                    'Pengajuan Pembuatan Surat Izin Dispensasi yang kamu lakukan sedang Diproses oleh Bagian Akademik!' . PHP_EOL .
                    'Proses dilakukan selama 3-5 hari kerja, namun bisa saja kurang atau melebihi waktu tersebut. Harap tunggu informasi selanjutnya' . PHP_EOL .
                    PHP_EOL .
                    'Terima Kasih'. PHP_EOL .
                    PHP_EOL .
                    '[Politeknik Negeri Subang]'
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
                    'Pengajuan Pembuatan Surat Izin Dispensasi yang kamu lakukan sedang Dalam Kendala!' . PHP_EOL .
                    'Harap menunggu pemberitahuan selanjutnya dikarenakan di lingkungan kampus sedang terdapat kegiatan yang melibatkan Bagian Akademik!' . PHP_EOL .
                    PHP_EOL .
                    'Terima Kasih'. PHP_EOL .
                    PHP_EOL .
                    '[Politeknik Negeri Subang]'
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
                    'Pengajuan Pembuatan Surat Izin Dispensasi yang kamu lakukan Telah Selesai!' . PHP_EOL .
                    'Surat Izin Dispensasi dapat diambil diruangan akademik dengan nomor surat ' . @$pengajuan->no_surat . PHP_EOL .
                    PHP_EOL .
                    'Terima Kasih'. PHP_EOL .
                    PHP_EOL .
                    '[Politeknik Negeri Subang]'
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

        $dispensasi = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 4)
            ->get();

        if ($user->hasRole('admin-jurusan')) {
            return view ('admin.riwayat.dispensasi.index-admin-jurusan', [
                'dispensasi'   => $dispensasi,
                'user'         => $user,
                'title'        => 'Surat Izin Dispensasi'
            ]);
        } else {
            return view ('admin.riwayat.dispensasi.index', [
                'dispensasi'   => $dispensasi,
                'title'        => 'Surat Izin Dispensasi'
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

        $dispensasi = Pengajuan::find($id);

        $data = Mahasiswa::whereIn('user_id', $dispensasi['nama_mahasiswa'])->get();

        return view ('admin.riwayat.dispensasi.detail', [
            'dispensasi'        =>  $dispensasi,
            'data'              =>  $data,
            'title'             =>  'Detail Pengajuan Izin Dispensasi'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function export(Request $request)
    {
        $user = auth()->user();

        $adminJurusan = auth()->user()->jurusan_id;

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
            $mahasiswa = Mahasiswa::whereHas('programStudi', function ($query) use ($adminJurusan) {
                $query->where('jurusan_id', $adminJurusan);
            })->get();  

            $id = $mahasiswa->pluck('id')->toArray();

            foreach ($id as $id) {
                
                $pengajuan = Pengajuan::with(['mahasiswa'])
                ->where('jenis_pengajuan_id', 4)
                ->where('mahasiswa_id', $id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

                $data = $data->concat($pengajuan);
            }
        } else {
            $data = Pengajuan::with(['mahasiswa'])
                ->where('jenis_pengajuan_id', 4)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();
        }

        return Excel::download(new DispensasiExport($data), 'Dispensasi-Export.xlsx');
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
        
        $dispensasi = Pengajuan::find($id);
        $mahasiswa = Mahasiswa::whereIn('user_id', $dispensasi['nama_mahasiswa'])->get();

        if ($dispensasi->tanggal_surat == null) {
            $now   = Carbon::now()->locale('id');
            $currentDate =  $now->translatedFormat('l, d F Y'); // Mendapatkan tanggal saat ini dengan nama hari dalam bahasa Indonesia
            
            $dispensasi->update([
                'tanggal_surat'            => $currentDate,
            ]);
        } 
        //mengambil data dan tampilan dari halaman laporan_pdf
        $data = PDF::loadview('admin.pengajuan.dispensasi.print', [
            'dispensasi' => $dispensasi,
            'mahasiswa' =>  $mahasiswa
        ]);
        //mendownload laporan.pdf
    	return $data->stream('Surat-dispensasi.pdf');
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
