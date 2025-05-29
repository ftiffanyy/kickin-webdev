<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data yang ingin dimasukkan ke dalam tabel cart_items
        $cartItems = [
            [
                'user_id' => 1,
                'variant_id' => 1,
                'qty' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'variant_id' => 2,
                'qty' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'variant_id' => 30,
                'qty' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'variant_id' => 31,
                'qty' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'variant_id' => 53,
                'qty' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'variant_id' => 54,
                'qty' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'variant_id' => 76,
                'qty' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'variant_id' => 99,
                'qty' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'variant_id' => 1,
                'qty' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'variant_id' => 3,
                'qty' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'variant_id' => 32,
                'qty' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data ke tabel cart_items
        DB::table('cart_items')->insert($cartItems);
    }
}
