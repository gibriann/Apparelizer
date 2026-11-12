<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrintingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('printing_types')->insert([
            [
                'printing_name' => 'Sablon',
            ],
            [
                'printing_name' => 'DTF',
            ]
        ]);
    }
}
