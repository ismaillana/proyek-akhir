<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\TempatPkl;

class TempatPklSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TempatPkl::create([
            'name'      => 'CV.Sagala Aya',
            'alamat'    => 'Subang',
            'web'       => 'sagalaaya.com',
            'telepon'   => '083804046583',
        ]);

        TempatPkl::create([
            'name'      => 'CV.Laris',
            'alamat'    => 'Subang',
            'web'       => 'laris.com',
            'telepon'   => '083804046583',
        ]);
    }
}
