<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'active_orders' => 2,
            'wishlist_count' => 5,
            'reward_points' => 1250,
        ];

        $recommendedProducts = \App\Models\Product::where('status', 'active')->take(3)->get();
        $activities = \App\Models\Activity::latest()->take(5)->get();
        
        return view('buyer.dashboard', compact('stats', 'recommendedProducts', 'activities'));
    }

    public function marketplace()
    {
        $products = \App\Models\Product::where('status', 'active')->latest()->get();
        return view('buyer.marketplace', compact('products'));
    }

    public function orders()
    {
        return view('buyer.orders');
    }

    public function wishlist()
    {
        return view('buyer.wishlist');
    }

    public function settings()
    {
        return view('buyer.settings');
    }
}
