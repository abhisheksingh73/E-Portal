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
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <div>
            <h1 style="font-size: 2.2rem; font-weight: 800; color: #1a2a6c;">Artisan <span style="color: #111827;">Business Center</span></h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Monitor your shop's performance and inventory health.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('seller.products') }}" style="background: #1a2a6c; color: white; text-decoration: none; padding: 14px 28px; border-radius: 12px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(26, 42, 108, 0.2); transition: all 0.3s; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-plus"></i> List New Textile
            </a>
        </div>
    </div>

    <!-- Business Metrics -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 40px;">
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 24px;">
            <div style="width: 44px; height: 44px; background: #ecfdf5; color: #059669; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 1.2rem;">
                <i class="fas fa-rupee-sign"></i>
            </div>
            <div style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Total Earnings</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-top: 4px;">₹{{ number_format($stats['total_earnings']) }}</div>
        </div>
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 24px;">
            <div style="width: 44px; height: 44px; background: #fffbeb; color: #b45309; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 1.2rem;">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Pending Orders</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #b45309; margin-top: 4px;">{{ $stats['pending_orders'] }}</div>
        </div>
        <div style="position: relative;">
            <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 24px;">
                <div style="width: 44px; height: 44px; background: #eef2ff; color: #4338ca; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 1.2rem;">
                    <i class="fas fa-comments"></i>
                </div>
                <div style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">New Inquiries</div>
                <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-top: 4px;">{{ $stats['unread_inquiries'] }}</div>
            </div>
            @if($stats['unread_inquiries'] > 0)
                <div style="position: absolute; top: -10px; right: -10px; background: #ef4444; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);">{{ $stats['unread_inquiries'] }}</div>
            @endif
        </div>
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 24px;">
            <div style="width: 44px; height: 44px; background: #f0f9ff; color: #0284c7; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 1.2rem;">
                <i class="fas fa-boxes"></i>
            </div>
            <div style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Active Listings</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-top: 4px;">{{ $stats['active_listings'] }}</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
        <!-- Recent Orders & Activity -->
        <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <div style="padding: 24px 32px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
                <h2 style="font-size: 1.25rem; font-weight: 800; color: #1a2a6c;">Recent Platform Activity</h2>
                <a href="{{ route('seller.orders') }}" style="color: #1a2a6c; font-weight: 700; text-decoration: none; font-size: 0.85rem;">Manage Orders <i class="fas fa-arrow-right" style="margin-left: 6px; font-size: 0.7rem;"></i></a>
            </div>
            <div style="padding: 24px 32px;">
                @forelse($activities as $activity)
                <div style="display: flex; gap: 20px; margin-bottom: 28px; align-items: flex-start;">
                    <div style="width: 40px; height: 40px; border-radius: 12px; background: #f1f5f9; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; color: #1a2a6c; font-size: 1rem; flex-shrink: 0;">
                        <i class="fas {{ $activity->type == 'product_listing' ? 'fa-tag' : ($activity->type == 'registration' ? 'fa-user-check' : 'fa-bell') }}"></i>
                    </div>
                    <div style="flex: 1;">
                        <p style="font-size: 1rem; color: #1e293b; line-height: 1.5; font-weight: 500;">{{ $activity->message }}</p>
                        <span style="font-size: 0.8rem; color: #94a3b8; font-weight: 600; display: block; margin-top: 4px;">{{ $activity->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 60px 0; color: #94a3b8;">
                    <i class="fas fa-history" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.1;"></i>
                    <p style="font-weight: 600;">No recent activity found for your shop.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div>
            <!-- Quick Navigation / Stats Summary -->
            <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 32px; background: linear-gradient(135deg, #1a2a6c, #243b55); color: white;">
                <h3 style="font-size: 1.2rem; font-weight: 800; margin-bottom: 20px;">Shop Summary</h3>
                <div style="display: grid; gap: 24px;">
                    <div>
                        <div style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; opacity: 0.7; letter-spacing: 1px; margin-bottom: 4px;">Total Orders Received</div>
                        <div style="font-size: 1.5rem; font-weight: 800;">{{ $stats['total_orders'] }}</div>
                    </div>
                    <div style="padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                        <a href="{{ route('seller.earnings') }}" style="color: #fdbb2d; text-decoration: none; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                            View Earnings Report <i class="fas fa-arrow-right" style="font-size: 0.8rem;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 32px;">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: #1a2a6c; margin-bottom: 16px;">Minister's Tip</h3>
                <p style="color: #475569; font-size: 0.95rem; line-height: 1.6; font-style: italic;">"Artisans who participate in Govt Schemes see a 30% increase in platform visibility. Check out the active schemes today!"</p>
                <a href="{{ route('seller.schemes') }}" style="display: inline-block; margin-top: 16px; color: #1a2a6c; font-weight: 800; text-decoration: none; font-size: 0.85rem;">View Schemes <i class="fas fa-chevron-right" style="margin-left: 4px; font-size: 0.7rem;"></i></a>
            </div>
        </div>
    </div>
@endsection