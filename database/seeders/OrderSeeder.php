<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            [
                'date' => Carbon::createFromFormat('d/m/Y', '25/05/2025'),
                'total_price' => 7845000,
                'total_qty' => 5,
                'status' => 'shipping',
                'shipping_address' => 'Cornell Apartment',
                'shipping_status' => 'Delivered',
                'invoice_number' => '1',
                'payment_url' => null,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => Carbon::createFromFormat('d/m/Y', '26/05/2025'),
                'total_price' => 1899000,
                'total_qty' => 1,
                'status' => 'pick up',
                'shipping_address' => 'Pakuwon Mall',
                'shipping_status' => 'Delivered',
                'invoice_number' => '2',
                'payment_url' => null,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => Carbon::createFromFormat('d/m/Y', '27/05/2025'),
                'total_price' => 2598000,
                'total_qty' => 2,
                'status' => 'shipping',
                'shipping_address' => 'Denver Apartment',
                'shipping_status' => 'Delivered',
                'invoice_number' => '3',
                'payment_url' => null,
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => Carbon::createFromFormat('d/m/Y', '27/05/2025'),
                'total_price' => 1549000,
                'total_qty' => 1,
                'status' => 'pick up',
                'shipping_address' => 'Galaxy Mall',
                'shipping_status' => 'In Transit',
                'invoice_number' => '4',
                'payment_url' => null,
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => Carbon::createFromFormat('d/m/Y', '27/05/2025'),
                'total_price' => 2099000,
                'total_qty' => 1,
                'status' => 'pick up',
                'shipping_address' => 'Ciputra World',
                'shipping_status' => 'In Transit',
                'invoice_number' => '5',
                'payment_url' => null,
                'user_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => Carbon::createFromFormat('d/m/Y', '28/05/2025'),
                'total_price' => 1549000,
                'total_qty' => 1,
                'status' => 'pick up',
                'shipping_address' => 'Galaxy Mall',
                'shipping_status' => 'In Transit',
                'invoice_number' => '6',
                'payment_url' => null,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => Carbon::createFromFormat('d/m/Y', '28/05/2025'),
                'total_price' => 1599000,
                'total_qty' => 1,
                'status' => 'shipping',
                'shipping_address' => 'Westin Surabaya',
                'shipping_status' => 'In Transit',
                'invoice_number' => '7',
                'payment_url' => null,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => Carbon::createFromFormat('d/m/Y', '29/05/2025'),
                'total_price' => 1899000,
                'total_qty' => 1,
                'status' => 'shipping',
                'shipping_address' => 'Cornell Apartment',
                'shipping_status' => 'Pending',
                'invoice_number' => '8',
                'payment_url' => null,
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => Carbon::createFromFormat('d/m/Y', '30/05/2025'),
                'total_price' => 1549000,
                'total_qty' => 1,
                'status' => 'shipping',
                'shipping_address' => 'Denver Apartment',
                'shipping_status' => 'Pending',
                'invoice_number' => '9',
                'payment_url' => null,
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => Carbon::createFromFormat('d/m/Y', '30/05/2025'),
                'total_price' => 1549000,
                'total_qty' => 1,
                'status' => 'shipping',
                'shipping_address' => 'Amor Apartment',
                'shipping_status' => 'Pending',
                'invoice_number' => '10',
                'payment_url' => null,
                'user_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date' => Carbon::createFromFormat('d/m/Y', '01/06/2025'),
                'total_price' => 3199000,
                'total_qty' => 2,
                'status' => 'pick up',
                'shipping_address' => 'Pakuwon Mall',
                'shipping_status' => 'Pending',
                'invoice_number' => '11',
                'payment_url' => null,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}


