<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_sales' => '₹45,000',
            'active_listings' => Product::where('user_id', Auth::id())->count(),
            'pending_orders' => 5,
            'customer_rating' => '4.9/5',
        ];

        $activities = \App\Models\Activity::latest()->take(6)->get();
        
        return view('seller.dashboard', compact('stats', 'activities'));
    }

    public function products(Request $request)
    {
        $query = Product::where('user_id', Auth::id());

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->get();
        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        return view('seller.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'user_id' => Auth::id(),
            'status' => 'active',
        ]);

        \App\Models\Activity::create([
            'user_id' => Auth::id(),
            'type' => 'product_listing',
            'message' => "Seller listed a new textile: '{$product->name}'.",
        ]);

        return redirect()->route('seller.products')->with('success', 'Product listed successfully!');
    }

    public function edit(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }
        return view('seller.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'status' => 'required|in:active,out_of_stock,pending',
        ]);

        $product->update($request->all());

        return redirect()->route('seller.products')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }
        $product->delete();
        return redirect()->route('seller.products')->with('success', 'Product deleted successfully!');
    }

    public function orders()
    {
        return view('seller.orders.index');
    }

    public function earnings()
    {
        return view('seller.earnings');
    }

    public function settings()
    {
        return view('seller.settings');
    }
}
