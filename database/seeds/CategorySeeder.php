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
                'type' =>'fixed',
                'category_name' => 'Furnitures',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'parent_id' => '1',
                'type' =>'fixed',
                'category_name' => 'Chair',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'parent_id' => '1',
                'type' =>'fixed',
                'category_name' => 'Table',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'parent_id' => '0',
                'type' =>'current',
                'category_name' => 'Papers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'parent_id' => '4',
                'type' =>'current',
                'category_name' => 'Normal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'parent_id' => '4',
                'type' =>'current',
                'category_name' => 'Opset',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('categories')->insert($categories);
    }
}
