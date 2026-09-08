<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $roleAdmin    = Role::where('nama_peran', 'Admin')->first();
        $roleOperator = Role::where('nama_peran', 'Operator')->first();
        $roleViewer   = Role::where('nama_peran', 'Viewer')->first();

        // ── Helper ──────────────────────────────────────────────
        $unit = fn(string $kode) => UnitKerja::where('kode_unit', $kode)->first();

        // ══════════════════════════════════════════════════════════
        // 1. ADMIN SISTEM (tidak terikat unit kerja)
        // ══════════════════════════════════════════════════════════
        User::create([
            'id_role'       => $roleAdmin->id,
            'id_unit_kerja' => null,
            'nama_lengkap'  => 'Administrator Sistem',
            'username'      => 'admin',
            'email'         => 'admin@desacaringin.id',
            'password'      => Hash::make('password123'),
            'status_aktif'  => true,
        ]);

        // ══════════════════════════════════════════════════════════
        // 2. KEPALA DESA — MARPUDIN
        //    (Pelantikan 13 Desember 2020, periode 2019-2025)
        // ══════════════════════════════════════════════════════════
        User::create([
            'id_role'       => $roleViewer->id,
            'id_unit_kerja' => $unit('KADES')->id,
            'nama_lengkap'  => 'Marpudin',
            'username'      => 'kades',
            'email'         => 'kades@desacaringin.id',
            'password'      => Hash::make('password123'),
            'status_aktif'  => true,
        ]);

        // ══════════════════════════════════════════════════════════
        // 3. SEKRETARIS DESA — EMAN HERMANSYAH, SE
        //    (Sumber: Profil Desa Caringin 2025)
        // ══════════════════════════════════════════════════════════
        User::create([
            'id_role'       => $roleAdmin->id,
            'id_unit_kerja' => $unit('SEKDES')->id,
            'nama_lengkap'  => 'Eman Hermansyah, SE',
            'username'      => 'sekdes',
            'email'         => 'sekdes@desacaringin.id',
            'password'      => Hash::make('password123'),
            'status_aktif'  => true,
        ]);

        // ══════════════════════════════════════════════════════════
        // 4. KAUR KEUANGAN
        // ══════════════════════════════════════════════════════════
        User::create([
            'id_role'       => $roleOperator->id,
            'id_unit_kerja' => $unit('KEU')->id,
            'nama_lengkap'  => 'Kaur Keuangan',
            'username'      => 'kaur_keuangan',
            'email'         => 'keuangan@desacaringin.id',
            'password'      => Hash::make('password123'),
            'status_aktif'  => true,
        ]);

        // ══════════════════════════════════════════════════════════
        // 5. KAUR PERENCANAAN
        // ══════════════════════════════════════════════════════════
        User::create([
            'id_role'       => $roleOperator->id,
            'id_unit_kerja' => $unit('REN')->id,
            'nama_lengkap'  => 'Kaur Perencanaan',
            'username'      => 'kaur_perencanaan',
            'email'         => 'perencanaan@desacaringin.id',
            'password'      => Hash::make('password123'),
            'status_aktif'  => true,
        ]);

        // ══════════════════════════════════════════════════════════
        // 6. KAUR ADMINISTRASI & TU
        // ══════════════════════════════════════════════════════════
        User::create([
            'id_role'       => $roleOperator->id,
            'id_unit_kerja' => $unit('ADM')->id,
            'nama_lengkap'  => 'Kaur Administrasi & TU',
            'username'      => 'kaur_adm',
            'email'         => 'administrasi@desacaringin.id',
            'password'      => Hash::make('password123'),
            'status_aktif'  => true,
        ]);

        // ══════════════════════════════════════════════════════════
        // 7. KASI PEMERINTAHAN
        // ══════════════════════════════════════════════════════════
        User::create([
            'id_role'       => $roleOperator->id,
            'id_unit_kerja' => $unit('PEM')->id,
            'nama_lengkap'  => 'Kasi Pemerintahan',
            'username'      => 'kasi_pem',
            'email'         => 'pemerintahan@desacaringin.id',
            'password'      => Hash::make('password123'),
            'status_aktif'  => true,
        ]);

        // ══════════════════════════════════════════════════════════
        // 8. KASI KESEJAHTERAAN
        // ══════════════════════════════════════════════════════════
        User::create([
            'id_role'       => $roleOperator->id,
            'id_unit_kerja' => $unit('KESRA')->id,
            'nama_lengkap'  => 'Kasi Kesejahteraan',
            'username'      => 'kasi_kesra',
            'email'         => 'kesra@desacaringin.id',
            'password'      => Hash::make('password123'),
            'status_aktif'  => true,
        ]);

        // ══════════════════════════════════════════════════════════
        // 9. KASI PELAYANAN UMUM
        // ══════════════════════════════════════════════════════════
        User::create([
            'id_role'       => $roleOperator->id,
            'id_unit_kerja' => $unit('PEL')->id,
            'nama_lengkap'  => 'Kasi Pelayanan Umum',
            'username'      => 'kasi_pel',
            'email'         => 'pelayanan@desacaringin.id',
            'password'      => Hash::make('password123'),
            'status_aktif'  => true,
        ]);

        // ══════════════════════════════════════════════════════════
        // 10-13. KEPALA DUSUN (4 Dusun sesuai profil desa)
        //   - Dusun Lio
        //   - Dusun Benjot
        //   - Dusun Kawungluwuk
        //   - Dusun Caringin
        // ══════════════════════════════════════════════════════════
        $kadusData = [
            ['kode' => 'KADUS1', 'nama' => 'Kadus Dusun Lio',         'username' => 'kadus_lio',         'email' => 'kadus.lio@desacaringin.id'],
            ['kode' => 'KADUS2', 'nama' => 'Kadus Dusun Benjot',       'username' => 'kadus_benjot',       'email' => 'kadus.benjot@desacaringin.id'],
            ['kode' => 'KADUS3', 'nama' => 'Kadus Dusun Kawungluwuk',  'username' => 'kadus_kawungluwuk',  'email' => 'kadus.kawungluwuk@desacaringin.id'],
            ['kode' => 'KADUS4', 'nama' => 'Kadus Dusun Caringin',    'username' => 'kadus_caringin',    'email' => 'kadus.caringin@desacaringin.id'],
        ];

        foreach ($kadusData as $kadus) {
            User::create([
                'id_role'       => $roleViewer->id,
                'id_unit_kerja' => $unit($kadus['kode'])->id,
                'nama_lengkap'  => $kadus['nama'],
                'username'      => $kadus['username'],
                'email'         => $kadus['email'],
                'password'      => Hash::make('password123'),
                'status_aktif'  => true,
            ]);
        }
    }
}