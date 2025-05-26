<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
        [
            'rating' => 5,
            'date' => '2025-06-01',
            'user_id' => 1,
            'product_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'rating' => 5,
            'date' => '2025-06-01',
            'user_id' => 1,
            'product_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'rating' => 5,
            'date' => '2025-06-01',
            'user_id' => 1,
            'product_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'rating' => 5,
            'date' => '2025-06-02',
            'user_id' => 2,
            'product_id' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'rating' => 4,
            'date' => '2025-06-02',
            'user_id' => 3,
            'product_id' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'rating' => 5,
            'date' => '2025-06-02',
            'user_id' => 3,
            'product_id' => 9,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'rating' => 4,
            'date' => '2025-06-03',
            'user_id' => 4,
            'product_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'rating' => 5,
            'date' => '2025-06-03',
            'user_id' => 5,
            'product_id' => 8,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'rating' => 4,
            'date' => '2025-06-04',
            'user_id' => 1,
            'product_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'rating' => 4,
            'date' => '2025-06-05',
            'user_id' => 2,
            'product_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'rating' => 4,
            'date' => '2025-06-05',
            'user_id' => 3,
            'product_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'rating' => 5,
            'date' => '2025-06-06',
            'user_id' => 4,
            'product_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'rating' => 5,
            'date' => '2025-06-06',
            'user_id' => 5,
            'product_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'rating' => 5,
            'date' => '2025-06-07',
            'user_id' => 1,
            'product_id' => 9,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'rating' => 5,
            'date' => '2025-06-08',
            'user_id' => 1,
            'product_id' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    }
}
