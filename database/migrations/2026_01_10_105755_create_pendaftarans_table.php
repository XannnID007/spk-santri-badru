<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id('pendaftaran_id');
            $table->string('no_pendaftaran', 20)->unique();
            $table->unsignedBigInteger('pengguna_id');
            $table->unsignedBigInteger('periode_id');
            $table->foreign('pengguna_id')->references('pengguna_id')->on('pengguna')->onDelete('cascade');
            $table->foreign('periode_id')->references('periode_id')->on('periode')->onDelete('cascade');
            $table->string('asal_sekolah', 100);
            $table->decimal('rata_nilai', 4, 2);
            $table->text('prestasi')->nullable();
            $table->string('file_kk', 200)->nullable();
            $table->string('file_akta', 200)->nullable();
            $table->string('file_ijazah', 200)->nullable();
            $table->string('file_foto', 200)->nullable();
            $table->string('file_sktm', 200)->nullable();
            $table->enum('status_verifikasi', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->enum('status_pendaftaran', ['draft', 'submitted'])->default('draft');
            $table->timestamp('tanggal_submit')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
