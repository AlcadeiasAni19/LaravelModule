<?php

namespace Modules\Roles\database\seeders;

use Illuminate\Database\Seeder;

class RolesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RolehasPermissionSeeder::class);
    }
}
