<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_tes', function (Blueprint $table) {
            $table->id('nilai_tes_id');
            $table->unsignedBigInteger('pendaftaran_id');
            $table->unsignedBigInteger('kriteria_id');
            $table->foreign('pendaftaran_id')->references('pendaftaran_id')->on('pendaftaran')->onDelete('cascade');
            $table->foreign('kriteria_id')->references('kriteria_id')->on('kriteria')->onDelete('cascade');
            $table->decimal('nilai', 5, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_tes');
    }
};
