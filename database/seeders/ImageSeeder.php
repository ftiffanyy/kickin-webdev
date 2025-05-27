<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all product IDs to associate images with products
        $productIds = Product::pluck('id')->toArray();

        foreach ($productIds as $productId) {
            // Get the product name to generate a clean URL-friendly slug
            $product = Product::find($productId);
            $productSlug = Str::slug($product->name, '-'); // Slugify the product name

            // Assume you have a folder named with the product ID (e.g., '1', '2', etc.)
            $folderNumber = $productId; // Assuming folder number is the product ID

            // You can check if the product folder exists and have a logic for images
            // In a real situation, you would ensure the images are in the correct folder

            // Assuming maximum 10 images, we insert up to 10 images for each product
            $maxImages = 10; 
            
            for ($i = 1; $i <= $maxImages; $i++) {
                // Check if image file exists for the current index (i.e., 1.webp, 2.webp, ...)
                $imagePath = 'products/' . $folderNumber . '/' . $i . '.webp';
                
                // Check if the image actually exists in the folder (optional check)
                if (file_exists(public_path('images/' . $imagePath))) {
                    $isMain = ($i === 1); // The first image will be the main image

                    DB::table('images')->insert([
                        'url' => $imagePath, // Dynamic image path
                        'main' => $isMain, // Set the first image as the main image
                        'product_id' => $productId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    // If no image file exists for this index, break the loop
                    break;
                }
            }
        }
    }
}
