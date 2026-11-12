<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(StatusUserSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StatusPaymentSeeder::class);
        $this->call(StatusShippingSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(PrintingTypeSeeder::class);
        $this->call(SizeSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
