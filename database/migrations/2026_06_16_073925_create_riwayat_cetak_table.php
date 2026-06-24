<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_cetak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_template')->constrained('template_surat')->onDelete('cascade');
            $table->foreignId('id_warga')->constrained('data_warga')->onDelete('cascade');
            $table->string('nomor_surat', 100)->nullable();
            $table->json('data_snapshot')->nullable(); // Snapshot data warga saat dicetak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_cetak');
    }
};
