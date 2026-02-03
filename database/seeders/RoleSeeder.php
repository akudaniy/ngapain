<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolePermissions = [
            'manager' => [
                'DailyAccomplishment' => ['ViewAny', 'View', 'Create', 'Update'],
                'Project' => ['ViewAny', 'View', 'Create', 'Update'],
                'User' => ['ViewAny', 'View', 'Create', 'Update'],
                'Task' => ['ViewAny', 'View', 'Create', 'Update'],
                'Company' => ['ViewAny', 'View', 'Create', 'Update'],
            ],
            'supervisor' => [
                'DailyAccomplishment' => ['ViewAny', 'View', 'Create', 'Update'],
                'Project' => ['ViewAny', 'View', 'Create', 'Update'],
                'User' => ['ViewAny', 'View', 'Create', 'Update'],
                'Task' => ['ViewAny', 'View', 'Create', 'Update'],
                'Company' => ['ViewAny', 'View', 'Update'],
            ],
            'leader' => [
                'DailyAccomplishment' => ['ViewAny', 'View', 'Create', 'Update'],
                'Project' => ['ViewAny', 'View', 'Create', 'Update'],
                'User' => ['ViewAny', 'View'],
                'Task' => ['ViewAny', 'View', 'Create', 'Update'],
                'Company' => ['ViewAny', 'View'],
            ],
            'staff' => [
                'DailyAccomplishment' => ['ViewAny', 'View', 'Create', 'Update'],
                'Project' => ['ViewAny', 'View', 'Create', 'Update'],
                'User' => ['ViewAny', 'View'],
                'Task' => ['ViewAny', 'View', 'Create', 'Update'],
                'Company' => ['ViewAny', 'View'],
            ],
            'observer' => [
                'DailyAccomplishment' => ['ViewAny', 'View'],
                'Project' => ['ViewAny', 'View'],
                'User' => ['ViewAny', 'View'],
                'Task' => ['ViewAny', 'View'],
                'Company' => ['ViewAny', 'View'],
            ],
        ];

        foreach ($rolePermissions as $roleName => $models) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Sync permissions for this role
            $permissionsToAssign = [];

            foreach ($models as $model => $actions) {
                foreach ($actions as $action) {
                    $permissionName = "{$action}:{$model}";
                    \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permissionName]);
                    $permissionsToAssign[] = $permissionName;
                }
            }

            $role->syncPermissions($permissionsToAssign);
        }
    }
}
