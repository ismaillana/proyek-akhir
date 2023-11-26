<?php

namespace App\Exports;

use App\Models\Pengajuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengantarPklExport implements FromCollection, WithHeadings, WithMapping
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
            'Kode Pengajuan',
            'Nama Mahasiswa',
            'NIM',
            'Tempat PKL',
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
            $pengajuan->kode_pkl,
            $pengajuan->mahasiswa->user->name,
            $pengajuan->mahasiswa->nim,
            $pengajuan->tempatPkl->name,
            $pengajuan->status,
            // Tambahkan value-value lain yang ingin Anda ekspor
        ];
    }
}
