<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
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
            ],
            [
                'id' => 2,
                'profile' => 'profiles/1-680a343539a63.jpg',
                'usertype' => 'admin',
                'username' => 'SAN ISIDRO',
                'email' => 'mg.gragasin00297@student.tsu.edu.ph',
                'first_name' => 'Admin',
                'last_name' => 'One',
                'address' => null,
                'phone' => null,
                'email_verified_at' => '2025-04-24 04:51:40',
                'password' => '$2y$12$QV/4vxexnAY0cuL4QC1J2u61T0gZSyptsYVntLw9FNgL3ftf39nlu',
                'remember_token' => null,
                'created_at' => '2025-04-24 04:50:56',
                'updated_at' => '2025-04-28 05:53:42'
            ],
            [
                'id' => 3,
                'profile' => 'profiles/2-680a349727022.jpg',
                'usertype' => 'user',
                'username' => 'Caly',
                'email' => 'a.punzalan01008@student.tsu.edu.ph',
                'first_name' => 'Alyza',
                'last_name' => 'Punzalan',
                'address' => null,
                'phone' => null,
                'email_verified_at' => '2025-04-24 04:54:07',
                'password' => '$2y$12$Z2fEVqqwvbh7OtfQ3wT/d.ckKFARUWcFWqACzB7/eVZOI/E0jUYRW',
                'remember_token' => null,
                'created_at' => '2025-04-24 04:53:51',
                'updated_at' => '2025-04-25 03:28:02'
            ],
            [
                'id' => 4,
                'profile' => 'profiles/3-680a352a663dd.jpg',
                'usertype' => 'user',
                'username' => 'Sam',
                'email' => 'zs.non00367@student.tsu.edu.ph',
                'first_name' => 'Zaira Samantha',
                'last_name' => 'Non',
                'address' => null,
                'phone' => null,
                'email_verified_at' => '2025-04-24 04:56:14',
                'password' => '$2y$12$7hBAI8Q/tN6A.XxJaDGD1.8n9GJEHaSQq0TVYExi8VPVPsM3vrvDO',
                'remember_token' => null,
                'created_at' => '2025-04-24 04:55:24',
                'updated_at' => '2025-04-24 04:57:14'
            ],
            [
                'id' => 5,
                'profile' => 'profiles/5-680f8b5203187.jpg',
                'usertype' => 'admin',
                'username' => 'MAIN',
                'email' => 'ca.fernandez00268@student.tsu.edu.ph',
                'first_name' => 'Admin',
                'last_name' => 'Two',
                'address' => null,
                'phone' => null,
                'email_verified_at' => '2025-04-28 06:03:48',
                'password' => '$2y$12$S3Rs6DpyknLCdPvqVORnROi60VDLmfH0SP6enYBZkVLVSav74N1gu',
                'remember_token' => null,
                'created_at' => '2025-04-28 06:03:31',
                'updated_at' => '2025-04-28 06:06:12'
            ]
        ];

        $insertedCount = 0;

        foreach ($users as $user) {
            if (!DB::table('users')->where('username', $user['username'])->exists()) {
                DB::table('users')->insert($user);
                $insertedCount++;
                $this->command->info("User {$user['username']} seeded successfully.");
            } else {
                $this->command->info("User {$user['username']} already exists, skipping.");
            }
        }

        $this->command->info("Total users seeded: {$insertedCount}/".count($users));
    }
}
