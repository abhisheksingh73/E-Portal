<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Scheme;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'user_id' => $request->user_id,
            'status' => 'active',
            'image' => $imagePath,
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

        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    public function destroyProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }

    public function orders()
    {
        $orders = \App\Models\Order::with(['product', 'buyer', 'product.seller'])->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder(\App\Models\Order $order)
    {
        $order->load(['product', 'buyer', 'product.seller']);
        return response()->json($order);
    }

    public function exportOrders()
    {
        $orders = \App\Models\Order::with(['product', 'buyer', 'product.seller'])->latest()->get();
        
        $filename = "market_orders_" . date('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // CSV Header
        fputcsv($handle, ['Order ID', 'Buyer', 'Seller', 'Product', 'Quantity', 'Total Price', 'Status', 'Date']);

        foreach ($orders as $order) {
            fputcsv($handle, [
                $order->id,
                $order->buyer->name,
                $order->product->seller->name ?? 'N/A',
                $order->product->name,
                $order->quantity,
                $order->total_price,
                $order->status,
                $order->created_at->format('Y-m-d H:i:s')
            ]);
        }

        fclose($handle);
        return exit;
    }

    public function analytics()
    {
        $marketStats = [
            'total_revenue' => \App\Models\Order::where('status', 'delivered')->sum('quantity'), // Simplified revenue
            'order_count' => \App\Models\Order::count(),
            'avg_order_value' => \App\Models\Order::count() > 0 ? \App\Models\Order::sum('quantity') / \App\Models\Order::count() : 0,
            'top_categories' => Product::groupBy('category')->select('category', \DB::raw('count(*) as total'))->get(),
        ];
        return view('admin.analytics', compact('marketStats'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    // Government Schemes Management
    public function schemes()
    {
        $schemes = Scheme::latest()->get();
        return view('admin.schemes.index', compact('schemes'));
    }

    public function storeScheme(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('schemes', 'public');
        }

        Scheme::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => 'active',
        ]);

        return back()->with('success', 'Scheme added successfully!');
    }

    // Marketing Articles Management
    public function articles()
    {
        $articles = Article::latest()->get();
        return view('admin.articles.index', compact('articles'));
    }

    public function storeArticle(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'image' => $imagePath,
            'status' => 'published',
        ]);

        return back()->with('success', 'Article published successfully!');
    }
}
