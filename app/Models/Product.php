<?php
namespace App\Models;

class Product
{
    protected static $products = [
        [
                'product_id' => 1,
                'product_name' => "AIR FORCE 1 '07 MEN'S BASKETBALL SHOES - WHITE",
                'price' => 1549000,
                'discount' => 30,
                'brand' => 'NIKE',
                'gender' => 'Men',
                'description' => "Step into a legend with the Nike Air Force 1 '07. Featuring crisp white leather and classic hoops-inspired style, this icon brings timeless street appeal and durable comfort. Padded collars and Nike Air cushioning provide all-day support on and off the court.",
                'rating_avg' => 4.4,
                'total_reviews' => 102,
                'sold' => 1323,
                'image' => 'images/products/1/NIKE air force 1 _07 men_s basketball shoes - white,1.webp', // Get first image for product 1
            ],
            [
                'product_id' => 2,
                'product_name' => "AIR FORCE 1 '07 MEN'S BASKETBALL SHOES - BLACK",
                'price' => 1549000,
                'discount' => 10,
                'brand' => 'NIKE',
                'gender' => 'Men',
                'description' => "Bold and iconic, the Nike Air Force 1 '07 in black delivers classic basketball style with a modern street edge. Premium materials and perforated toe details ensure comfort and breathability, while the Nike Air unit softens every step.",
                'rating_avg' => 4.8,
                'total_reviews' => 94,
                'sold' => 1240,
                'image' => 'images/products/2/NIKE air force 1 _07 men_s basketball shoes - black,1.webp', // Get first image for product 2
            ],
            [
                'product_id' => 3,
                'product_name' => "SPEEDCAT OG UNISEX LIFESTYLE SHOES - BLACK",
                'price' => 1899000,
                'discount' => 0,
                'brand' => 'PUMA',
                'gender' => 'Unisex',
                'description' => "Originally made for Formula 1 drivers, the Speedcat OG returns as a lifestyle icon. Sleek black suede and a low-profile silhouette offer motorsport heritage and street-ready style for everyday wear.",
                'rating_avg' => 4.6,
                'total_reviews' => 76,
                'sold' => 796,
                'image' => 'images/products/3/PUMA speedcat og unisex lifestyle shoes - black,1.webp',
            ],
            [
                'product_id' => 4,
                'product_name' => "SPEEDCAT OG UNISEX LIFESTYLE SHOES - RED",
                'price' => 1899000,
                'discount' => 0,
                'brand' => 'PUMA',
                'gender' => 'Unisex',
                'description' => "Drive your street style with the Speedcat OG in vibrant red. Inspired by the fast lane, this sleek silhouette brings racing DNA into your daily rotation with rich suede and a heritage motorsport vibe.",
                'rating_avg' => 4.5,
                'total_reviews' => 98,
                'sold' => 925,
                'image' => 'images/products/4/PUMA speedcat og unisex lifestyle shoes - red,1.webp',
            ],
            [
                'product_id' => 5,
                'product_name' => "PALERMO MODA VINTAGE WOMEN'S LIFESTYLE SHOES - BLUE",
                'price' => 1599000,
                'discount' => 10,
                'brand' => 'PUMA',
                'gender' => 'Women',
                'description' => "Channel vintage Italian flair with the Palermo Moda. This women's sneaker pairs a vibrant blue suede upper with retro charm and everyday comfort, making it a perfect choice for relaxed and stylish days.",
                'rating_avg' => 4.3,
                'total_reviews' => 45,
                'sold' => 570,
                'image' => 'images/products/5/PUMA palermo moda vintage women_s lifestyle shoes - blue,1.webp',
            ],
            [
                'product_id' => 6,
                'product_name' => "530 UNISEX SNEAKERS SHOES - SILVER",
                'price' => 1599000,
                'discount' => 30,
                'brand' => 'NEW BALANCE',
                'gender' => 'Unisex',
                'description' => "The New Balance 530 blends retro running style with modern comfort. A standout silver finish and ABZORB cushioning create a bold and cushy ride for all-day exploration in timeless fashion.",
                'rating_avg' => 4.2,
                'total_reviews' => 154,
                'sold' => 1620,
                'image' => 'images/products/6/NEW BALANCE 530 unisex sneakers shoes - silver,1.webp',
            ],
            [
                'product_id' => 7,
                'product_name' => "MR530 MEN'S RUNNING SHOES - WHITE WITH NATURAL INDIGO",
                'price' => 1599000,
                'discount' => 0,
                'brand' => 'NEW BALANCE',
                'gender' => 'Men',
                'description' => "Run the streets with the MR530 in fresh white and natural indigo. Designed for both performance and daily wear, it combines breathable mesh, durable overlays, and advanced cushioning to keep you moving in comfort and style.",
                'rating_avg' => 4.7,
                'total_reviews' => 123,
                'sold' => 1096,
                'image' => 'images/products/7/NEW BALANCE mr530 men_s running shoes - white with natural indigo,1.webp',
            ],
            [
                'product_id' => 8,
                'product_name' => "550 MEN'S SNEAKERS - BLACK",
                'price' => 2099000,
                'discount' => 50,
                'brand' => 'NEW BALANCE',
                'gender' => 'Men',
                'description' => "A true throwback from the archives, the New Balance 550 in sleek black revives basketball-inspired heritage with a streetwear twist. Leather overlays and a classic build deliver bold style with everyday durability.",
                'rating_avg' => 3.7,
                'total_reviews' => 68,
                'sold' => 612,
                'image' => 'shoestore/public/images/products/8/NEW BALANCE 550 men_s sneakers- black,1.webp',
            ],
            [
                'product_id' => 9,
                'product_name' => "OLD SKOOL UNISEX SNEAKERS SHOES - BLACK",
                'price' => 999000,
                'discount' => 0,
                'brand' => 'VANS',
                'gender' => 'Unisex',
                'description' => "The Vans Old Skool is a timeless icon. This black unisex version features signature side stripes, sturdy canvas and suede uppers, and the original waffle sole. Perfect for skaters and casual creatives alike.",
                'rating_avg' => 4.9,
                'total_reviews' => 13,
                'sold' => 112,
                'image' => 'shoestore/public/images/products/9/VANS old skool unisex sneakers shoes - black,1.webp',
            ],
            [
                'product_id' => 10,
                'product_name' => "SAMBAE WOMEN'S SNEAKERS - FTWR WHITE",
                'price' => 2200000,
                'discount' => 50,
                'brand' => 'ADIDAS',
                'gender' => 'Women',
                'description' => "Rediscover movement with the Sambae Women’s Sneakers in Footwear White. This fresh take on a classic archive style features a supportive fit, durable synthetic upper, and lightweight EVA midsole ideal for urban exploration and everyday comfort.",
                'rating_avg' => 4.8,
                'total_reviews' => 113,
                'sold' => 1118,
                'image' => 'shoestore/public/images/products/10/ADIDAS sambae women_s sneakers - ftwr white,1.webp',
            ],
    ];

    public static function all()
    {
        return collect(self::$products);
    }

    public static function find($id)
    {
        return collect(self::$products)->firstWhere('product_id', $id);
    }
}

