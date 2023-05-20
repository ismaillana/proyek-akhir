<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jurusan::create([
            'name'  => 'Manajemen Informatika'
        ]);

        Jurusan::create([
            'name'  => 'Agro Industri'
        ]);

        Jurusan::create([
            'name'  => 'Perawatan dan Pemeliharaan Mesin'
        ]);

    }
}
