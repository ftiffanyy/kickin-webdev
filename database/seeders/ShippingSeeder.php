<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShippingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('shippings')->insert([
        [
            'status' => 'Dispatched',
            'date' => '2025-06-01',
            'comment' => 'diambil kurir',
            'order_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'status' => 'In Transit',
            'date' => '2025-06-03',
            'comment' => 'di DC cakung',
            'order_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'status' => 'Delivered',
            'date' => '2025-06-05',
            'comment' => 'pesanan diterima',
            'order_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'status' => 'Already Pick Up',
            'date' => '2025-06-05',
            'comment' => 'Sepatu sudah diambil',
            'order_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'status' => 'Dispatched',
            'date' => '2025-06-06',
            'comment' => 'diambil kurir',
            'order_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'status' => 'In Transit',
            'date' => '2025-06-07',
            'comment' => 'di Made',
            'order_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'status' => 'Delivered',
            'date' => '2025-06-08',
            'comment' => 'di lobby satpam',
            'order_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'status' => 'Already Pick Up',
            'date' => '2025-06-08',
            'comment' => 'sudah diambil',
            'order_id' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'status' => 'Dispatched',
            'date' => '2025-06-08',
            'comment' => 'sudah diambil kurir',
            'order_id' => 7,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'status' => 'In Transit',
            'date' => '2025-06-10',
            'comment' => 'di DC cakung',
            'order_id' => 7,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    }
}
