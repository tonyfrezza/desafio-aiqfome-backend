<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            MasterUserSeeder::class,
            RolesAndPermissionsSeeder::class,
            MasterUsersRolesSeeder::class,
        ]);
    }
}
