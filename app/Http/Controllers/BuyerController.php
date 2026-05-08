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
        $stats = [
            'active_orders' => Order::where('buyer_id', Auth::id())->where('status', 'pending')->count(),
            'wishlist_count' => \App\Models\Wishlist::where('user_id', Auth::id())->count(),
            'reward_points' => 1250,
            'total_spent' => Order::where('buyer_id', Auth::id())->where('status', '!=', 'cancelled')->sum('total_price'),
        ];

        $recommendedProducts = \App\Models\Product::where('status', 'active')->take(3)->get();
        $activities = \App\Models\Activity::latest()->take(5)->get();
        
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

    public function marketplace()
    {
        $products = \App\Models\Product::where('status', 'active')->latest()->get();
        return view('buyer.marketplace', compact('products'));
    }

    public function orders()
    {
        $orders = Order::with('product.seller')
            ->where('buyer_id', Auth::id())
            ->latest()
            ->get();
        return view('buyer.orders', compact('orders'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string|min:10',
        ]);

        $product = Product::findOrFail($request->product_id);

        $order = Order::create([
            'buyer_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' => $product->price * $request->quantity,
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
        ]);

        \App\Models\Activity::create([
            'user_id' => Auth::id(),
            'type' => 'purchase',
            'message' => "Buyer placed an order for '{$product->name}'.",
        ]);

        return redirect()->route('buyer.orders')->with('success', 'Order placed successfully!');
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
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        foreach ($cartItems as $item) {
            $product = $item->product;
            
            Order::create([
                'buyer_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $item->quantity,
                'total_price' => $product->price * $item->quantity,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
            ]);

            \App\Models\Activity::create([
                'user_id' => Auth::id(),
                'type' => 'purchase',
                'message' => "Buyer placed an order for '{$product->name}' via cart.",
            ]);

            $item->delete();
        }

        return redirect()->route('buyer.orders')->with('success', 'All orders placed successfully!');
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
}
