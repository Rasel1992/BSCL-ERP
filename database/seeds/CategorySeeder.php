<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'parent_id' => '0',
                'category_name' => 'Fixed Asset',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'parent_id' => '1',
                'category_name' => 'Electronics',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'parent_id' => '1',
                'category_name' => 'Furnitures',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'parent_id' => '0',
                'category_name' => 'Current Asset',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'parent_id' => '4',
                'category_name' => 'Papers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'parent_id' => '4',
                'category_name' => 'Pen',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('categories')->insert($categories);
    }
}
