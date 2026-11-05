<?php

namespace Database\Seeders;

use App\Models\Layanan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Permission::create(['name' => 'lihat dashboard']);
        Permission::create(['name' => 'kelola akun']);
        Permission::create(['name' => 'kelola lead']);

        Role::create(['name' => Role::OWNER])->givePermissionTo(['lihat dashboard', 'kelola akun', 'kelola lead']);
        Role::create(['name' => Role::SUPER_ADMIN])->givePermissionTo('kelola akun');
        Role::create(['name' => Role::ADMIN])->givePermissionTo(['lihat dashboard', 'kelola lead']);
        Role::create(['name' => Role::KEPALA_STAF_DESIGN])->givePermissionTo('lihat dashboard');
        Role::create(['name' => Role::DESAINER]);

        // akun buat testing, password semua: password123
        $users = [
            ['name' => 'Owner TipeCreative', 'nip' => '10000000001', 'role' => Role::OWNER],
            ['name' => 'Super Admin', 'nip' => '10000000002', 'role' => Role::SUPER_ADMIN],
            ['name' => 'Admin', 'nip' => '10000000003', 'role' => Role::ADMIN],
            ['name' => 'Kepala Staf Design', 'nip' => '10000000004', 'role' => Role::KEPALA_STAF_DESIGN],
            ['name' => 'Desainer', 'nip' => '10000000005', 'role' => Role::DESAINER],
        ];

        foreach ($users as $user) {
            $akun = User::create([
                'name' => $user['name'],
                'nip' => $user['nip'],
                'password' => 'password123',
            ]);

            $akun->assignRole($user['role']);
        }

        $layanans = ['Desain Logo', 'Desain Kaos', 'Editing Video', 'Editing Foto', 'Poster', 'Banner', 'Flyer'];

        foreach ($layanans as $nama) {
            Layanan::create(['nama' => $nama]);
        }
    }
}
