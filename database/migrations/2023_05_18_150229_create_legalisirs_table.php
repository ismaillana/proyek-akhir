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
        Schema::create('legalisirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')
                ->constrained()
                ->cascadeOnUpdate();
            $table->json('jenis_legalisir_id');
            $table->string('no_ijazah');
            $table->string('keperluan');
            $table->string('pekerjaan_terakhir');
            $table->string('tempat_pekerjaan_terakhir');
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
        Schema::dropIfExists('legalisirs');
    }
};
