<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Unit Kerja ===\n";
print_r(DB::table('unit_kerja')->get()->toArray());

echo "\n=== Roles ===\n";
print_r(DB::table('roles')->get()->toArray());

echo "\n=== Users ===\n";
print_r(DB::table('users')->select('id', 'name', 'id_unit_kerja', 'id_role')->get()->toArray());
