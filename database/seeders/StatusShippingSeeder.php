<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shipping_statuses')->insert([
            [
                'shipping_status_name' => 'Menunggu Konfirmasi',
            ],
            [
                'shipping_status_name' => 'Dikemas',
            ],
            [
                'shipping_status_name' => 'Dalam Perjalanan',
            ],
            [
                'shipping_status_name' => 'Selesai',
            ],
            [
                'shipping_status_name' => 'Dibatalkan',
            ]
        ]);
    }
}
