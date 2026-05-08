@extends('layouts.dashboard')

@section('title', 'My Orders')

@section('sidebar_links')
    <a href="{{ route('buyer.dashboard') }}" class="nav-item">
        <i class="fas fa-home"></i>
        <span>My Home</span>
    </a>
    <a href="{{ route('buyer.marketplace') }}" class="nav-item">
        <i class="fas fa-shopping-bag"></i>
        <span>Marketplace</span>
    </a>
    <a href="{{ route('buyer.orders') }}" class="nav-item active">
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
    <a href="{{ route('buyer.schemes') }}" class="nav-item">
        <i class="fas fa-file-invoice"></i>
        <span>Govt Schemes</span>
    </a>
    <a href="{{ route('buyer.articles') }}" class="nav-item">
        <i class="fas fa-bullhorn"></i>
        <span>Textile Articles</span>
    </a>
    <a href="{{ route('buyer.settings') }}" class="nav-item">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
    </a>
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Order History</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Track your recent purchases and download invoices.</p>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; color: #059669; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-weight: 600; border: 1px solid #10b981;">
            <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; flex-direction: column; gap: 24px;">
        @forelse($orders as $order)
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 0; overflow: hidden;">
            <div style="padding: 20px 32px; background: #f8fafc; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; gap: 40px;">
                    <div>
                        <div style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 4px;">Order Placed</div>
                        <div style="font-size: 0.95rem; font-weight: 600; color: #1e293b;">{{ $order->created_at->format('M d, Y') }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 4px;">Total Amount</div>
                        <div style="font-size: 0.95rem; font-weight: 600; color: #1e293b;">₹{{ number_format($order->total_price, 2) }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 4px;">Ship To</div>
                        <div style="font-size: 0.95rem; font-weight: 600; color: #1a2a6c; cursor: pointer;">{{ auth()->user()->name }} <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i></div>
                    </div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 4px; text-align: right;">Order #</div>
                    <div style="font-size: 0.95rem; font-weight: 600; color: #1e293b;">ORD-{{ $order->id }}</div>
                </div>
            </div>
            <div style="padding: 32px; display: flex; gap: 24px; align-items: center;">
                <div style="width: 100px; height: 100px; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                    @if($order->product->image)
                        <img src="{{ asset('storage/' . $order->product->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fas fa-image" style="font-size: 2rem; color: #cbd5e1;"></i>
                    @endif
                </div>
                <div style="flex: 1;">
                    @php
                        $statusColors = [
                            'pending' => ['bg' => '#fffbeb', 'text' => '#b45309'],
                            'shipped' => ['bg' => '#eff6ff', 'text' => '#1d4ed8'],
                            'delivered' => ['bg' => '#ecfdf5', 'text' => '#059669'],
                            'cancelled' => ['bg' => '#fef2f2', 'text' => '#b91c1c'],
                        ];
                        $colors = $statusColors[$order->status] ?? $statusColors['pending'];
                    @endphp
                    <div style="background: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; font-size: 0.75rem; font-weight: 800; padding: 4px 10px; border-radius: 4px; display: inline-block; margin-bottom: 12px; text-transform: uppercase;">{{ $order->status }}</div>
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 4px;">{{ $order->product->name }}</h3>
                    <p style="font-size: 0.9rem; color: #64748b;">Sold by: <b>{{ $order->product->seller->name ?? 'Premium Seller' }}</b></p>
                </div>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <button style="background: #1a2a6c; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer;">Track Package</button>
                    <button style="background: white; color: #1e293b; border: 1px solid #e2e8f0; padding: 10px 24px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer;">View Invoice</button>
                </div>
            </div>
        </div>
        @empty
        <div style="text-align: center; padding: 100px 0; background: white; border-radius: 20px;">
            <i class="fas fa-shopping-basket" style="font-size: 4rem; color: #e2e8f0; margin-bottom: 24px;"></i>
            <h2 style="color: #64748b; font-weight: 600;">You haven't placed any orders yet</h2>
            <a href="{{ route('buyer.marketplace') }}" style="color: #1a2a6c; font-weight: 700; text-decoration: none; margin-top: 12px; display: inline-block;">Start Shopping <i class="fas fa-arrow-right"></i></a>
        </div>
        @endforelse
    </div>
@endsection
