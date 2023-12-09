<?php

namespace Modules\Roles\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Roles\app\Models\RolehasPermission;

class RolehasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RolehasPermission::truncate();
        RolehasPermission::create(['role_id' => '1', 'permission_id' => '1']);
        RolehasPermission::create(['role_id' => '1', 'permission_id' => '2']);
        RolehasPermission::create(['role_id' => '1', 'permission_id' => '3']);
        RolehasPermission::create(['role_id' => '1', 'permission_id' => '4']);
        RolehasPermission::create(['role_id' => '1', 'permission_id' => '5']);
        RolehasPermission::create(['role_id' => '1', 'permission_id' => '6']);
        RolehasPermission::create(['role_id' => '1', 'permission_id' => '7']);
        RolehasPermission::create(['role_id' => '1', 'permission_id' => '8']);
        RolehasPermission::create(['role_id' => '1', 'permission_id' => '9']);
        RolehasPermission::create(['role_id' => '1', 'permission_id' => '10']);
        RolehasPermission::create(['role_id' => '1', 'permission_id' => '11']);
        RolehasPermission::create(['role_id' => '1', 'permission_id' => '12']);
        RolehasPermission::create(['role_id' => '1', 'permission_id' => '13']);
        RolehasPermission::create(['role_id' => '1', 'permission_id' => '14']);
        RolehasPermission::create(['role_id' => '2', 'permission_id' => '2']);
        RolehasPermission::create(['role_id' => '2', 'permission_id' => '3']);
        RolehasPermission::create(['role_id' => '2', 'permission_id' => '5']);
        RolehasPermission::create(['role_id' => '2', 'permission_id' => '6']);
        RolehasPermission::create(['role_id' => '2', 'permission_id' => '8']);
        RolehasPermission::create(['role_id' => '2', 'permission_id' => '9']);
        RolehasPermission::create(['role_id' => '2', 'permission_id' => '10']);
        RolehasPermission::create(['role_id' => '2', 'permission_id' => '11']);
        RolehasPermission::create(['role_id' => '2', 'permission_id' => '12']);
        RolehasPermission::create(['role_id' => '2', 'permission_id' => '13']);
        RolehasPermission::create(['role_id' => '2', 'permission_id' => '14']);
        RolehasPermission::create(['role_id' => '3', 'permission_id' => '3']);
        RolehasPermission::create(['role_id' => '3', 'permission_id' => '6']);
        RolehasPermission::create(['role_id' => '3', 'permission_id' => '9']);
        RolehasPermission::create(['role_id' => '3', 'permission_id' => '10']);
        RolehasPermission::create(['role_id' => '3', 'permission_id' => '11']);
        RolehasPermission::create(['role_id' => '3', 'permission_id' => '12']);
        RolehasPermission::create(['role_id' => '3', 'permission_id' => '13']);
        RolehasPermission::create(['role_id' => '3', 'permission_id' => '14']);
    }
}
