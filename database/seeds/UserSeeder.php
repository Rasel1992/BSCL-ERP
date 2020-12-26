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
                'type' => 'admin',
                'email' => 'rasel@gmail.com',
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sohana Kabir',
                'type' => 'staff',
                'email' => 'sohana@gmail.com',
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
