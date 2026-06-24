<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_warga', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16)->nullable();
            $table->string('nama_lengkap', 255);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 50)->nullable();
            $table->string('status_perkawinan', 50)->nullable();
            $table->string('shdk', 50)->nullable(); // Status Hubungan Dalam Keluarga
            $table->string('pendidikan_terakhir', 100)->nullable();
            $table->string('pekerjaan', 100)->nullable();
            $table->string('nama_ibu', 255)->nullable();
            $table->string('nama_ayah', 255)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();
            $table->string('kelurahan', 100)->nullable()->default('CARINGIN');
            $table->string('kecamatan', 100)->nullable()->default('GEGERBITUNG');
            $table->string('kabupaten', 100)->nullable()->default('SUKABUMI');
            $table->string('provinsi', 100)->nullable()->default('JAWA BARAT');
            $table->string('golongan_darah', 5)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_warga');
    }
};
