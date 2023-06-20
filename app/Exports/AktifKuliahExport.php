<?php

namespace App\Exports;

use App\Models\Pengajuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AktifKuliahExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Pengajuan',
            'Nama Mahasiswa',
            'NIM',
            'Status Pengajuan',
            // Tambahkan atribut-atribut lain yang ingin Anda ekspor
        ];
    }

    public function map($pengajuan): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $pengajuan->created_at,
            $pengajuan->mahasiswa->user->name,
            $pengajuan->mahasiswa->nim,
            $pengajuan->status,
            // Tambahkan value-value lain yang ingin Anda ekspor
        ];
    }
}