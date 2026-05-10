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

    public function users(Request $request)
    {
        $query = User::latest();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(10)->withQueryString();
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
        $query = Product::with('seller')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->paginate(10)->withQueryString();
        return view('admin.products.index', compact('products'));
    }

    public function orders(Request $request)
    {
        $query = Order::with(['product', 'buyer'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                  ->orWhereHas('buyer', function($bq) use ($search) {
                      $bq->where('name', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('product', function($pq) use ($search) {
                      $pq->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();
        return view('admin.orders.index', compact('orders'));
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
            'total_revenue' => \App\Models\Order::where('status', 'delivered')->sum('total_price'),
            'total_orders' => \App\Models\Order::count(),
            'pending_orders' => \App\Models\Order::where('status', 'pending')->count(),
            'avg_order_value' => \App\Models\Order::where('status', 'delivered')->count() > 0 
                ? \App\Models\Order::where('status', 'delivered')->sum('total_price') / \App\Models\Order::where('status', 'delivered')->count() 
                : 0,
            
            'users' => [
                'sellers' => User::where('role', 'seller')->count(),
                'buyers' => User::where('role', 'buyer')->count(),
                'pending_sellers' => User::where('role', 'seller')->where('is_approved', false)->count(),
            ],
            
            'products' => [
                'total' => Product::count(),
                'active' => Product::where('status', 'active')->count(),
            ],

            'schemes' => [
                'total_applications' => \App\Models\SchemeApplication::count(),
                'pending_applications' => \App\Models\SchemeApplication::where('status', 'pending')->count(),
                'approved_applications' => \App\Models\SchemeApplication::where('status', 'approved')->count(),
                'active_schemes' => \App\Models\Scheme::where('status', 'active')->count(),
            ],
            
            'top_categories' => Product::groupBy('category')
                ->select('category', \DB::raw('count(*) as total'))
                ->orderBy('total', 'desc')
                ->take(5)
                ->get(),
        ];

        return view('admin.analytics', compact('marketStats'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    // Government Schemes Management
    public function schemes(Request $request)
    {
        $query = Scheme::latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $schemes = $query->paginate(10)->withQueryString();
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

    public function updateScheme(Request $request, Scheme $scheme)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'status']);

        if ($request->hasFile('image')) {
            if ($scheme->image) {
                Storage::disk('public')->delete($scheme->image);
            }
            $data['image'] = $request->file('image')->store('schemes', 'public');
        }

        $scheme->update($data);

        return back()->with('success', 'Scheme updated successfully!');
    }

    public function destroyScheme(Scheme $scheme)
    {
        if ($scheme->image) {
            Storage::disk('public')->delete($scheme->image);
        }
        $scheme->delete();
        return back()->with('success', 'Scheme deleted successfully!');
    }

    public function schemeApplications()
    {
        $applications = \App\Models\SchemeApplication::with(['scheme', 'user'])->latest()->get();
        return view('admin.schemes.applications', compact('applications'));
    }

    public function updateApplicationStatus(Request $request, \App\Models\SchemeApplication $application)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $application->update(['status' => $request->status]);

        \App\Models\Activity::create([
            'user_id' => auth()->id(),
            'type' => 'scheme_update',
            'message' => "Administrator {$request->status} scheme application from '{$application->user->name}' for '{$application->scheme->title}'.",
        ]);

        return back()->with('success', "Application has been " . strtoupper($request->status));
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

    public function updateArticle(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|in:published,draft,archived',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'content', 'category', 'status']);

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($data);

        return back()->with('success', 'Article updated successfully!');
    }

    public function destroyArticle(Article $article)
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();
        return back()->with('success', 'Article deleted successfully!');
    }
}
