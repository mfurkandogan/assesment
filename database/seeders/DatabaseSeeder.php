<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
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
        $this->call([
            OrderSeeder::class,
            ProductSeeder::class,
            CustomerSeeder::class,
            DiscountSeeder::class
        ]);
    }
    
}
