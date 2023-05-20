<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\JenisLegalisir;

class JenisLegalisirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisLegalisir::create([
            'name'  => 'Ijazah'
        ]);

        JenisLegalisir::create([
            'name'  => 'Transkrip'
        ]);
        
        JenisLegalisir::create([
            'name'  => 'SKPI'
        ]);
        
        JenisLegalisir::create([
            'name'  => 'SKL'
        ]);
    }
}
