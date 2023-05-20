<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Super Admin',
            'nomor_induk' => '13092002',
            'email' => 'superadmin@gmail.com',
            'status' => '1',
            'password' => Hash::make('superadmin'),
        ]);

        $user->assignRole('super-admin');

    }
}
