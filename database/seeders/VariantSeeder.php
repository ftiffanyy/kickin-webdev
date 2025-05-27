<?php

namespace Database\Seeders;

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
            45, 45.5, 46,
            // Add more sizes if needed, or customize as per your data
        ];

        $data = [];

        // Loop to create 230 variants across 10 products
        for ($id = 1; $id <= 230; $id++) {
            // Determine which product_id to assign
            $productId = ceil($id / 23);  // Every 23 iterations, the product_id increments

            // Cycle through the sizes
            $size = $sizes[($id - 1) % count($sizes)];

            // Assign stock based on some logic
            $stock = $id <= 10 ? 5 : 0; // Example: first 10 variants have stock, the rest don't

            // Add to the data array
            $data[] = [
                'product_id' => $productId,  // Increment product_id every 23 variants
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
