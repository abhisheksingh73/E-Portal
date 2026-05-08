@extends('layouts.dashboard')

@section('title', 'Market Orders')

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
    <a href="{{ route('admin.orders') }}" class="nav-item active">
        <i class="fas fa-shopping-cart"></i>
        <span>Market Orders</span>
    </a>
    <a href="{{ route('admin.analytics') }}" class="nav-item">
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
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Market Orders</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Track and manage transactions across the e-portal.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.orders.export') }}" style="background: white; color: #1e293b; border: 1px solid #e2e8f0; padding: 12px 20px; border-radius: 12px; font-weight: 600; cursor: pointer; text-decoration: none;">
                <i class="fas fa-download" style="margin-right: 8px;"></i> Download Report
            </a>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="orderModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: white; width: 600px; border-radius: 24px; padding: 40px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative;">
            <button onclick="closeModal()" style="position: absolute; top: 24px; right: 24px; background: #f1f5f9; border: none; width: 36px; height: 36px; border-radius: 50%; color: #64748b; cursor: pointer;"><i class="fas fa-times"></i></button>
            <div id="modalContent">
                <!-- Loaded via JS -->
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #1a2a6c;"></i>
                    <p style="margin-top: 15px; color: #64748b;">Loading order details...</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; background: #f8fafc; border-bottom: 1px solid #f1f5f9;">
                    <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Order ID</th>
                    <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Stakeholders</th>
                    <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Product</th>
                    <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Status</th>
                    <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Date</th>
                    <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr style="border-bottom: 1px solid #f8fafc;">
                    <td style="padding: 20px 24px; font-weight: 700; color: #1e293b;">#ORD-{{ $order->id }}</td>
                    <td style="padding: 20px 24px;">
                        <div style="font-size: 0.9rem; font-weight: 600; color: #1e293b;">B: {{ $order->buyer->name }}</div>
                        <div style="font-size: 0.8rem; color: #64748b;">S: {{ $order->product->seller->name ?? 'N/A' }}</div>
                    </td>
                    <td style="padding: 20px 24px;">
                        <div style="font-size: 0.9rem; font-weight: 600;">{{ $order->product->name }}</div>
                        <div style="font-size: 0.8rem; color: #64748b;">Qty: {{ $order->quantity }}</div>
                    </td>
                    <td style="padding: 20px 24px;">
                        <span style="
                            padding: 4px 12px; 
                            border-radius: 20px; 
                            font-size: 0.75rem; 
                            font-weight: 700;
                            text-transform: uppercase;
                            {{ $order->status == 'pending' ? 'background: #fffbeb; color: #b45309;' : ($order->status == 'shipped' ? 'background: #eff6ff; color: #1d4ed8;' : ($order->status == 'delivered' ? 'background: #ecfdf5; color: #059669;' : 'background: #fef2f2; color: #ef4444;')) }}
                        ">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td style="padding: 20px 24px; color: #64748b; font-size: 0.9rem;">{{ $order->created_at->format('M d, Y') }}</td>
                    <td style="padding: 20px 24px; text-align: center;">
                        <button onclick="viewOrder('{{ $order->id }}')" style="background: #f1f5f9; border: none; color: #1a2a6c; padding: 8px 16px; border-radius: 8px; font-size: 0.8rem; font-weight: 700; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#eef2ff'" onmouseout="this.style.background='#f1f5f9'">
                            <i class="fas fa-eye" style="margin-right: 4px;"></i> View
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center; color: #94a3b8;">No orders found in the system.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        function viewOrder(id) {
            document.getElementById('orderModal').style.display = 'flex';
            document.getElementById('modalContent').innerHTML = `
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #1a2a6c;"></i>
                    <p style="margin-top: 15px; color: #64748b;">Loading order details...</p>
                </div>
            `;

            fetch(`/admin/orders/${id}`)
                .then(response => response.json())
                .then(order => {
                    document.getElementById('modalContent').innerHTML = `
                        <div style="margin-bottom: 32px;">
                            <h2 style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-bottom: 8px;">Order Details #ORD-${order.id}</h2>
                            <p style="color: #64748b;">Status: <span style="text-transform: uppercase; font-weight: 700;">${order.status}</span></p>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px; margin-bottom: 32px;">
                            <div>
                                <h4 style="font-size: 0.8rem; text-transform: uppercase; color: #94a3b8; margin-bottom: 12px; font-weight: 700;">Product Information</h4>
                                <div style="font-weight: 700; font-size: 1.1rem; color: #1e293b;">${order.product.name}</div>
                                <div style="color: #64748b;">Quantity: ${order.quantity}</div>
                                <div style="color: #1a2a6c; font-weight: 800; font-size: 1.2rem; margin-top: 8px;">₹${parseFloat(order.total_price).toLocaleString()}</div>
                            </div>
                            <div>
                                <h4 style="font-size: 0.8rem; text-transform: uppercase; color: #94a3b8; margin-bottom: 12px; font-weight: 700;">Shipping Address</h4>
                                <div style="color: #1e293b; font-weight: 600; line-height: 1.5;">${order.shipping_address || 'No address provided'}</div>
                            </div>
                        </div>

                        <div style="background: #f8fafc; border-radius: 16px; padding: 24px; display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                            <div>
                                <h4 style="font-size: 0.7rem; text-transform: uppercase; color: #94a3b8; margin-bottom: 8px; font-weight: 700;">Buyer</h4>
                                <div style="font-weight: 700; color: #1e293b;">${order.buyer.name}</div>
                                <div style="font-size: 0.85rem; color: #64748b;">${order.buyer.email}</div>
                            </div>
                            <div>
                                <h4 style="font-size: 0.7rem; text-transform: uppercase; color: #94a3b8; margin-bottom: 8px; font-weight: 700;">Seller</h4>
                                <div style="font-weight: 700; color: #1e293b;">${order.product.seller ? order.product.seller.name : 'N/A'}</div>
                                <div style="font-size: 0.85rem; color: #64748b;">${order.product.seller ? order.product.seller.email : ''}</div>
                            </div>
                        </div>

                        <div style="margin-top: 32px; display: flex; gap: 12px;">
                            <button onclick="closeModal()" style="flex: 1; padding: 14px; border-radius: 12px; border: 1.5px solid #e2e8f0; background: white; font-weight: 700; color: #64748b; cursor: pointer;">Close Details</button>
                        </div>
                    `;
                })
                .catch(err => {
                    document.getElementById('modalContent').innerHTML = `
                        <div style="text-align: center; padding: 40px; color: #ef4444;">
                            <i class="fas fa-exclamation-triangle" style="font-size: 2rem;"></i>
                            <p style="margin-top: 15px; font-weight: 700;">Failed to load order details.</p>
                            <button onclick="closeModal()" style="margin-top: 20px; padding: 8px 20px; border-radius: 8px; border: none; background: #ef4444; color: white; cursor: pointer;">Close</button>
                        </div>
                    `;
                });
        }

        function closeModal() {
            document.getElementById('orderModal').style.display = 'none';
        }
    </script>
@endsection
