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
        Schema::create('aktif_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')
                ->constrained()
                ->cascadeOnUpdate();
            $table->string('semester')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('tahun_ajaran')->nullable();
            $table->string('orang_tua')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('nip_nrp')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('instansi')->nullable();
            $table->text('keperluan');
            $table->ENUM('status', ['Menunggu Konfirmasi', 'Diproses', 'Selesai'])
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
        Schema::dropIfExists('aktif_kuliahs');
    }
};
