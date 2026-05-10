@extends('layouts.dashboard')

@section('title', 'My Dashboard')

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
    <a href="{{ route('buyer.cart') }}" class="nav-item">
        <i class="fas fa-shopping-cart"></i>
        <span>Shopping Cart</span>
    </a>
    <a href="{{ route('buyer.wishlist') }}" class="nav-item">
        <i class="fas fa-heart"></i>
        <span>Wishlist</span>
    </a>
    <a href="{{ route('buyer.articles') }}" class="nav-item">
        <i class="fas fa-bullhorn"></i>
        <span>Textile Articles</span>
    </a>
    <a href="{{ route('buyer.schemes') }}" class="nav-item">
        <i class="fas fa-file-invoice"></i>
        <span>Govt Schemes</span>
    </a>
    <a href="{{ route('buyer.settings') }}" class="nav-item">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
    </a>
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <div>
            <h1 style="font-size: 2.2rem; font-weight: 800; color: #1a2a6c;">Welcome back, <span style="color: #111827;">{{ explode(' ', auth()->user()->name)[0] }}!</span></h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Manage your orders and explore the finest textiles.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('buyer.marketplace') }}" style="background: #1a2a6c; color: white; text-decoration: none; padding: 14px 28px; border-radius: 12px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(26, 42, 108, 0.2); transition: all 0.3s; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-shopping-bag"></i> Browse Marketplace
            </a>
        </div>
    </div>

    <!-- Shopping Summary -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 40px;">
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 24px;">
            <div style="width: 44px; height: 44px; background: #eef2ff; color: #4338ca; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 1.2rem;">
                <i class="fas fa-box-open"></i>
            </div>
            <div style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Active Orders</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-top: 4px;">{{ $stats['active_orders'] }}</div>
        </div>
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 24px;">
            <div style="width: 44px; height: 44px; background: #fef2f2; color: #ef4444; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 1.2rem;">
                <i class="fas fa-heart"></i>
            </div>
            <div style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Wishlist Items</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-top: 4px;">{{ $stats['wishlist_count'] }}</div>
        </div>
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 24px;">
            <div style="width: 44px; height: 44px; background: #ecfdf5; color: #059669; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 1.2rem;">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Items in Cart</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-top: 4px;">{{ $stats['cart_count'] }}</div>
        </div>
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 24px;">
            <div style="width: 44px; height: 44px; background: #fffbeb; color: #ca8a04; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 1.2rem;">
                <i class="fas fa-wallet"></i>
            </div>
            <div style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Total Spent</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-top: 4px;">₹{{ number_format($stats['total_spent']) }}</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
        <div style="display: flex; flex-direction: column; gap: 40px;">
            <!-- Recommended Section -->
            <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <div style="padding: 24px 32px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
                    <h2 style="font-size: 1.25rem; font-weight: 800; color: #1a2a6c;">Recommended Textiles</h2>
                    <a href="{{ route('buyer.marketplace') }}" style="color: #1a2a6c; font-weight: 700; text-decoration: none; font-size: 0.85rem;">View All <i class="fas fa-arrow-right" style="margin-left: 6px; font-size: 0.7rem;"></i></a>
                </div>
                <div style="padding: 32px; display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    @forelse($recommendedProducts as $product)
                    <div style="border-radius: 16px; border: 1px solid #f1f5f9; overflow: hidden; display: flex; gap: 16px; padding: 12px; transition: all 0.2s;" onmouseover="this.style.borderColor='#1a2a6c'; this.style.background='#f8fafc'" onmouseout="this.style.borderColor='#f1f5f9'; this.style.background='transparent'">
                        <div style="width: 100px; height: 100px; border-radius: 12px; overflow: hidden; flex-shrink: 0;">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #cbd5e1;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                        <div style="flex: 1; display: flex; flex-direction: column; justify-content: center;">
                            <div style="font-size: 0.75rem; color: #6366f1; font-weight: 700; text-transform: uppercase;">{{ $product->category }}</div>
                            <h4 style="font-size: 1rem; font-weight: 800; color: #1e293b; margin: 4px 0;">{{ $product->name }}</h4>
                            <div style="font-size: 1.1rem; font-weight: 800; color: #1a2a6c;">₹{{ number_format($product->price) }}</div>
                        </div>
                    </div>
                    @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #94a3b8;">
                        <p>No recommendations at the moment.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <div style="padding: 24px 32px; border-bottom: 1px solid #f1f5f9; background: #fafafa;">
                    <h2 style="font-size: 1.25rem; font-weight: 800; color: #1a2a6c;">Recent Activity</h2>
                </div>
                <div style="padding: 24px 32px;">
                    @forelse($activities as $activity)
                    <div style="display: flex; gap: 20px; margin-bottom: 24px; align-items: flex-start;">
                        <div style="width: 40px; height: 40px; border-radius: 12px; background: #f1f5f9; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: #1a2a6c; font-size: 1rem; flex-shrink: 0;">
                            <i class="fas {{ $activity->type == 'purchase' ? 'fa-shopping-bag' : ($activity->type == 'delivery_confirmation' ? 'fa-check' : 'fa-bell') }}"></i>
                        </div>
                        <div style="flex: 1;">
                            <p style="font-size: 0.95rem; color: #1e293b; line-height: 1.5; font-weight: 500;">{{ $activity->message }}</p>
                            <span style="font-size: 0.8rem; color: #94a3b8; font-weight: 600; display: block; margin-top: 4px;">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 60px 0; color: #94a3b8;">
                        <p style="font-weight: 600;">No recent activity.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div>
            <!-- Summary Card -->
            <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 32px; background: linear-gradient(135deg, #1a2a6c, #243b55); color: white; margin-bottom: 32px;">
                <h3 style="font-size: 1.2rem; font-weight: 800; margin-bottom: 20px;">Shopping Summary</h3>
                <div style="display: grid; gap: 24px;">
                    <div>
                        <div style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; opacity: 0.7; letter-spacing: 1px; margin-bottom: 4px;">Total Lifetime Orders</div>
                        <div style="font-size: 1.5rem; font-weight: 800;">{{ $stats['total_orders'] }}</div>
                    </div>
                    <div style="padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                        <a href="{{ route('buyer.orders') }}" style="color: #fdbb2d; text-decoration: none; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                            Track Recent Orders <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Helpful Info -->
            <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 32px;">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: #1a2a6c; margin-bottom: 16px;">Authenticity Guarantee</h3>
                <p style="color: #475569; font-size: 0.9rem; line-height: 1.6;">Every product on the E-Portal is verified by the Ministry of Textiles. Shop with confidence knowing you are supporting genuine Indian artisans.</p>
            </div>
        </div>
    </div>
@endsection