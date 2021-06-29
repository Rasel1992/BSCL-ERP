<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            [
                'department' => 'IT',
                'department_id' => 'IT-1',
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ]);
    }
}
