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
        Schema::create('dosen_promotions', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->unique();
            $table->string('nama_dosen'); 
            $table->string('jabatan_akademik_sebelumnya'); 
            $table->string('jabatan_akademik_di_usulkan'); 
            $table->date('tanggal_proses'); 
            $table->date('tanggal_selesai')->nullable();
            $table->string('surat_pengantar_pimpinan_pts')->nullable(); 
            $table->string('berita_acara_senat')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_promotions');
    }
};
