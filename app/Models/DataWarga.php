<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataWarga extends Model
{
    use HasFactory;

    protected $table = 'data_warga';

    protected $fillable = [
        'nik',
        'no_kk',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'status_perkawinan',
        'shdk',
        'pendidikan_terakhir',
        'pekerjaan',
        'nama_ibu',
        'nama_ayah',
        'alamat',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'golongan_darah',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relasi
    public function riwayatCetak()
    {
        return $this->hasMany(RiwayatCetak::class, 'id_warga');
    }

    // Helper: Nama agama dari kode
    public static function namaAgama($kode)
    {
        $agama = [
            '1' => 'Islam',
            '2' => 'Kristen',
            '3' => 'Katholik',
            '4' => 'Hindu',
            '5' => 'Budha',
            '6' => 'Konghucu',
            '7' => 'Kepercayaan',
        ];
        return $agama[$kode] ?? $kode;
    }
}
