<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MasterUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insertGetId([
            'name' => 'Master Admin',
            'email' => 'master@aiqfome.com',
            'password' => Hash::make('Master123!'),
            'is_master' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
