<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persyaratan', function (Blueprint $table) {
            $table->id('persyaratan_id');
            $table->string('nama_dokumen', 100);
            $table->text('deskripsi')->nullable();
            $table->boolean('wajib')->default(true);
            $table->string('format_file', 50);
            $table->integer('max_size');
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persyaratan');
    }
};
