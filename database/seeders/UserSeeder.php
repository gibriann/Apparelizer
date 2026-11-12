<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'name' => 'Admin',
                'role_id' => '1',
                'user_status_id' => '1',
                'email' => 'superadmin@gmail.com',
                'password' => bcrypt('123456'),
                'avatar' => 'default.png',
            ],
            [
                'name' => 'Owner',
                'role_id' => '2',
                'user_status_id' => '1',
                'email' => 'owner@gmail.com',
                'password' => bcrypt('654321'),
                'avatar' => 'default.png',
            ]
        ]);
    }
}
