@extends('layouts.dashboard')

@section('title', 'Received Orders')

@section('sidebar_links')
    <a href="{{ route('seller.dashboard') }}" class="nav-item">
        <i class="fas fa-chart-line"></i>
        <span>Dashboard</span>
    </a>
    <a href="{{ route('seller.products') }}" class="nav-item">
        <i class="fas fa-boxes"></i>
        <span>My Inventory</span>
    </a>
    <a href="{{ route('seller.orders') }}" class="nav-item active">
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
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Received Orders</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Manage customer orders and fulfillment status.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <form action="{{ route('seller.orders') }}" method="GET" style="display: flex; gap: 12px;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Order ID or Name..." style="padding: 12px 16px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; width: 220px;">
                <select name="status" onchange="this.form.submit()" style="padding: 12px 16px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; background: white; cursor: pointer; color: #64748b; font-weight: 600;">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @if(request()->filled('search') || request()->filled('status'))
                    <a href="{{ route('seller.orders') }}" style="background: white; color: #ef4444; border: 1px solid #ef4444; padding: 12px; border-radius: 12px; display: flex; align-items: center; text-decoration: none;"><i class="fas fa-times"></i></a>
                @endif
            </form>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; color: #059669; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-weight: 600; border: 1px solid #10b981;">
            <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; background: #f8fafc; border-bottom: 1px solid #f1f5f9;">
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Order ID</th>
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Customer</th>
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Items</th>
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Total</th>
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Status</th>
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr style="border-bottom: 1px solid #f8fafc; transition: background 0.3s;" onmouseover="this.style.background='#fcfdff'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 20px 24px; font-weight: 700; color: #1e293b;">#ORD-{{ $order->id }}</td>
                    <td style="padding: 20px 24px;">
                        <div style="font-weight: 600; color: #1e293b;">{{ $order->buyer->name }}</div>
                        <div style="font-size: 0.8rem; color: #94a3b8;">{{ $order->shipping_address }}</div>
                    </td>
                    <td style="padding: 20px 24px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            @if($order->product->image)
                                <img src="{{ asset('storage/' . $order->product->image) }}" style="width: 32px; height: 32px; border-radius: 4px; object-fit: cover;">
                            @endif
                            <span style="color: #64748b; font-size: 0.9rem;">{{ $order->quantity }}x {{ $order->product->name }}</span>
                        </div>
                    </td>
                    <td style="padding: 20px 24px; font-weight: 700; color: #1a2a6c;">₹{{ number_format($order->total_price, 2) }}</td>
                    <td style="padding: 20px 24px;">
                        @php
                            $statusColors = [
                                'pending' => ['bg' => '#fffbeb', 'text' => '#b45309'],
                                'shipped' => ['bg' => '#eff6ff', 'text' => '#1d4ed8'],
                                'delivered' => ['bg' => '#ecfdf5', 'text' => '#059669'],
                                'cancelled' => ['bg' => '#fef2f2', 'text' => '#b91c1c'],
                            ];
                            $colors = $statusColors[$order->status] ?? $statusColors['pending'];
                        @endphp
                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; background: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; text-transform: uppercase;">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td style="padding: 20px 24px; text-align: center;">
                        <div style="margin-bottom: 8px;">
                            <span style="font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase;">{{ $order->payment_method }}</span>
                            <span style="font-size: 0.7rem; color: {{ $order->payment_status == 'paid' ? '#059669' : '#b45309' }}; font-weight: 700;">({{ strtoupper($order->payment_status) }})</span>
                        </div>
                        @if($order->status == 'pending')
                            <div style="display: flex; justify-content: center; gap: 8px;">
                                <form action="{{ route('seller.orders.updateStatus', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="shipped">
                                    <button type="submit" style="background: #1a2a6c; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">Ship Now</button>
                                </form>
                                <form action="{{ route('seller.orders.updateStatus', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" style="background: white; color: #ef4444; border: 1px solid #ef4444; padding: 8px 12px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; cursor: pointer;" title="Cancel Order"><i class="fas fa-times"></i></button>
                                </form>
                            </div>
                        @elseif($order->status == 'shipped')
                            <form action="{{ route('seller.orders.updateStatus', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="delivered">
                                <button type="submit" style="background: #10b981; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">Mark Delivered</button>
                            </form>
                        @else
                            <span style="color: #94a3b8; font-size: 0.8rem; font-style: italic;">Fulfilled</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center; color: #94a3b8;">
                        <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.2;"></i>
                        <p>No orders received yet.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
