<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_surat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_template', 255);
            $table->string('kode_template', 100)->unique();
            $table->text('deskripsi')->nullable();
            $table->string('lokasi_file', 255); // Path ke file .docx template
            $table->json('placeholders')->nullable(); // JSON array placeholder yang digunakan
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_surat');
    }
};
