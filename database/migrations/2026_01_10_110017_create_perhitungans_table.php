<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perhitungan', function (Blueprint $table) {
            $table->id('perhitungan_id');
            $table->unsignedBigInteger('pendaftaran_id');
            $table->foreign('pendaftaran_id')->references('pendaftaran_id')->on('pendaftaran')->onDelete('cascade');
            $table->decimal('nilai_akhir', 5, 4);
            $table->integer('ranking');
            $table->enum('status_kelulusan', ['diterima', 'cadangan', 'tidak_diterima'])->nullable();
            $table->text('catatan')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perhitungan');
    }
};
