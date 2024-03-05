<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $breezeAdmin = User::create([
            'name' => 'Breeze Admin',
            'email' => 'admin@breezemm.com',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        Role::create(['name' => 'user']);

        $adminRole = Role::create(['name' => 'admin']);

        $breezeAdmin->assignRole($adminRole);
    }
}
