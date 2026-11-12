<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert([
            [
                'color_name' => 'Hitam',
            ],
            [
                'color_name' => 'Putih',
            ],
            [
                'color_name' => 'Merah',
            ],
            [
                'color_name' => 'Biru',
            ]
        ]);
    }
}
