<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrationsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('migrations')->insert([
            [
                'id' => 1,
                'migration' => '0001_01_01_000000_create_users_table',
                'batch' => 1
            ],
            [
                'id' => 2,
                'migration' => '0001_01_01_000001_create_cache_table',
                'batch' => 1
            ],
            [
                'id' => 3,
                'migration' => '0001_01_01_000002_create_jobs_table',
                'batch' => 1
            ],
            [
                'id' => 4,
                'migration' => '2024_09_21_050710_create_items_table',
                'batch' => 1
            ],
            [
                'id' => 5,
                'migration' => '2025_04_24_041724_create_item_histories_table',
                'batch' => 1
            ]
        ]);
    }
}
