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
        $breezeAdmin = User::find(1);
        Role::create(['name' => 'user']);

        $adminRole = Role::create(['name' => 'admin']);

        $breezeAdmin->assignRole($adminRole);
    }
}
