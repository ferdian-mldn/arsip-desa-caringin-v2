<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dokumen', function (Blueprint $table) {
            // Drop existing foreign key constraint if possible, but SQLite handles it differently.
            // On MySQL we can just modify the column to nullable and the FK remains intact.
            $table->unsignedBigInteger('id_unit_kerja')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('dokumen', function (Blueprint $table) {
            $table->unsignedBigInteger('id_unit_kerja')->nullable(false)->change();
        });
    }
};
