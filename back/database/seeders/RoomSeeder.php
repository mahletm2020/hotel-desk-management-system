<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::insert([
        [
            'room_number' => '101',
            'room_type_id' => 1,
            'floor' => 1,
            'status' => 'available',
        ],
        [
            'room_number' => '102',
            'room_type_id' => 1,
            'floor' => 1,
            'status' => 'available',
        ],
        [
            'room_number' => '201',
            'room_type_id' => 2,
            'floor' => 2,
            'status' => 'available',
        ],
        [
            'room_number' => '202',
            'room_type_id' => 2,
            'floor' => 2,
            'status' => 'available',
        ],
        [
            'room_number' => '301',
            'room_type_id' => 3,
            'floor' => 3,
            'status' => 'available',
        ],
    ]);
    }
}
