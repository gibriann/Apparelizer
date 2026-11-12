<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sizes')->insert([
            [
                'size_name' => 'S',
            ],
            [
                'size_name' => 'M',
            ],
            [
                'size_name' => 'L',
            ],
            [
                'size_name' => 'XL',
            ],
            [
                'size_name' => 'XXL',
            ]
        ]);
    }
}
