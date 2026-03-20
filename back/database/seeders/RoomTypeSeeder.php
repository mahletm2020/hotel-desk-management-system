<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoomType::insert([
        [
            'name' => 'Single',
            'description' => 'Single room',
            'base_price' => 800,
            'capacity' => 1,
        ],
        [
            'name' => 'Double',
            'description' => 'Double room',
            'base_price' => 1200,
            'capacity' => 2,
        ],
        [
            'name' => 'Suite',
            'description' => 'Luxury suite',
            'base_price' => 3000,
            'capacity' => 4,
        ],
    ]);
    }
}
