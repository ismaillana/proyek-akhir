<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\JenisPengajuan;

class JenisPengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisPengajuan::create([
            'name'      => 'Surat Aktif Kuliah',
        ]);

        JenisPengajuan::create([
            'name'      => 'Surat Pengantar Pkl',
        ]);

        JenisPengajuan::create([
            'name'      => 'Surat Izin Penelitian',
        ]);

        JenisPengajuan::create([
            'name'      => 'Surat Dispensasi',
        ]);

        JenisPengajuan::create([
            'name'      => 'Legalisir',
        ]);

        JenisPengajuan::create([
            'name'      => 'Verifikasi Ijazah',
        ]);
    }
}
