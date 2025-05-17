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
            'Notebook', 'Pen', 'Pencil', 'Eraser', 'Ruler',
            'Highlighter', 'Binder', 'Scissors'
        ]);

        // Electronics
        $this->createItemTypes('Electronics', [
            'Calculator', 'USB Flash Drive', 'Headphones', 'Charger',
            'Mobile Phone', 'Tablet', 'Portable Electric Fan'
        ]);

        // Accessories
        $this->createItemTypes('Accessories', [
            'Eyewear', 'Watch', 'Wallet', 'Keys', 'ID Card', 'Hand Fan'
        ]);

        // Clothing
        $this->createItemTypes('Clothing', [
            'Jacket', 'Sweater', 'Hat', 'Mask'
        ]);

        // Miscellaneous
        $this->createItemTypes('Miscellaneous', [
            'Backpack', 'Water Bottle', 'Lunch Box', 
            'Lunch Bag', 'Sports Equipment', 'Umbrella'
        ]);

        // Personal Items
        $this->createItemTypes('Personal Items', [
            'Cologne', 'Alcohol Bottle', 'Mirror'
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