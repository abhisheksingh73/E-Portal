@extends('layouts.dashboard')

@section('title', 'Earnings')

@section('sidebar_links')
    <a href="{{ route('seller.dashboard') }}" class="nav-item">
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
    <a href="{{ route('seller.earnings') }}" class="nav-item active">
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
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Financial Overview</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Track your revenue, payouts, and settlements.</p>
        </div>
        <button style="background: #1a2a6c; color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; cursor: pointer;">
            <i class="fas fa-file-invoice-dollar" style="margin-right: 8px;"></i> Download Statement
        </button>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 32px;">
        <div class="card" style="background: linear-gradient(135deg, #1a2a6c, #243b55); color: white; border: none; padding: 32px;">
            <div style="font-size: 0.9rem; opacity: 0.8; margin-bottom: 8px;">Available for Payout</div>
            <div style="font-size: 2.5rem; font-weight: 800; margin-bottom: 24px;">₹{{ number_format($availableForPayout, 2) }}</div>
            <button style="width: 100%; padding: 14px; border-radius: 10px; border: none; background: #fdbb2d; color: #1a1a1a; font-weight: 800; font-size: 1rem; cursor: pointer;">Withdraw Funds</button>
            <div style="margin-top: 24px; padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 0.85rem; opacity: 0.7;">
                Next automated settlement on: <b>{{ now()->addDays(7)->format('M d, Y') }}</b>
            </div>
        </div>

        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 32px;">
            <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 24px;">Recent Delivered Orders</h3>
            <div style="display: flex; flex-direction: column; gap: 20px;">
                @forelse($deliveredOrders as $order)
                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9;">
                    <div style="display: flex; gap: 16px; align-items: center;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center;"><i class="fas fa-arrow-down"></i></div>
                        <div>
                            <div style="font-weight: 700; color: #1e293b;">{{ $order->product->name }} (ORD-{{ $order->id }})</div>
                            <div style="font-size: 0.8rem; color: #94a3b8;">{{ $order->updated_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-weight: 800; color: #059669;">+₹{{ number_format($order->total_price, 2) }}</div>
                        <div style="font-size: 0.75rem; color: #94a3b8;">
                            @if($order->status == 'shipped')
                                <span style="background: #fef3c7; color: #92400e; padding: 2px 6px; border-radius: 4px; font-weight: 800; font-size: 0.65rem;">AUTO-SETTLED</span>
                            @else
                                Completed
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 40px;">
                    <p style="color: #94a3b8;">No settled earnings yet.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
