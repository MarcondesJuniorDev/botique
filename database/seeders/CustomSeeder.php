<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permissões básicas
        $permissions = [
            'access_admin_panel',
            'create_users',
            'update_users',
            'delete_users',
            'read_users',
            'create_roles',
            'update_roles',
            'delete_roles',
            'read_roles',
            'create_permissions',
            'update_permissions',
            'delete_permissions',
            'read_permissions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Papéis básicos
        $roles = [
            'admin' => [
                'access_admin_panel',
                'create_users',
                'read_users',
                'update_users',
                'delete_users',
                'create_roles',
                'read_roles',
                'update_roles',
                'delete_roles',
                'create_permissions',
                'read_permissions',
                'update_permissions',
                'delete_permissions',
            ],
            'manager' => [
                'access_admin_panel',
                'create_users',
                'read_users',
                'update_users'
            ],
            'user' => [
                'access_admin_panel',
                'read_users'
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }

        User::factory(9)->create()->each(function ($user) {
            $user->assignRole(Role::all()->random());
        });

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('admin');

        User::factory()->create([
            'name' => 'manager',
            'email' => 'manager@manager.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('manager');

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@user.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('user');

        User::factory(17)->create()->each(function ($user) {
            $user->assignRole(Role::all()->random());
        });
    }
}
