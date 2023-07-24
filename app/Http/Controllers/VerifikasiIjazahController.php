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
    public function index()
    {
        $verifikasiIjazah = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 6)
            ->whereNotIn('status', ['Selesai', 'Tolak'])
            ->get();

        return view ('admin.pengajuan.verifikasi-ijazah.index', [
            'verifikasiIjazah'  => $verifikasiIjazah,
            'title'             => 'Verifikasi Ijazah'
        ]);
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
    public function store(VerifikasiIjazahRequest $request)
    {
        $user = auth()->user();

        $bagianAkademik = User::role('bagian-akademik') 
            ->get();
        $numbers = $bagianAkademik->pluck('wa')->toArray();
        // dd($numbers);

        $instansi       = Instansi::whereUserId($user->id)->first();

        $waGateway = $user->wa; //get no wa

        $data = ([
            'jenis_pengajuan_id' => 6,
            'instansi_id'      => $instansi->id,
            'nama'             => $request->nama,
            'nim'              => $request->nim,
            'no_ijazah'        => $request->no_ijazah,
            'tahun_lulus'      => $request->tahun_lulus,
            'dokumen'          => $request->dokumen,
        ]);

        $dokumen = Pengajuan::saveDokumen($request);

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
                'Pengajuan Pengecekan keaslian ijazah yang kamu lakukan Berhasil! ' . PHP_EOL .
                'Harap tunggu Konfirmasi dari bagian akademik.' . PHP_EOL .
                PHP_EOL .
                'Terima Kasih'. PHP_EOL .
                PHP_EOL .
                '[Politeknik Negeri Subang]'
        ); //->Kirim Chat

        foreach ($numbers as $number) {
            WhatsappGatewayService::sendMessage($number, 
                'Hai, Bagian Akademik!' . PHP_EOL .
                    PHP_EOL .
                    'Ada pengajuan Verifikasi Ijazah baru dari '. $user->name . PHP_EOL .
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

        $verifikasiIjazah = Pengajuan::find($id);
        return view ('admin.pengajuan.verifikasi-ijazah.detail', [
            'verifikasiIjazah'    =>  $verifikasiIjazah,
            'title'         =>  'Detail Pengajuan Verifikasi Ijazah'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function konfirmasi(Request $request, string $id)
    {
        $pengajuan = Pengajuan::where('id',$id)->first();
        
        $waGateway = $pengajuan->instansi->user->wa; //get no wa

        if ($pengajuan->no_surat == null) {
            return redirect()->back()->with('error', 'Nomor Surat Belum Diisi!');
        }

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
        'Hai, ' . $pengajuan->instansi->user->name . ',' . PHP_EOL .
                PHP_EOL .
                'Pengajuan Pengecekan keaslian ijazah yang kamu lakukan telah dikonfirmasi oleh Bagian Akademik! ' . PHP_EOL .
                'Harap tunggu pemberitahuan selanjutnya.' . PHP_EOL .
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
    public function tolak(KonfirmasiRequest $request, string $id)
    {
        $pengajuan = Pengajuan::where('id',$id)->first();
        
        $waGateway = $pengajuan->instansi->user->wa; //get no wa

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
        'Hai, ' . $pengajuan->instansi->user->name . ',' . PHP_EOL .
                PHP_EOL .
                'Pengajuan Pengecekan keaslian ijazah yang kamu lakukan Ditolak oleh Bagian Akademik dengan alasan/catatan ' . PHP_EOL .
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
        $request->validate([
            'status' => 'required',
            'dokumen_hasil' => 'required_if:status,Selesai',
        ], [
            'status.required' => 'Pilih Status',
            'dokumen_hasil.required_if' => 'Masukkan Dokumen Hasil',
        ]);

        if ($request->status == 'Selesai') {

            $dokumen = Pengajuan::saveDokumenHasil($request);

            $data = [
                'status'  =>  $request->status,
                'dokumen_hasil' => $dokumen
            ];
        } else {
            $data = [
                'status'  =>  $request->status
            ];
        }

        Pengajuan::where('id', $id)->update($data);

        $pengajuan = Pengajuan::where('id',$id)->first();
        
        $waGateway = $pengajuan->instansi->user->wa; //get no wa

        if ($request->status == 'Proses' ) {
            Riwayat::create([
                'pengajuan_id'  => $id,
                'status'        => 'Diproses',
                'catatan'       => 'Pengajuan Anda Sedang Diproses. Tunggu pemberitahuan selanjutnya'
            ]);

            WhatsappGatewayService::sendMessage($waGateway, 
                'Hai, ' . $pengajuan->instansi->user->name . ',' . PHP_EOL .
                    PHP_EOL .
                    'Pengajuan Pengecekan keaslian ijazah yang kamu lakukan sedang Diproses oleh Bagian Akademik!' . PHP_EOL .
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
                'Hai, ' . $pengajuan->instansi->user->name . ',' . PHP_EOL .
                    PHP_EOL .
                    'Pengajuan Pengecekan keaslian ijazah yang kamu lakukan sedang Dalam Kendala!' . PHP_EOL .
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
                'Hai, ' . $pengajuan->instansi->user->name . ',' . PHP_EOL .
                    PHP_EOL .
                    'Pengajuan Pengecekan keaslian ijazah yang kamu lakukan Telah Selesai!' . PHP_EOL .
                    'Silahkan login kembali ke website pengajuan kemudian buka menu Riwayat Pengajuan untuk mengunduh hasil pengajuan.' . PHP_EOL .
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
        $verifikasiIjazah = Pengajuan::latest()
            ->where('jenis_pengajuan_id', 6)
            ->get();

        return view ('admin.riwayat.verifikasi-ijazah.index', [
            'verifikasiIjazah'   => $verifikasiIjazah,
            'title'         => 'Verifikasi Ijazah'
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

        $verifikasiIjazah = Pengajuan::find($id);
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
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            abort(404);
        }

        $verifikasiIjazah = Pengajuan::find($id);
        
        if ($verifikasiIjazah->no_surat == null) {
            return redirect()->back()->with('error', 'Nomor Surat Belum Diisi!');
        }

        if ($verifikasiIjazah->tanggal_surat == null) {
            $now   = Carbon::now()->locale('id');
            $currentDate =  $now->translatedFormat('l, d F Y'); // Mendapatkan tanggal saat ini dengan nama hari dalam bahasa Indonesia
            
            $verifikasiIjazah->update([
                'tanggal_surat'            => $currentDate,
            ]);
        }
        //mengambil data dan tampilan dari halaman laporan_pdf
        $data = PDF::loadview('admin.pengajuan.verifikasi-ijazah.print', [
            'verifikasiIjazah' => $verifikasiIjazah
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
            ->where('jenis_pengajuan_id', 6)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return Excel::download(new VerifikasiIjazahExport($data), 'Verifikasi-Ijazah-Export.xlsx');
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
