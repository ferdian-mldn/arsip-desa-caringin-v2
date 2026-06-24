<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatCetak extends Model
{
    use HasFactory;

    protected $table = 'riwayat_cetak';

    protected $fillable = [
        'id_user',
        'id_template',
        'id_warga',
        'nomor_surat',
        'data_snapshot',
    ];

    protected $casts = [
        'data_snapshot' => 'array',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function template()
    {
        return $this->belongsTo(TemplateSurat::class, 'id_template');
    }

    public function warga()
    {
        return $this->belongsTo(DataWarga::class, 'id_warga');
    }
}
