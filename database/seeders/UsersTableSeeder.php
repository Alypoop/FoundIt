<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'profile' => '',
            'usertype' => 'admin',
            'username' => 'tsulucinda_admin',
            'email' => 'tsulucinda_admin@student.tsu.edu.ph',
            'first_name' => 'Tsu Lucinda',
            'last_name' => 'Admin',
            'address' => null,
            'phone' => null,
            'email_verified_at' => '2025-04-24 04:51:40',
            'password' => Hash::make('tsulucinda_admin'),
            'remember_token' => null,
            'created_at' => '2025-04-24 04:50:56',
            'updated_at' => '2025-04-28 05:53:42'
        ],
    [
            'profile' => '',
            'usertype' => 'admin',
            'username' => 'tsusanisidro_admin',
            'email' => 'tsusanisidro_admin@student.tsu.edu.ph',
            'first_name' => 'Tsu San Isidro',
            'last_name' => 'Admin',
            'address' => null,
            'phone' => null,
            'email_verified_at' => '2025-04-24 04:51:40',
            'password' => Hash::make('tsusanisidro_admin'),
            'remember_token' => null,
            'created_at' => '2025-04-24 04:50:56',
            'updated_at' => '2025-04-28 05:53:42'
        ],
    [
            'profile' => '',
            'usertype' => 'admin',
            'username' => 'tsumain_admin',
            'email' => 'tsumain_admin@student.tsu.edu.ph',
            'first_name' => 'Tsu Main',
            'last_name' => 'Admin',
            'address' => null,
            'phone' => null,
            'email_verified_at' => '2025-04-24 04:51:40',
            'password' => Hash::make('tsumain_admin'),
            'remember_token' => null,
            'created_at' => '2025-04-24 04:50:56',
            'updated_at' => '2025-04-28 05:53:42'
        ]);
    }
}