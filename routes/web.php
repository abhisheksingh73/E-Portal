<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredProducts = \App\Models\Product::where('is_featured', true)->where('status', 'active')->take(6)->get();
    $latestArticles = \App\Models\Article::where('status', 'published')->latest()->take(3)->get();
    return view('welcome', compact('featuredProducts', 'latestArticles'));
});

Route::middleware('auth')->group(function () {

    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::patch('/users/{user}/approve', [AdminController::class, 'approveUser'])->name('admin.users.approve');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
        
        // Products CRUD for Admin
        Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
        Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
        Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
        Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
        Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
        Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');

        Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
        Route::get('/orders/export', [AdminController::class, 'exportOrders'])->name('admin.orders.export');
        Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
        Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
        
        // Schemes & Articles
        Route::get('/schemes', [AdminController::class, 'schemes'])->name('admin.schemes');
        Route::post('/schemes', [AdminController::class, 'storeScheme'])->name('admin.schemes.store');
        Route::get('/articles', [AdminController::class, 'articles'])->name('admin.articles');
        Route::post('/articles', [AdminController::class, 'storeArticle'])->name('admin.articles.store');

        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    });

    Route::prefix('buyer')->middleware('role:buyer')->group(function () {
        Route::get('/dashboard', [BuyerController::class, 'dashboard'])->name('buyer.dashboard');
        Route::get('/marketplace', [BuyerController::class, 'marketplace'])->name('buyer.marketplace');
        Route::get('/orders', [BuyerController::class, 'orders'])->name('buyer.orders');
        Route::post('/orders', [BuyerController::class, 'placeOrder'])->name('buyer.orders.store');
        Route::get('/schemes', [BuyerController::class, 'schemes'])->name('buyer.schemes');
        Route::get('/articles', [BuyerController::class, 'articles'])->name('buyer.articles');
        Route::post('/contact', [BuyerController::class, 'contactSeller'])->name('buyer.contact.store');
        Route::get('/wishlist', [BuyerController::class, 'wishlist'])->name('buyer.wishlist');
        Route::post('/wishlist/toggle', [BuyerController::class, 'toggleWishlist'])->name('buyer.wishlist.toggle');
        Route::delete('/wishlist/{wishlist}', [BuyerController::class, 'removeFromWishlist'])->name('buyer.wishlist.destroy');
        
        // Cart Routes
        Route::get('/cart', [BuyerController::class, 'cart'])->name('buyer.cart');
        Route::post('/cart/add', [BuyerController::class, 'addToCart'])->name('buyer.cart.add');
        Route::patch('/cart/{cart}', [BuyerController::class, 'updateCart'])->name('buyer.cart.update');
        Route::delete('/cart/{cart}', [BuyerController::class, 'removeFromCart'])->name('buyer.cart.destroy');
        Route::post('/cart/checkout', [BuyerController::class, 'checkout'])->name('buyer.cart.checkout');

        Route::get('/settings', [BuyerController::class, 'settings'])->name('buyer.settings');
        Route::patch('/settings', [BuyerController::class, 'updateSettings'])->name('buyer.settings.update');
    });

    Route::prefix('seller')->middleware('role:seller')->group(function () {
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
        
        // Products CRUD for Seller
        Route::get('/products', [SellerController::class, 'products'])->name('seller.products');
        Route::get('/products/create', [SellerController::class, 'create'])->name('seller.products.create');
        Route::post('/products', [SellerController::class, 'store'])->name('seller.products.store');
        Route::get('/products/{product}/edit', [SellerController::class, 'edit'])->name('seller.products.edit');
        Route::put('/products/{product}', [SellerController::class, 'update'])->name('seller.products.update');
        Route::delete('/products/{product}', [SellerController::class, 'destroy'])->name('seller.products.destroy');

        Route::get('/orders', [SellerController::class, 'orders'])->name('seller.orders');
        Route::patch('/orders/{order}/status', [SellerController::class, 'updateOrderStatus'])->name('seller.orders.updateStatus');
        Route::get('/inquiries', [SellerController::class, 'inquiries'])->name('seller.inquiries');
        Route::patch('/inquiries/{inquiry}/status', [SellerController::class, 'updateInquiryStatus'])->name('seller.inquiries.updateStatus');
        Route::get('/earnings', [SellerController::class, 'earnings'])->name('seller.earnings');
        Route::get('/settings', [SellerController::class, 'settings'])->name('seller.settings');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';