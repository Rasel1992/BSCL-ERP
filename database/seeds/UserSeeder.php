<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Rasel Uddin',
                'user_id' => 'User-01',
                'type' => 'admin',
                'email' => 'rasel@gmail.com',
                'dept_id' => 1,
                'designation' => 'IT Support',
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sohana Kabir',
                'user_id' => 'User-02',
                'type' => 'staff',
                'email' => 'sohana@gmail.com',
                'dept_id' => 1,
                'designation' => 'IT Support',
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
