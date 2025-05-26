<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class OrderDetailsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('order_details')->insert([
            [
                'price_at_purchase' => 1549000,
                'qty' => 1,
                'variant_id' => 23,
                'order_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price_at_purchase' => 1549000,
                'qty' => 2,
                'variant_id' => 44,
                'order_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price_at_purchase' => 1599000,
                'qty' => 2,
                'variant_id' => 100,
                'order_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price_at_purchase' => 1899000,
                'qty' => 1,
                'variant_id' => 80,
                'order_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price_at_purchase' => 1599000,
                'qty' => 1,
                'variant_id' => 120,
                'order_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price_at_purchase' => 999000,
                'qty' => 1,
                'variant_id' => 200,
                'order_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price_at_purchase' => 1549000,
                'qty' => 1,
                'variant_id' => 22,
                'order_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price_at_purchase' => 2099000,
                'qty' => 1,
                'variant_id' => 180,
                'order_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price_at_purchase' => 1549000,
                'qty' => 1,
                'variant_id' => 44,
                'order_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price_at_purchase' => 1599000,
                'qty' => 1,
                'variant_id' => 100,
                'order_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price_at_purchase' => 1899000,
                'qty' => 1,
                'variant_id' => 48,
                'order_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price_at_purchase' => 1549000,
                'qty' => 1,
                'variant_id' => 42,
                'order_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price_at_purchase' => 1549000,
                'qty' => 1,
                'variant_id' => 20,
                'order_id' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price_at_purchase' => 999000,
                'qty' => 1,
                'variant_id' => 200,
                'order_id' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'price_at_purchase' => 2200000,
                'qty' => 1,
                'variant_id' => 230,
                'order_id' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

