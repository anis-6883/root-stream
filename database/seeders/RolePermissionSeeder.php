<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Role
        $adminRole = Role::create(['name' => 'admin']);

        // Permission List
        $permissions = [
            [
                'group_name' => 'permission',
                'permissions' => [
                    // permission Permissions
                    'permission.create',
                    'permission.view',
                    'permission.edit',
                    'permission.delete',
                    'permission.access',
                ]
            ],
            [
                'group_name' => 'role',
                'permissions' => [
                    // role Permissions
                    'role.create',
                    'role.view',
                    'role.edit',
                    'role.delete',
                    'role.access',
                ]
            ],
            [
                'group_name' => 'app',
                'permissions' => [
                    // app Permissions
                    'app.create',
                    'app.view',
                    'app.edit',
                    'app.delete',
                    'app.access',
                ]
            ],
            [
                'group_name' => 'live_match',
                'permissions' => [
                    // live match Permissions
                    'live_match.create',
                    'live_match.view',
                    'live_match.edit',
                    'live_match.delete',
                    'live_match.access',
                ]
            ],
        ];

        $user = User::find(1);

        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup]);
                $adminRole->givePermissionTo($permission);
                $user->givePermissionTo($permission);
                // $permission->assignRole($adminRole);
            }
        }
        
        $user->assignRole($adminRole);
    }
}
