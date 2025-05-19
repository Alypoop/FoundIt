<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemTypesTableSeeder extends Seeder
{
    public function run()
    {
        // School Supplies
        $this->createItemTypes('School Supplies', [
            'Notebook', 'Pen', 'Ruler', 'Highlighter', 'Scissors'
        ]);

        // Electronics
        $this->createItemTypes('Electronics', [
            'Calculator', 'USB Flash Drive', 'Headphones',
            'Charger', 'Mobile Phone', 'Portable Electric Fan'
        ]);

        // Personal Accessories
        $this->createItemTypes('Personal Accessories', [
            'Eyewear', 'Watch', 'Jewelry', 'Hats'
        ]);

        // Personal Items
        $this->createItemTypes('Personal Items', [
            'Cologne', 'Alcohol Bottle', 'Tumbler', 'Wallet', 'Keys', 'Bags'
        ]);

        // Others
        $this->createItemTypes('Others', [
            'None'
        ]);
    }

    protected function createItemTypes($categoryName, array $types)
    {
        $categoryId = DB::table('categories')
                       ->where('name', $categoryName)
                       ->value('id');

        $itemTypes = array_map(function($type) use ($categoryId) {
            return [
                'name' => $type,
                'category_id' => $categoryId,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }, $types);

        DB::table('item_types')->insert($itemTypes);
    }
}
