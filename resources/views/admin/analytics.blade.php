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
            <p style="color: var(--text-muted); font-size: 1.1rem;">Live ministry intelligence derived from real-time portal activity.</p>
        </div>
        <div style="background: white; padding: 8px 16px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); font-weight: 700; color: #059669; display: flex; align-items: center; gap: 8px;">
            <div style="width: 8px; height: 8px; background: #059669; border-radius: 50%; animation: pulse 2s infinite;"></div>
            Live Updates Enabled
        </div>
    </div>

    <!-- Top Row Stats -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 32px;">
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 24px;">
            <div style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Total Revenue</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c;">₹{{ number_format($marketStats['total_revenue']) }}</div>
            <div style="font-size: 0.8rem; color: #059669; font-weight: 600; margin-top: 4px;">Delivered Sales</div>
        </div>
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 24px;">
            <div style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Orders Processed</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c;">{{ $marketStats['total_orders'] }}</div>
            <div style="font-size: 0.8rem; color: #4338ca; font-weight: 600; margin-top: 4px;">{{ $marketStats['pending_orders'] }} Pending</div>
        </div>
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 24px;">
            <div style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Avg. Order Value</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c;">₹{{ number_format($marketStats['avg_order_value']) }}</div>
            <div style="font-size: 0.8rem; color: #b45309; font-weight: 600; margin-top: 4px;">Per transaction</div>
        </div>
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 24px;">
            <div style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Total Users</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c;">{{ $marketStats['users']['sellers'] + $marketStats['users']['buyers'] }}</div>
            <div style="font-size: 0.8rem; color: #db2777; font-weight: 600; margin-top: 4px;">{{ $marketStats['users']['pending_sellers'] }} Pending Sellers</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px; margin-bottom: 32px;">
        <!-- Category Chart -->
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 24px;">Volume by Category</h3>
            <div style="height: 300px; width: 100%; display: flex; align-items: flex-end; gap: 20px; padding: 20px 0 40px;">
                @foreach($marketStats['top_categories'] as $cat)
                @php 
                    $maxVal = $marketStats['top_categories']->max('total') ?: 1;
                    $h = ($cat->total / $maxVal) * 100; 
                @endphp
                <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 12px; height: 100%; justify-content: flex-end;">
                    <div style="font-size: 0.85rem; font-weight: 800; color: #1a2a6c;">{{ $cat->total }}</div>
                    <div style="width: 100%; background: linear-gradient(to top, #1a2a6c, #4338ca); height: {{ $h }}%; border-radius: 8px; position: relative; transition: all 0.3s; cursor: pointer;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    </div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 100%;">{{ $cat->category }}</div>
                </div>
                @endforeach
                @if(count($marketStats['top_categories']) == 0)
                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-style: italic;">No product data available yet.</div>
                @endif
            </div>
        </div>

        <!-- Scheme Participation -->
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 24px;">Scheme Participation</h3>
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="font-weight: 600; color: #475569;">Application Approval Rate</span>
                        <span style="font-weight: 800; color: #059669;">
                            {{ $marketStats['schemes']['total_applications'] > 0 
                                ? round(($marketStats['schemes']['approved_applications'] / $marketStats['schemes']['total_applications']) * 100) 
                                : 0 }}%
                        </span>
                    </div>
                    <div style="height: 8px; width: 100%; background: #f1f5f9; border-radius: 4px;">
                        <div style="height: 100%; width: {{ $marketStats['schemes']['total_applications'] > 0 ? ($marketStats['schemes']['approved_applications'] / $marketStats['schemes']['total_applications']) * 100 : 0 }}%; background: #059669; border-radius: 4px;"></div>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 12px;">
                    <div style="padding: 16px; background: #fffbeb; border-radius: 12px; text-align: center;">
                        <div style="font-size: 1.25rem; font-weight: 800; color: #b45309;">{{ $marketStats['schemes']['pending_applications'] }}</div>
                        <div style="font-size: 0.75rem; font-weight: 700; color: #b45309; text-transform: uppercase;">Pending</div>
                    </div>
                    <div style="padding: 16px; background: #f0f9ff; border-radius: 12px; text-align: center;">
                        <div style="font-size: 1.25rem; font-weight: 800; color: #0369a1;">{{ $marketStats['schemes']['active_schemes'] }}</div>
                        <div style="font-size: 0.75rem; font-weight: 700; color: #0369a1; text-transform: uppercase;">Active Schemes</div>
                    </div>
                </div>

                <div style="margin-top: 12px; padding-top: 24px; border-top: 1px solid #f1f5f9; text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: 800; color: #1e293b;">{{ $marketStats['schemes']['total_applications'] }}</div>
                    <div style="color: #64748b; font-size: 0.9rem; font-weight: 600;">Total Applications Received</div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.5); opacity: 0.5; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
@endsection
