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
        Schema::create('izin_penelitians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')
                ->constrained()
                ->cascadeOnUpdate();
            $table->string('nama_tempat')->nullable();
            $table->string('alamat_penelitian')->nullable();
            $table->string('tujuan_surat')->nullable();
            $table->string('perihal')->nullable();
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
        Schema::dropIfExists('izin_penelitians');
    }
};
