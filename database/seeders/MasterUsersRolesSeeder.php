<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class MasterUsersRolesSeeder extends Seeder
{
    public function run(): void
    {
        $mastersUsers = User::where('is_master', true)->get();
        foreach ($mastersUsers as $masterUser) {
            $masterUser->assignRole('super-admin');
        }
    }
}
