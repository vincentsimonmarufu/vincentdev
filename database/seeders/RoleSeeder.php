<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define an array of role names
        $roles = ['customer', 'merchant', 'admin', 'super_admin'];

        // Loop through each role and create it
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
