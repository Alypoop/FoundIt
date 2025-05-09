<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'profile' => '',
                'usertype' => 'admin',
                'username' => 'admin',
                'email' => 'admin',
                'first_name' => 'admin',
                'last_name' => 'admin',
                'address' => null,
                'phone' => null,
                'email_verified_at' => '2025-04-24 04:51:40',
                'password' => Hash::make('admin'),
                'remember_token' => null,
                'created_at' => '2025-04-24 04:50:56',
                'updated_at' => '2025-04-28 05:53:42'
            ]
        ]);
    }
}
