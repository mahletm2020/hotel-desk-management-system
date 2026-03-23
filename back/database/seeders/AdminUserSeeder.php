<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@hotel.com'],
            [
                'name' => 'Admin',
                'email_verified_at' => now(), 
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10), 
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}