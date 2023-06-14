<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_pengajuan_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate();
            $table->foreignId('mahasiswa_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate();
            $table->foreignId('instansi_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate();
            $table->foreignId('tempat_pkl_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate();
            $table->json('nama_mahasiswa')->nullable();
            $table->json('jenis_legalisir')->nullable(); //Legalisir
            $table->string('no_ijazah')->nullable();
            $table->string('pekerjaan_terakhir')->nullable();
            $table->string('nama_tempat')->nullable(); //Nama perusahaan Izin Penelitian, Tempat Kegiatan, tempat kerja terakhir
            $table->string('alamat_tempat')->nullable(); //Izin Penelitian
            $table->string('tujuan_surat')->nullable(); // Ditujukan untuk siapa
            $table->string('perihal')->nullable();
            $table->string('nama')->nullable(); //Verifikasi Ijazah
            $table->string('nim')->nullable();
            $table->year('tahun_lulus')->nullable();
            $table->string('kegiatan')->nullable(); //Dispensasi
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->text('keperluan')->nullable();
            $table->string('dokumen')->nullable();
            $table->text('catatan')->nullable();
            $table->ENUM('status', ['Menunggu Konfirmasi', 'Konfirmasi', 
            'Proses', 'Kendala', 'Tolak', 'Selesai', 
            'Diterima Perusahaan', 'Ditolak Perusahaan', 'Review', 'Setuju'])
            ->default('Menunggu Konfirmasi')
            ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
