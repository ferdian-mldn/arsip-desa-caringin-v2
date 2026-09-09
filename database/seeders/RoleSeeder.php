<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $roles = [
            [
                'nama_peran' => 'Admin',
                'deskripsi' => 'Administrator sistem dengan akses penuh (Koordinator)',
            ],
            [
                'nama_peran' => 'Operator',
                'deskripsi' => 'Kasi/Kaur yang mengelola dokumen unit kerja spesifik',
            ],
            [
                'nama_peran' => 'Viewer',
                'deskripsi' => 'Staf desa yang hanya melihat dan mengunduh dokumen',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}