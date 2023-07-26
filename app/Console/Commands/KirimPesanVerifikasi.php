<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pengajuan;
use App\Models\User;
use App\Services\WhatsappGatewayService;
use Carbon\Carbon;

class KirimPesanVerifikasi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pesan:verifikasi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengirim pesan pengingat jika pengajuan belum diverifikasi lebih dari 1 hari';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        {
            $pengajuans = Pengajuan::where('status', 'Menunggu Konfirmasi')
                ->whereIn('jenis_pengajuan_id', [1, 5, 6])
                ->where('created_at', '<=', Carbon::now()->subDay())
                ->get();

            $pengantarPklll = Pengajuan::select('kode_pkl', 'tempat_pkl_id', 'status', \DB::raw('MAX(mahasiswa_id) as mahasiswa_id'))
                ->where('jenis_pengajuan_id', 2)
                ->where(function ($query) {
                    $query->where('status', 'Menunggu Konfirmasi');
                })
                ->where('created_at', '<=', Carbon::now()->subDay())
                ->groupBy('kode_pkl', 'tempat_pkl_id', 'status')
                ->get();
    
            $jurusanIds = $pengantarPklll->pluck('mahasiswa.programStudi.jurusan_id')->toArray();
    
                // Ambil data user dengan role 'admin-jurusan' yang memiliki jurusan_id sesuai dengan $jurusanIds
                $userId = User::role('admin-jurusan')
                ->whereIn('jurusan_id', $jurusanIds)
                ->get();
                $waNumbers = $userId->pluck('wa')->toArray();
    
            $bagianAkademikNumbers = User::role('bagian-akademik')->pluck('wa')->toArray();
    
            if (count($pengajuans) > 0) {
                foreach ($bagianAkademikNumbers as $number) {
                    WhatsappGatewayService::sendMessage($number, 
                        'Hai, Bagian Akademik!' . PHP_EOL .
                        PHP_EOL .
                        'Ada pengajuan Baru Yang Belum Dikonfirmasi Lebih Dari 1 hari' . PHP_EOL .
                        'Segera lakukan pengecekan data pengajuan!' . PHP_EOL .
                        PHP_EOL .
                        '[Politeknik Negeri Subang]'
                    );
                }
            }

            if (count($pengantarPklll) > 0) {
                foreach ($waNumbers as $wa) {
                    WhatsappGatewayService::sendMessage($wa, 
                        'Hai, Admin Jurusan!' . PHP_EOL .
                        PHP_EOL .
                        'Ada pengajuan Baru Yang Belum Dikonfirmasi Lebih Dari 1 hari' . PHP_EOL .
                        'Segera lakukan pengecekan data pengajuan!' . PHP_EOL .
                        PHP_EOL .
                        '[Politeknik Negeri Subang]'
                    );
                }
            }
        }
    
    }
}
