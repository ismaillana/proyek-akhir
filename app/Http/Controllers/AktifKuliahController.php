<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AktifKuliah;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Riwayat;
use App\Models\Pengajuan;
use App\Models\JenisPengajuan;

use App\Http\Requests\AktifKuliahRequest;
use App\Http\Requests\KonfirmasiRequest;
use App\Exports\AktifKuliahExport;
use App\Services\WhatsappGatewayService;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use File;
use Repsonse;
use PDF;
use setasign\Fpdi\Fpdi;


class AktifKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aktifKuliah = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 1)
            ->whereNot('status', 'Selesai')
            ->whereNot('status', 'Tolak')
            ->get();

        return view ('admin.pengajuan.surat-aktif-kuliah.index', [
            'aktifKuliah'   => $aktifKuliah,
            'title'         => 'Surat Keterangan Aktif Kuliah'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        $mahasiswa       = Mahasiswa::with(['pengajuan'])->whereUserId($user->id)->first();

        $pengajuan = Pengajuan::where('mahasiswa_id', $mahasiswa->id)
            ->where('jenis_pengajuan_id', 1)
            ->latest()
            ->first();

        return view ('user.pengajuan.aktif-kuliah.form', [
            'mahasiswa' => $mahasiswa,
            'pengajuan' => $pengajuan,
            'title'     => 'Surat Keterangan Aktif Kuliah'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AktifKuliahRequest $request)
    {
        $user = auth()->user();

        $bagianAkademik = User::role('bagian-akademik') 
            ->get();
        $numbers = $bagianAkademik->pluck('wa')->toArray();

        $mahasiswa = Mahasiswa::whereUserId($user->id)->first();

        $waGateway = $user->wa; //get no wa

        if ($request->status_data == 'Update Data') {
            $mahasiswa->update([
                'orang_tua'     => $request->orang_tua,
                'pekerjaan'     => $request->pekerjaan,
                'nip_nrp'       => $request->nip_nrp,
                'pangkat'       => $request->pangkat,
                'jabatan'       => $request->jabatan,
                'golongan'       => $request->golongan,
                'instansi'      => $request->instansi,
            ]);

            $pengajuan = Pengajuan::create([
                'jenis_pengajuan_id' => '1',
                'mahasiswa_id'  => $mahasiswa->id,
                'keperluan'     => $request->keperluan,
            ]);
        } else {
            $pengajuan = Pengajuan::create([
                'jenis_pengajuan_id' => '1',
                'mahasiswa_id'  => $mahasiswa->id,
                'keperluan'     => $request->keperluan,
            ]);
        }

        Riwayat::create([
            'pengajuan_id'  => $pengajuan->id,
            'status'        => 'Menunggu Konfirmasi',
            'catatan'       => 'Pengajuan Berhasil Dibuat. Tunggu pemberitahuan selanjutnya'
        ]);

        WhatsappGatewayService::sendMessage($waGateway, 
            'Hai, ' . $user->name . PHP_EOL .
                PHP_EOL .
                'Pengajuan Pembuatan Surat Keterangan Aktif Kuliah yang kamu lakukan Berhasil! ' . PHP_EOL .
                'Harap tunggu Konfirmasi dari bagian akademik.' . PHP_EOL .
                PHP_EOL .
                'Terima Kasih'
        ); //->Kirim Chat

        foreach ($numbers as $number) {
            WhatsappGatewayService::sendMessage($number, 
                'Hai, Bagian Akademik!' . PHP_EOL .
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
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            abort(404);
        }

        $aktifKuliah = Pengajuan::find($id);
        return view ('admin.pengajuan.surat-aktif-kuliah.detail', [
            'aktifKuliah'    =>  $aktifKuliah,
            'title'         =>  'Detail Pengajuan Keterangan Aktif Kuliah'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function konfirmasi(Request $request, string $id)
    {
        $pengajuan = Pengajuan::where('id',$id)->first();

        $waGateway = $pengajuan->mahasiswa->user->wa; //get no wa

        $data = [
            'status'  =>  'Konfirmasi'
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
                'Pengajuan Pembuatan Surat Keterangan Aktif Kuliah yang kamu lakukan telah dikonfirmasi oleh Bagian Akademik! ' . PHP_EOL .
                'Harap tunggu pemberitahuan selanjutnya.' . PHP_EOL .
                PHP_EOL .
                'Terima Kasih'
        ); //->Kirim Chat

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
            'pengajuan_id'          => $id,
            'status'                => 'Ditolak',
            'catatan'               => $request->catatan
        ]);

        Pengajuan::where('id', $id)->update($data);

        WhatsappGatewayService::sendMessage($waGateway, 
        'Hai, ' . $pengajuan->mahasiswa->user->name . ',' . PHP_EOL .
                PHP_EOL .
                'Pengajuan Pembuatan Surat Keterangan Aktif Kuliah yang kamu lakukan Ditolak oleh Bagian Akademik dengan alasan/catatan ' . PHP_EOL .
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
                    'Pengajuan Pembuatan Surat Keterangan Aktif Kuliah yang kamu lakukan sedang Diproses oleh Bagian Akademik!' . PHP_EOL .
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
                    'Pengajuan Pembuatan Surat Keterangan Aktif Kuliah yang kamu lakukan sedang Dalam Kendala!' . PHP_EOL .
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
                    'Pengajuan Pembuatan Surat Keterangan Aktif Kuliah yang kamu lakukan Telah Selesa!' . PHP_EOL .
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
        $aktifKuliah = Pengajuan::where('jenis_pengajuan_id', 1)
            ->where('status', 'Selesai')
            ->orWhere('jenis_pengajuan_id', 1)
            ->where('status', 'Tolak')
            ->latest()
            ->get();

        return view ('admin.riwayat.surat-aktif-kuliah.index', [
            'aktifKuliah'   => $aktifKuliah,
            'title'         => 'Surat Keterangan Aktif Kuliah'
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

        $aktifKuliah = Pengajuan::find($id);

        return view ('admin.riwayat.surat-aktif-kuliah.detail', [
            'aktifKuliah'        =>  $aktifKuliah,
            'title'             =>  'Detail Pengajuan Surat Keterangan AKtid Kuliah'
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
            ->where('jenis_pengajuan_id', 1)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return Excel::download(new AktifKuliahExport($data), 'Surat-Aktif-Kuliah-Export.xlsx');
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
        
        $aktifKuliah = Pengajuan::find($id);
        if ($aktifKuliah->tanggal_surat == null) {
            $now   = Carbon::now()->locale('id');
            $currentDate =  $now->translatedFormat('l, d F Y'); // Mendapatkan tanggal saat ini dengan nama hari dalam bahasa Indonesia
            
            $aktifKuliah->update([
                'tanggal_surat'            => $currentDate,
            ]);
        } // Mendapatkan tanggal saat ini dengan nama hari dalam bahasa Indonesia
            // Mendapatkan tanggal saat ini dengan nama hari
        //mengambil data dan tampilan dari halaman laporan_pdf
        //data di bawah ini bisa kalian ganti nantinya dengan data dari database
        $data = PDF::loadview('admin.pengajuan.surat-aktif-kuliah.print', [
            'aktifKuliah'   => $aktifKuliah
        ]);
        //mendownload laporan.pdf
    	return $data->stream('Surat-Keterangan-Aktif-Kuliah.pdf');
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
