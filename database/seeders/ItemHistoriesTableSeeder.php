<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemHistoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('item_histories')->insert([
            [
                'id' => 1,
                'item_id' => 19,
                'changed_from' => 'Unclaimed',
                'changed_to' => 'To Be Claimed',
                'action' => 'claimed',
                'changed_by' => 'Zaira Samantha Non (Sam)',
                'created_at' => '2025-04-24 09:05:31',
                'updated_at' => '2025-04-24 09:05:31'
            ],
            [
                'id' => 8,
                'item_id' => 19,
                'changed_from' => 'To Be Claimed',
                'changed_to' => 'Unclaimed',
                'action' => 'status update',
                'changed_by' => 'Admin Two (MAIN)',
                'created_at' => '2025-04-28 06:07:14',
                'updated_at' => '2025-04-28 06:07:14'
            ]
        ]);
    }
}
