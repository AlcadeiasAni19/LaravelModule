<?php

namespace Modules\Roles\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Roles\app\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::truncate();
        Role::create(['name' => 'SuperAdmin']);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Customer']);
    }
}
