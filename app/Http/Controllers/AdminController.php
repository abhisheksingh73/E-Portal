<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'active_sellers' => User::where('role', 'seller')->where('is_approved', true)->count(),
            'active_buyers' => User::where('role', 'buyer')->count(),
            'total_products' => Product::count(),
            'pending_approvals' => User::where('is_approved', false)->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $pendingSellers = User::where('role', 'seller')->where('is_approved', false)->get();
        $activities = \App\Models\Activity::latest()->take(8)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'pendingSellers', 'activities'));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function approveUser(User $user)
    {
        $user->update(['is_approved' => true]);

        \App\Models\Activity::create([
            'user_id' => auth()->id(),
            'type' => 'approval',
            'message' => "Administrator approved seller account: '{$user->name}'.",
        ]);

        return back()->with('success', "User {$user->name} has been approved.");
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', "You cannot delete yourself.");
        }
        $user->delete();
        return back()->with('success', "User has been deleted successfully.");
    }

    public function products(Request $request)
    {
        $query = Product::with('seller');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $sellers = User::where('role', 'seller')->get();
        return view('admin.products.create', compact('sellers'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'user_id' => $request->user_id,
            'status' => 'active',
        ]);

        return redirect()->route('admin.products')->with('success', 'Product created successfully!');
    }

    public function editProduct(Product $product)
    {
        $sellers = User::where('role', 'seller')->get();
        return view('admin.products.edit', compact('product', 'sellers'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'status' => 'required|in:active,out_of_stock,pending',
        ]);

        $product->update($request->all());

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    public function destroyProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }

    public function orders()
    {
        return view('admin.orders.index');
    }

    public function analytics()
    {
        return view('admin.analytics');
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
