<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('variants')->insert([
        [
            'id' => 1,
            'product_id' => 1,
            'size' => '35',
            'stock' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id' => 2,
            'product_id' => 1,
            'size' => '35.5',
            'stock' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id' => 3,
            'product_id' => 1,
            'size' => '36',
            'stock' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id' => 4,
            'product_id' => 1,
            'size' => '36.5',
            'stock' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id' => 5,
            'product_id' => 1,
            'size' => '37',
            'stock' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id' => 6,
            'product_id' => 1,
            'size' => '37.5',
            'stock' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id' => 7,
            'product_id' => 1,
            'size' => '38',
            'stock' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id' => 8,
            'product_id' => 1,
            'size' => '38.5',
            'stock' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id' => 9,
            'product_id' => 1,
            'size' => '39',
            'stock' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id' => 10,
            'product_id' => 1,
            'size' => '39.5',
            'stock' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // ...lanjutkan hingga id ke-230
        ]);
    }
}
