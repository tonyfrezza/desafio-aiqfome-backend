<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $baseRolesPermissions = [
            'super-admin' => [],
            'client'    =>  [
                'view-favorites-products',
                'add-favorites-products',
                'remove-favorites-products',
            ],
        ];

        foreach ($baseRolesPermissions as $baseRoleName => $permissions) {
            foreach ($permissions as $basePermission) {
                Permission::firstOrCreate([
                    'name'  =>  $basePermission,
                    'guard_name'    =>  'sanctum',
                ]);
            }
            $role = Role::firstOrCreate([
                'name'  =>  $baseRoleName,
                'guard_name'    =>  'sanctum',
            ]);
            $role->syncPermissions($permissions);
        }
    }
}
