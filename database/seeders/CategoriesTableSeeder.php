<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'School Supplies', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Electronics', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Accessories', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Clothing', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Miscellaneous', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Personal Items', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}