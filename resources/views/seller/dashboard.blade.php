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
    <a href="{{ route('seller.settings') }}" class="nav-item">
        <i class="fas fa-store"></i>
        <span>Shop Settings</span>
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
                <p>{{ $stats['total_sales'] }}</p>
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
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #1a2a6c;">Recent Sales</h2>
                <a href="{{ route('seller.orders') }}" style="color: #4338ca; font-size: 0.9rem; font-weight: 700; text-decoration: none;">View All Orders</a>
            </div>
            <div style="padding: 0 24px 24px 24px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 1px solid #f1f5f9;">
                            <th style="padding: 16px 12px; color: #94a3b8; font-size: 0.8rem; text-transform: uppercase;">Product</th>
                            <th style="padding: 16px 12px; color: #94a3b8; font-size: 0.8rem; text-transform: uppercase;">Amount</th>
                            <th style="padding: 16px 12px; color: #94a3b8; font-size: 0.8rem; text-transform: uppercase;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 4; $i++)
                        <tr style="border-bottom: 1px solid #f8fafc;">
                            <td style="padding: 16px 12px;">
                                <div style="font-weight: 600; color: #1e293b;">Kashmiri Woolen Wrap</div>
                                <div style="font-size: 0.8rem; color: #94a3b8;">Order #{{ rand(1000, 9999) }}</div>
                            </td>
                            <td style="padding: 16px 12px; font-weight: 700; color: #1a2a6c;">₹5,400</td>
                            <td style="padding: 16px 12px;">
                                <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; background: #ecfdf5; color: #059669;">Delivered</span>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 24px;">
            <div class="card" style="background: linear-gradient(135deg, #1a2a6c, #b21f1f); color: white; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 16px;">Quick Inventory Alert</h3>
                <div style="display: flex; gap: 12px; align-items: center; background: rgba(255,255,255,0.1); padding: 12px; border-radius: 12px; margin-bottom: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">🧵</div>
                    <div style="flex: 1;">
                        <div style="font-size: 0.85rem; font-weight: 700;">Silk Yarn Blue</div>
                        <div style="font-size: 0.75rem; opacity: 0.8;">Only 2 units left</div>
                    </div>
                    <button style="background: white; color: #b21f1f; border: none; padding: 6px 12px; border-radius: 6px; font-weight: 700; font-size: 0.75rem; cursor: pointer;">Refill</button>
                </div>
            </div>

            <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 16px;">Upcoming Events</h3>
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div style="display: flex; gap: 12px; align-items: center;">
                        <div style="width: 45px; height: 45px; background: #fef2f2; color: #ef4444; border-radius: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            <span style="font-size: 0.65rem; font-weight: 800;">MAY</span>
                            <span style="font-size: 1rem; font-weight: 800;">12</span>
                        </div>
                        <div>
                            <div style="font-size: 0.9rem; font-weight: 700; color: #1e293b;">National Textile Expo</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">Registration Open</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection