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
        $sizes = [
            35, 35.5, 36, 36.5, 37, 37.5, 38, 38.5, 39, 39.5, 
            40, 40.5, 41, 41.5, 42, 42.5, 43, 43.5, 44, 44.5,
            45, 45.5, 46, 46.5, 47, 47.5, 48, 48.5, 49, 49.5, 
            // Add more sizes if needed, or customize as per your data
        ];

        $data = [];

        // Loop to create variants up to id 230
        for ($id = 1; $id <= 230; $id++) {
            $size = $sizes[($id - 1) % count($sizes)]; // Loop through sizes cyclically
            $stock = $id <= 10 ? 5 : 0; // Example: first 10 sizes have stock, the rest don't

            $data[] = [
                'id' => $id,
                'product_id' => 1, // Adjust product_id as needed
                'size' => $size,
                'stock' => $stock,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert the data in batches
        DB::table('variants')->insert($data);
    }
}
