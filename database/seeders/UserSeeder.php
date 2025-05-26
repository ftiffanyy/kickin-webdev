<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
        [
                'name' => 'Jevon',
                'email' => 'jevon@gmail.com',
                'password' => Hash::make('jevon123'),
                'phone' => '6281233336560',
                'role' => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Felicia',
                'email' => 'feli@gmail.com',
                'password' => Hash::make('feli123'),
                'phone' => '6282266100102',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Valen',
                'email' => 'valen@gmail.com',
                'password' => Hash::make('valen123'),
                'phone' => '6281919688000',
                'role' => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kevin',
                'email' => 'kevin@gmail.com',
                'password' => Hash::make('kevin123'),
                'phone' => '6285103177002',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Keenan',
                'email' => 'keenanchan1306@gmail.com',
                'password' => Hash::make('keenan123'),
                'phone' => '6281231293688',
                'role' => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
