<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Throwable;

class MahasiswaImport implements ToCollection, WithHeadingRow, SkipsOnError
{
    public function  __construct($id)
    {
        $this->id = $id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
           $user = User::create([
               'name' => $row['nama'],
               'nomor_induk' => $row['nim'],
               'email'    => $row['email'],
               'password' => Hash::make($row['nim']),
           ]);

           Mahasiswa::Create([
               'user_id' => $user->id,
               'program_studi_id' => $this->id,
               'nim' => $row['nim'],
               'angkatan' => $row['angkatan'],
           ]);

        $user->assignRole('mahasiswa');
          
      }

    }

    public function onError(Throwable $e)
    {
        
    }
}
