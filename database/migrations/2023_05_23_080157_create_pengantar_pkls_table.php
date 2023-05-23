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
        Schema::create('pengantar_pkls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')
                ->constrained()
                ->cascadeOnUpdate();
            $table->json('nama_mahasiswa');
            $table->string('nama_perusahaan');
            $table->text('alamat');
            $table->string('web');
            $table->string('telepon');
            $table->date('mulai');
            $table->date('selesai');
            $table->string('kepada');
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
        Schema::dropIfExists('pengantar_pkls');
    }
};
