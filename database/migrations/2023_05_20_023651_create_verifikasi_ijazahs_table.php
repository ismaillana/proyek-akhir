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
        Schema::create('verifikasi_ijazahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instansi_id')
                ->constrained()
                ->cascadeOnUpdate();
            $table->string('name');
            $table->string('nim');
            $table->string('no_ijazah');
            $table->string('tahun_lulus');
            $table->string('dokumen');
            $table->text('catatan')->nullable();
            $table->ENUM('status', ['Menunggu Konfirmasi', 'Konfirmasi', 'Proses', 'Kendala', 'Tolak', 'Selesai'])
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
        Schema::dropIfExists('verifikasi_ijazahs');
    }
};
