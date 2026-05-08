<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'user_id' => Auth::id(),
            'status' => 'active',
            'image' => $imagePath,
            'is_featured' => $request->has('is_featured'),
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'category', 'status']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['is_featured'] = $request->has('is_featured');
        $product->update($data);

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
        $orders = Order::whereHas('product', function($query) {
            $query->where('user_id', Auth::id());
        })->with(['product', 'buyer'])->latest()->get();
        
        return view('seller.orders.index', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        // Security check: Order must belong to seller's product
        if ($order->product->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        \App\Models\Activity::create([
            'user_id' => Auth::id(),
            'type' => 'order_status',
            'message' => "Seller updated order #ORD-{$order->id} status to '{$request->status}'.",
        ]);

        return back()->with('success', "Order #ORD-{$order->id} status updated to " . strtoupper($request->status));
    }

    public function earnings()
    {
        return view('seller.earnings');
    }

    public function settings()
    {
        return view('seller.settings');
    }

    public function inquiries()
    {
        $inquiries = Inquiry::where('seller_id', Auth::id())
            ->with(['buyer', 'product'])
            ->latest()
            ->get();
        return view('seller.inquiries.index', compact('inquiries'));
    }

    public function updateInquiryStatus(Request $request, Inquiry $inquiry)
    {
        if ($inquiry->seller_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:unread,read,replied',
        ]);

        $inquiry->update(['status' => $request->status]);

        return back()->with('success', 'Inquiry status updated.');
    }

    public function schemes()
    {
        $schemes = \App\Models\Scheme::where('status', 'active')->latest()->get();
        return view('seller.schemes', compact('schemes'));
    }

    public function articles()
    {
        $articles = \App\Models\Article::where('status', 'published')->latest()->get();
        return view('seller.articles', compact('articles'));
    }
}
