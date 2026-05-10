@extends('layouts.dashboard')

@section('title', 'Seller Dashboard')

@section('sidebar_links')
    <a href="{{ route('seller.dashboard') }}" class="nav-item active">
        <i class="fas fa-chart-line"></i>
        <span>Dashboard</span>
    </a>
    <a href="{{ route('seller.products') }}" class="nav-item">
        <i class="fas fa-boxes"></i>
        <span>My Inventory</span>
    </a>
    <a href="{{ route('seller.orders') }}" class="nav-item">
        <i class="fas fa-clipboard-list"></i>
        <span>Received Orders</span>
    </a>
    <a href="{{ route('seller.earnings') }}" class="nav-item">
        <i class="fas fa-wallet"></i>
        <span>Earnings</span>
    </a>
    <a href="{{ route('seller.inquiries') }}" class="nav-item">
        <i class="fas fa-comments"></i>
        <span>Customer Inquiries</span>
    </a>
    <a href="{{ route('seller.settings') }}" class="nav-item">
        <i class="fas fa-store"></i>
        <span>Shop Settings</span>
    </a>
    <a href="{{ route('seller.schemes') }}" class="nav-item">
        <i class="fas fa-file-invoice"></i>
        <span>Govt Schemes</span>
    </a>
    <a href="{{ route('seller.articles') }}" class="nav-item">
        <i class="fas fa-bullhorn"></i>
        <span>Textile Articles</span>
    </a>
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Seller Command Center</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Manage your shop performance and inventory.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('seller.products') }}" style="background: #1a2a6c; color: white; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 12px rgba(26, 42, 108, 0.2); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-plus" style="margin-right: 8px;"></i> List New Textile
            </a>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card" style="border-bottom: 4px solid #10b981;">
            <div class="stat-icon" style="background: #ecfdf5; color: #059669;">
                <i class="fas fa-rupee-sign"></i>
            </div>
            <div class="stat-info">
                <h3>Total Earnings</h3>
                <p>₹{{ number_format($stats['total_sales']) }}</p>
                <span style="color: #059669; font-size: 0.8rem; font-weight: 700;"><i class="fas fa-arrow-up"></i> +15% vs last month</span>
            </div>
        </div>
        <div class="stat-card" style="border-bottom: 4px solid #6366f1;">
            <div class="stat-icon" style="background: #eef2ff; color: #4338ca;">
                <i class="fas fa-box-open"></i>
            </div>
            <div class="stat-info">
                <h3>Active Listings</h3>
                <p>{{ $stats['active_listings'] }}</p>
                <span style="color: #64748b; font-size: 0.8rem; font-weight: 600;">{{ 20 - $stats['active_listings'] }} slots remaining</span>
            </div>
        </div>
        <div class="stat-card" style="border-bottom: 4px solid #f59e0b;">
            <div class="stat-icon" style="background: #fffbeb; color: #b45309;">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stat-info">
                <h3>Pending Orders</h3>
                <p>{{ $stats['pending_orders'] }}</p>
                <span style="color: #b45309; font-size: 0.8rem; font-weight: 700;">Action required</span>
            </div>
        </div>
        <div class="stat-card" style="border-bottom: 4px solid #f43f5e;">
            <div class="stat-icon" style="background: #fff1f2; color: #e11d48;">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-info">
                <h3>Shop Rating</h3>
                <p>{{ $stats['customer_rating'] }}</p>
                <span style="color: #e11d48; font-size: 0.8rem; font-weight: 700;">Top Rated Seller</span>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
        <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <div style="padding: 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <h2 style="font-weight: 700; color: #1e293b;">Market Activity Feed</h2>
                <span style="font-size: 0.75rem; font-weight: 700; color: #4338ca;">LIVE UPDATES</span>
            </div>
            <div style="padding: 24px;">
                @forelse($activities as $activity)
                <div style="display: flex; gap: 16px; margin-bottom: 24px;">
                    <div style="width: 40px; height: 40px; border-radius: 12px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #1a2a6c; font-size: 1rem;">
                        <i class="fas {{ $activity->type == 'product_listing' ? 'fa-tag' : ($activity->type == 'registration' ? 'fa-user-check' : 'fa-bell') }}"></i>
                    </div>
                    <div style="flex: 1;">
                        <p style="font-size: 0.95rem; color: #1e293b; line-height: 1.5; margin-bottom: 4px;">{{ $activity->message }}</p>
                        <span style="font-size: 0.8rem; color: #94a3b8;">{{ $activity->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 40px 0; color: #94a3b8;">
                    <i class="fas fa-history" style="font-size: 2rem; margin-bottom: 12px; opacity: 0.2;"></i>
                    <p>No recent platform activity found.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 24px;">
            <div class="card" style="background: linear-gradient(135deg, #1a2a6c, #243b55); color: white; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 16px;">Quick Tip</h3>
                <p style="font-size: 0.85rem; opacity: 0.8; line-height: 1.6;">Textiles with detailed 'Story' descriptions receive 45% more engagement. Update your product stories today!</p>
            </div>

            <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 16px;">System Health</h3>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <div style="width: 10px; height: 10px; border-radius: 50%; background: #10b981;"></div>
                    <span style="font-size: 0.9rem; font-weight: 600;">Server Status: Optimal</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 10px; height: 10px; border-radius: 50%; background: #10b981;"></div>
                    <span style="font-size: 0.9rem; font-weight: 600;">Payment Gateway: Active</span>
                </div>
            </div>
        </div>
    </div>
@endsection