@extends('layouts.dashboard')

@section('title', 'Market Insights')

@section('sidebar_links')
    <a href="{{ route('admin.dashboard') }}" class="nav-item">
        <i class="fas fa-chart-pie"></i>
        <span>Overview</span>
    </a>
    <a href="{{ route('admin.users') }}" class="nav-item">
        <i class="fas fa-users"></i>
        <span>User Management</span>
    </a>
    <a href="{{ route('admin.products') }}" class="nav-item">
        <i class="fas fa-box"></i>
        <span>Textile Catalog</span>
    </a>
    <a href="{{ route('admin.orders') }}" class="nav-item">
        <i class="fas fa-shopping-cart"></i>
        <span>Market Orders</span>
    </a>
    <a href="{{ route('admin.analytics') }}" class="nav-item active">
        <i class="fas fa-chart-line"></i>
        <span>Insights</span>
    </a>
    <a href="{{ route('admin.schemes') }}" class="nav-item">
        <i class="fas fa-file-invoice"></i>
        <span>Govt Schemes</span>
    </a>
    <a href="{{ route('admin.articles') }}" class="nav-item">
        <i class="fas fa-bullhorn"></i>
        <span>Marketing Content</span>
    </a>
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Market Insights</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Deep dive into textile market performance and trends.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px; margin-bottom: 32px;">
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 24px;">Volume by Category</h3>
            <div style="height: 250px; width: 100%; display: flex; align-items: flex-end; gap: 12px; padding-bottom: 20px;">
                @foreach($marketStats['top_categories'] as $cat)
                @php $h = ($cat->total / max($marketStats['top_categories']->pluck('total')->toArray() ?: [1])) * 100; @endphp
                <div style="flex: 1; background: linear-gradient(to top, #1a2a6c, #4338ca); height: {{ $h }}%; border-radius: 8px 8px 0 0; position: relative;" title="{{ $cat->total }} products">
                    <div style="position: absolute; bottom: -25px; left: 50%; transform: translateX(-50%); font-size: 0.7rem; color: #94a3b8; font-weight: 600;">{{ $cat->category }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 24px;">Market Overview</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="padding: 20px; background: #f8fafc; border-radius: 16px;">
                    <span style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Sales Volume</span>
                    <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-top: 4px;">{{ number_format($marketStats['total_revenue']) }}</div>
                    <span style="font-size: 0.8rem; color: #059669; font-weight: 600;">Units sold</span>
                </div>
                <div style="padding: 20px; background: #f8fafc; border-radius: 16px;">
                    <span style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Transactions</span>
                    <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-top: 4px;">{{ $marketStats['order_count'] }}</div>
                    <span style="font-size: 0.8rem; color: #4338ca; font-weight: 600;">Orders processed</span>
                </div>
                <div style="padding: 20px; background: #f8fafc; border-radius: 16px;">
                    <span style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Avg. Order Size</span>
                    <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-top: 4px;">{{ number_format($marketStats['avg_order_value'], 1) }}</div>
                    <span style="font-size: 0.8rem; color: #b45309; font-weight: 600;">Units / order</span>
                </div>
                <div style="padding: 20px; background: #f8fafc; border-radius: 16px;">
                    <span style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Growth Rate</span>
                    <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-top: 4px;">+12.4%</div>
                    <span style="font-size: 0.8rem; color: #059669; font-weight: 600;">Month-over-month</span>
                </div>
            </div>
        </div>
    </div>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px;">
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center;">
            <div style="color: #4338ca; font-size: 2rem; margin-bottom: 12px;"><i class="fas fa-bolt"></i></div>
            <h4 style="font-size: 0.9rem; color: #64748b; margin-bottom: 8px;">Peak Hour Activity</h4>
            <div style="font-size: 1.5rem; font-weight: 800; color: #1e293b;">11:00 AM - 2:00 PM</div>
        </div>
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center;">
            <div style="color: #059669; font-size: 2rem; margin-bottom: 12px;"><i class="fas fa-globe"></i></div>
            <h4 style="font-size: 0.9rem; color: #64748b; margin-bottom: 8px;">Top Regional Hub</h4>
            <div style="font-size: 1.5rem; font-weight: 800; color: #1e293b;">Varanasi Cluster</div>
        </div>
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center;">
            <div style="color: #f59e0b; font-size: 2rem; margin-bottom: 12px;"><i class="fas fa-star"></i></div>
            <h4 style="font-size: 0.9rem; color: #64748b; margin-bottom: 8px;">User Satisfaction</h4>
            <div style="font-size: 1.5rem; font-weight: 800; color: #1e293b;">4.8 / 5.0</div>
        </div>
    </div>
@endsection
