<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'view-licenses',
            'create-licenses',
            'edit-licenses',
            'delete-licenses'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create admin role and assign all permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($permissions);

        // Create user role and assign view permission
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo(['view-licenses']);
    }
} 