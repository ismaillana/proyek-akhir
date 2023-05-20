<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name'      => 'super-admin',
            'guard_name'=> 'web'
        ]);

        Role::create([
            'name'      => 'admin-jurusan',
            'guard_name'=> 'web'
        ]);

        Role::create([
            'name'      => 'koor-pkl',
            'guard_name'=> 'web'
        ]);

        Role::create([
            'name'      => 'mahasiswa',
            'guard_name'=> 'web'
        ]);

        Role::create([
            'name'      => 'alumni',
            'guard_name'=> 'web'
        ]);

        Role::create([
            'name'      => 'instansi',
            'guard_name'=> 'web'
        ]);
    }
}
