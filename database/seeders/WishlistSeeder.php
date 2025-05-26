<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('wishlists')->insert([
        [
            'user_id' => 1,
            'product_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'user_id' => 2,
            'product_id' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'user_id' => 3,
            'product_id' => 8,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    }
}
