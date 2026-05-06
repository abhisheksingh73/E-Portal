@extends('layouts.dashboard')

@section('title', 'Buyer Home')

@section('sidebar_links')
    <a href="{{ route('buyer.dashboard') }}" class="nav-item active">
        <i class="fas fa-home"></i>
        <span>My Home</span>
    </a>
    <a href="{{ route('buyer.marketplace') }}" class="nav-item">
        <i class="fas fa-shopping-bag"></i>
        <span>Marketplace</span>
    </a>
    <a href="{{ route('buyer.orders') }}" class="nav-item">
        <i class="fas fa-history"></i>
        <span>My Orders</span>
    </a>
    <a href="{{ route('buyer.wishlist') }}" class="nav-item">
        <i class="fas fa-heart"></i>
        <span>Wishlist</span>
    </a>
    <a href="{{ route('buyer.settings') }}" class="nav-item">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
    </a>
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}!</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Explore the latest premium textile collections.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('buyer.marketplace') }}" style="background: #1a2a6c; color: white; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 12px rgba(26, 42, 108, 0.2); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-shopping-cart" style="margin-right: 8px;"></i> Shop Marketplace
            </a>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card" style="background: linear-gradient(135deg, #ffffff, #f5f7ff); border: 1px solid #eef2ff;">
            <div class="stat-icon" style="background: #eef2ff; color: #4338ca;">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-info">
                <h3>Active Orders</h3>
                <p>{{ $stats['active_orders'] }}</p>
                <span style="color: #4338ca; font-size: 0.8rem; font-weight: 700;">In Transit</span>
            </div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #ffffff, #fff5f5); border: 1px solid #fff5f5;">
            <div class="stat-icon" style="background: #fef2f2; color: #ef4444;">
                <i class="fas fa-heart"></i>
            </div>
            <div class="stat-info">
                <h3>Saved Items</h3>
                <p>{{ $stats['wishlist_count'] }}</p>
                <span style="color: #ef4444; font-size: 0.8rem; font-weight: 700;">3 Price Drops</span>
            </div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #ffffff, #f0fdf4); border: 1px solid #f0fdf4;">
            <div class="stat-icon" style="background: #ecfdf5; color: #059669;">
                <i class="fas fa-award"></i>
            </div>
            <div class="stat-info">
                <h3>Reward Points</h3>
                <p>{{ $stats['reward_points'] }}</p>
                <span style="color: #059669; font-size: 0.8rem; font-weight: 700;">Silver Member</span>
            </div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #ffffff, #fefce8); border: 1px solid #fefce8;">
            <div class="stat-icon" style="background: #fef9c3; color: #ca8a04;">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-info">
                <h3>Total Spent</h3>
                <p>₹1.2k</p>
                <span style="color: #ca8a04; font-size: 0.8rem; font-weight: 700;">Lifetime savings</span>
            </div>
        </div>
    </div>

    <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 0; overflow: hidden;">
        <div style="padding: 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: #1a2a6c;">Recommended Textiles</h2>
            <a href="{{ route('buyer.marketplace') }}" style="color: #4338ca; font-size: 0.9rem; font-weight: 700; text-decoration: none;">Explore Gallery <i class="fas fa-arrow-right" style="margin-left: 5px;"></i></a>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; padding: 24px;">
            @foreach($recommendedProducts as $product)
            <div style="border-radius: 16px; border: 1px solid #f1f5f9; overflow: hidden; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                <div style="height: 180px; background: #f8fafc; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
                    <span style="position: absolute; top: 12px; left: 12px; background: #1a2a6c; color: white; font-size: 0.7rem; font-weight: 700; padding: 4px 10px; border-radius: 50px;">{{ $product->category }}</span>
                    @if($product->image)
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fas fa-image" style="font-size: 2.5rem; color: #cbd5e1;"></i>
                    @endif
                </div>
                <div style="padding: 20px;">
                    <div style="font-size: 0.8rem; color: #6366f1; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">{{ $product->seller->name ?? 'Premium Seller' }}</div>
                    <h4 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 8px;">{{ $product->name }}</h4>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 1.25rem; font-weight: 800; color: #1a2a6c;">₹{{ number_format($product->price) }}</span>
                        <button style="width: 36px; height: 36px; border-radius: 10px; border: none; background: #f1f5f9; color: #1a2a6c; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#1a2a6c'; this.style.color='white'" onmouseout="this.style.background='#f1f5f9'; this.style.color='#1a2a6c'"><i class="fas fa-shopping-cart"></i></button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection