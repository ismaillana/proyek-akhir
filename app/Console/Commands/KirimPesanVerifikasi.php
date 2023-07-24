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
    
            $bagianAkademikNumbers = User::role('bagian-akademik')->pluck('wa')->toArray();
    
            foreach ($bagianAkademikNumbers as $number) {
                WhatsappGatewayService::sendMessage($number, 'Hai, Bagian Akademik!' . PHP_EOL .
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
