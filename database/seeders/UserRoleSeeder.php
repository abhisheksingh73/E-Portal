<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        User::updateOrCreate(
            ['email' => 'admin@eportal.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create Seller 1
        User::updateOrCreate(
            ['email' => 'seller@eportal.com'],
            [
                'name' => 'Heritage Weaves',
                'password' => Hash::make('password'),
                'role' => 'seller',
            ]
        );

        // Create Seller 2
        User::updateOrCreate(
            ['email' => 'seller2@eportal.com'],
            [
                'name' => 'Royal Silks',
                'password' => Hash::make('password'),
                'role' => 'seller',
            ]
        );

        // Create Buyer
        User::updateOrCreate(
            ['email' => 'buyer@eportal.com'],
            [
                'name' => 'Fashion Buyer',
                'password' => Hash::make('password'),
                'role' => 'buyer',
            ]
        );
    }
}
