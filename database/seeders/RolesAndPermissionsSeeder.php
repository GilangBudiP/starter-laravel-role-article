<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'roles.read',
            'roles.create',
            'roles.update',
            'roles.delete',
            'permissions.read',
            'permissions.create',
            'permissions.update',
            'permissions.delete',
            'articles.read',
            'articles.create',
            'articles.update',
            'articles.delete',
            'users.read',
            'users.create',
            'users.update',
            'users.delete',
            'categories.read',
            'categories.create',
            'categories.update',
            'categories.delete',
            'galleries.read',
            'galleries.create',
            'galleries.update',
            'galleries.delete',
        ];

        foreach ($permissions as  $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $roles = [
            'Super Admin', 'Admin', 'User'
        ];

        foreach ($roles as  $role) {
            Role::firstOrCreate([
                'name' => $role
            ],
            ['name' => $role, 'guard_name' => 'web']);
        }

        $user = User::firstOrCreate([
                'email' => 'admin@admin.com'
            ],
            [
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123'),
        ]);

        $user->assignRole('Super Admin');
    }
}
