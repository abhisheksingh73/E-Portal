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
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Market Insights</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Deep dive into textile market performance and trends.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <div style="display: flex; background: white; border-radius: 12px; border: 1px solid #e2e8f0; padding: 4px;">
                <button style="padding: 8px 16px; border-radius: 8px; border: none; background: #1a2a6c; color: white; font-weight: 600; font-size: 0.85rem; cursor: pointer;">Weekly</button>
                <button style="padding: 8px 16px; border-radius: 8px; border: none; background: transparent; color: #64748b; font-weight: 600; font-size: 0.85rem; cursor: pointer;">Monthly</button>
                <button style="padding: 8px 16px; border-radius: 8px; border: none; background: transparent; color: #64748b; font-weight: 600; font-size: 0.85rem; cursor: pointer;">Yearly</button>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px; margin-bottom: 32px;">
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 24px;">Revenue Growth</h3>
            <div style="height: 250px; width: 100%; display: flex; align-items: flex-end; gap: 12px; padding-bottom: 20px;">
                @php $heights = [40, 60, 35, 90, 55, 80, 100]; @endphp
                @foreach($heights as $h)
                <div style="flex: 1; background: linear-gradient(to top, #1a2a6c, #4338ca); height: {{ $h }}%; border-radius: 8px 8px 0 0; position: relative;" title="{{ $h }}% growth">
                    <div style="position: absolute; bottom: -25px; left: 50%; transform: translateX(-50%); font-size: 0.7rem; color: #94a3b8; font-weight: 600;">Day {{ $loop->index + 1 }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 24px;">Stakeholder Distribution</h3>
            <div style="display: flex; align-items: center; justify-content: center; height: 250px;">
                <div style="position: relative; width: 180px; height: 180px; border-radius: 50%; background: conic-gradient(#1a2a6c 0% 40%, #fdbb2d 40% 75%, #ef4444 75% 100%);">
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 100px; height: 100px; border-radius: 50%; background: white; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                        <span style="font-size: 1.5rem; font-weight: 800; color: #1e293b;">12.8k</span>
                        <span style="font-size: 0.65rem; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Total</span>
                    </div>
                </div>
                <div style="margin-left: 40px; display: flex; flex-direction: column; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 12px; height: 12px; border-radius: 3px; background: #1a2a6c;"></div>
                        <span style="font-size: 0.85rem; font-weight: 600;">Sellers (40%)</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 12px; height: 12px; border-radius: 3px; background: #fdbb2d;"></div>
                        <span style="font-size: 0.85rem; font-weight: 600;">Buyers (35%)</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 12px; height: 12px; border-radius: 3px; background: #ef4444;"></div>
                        <span style="font-size: 0.85rem; font-weight: 600;">Guests (25%)</span>
                    </div>
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
