<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Inquiry;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();
        
        $stats = [
            'total_earnings' => Order::whereHas('product', function($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->where('payment_status', 'paid')->sum('total_price'),
            'active_listings' => Product::where('user_id', $userId)->where('status', 'active')->count(),
            'pending_orders' => Order::whereHas('product', function($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->where('status', 'pending')->count(),
            'unread_inquiries' => Inquiry::where('seller_id', $userId)->where('status', 'unread')->count(),
            'total_orders' => Order::whereHas('product', function($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->count(),
        ];

        $activities = \App\Models\Activity::where('user_id', $userId)
            ->orWhereNull('user_id')
            ->latest()
            ->take(8)
            ->get();
            
        return view('seller.dashboard', compact('stats', 'activities'));
    }

    public function products(Request $request)
    {
        $query = Product::where('user_id', Auth::id())->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->paginate(10)->withQueryString();
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadImage($request->file('image'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'category', 'status']);

        if ($request->hasFile('image')) {
            // New image upload
            $newImagePath = $this->uploadImage($request->file('image'));
            
            // Delete old local image if it exists
            if ($product->image && !str_starts_with($product->image, 'http')) {
                Storage::disk('public')->delete($product->image);
            }
            
            $data['image'] = $newImagePath;
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

        $updateData = ['status' => $request->status];

        // If marked as delivered and it was Cash on Delivery, mark as paid
        if ($request->status === 'delivered' && $order->payment_method === 'cod') {
            $updateData['payment_status'] = 'paid';
        }

        $order->update($updateData);

        \App\Models\Activity::create([
            'user_id' => Auth::id(),
            'type' => 'order_status',
            'message' => "Seller updated order #ORD-{$order->id} status to '{$request->status}'" . ($request->status === 'delivered' ? " and confirmed payment collection." : "."),
        ]);

        return back()->with('success', "Order #ORD-{$order->id} status updated to " . strtoupper($request->status));
    }

    public function earnings()
    {
        // Online payments: Count if payment_status is 'paid'
        // COD payments: Count only if status is 'delivered'
        $deliveredOrders = Order::whereHas('product', function($query) {
            $query->where('user_id', Auth::id());
        })
        ->where(function($query) {
            $query->where('payment_method', 'online')->where('payment_status', 'paid')
                  ->orWhere(function($q) {
                      $q->where('payment_method', 'cod')->where('status', 'delivered');
                  });
        })
        ->with('product', 'buyer')
        ->latest()
        ->get();

        $totalEarnings = $deliveredOrders->sum('total_price');
        $availableForPayout = $totalEarnings * 0.95; // 5% platform fee

        return view('seller.earnings', compact('deliveredOrders', 'totalEarnings', 'availableForPayout'));
    }

    public function settings()
    {
        return view('seller.settings');
    }

    public function inquiries(Request $request)
    {
        $query = Inquiry::where('seller_id', Auth::id())
            ->with(['buyer', 'product', 'messages'])
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('message', 'like', '%' . $search . '%')
                  ->orWhereHas('buyer', function($bq) use ($search) {
                      $bq->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $inquiries = $query->paginate(10)->withQueryString();
        return view('seller.inquiries.index', compact('inquiries'));
    }

    public function replyToInquiry(Request $request, Inquiry $inquiry)
    {
        if ($inquiry->seller_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'reply_message' => 'required|string|max:2000',
        ]);

        $inquiry->update([
            'reply_message' => $request->reply_message, // Keep for legacy/shortcut
            'status' => 'replied'
        ]);

        // Add to threaded conversation
        Message::create([
            'inquiry_id' => $inquiry->id,
            'sender_id' => Auth::id(),
            'body' => $request->reply_message,
        ]);

        return back()->with('success', 'Your professional reply has been sent to the buyer!');
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

    public function applyForScheme(Request $request, \App\Models\Scheme $scheme)
    {
        // Check if already applied
        $existing = \App\Models\SchemeApplication::where('scheme_id', $scheme->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already applied for this scheme.');
        }

        \App\Models\SchemeApplication::create([
            'scheme_id' => $scheme->id,
            'user_id' => Auth::id(),
            'application_notes' => $request->notes,
            'status' => 'pending',
        ]);

        \App\Models\Activity::create([
            'user_id' => Auth::id(),
            'type' => 'scheme_application',
            'message' => "Seller submitted an application for the scheme: '{$scheme->title}'.",
        ]);

        return back()->with('success', 'Your application has been submitted successfully! The Ministry will review it shortly.');
    }

    private function uploadImage($file)
    {
        $cloudinaryUrl = env('CLOUDINARY_URL');
        
        if ($cloudinaryUrl) {
            try {
                // Parse cloudinary://key:secret@cloudname
                $url = str_replace('cloudinary://', '', $cloudinaryUrl);
                $parts = explode('@', $url);
                $auth = explode(':', $parts[0]);
                $cloudName = $parts[1];
                $apiKey = $auth[0];
                $apiSecret = $auth[1];

                $timestamp = time();
                $signature = sha1("timestamp={$timestamp}{$apiSecret}");
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload");
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, [
                    'file' => new \CURLFile($file->getRealPath()),
                    'timestamp' => $timestamp,
                    'api_key' => $apiKey,
                    'signature' => $signature,
                    'folder' => 'products'
                ]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                $response = curl_exec($ch);
                curl_close($ch);
                
                $result = json_decode($response, true);
                
                if (isset($result['secure_url'])) {
                    return $result['secure_url'];
                }
            } catch (\Exception $e) {
                // Fallback to local if Cloudinary fails
            }
        }
        
        // Default Local Storage fallback
        return $file->store('products', 'public');
    }

    public function articles()
    {
        $articles = \App\Models\Article::where('status', 'published')->latest()->get();
        return view('seller.articles', compact('articles'));
    }
}
