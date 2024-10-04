<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = new User;
        $user1->surname = 'Asegid';
        $user1->name = 'Mulugeta';
        $user1->email = 'admin@abisiniya.com';
        $user1->password = Hash::make('password');
        $user1->role = 'admin';
        $user1->save();

        $user2 = new User;
        $user2->surname = 'Asegid';
        $user2->name = 'Mulugeta';
        $user2->email = 'customer@abisiniya.com';
        $user2->password = Hash::make('password');
        $user2->role = 'customer';
        $user2->save();
    }
}
