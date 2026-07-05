<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin role
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // Optional: Create example permissions
        $permissions = [
            'access dashboard',
            'manage users',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            $perm = Permission::firstOrCreate(['name' => $permission]);
            $adminRole->givePermissionTo($perm);
        }

        // Create the first admin user
        $admin = User::firstOrCreate(
            ['email' => 'authenticmoroccoadventures@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Assign Admin role to the user
        $admin->assignRole($adminRole);
    }
}
