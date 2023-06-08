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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('legalisir_id')->nullable();
            $table->foreignId('aktif_kuliah_id')->nullable();
            $table->foreignId('pengantar_pkl_id')->nullable();
            $table->foreignId('izin_penelitian_id')->nullable();
            $table->foreignId('dispensasi_id')->nullable();
            $table->foreignId('verifikasi_ijazah_id')->nullable();
            $table->string('status')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
