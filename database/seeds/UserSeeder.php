<?php

use App\User;
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
        $user = User::create([
            'name' => 'Rasel Uddin',
            'user_id' => 'User-01',
            'type' => 'admin',
            'email' => 'rasel@gmail.com',
            'mobile' => '01700002222',
            'dept_id' => 1,
            'designation' => 'IT Support',
            'password' => bcrypt('12345678'),
            'status' => 'Active',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user->assignRole('Super Admin');

        $user = User::create([
            'name' => 'Sohana Kabir',
            'user_id' => 'User-02',
            'type' => 'admin',
            'email' => 'sohana@gmail.com',
            'mobile' => '01700002220',
            'dept_id' => 1,
            'designation' => 'IT Support',
            'password' => bcrypt('12345678'),
            'status' => 'Active',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user->assignRole('Super Admin');

        $user = User::create([
            'name' => 'user1',
            'user_id' => 'User-03',
            'type' => 'admin',
            'email' => 'user1@gmail.com',
            'mobile' => '01700002221',
            'dept_id' => 1,
            'designation' => 'IT Support',
            'password' => bcrypt('12345678'),
            'status' => 'Active',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user->assignRole('Super Admin');

        $user = User::create([
            'name' => 'user3',
            'user_id' => 'User-04',
            'type' => 'admin',
            'email' => 'user3@gmail.com',
            'mobile' => '01700002224',
            'dept_id' => 1,
            'designation' => 'IT Support',
            'password' => bcrypt('12345678'),
            'status' => 'Active',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user->assignRole('Super Admin');

        $user = User::create([
            'name' => 'user4',
            'user_id' => 'User-05',
            'type' => 'admin',
            'email' => 'user4@gmail.com',
            'mobile' => '01700002226',
            'dept_id' => 1,
            'designation' => 'IT Support',
            'password' => bcrypt('12345678'),
            'status' => 'Active',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user->assignRole('Super Admin');
    }
}
