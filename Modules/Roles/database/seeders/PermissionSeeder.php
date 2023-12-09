<?php

namespace Modules\Roles\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Roles\app\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::truncate();
        Permission::create(['name' => 'Manage-User-EditCredentials']);
        Permission::create(['name' => 'Manage-User-Add-ViewAll']);
        Permission::create(['name' => 'Manage-User']);
        Permission::create(['name' => 'Manage-Category-Edit-Delete']);
        Permission::create(['name' => 'Manage-Category-Add']);
        Permission::create(['name' => 'Manage-Category']);
        Permission::create(['name' => 'Manage-Product-EditCredentials-Delete']);
        Permission::create(['name' => 'Manage-Product-Add-Edit']);
        Permission::create(['name' => 'Manage-Product']);
        Permission::create(['name' => 'Manage-Review']);
        Permission::create(['name' => 'Manage-Wishlist']);
        Permission::create(['name' => 'Manage-Cart']);
        Permission::create(['name' => 'Manage-Order']);
        Permission::create(['name' => 'Manage-Transaction']);
    }
}
