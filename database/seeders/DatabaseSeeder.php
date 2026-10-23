<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            Role::OWNER => 'Pemegang lisensi, kedudukan tertinggi',
            Role::SUPER_ADMIN => 'Pengelola akun pengguna',
            Role::ADMIN => 'Mengelola data dan komunikasi pelanggan',
            Role::KEPALA_STAF_DESIGN => 'Mengelola pengerjaan desain dan revisi',
        ];

        foreach ($roles as $name => $description) {
            Role::create(['name' => $name, 'description' => $description]);
        }

        // akun buat testing, password semua: password123
        $users = [
            ['name' => 'Owner TipeCreative', 'nip' => '10000000001', 'role' => Role::OWNER],
            ['name' => 'Super Admin', 'nip' => '10000000002', 'role' => Role::SUPER_ADMIN],
            ['name' => 'Admin', 'nip' => '10000000003', 'role' => Role::ADMIN],
            ['name' => 'Kepala Staf Design', 'nip' => '10000000004', 'role' => Role::KEPALA_STAF_DESIGN],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'nip' => $user['nip'],
                'password' => 'password123',
                'role_id' => Role::where('name', $user['role'])->value('id'),
            ]);
        }
    }
}
