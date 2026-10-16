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
            ['name' => 'Owner TipeCreative', 'email' => 'owner@tipecreative.test', 'role' => Role::OWNER],
            ['name' => 'Super Admin', 'email' => 'superadmin@tipecreative.test', 'role' => Role::SUPER_ADMIN],
            ['name' => 'Admin', 'email' => 'admin@tipecreative.test', 'role' => Role::ADMIN],
            ['name' => 'Kepala Staf Design', 'email' => 'design@tipecreative.test', 'role' => Role::KEPALA_STAF_DESIGN],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => 'password123',
                'role_id' => Role::where('name', $user['role'])->value('id'),
                'status' => 'aktif',
                'email_verified_at' => now(),
            ]);
        }
    }
}
