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
        Schema::create('dispensasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')
                ->constrained()
                ->cascadeOnUpdate();
            $table->json('nama_mahasiswa');
            $table->dateTime('mulai');
            $table->dateTime('selesai');
            $table->string('kegiatan');
            $table->string('tempat');
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
        Schema::dropIfExists('dispensasis');
    }
};
