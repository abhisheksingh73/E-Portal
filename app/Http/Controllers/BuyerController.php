<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Scheme;
use App\Models\Article;
use App\Models\Inquiry;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $stats = [
            'active_orders' => Order::where('buyer_id', $user->id)
                ->whereIn('status', ['pending', 'shipped'])
                ->count(),
            'wishlist_count' => \App\Models\Wishlist::where('user_id', $user->id)->count(),
            'cart_count' => \App\Models\Cart::where('user_id', $user->id)->count(),
            'total_spent' => Order::where('buyer_id', $user->id)
                ->where('payment_status', 'paid')
                ->sum('total_price'),
            'total_orders' => Order::where('buyer_id', $user->id)->count(),
        ];

        // Fetch up to 4 active products for the grid
        $recommendedProducts = \App\Models\Product::where('status', 'active')
            ->with('seller')
            ->latest()
            ->take(4)
            ->get();

        // Personal activities + general marketplace activities
        $activities = \App\Models\Activity::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhereNull('user_id');
            })
            ->latest()
            ->take(5)
            ->get();
            
        return view('buyer.dashboard', compact('stats', 'recommendedProducts', 'activities'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'address' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $user->update($request->only('name', 'email', 'address'));

        return back()->with('success', 'Profile updated successfully!');
    }

    public function marketplace(Request $request)
    {
        $query = Product::where('status', 'active')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->paginate(12)->withQueryString();
        return view('buyer.marketplace', compact('products'));
    }

    public function orders(Request $request)
    {
        $query = Order::with('product.seller')
            ->where('buyer_id', Auth::id())
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();
        return view('buyer.orders', compact('orders'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string|min:10',
            'payment_method' => 'required|in:cod,online',
        ]);

        $product = Product::findOrFail($request->product_id);
        $totalAmount = $product->price * $request->quantity;

        // If online payment, redirect to payment page
        if ($request->payment_method === 'online') {
            // We pass as array to match checkout expectation if needed
            return view('buyer.payment', [
                'total_amount' => $totalAmount,
                'shipping_address' => $request->shipping_address,
                'items' => [ (object)[ 'product' => $product, 'quantity' => $request->quantity ] ]
            ]);
        }

        // Handle COD
        Order::create([
            'buyer_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' => $totalAmount,
            'status' => 'pending',
            'payment_method' => 'cod',
            'payment_status' => 'pending',
            'shipping_address' => $request->shipping_address,
        ]);

        \App\Models\Activity::create([
            'user_id' => Auth::id(),
            'type' => 'purchase',
            'message' => "Buyer placed a COD order for '{$product->name}'.",
        ]);

        // Clear from cart if it was there
        Cart::where('user_id', Auth::id())->where('product_id', $product->id)->delete();

        return redirect()->route('buyer.orders')->with('success', 'Order placed successfully via Cash on Delivery!');
    }

    public function wishlist()
    {
        $wishlistItems = \App\Models\Wishlist::with('product.seller')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        return view('buyer.wishlist', compact('wishlistItems'));
    }

    public function toggleWishlist(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $exists = \App\Models\Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($exists) {
            $exists->delete();
            return back()->with('success', 'Removed from wishlist.');
        }

        \App\Models\Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
        ]);

        return back()->with('success', 'Added to wishlist.');
    }

    public function removeFromWishlist(\App\Models\Wishlist $wishlist)
    {
        if ($wishlist->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $wishlist->delete();
        return back()->with('success', 'Item removed from wishlist.');
    }

    public function settings()
    {
        return view('buyer.settings');
    }

    public function cart()
    {
        $cartItems = Cart::with('product.seller')
            ->where('user_id', Auth::id())
            ->get();
        return view('buyer.cart', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('buyer.cart')->with('success', 'Item added to cart successfully!');
    }

    public function updateCart(Request $request, Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) abort(403);

        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated.');
    }

    public function removeFromCart(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) abort(403);
        $cart->delete();
        return back()->with('success', 'Item removed from cart.');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|min:10',
            'payment_method' => 'required|in:cod,online',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item->product->price * $item->quantity;
        }

        // If online payment, redirect to payment page
        if ($request->payment_method === 'online') {
            return view('buyer.payment', [
                'total_amount' => $totalAmount,
                'shipping_address' => $request->shipping_address,
                'items' => $cartItems
            ]);
        }

        // Handle COD
        foreach ($cartItems as $item) {
            $product = $item->product;
            
            Order::create([
                'buyer_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $item->quantity,
                'total_price' => $product->price * $item->quantity,
                'status' => 'pending',
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'shipping_address' => $request->shipping_address,
            ]);

            \App\Models\Activity::create([
                'user_id' => Auth::id(),
                'type' => 'purchase',
                'message' => "Buyer placed a COD order for '{$product->name}'.",
            ]);

            $item->delete();
        }

        // Final safety check to empty cart for COD bulk checkout
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('buyer.orders')->with('success', 'Orders placed successfully via Cash on Delivery!');
    }

    public function processOnlinePayment(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'card_number' => 'required|string|min:16',
            'items' => 'required|array',
        ]);

        foreach ($request->items as $itemJson) {
            $itemData = json_decode($itemJson);
            $product = Product::findOrFail($itemData->id);
            
            Order::create([
                'buyer_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $itemData->qty,
                'total_price' => $product->price * $itemData->qty,
                'status' => 'pending',
                'payment_method' => 'online',
                'payment_status' => 'paid',
                'shipping_address' => $request->shipping_address,
            ]);

            \App\Models\Activity::create([
                'user_id' => Auth::id(),
                'type' => 'purchase',
                'message' => "Buyer placed an online paid order for '{$product->name}'.",
            ]);

            // Clear from cart if it exists
            Cart::where('user_id', Auth::id())->where('product_id', $product->id)->delete();
        }

        // Final safety check to empty cart for Online bulk checkout
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('buyer.orders')->with('success', 'Payment successful! Your orders have been placed.');
    }

    public function schemes()
    {
        $schemes = Scheme::where('status', 'active')->latest()->get();
        return view('buyer.schemes', compact('schemes'));
    }

    public function articles()
    {
        $articles = Article::where('status', 'published')->latest()->get();
        return view('buyer.articles', compact('articles'));
    }

    public function confirmDelivery(Order $order)
    {
        if ($order->buyer_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'shipped') {
            return back()->with('error', 'Only shipped orders can be marked as delivered.');
        }

        $order->update(['status' => 'delivered']);

        \App\Models\Activity::create([
            'user_id' => Auth::id(),
            'type' => 'delivery_confirmation',
            'message' => "Buyer confirmed delivery for order #ORD-{$order->id}.",
        ]);

        return back()->with('success', 'Order marked as delivered. Thank you for shopping!');
    }

    public function contactSeller(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:products,id',
            'message' => 'required|string',
        ]);

        Inquiry::create([
            'buyer_id' => Auth::id(),
            'seller_id' => $request->seller_id,
            'product_id' => $request->product_id,
            'message' => $request->message,
            'status' => 'unread',
        ]);

        return back()->with('success', 'Your inquiry has been sent to the seller.');
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
            'message' => "User submitted an application for the scheme: '{$scheme->title}'.",
        ]);

        return back()->with('success', 'Your application has been submitted successfully! The Ministry will review it shortly.');
    }
}
