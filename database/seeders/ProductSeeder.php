<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seller = User::where('role', 'seller')->first();

        if (!$seller) {
            return;
        }

        $products = [
            [
                'name' => 'Premium Banarasi Silk',
                'description' => 'Authentic hand-woven silk from Varanasi with intricate gold zari work.',
                'price' => 12500.00,
                'category' => 'Silk',
                'status' => 'active',
                'user_id' => $seller->id,
            ],
            [
                'name' => 'Kashmiri Pashmina Shawl',
                'description' => 'Fine wool shawl handcrafted in the valley of Kashmir, known for its warmth and soft texture.',
                'price' => 25000.00,
                'category' => 'Woolen',
                'status' => 'active',
                'user_id' => $seller->id,
            ],
            [
                'name' => 'Chanderi Cotton Fabric',
                'description' => 'Lightweight and sheer cotton fabric from Chanderi, Madhya Pradesh, perfect for summer wear.',
                'price' => 850.00,
                'category' => 'Cotton',
                'status' => 'active',
                'user_id' => $seller->id,
            ],
            [
                'name' => 'Kanchipuram Silk Saree',
                'description' => 'Traditional wedding saree from Tamil Nadu, featuring rich borders and vibrant colors.',
                'price' => 18000.00,
                'category' => 'Silk',
                'status' => 'active',
                'user_id' => $seller->id,
            ],
            [
                'name' => 'Bandhani Hand-dyed Dupatta',
                'description' => 'Vibrant tie-and-dye dupatta from Gujarat, made using traditional techniques.',
                'price' => 1200.00,
                'category' => 'Hand-dyed',
                'status' => 'active',
                'user_id' => $seller->id,
            ],
            [
                'name' => 'Sambalpuri Ikat Cotton',
                'description' => 'Hand-woven ikat fabric from Odisha with traditional geometric patterns.',
                'price' => 950.00,
                'category' => 'Ikat',
                'status' => 'active',
                'user_id' => $seller->id,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
