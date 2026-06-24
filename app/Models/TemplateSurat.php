<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateSurat extends Model
{
    use HasFactory;

    protected $table = 'template_surat';

    protected $fillable = [
        'nama_template',
        'kode_template',
        'deskripsi',
        'lokasi_file',
        'placeholders',
        'status_aktif',
    ];

    protected $casts = [
        'placeholders' => 'array',
        'status_aktif' => 'boolean',
    ];

    // Relasi
    public function riwayatCetak()
    {
        return $this->hasMany(RiwayatCetak::class, 'id_template');
    }
}
