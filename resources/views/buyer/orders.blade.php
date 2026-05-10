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
    <a href="{{ route('buyer.articles') }}" class="nav-item">
        <i class="fas fa-bullhorn"></i>
        <span>Textile Articles</span>
    </a>
    <a href="{{ route('buyer.schemes') }}" class="nav-item">
        <i class="fas fa-file-invoice"></i>
        <span>Govt Schemes</span>
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
        <div style="display: flex; gap: 12px;">
            <form action="{{ route('buyer.orders') }}" method="GET" style="display: flex; gap: 12px;">
                <select name="status" onchange="this.form.submit()" style="padding: 12px 16px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; background: white; cursor: pointer; color: #64748b; font-weight: 600;">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                @if(request()->filled('status'))
                    <a href="{{ route('buyer.orders') }}" style="background: white; color: #ef4444; border: 1px solid #ef4444; padding: 12px; border-radius: 12px; display: flex; align-items: center; text-decoration: none;"><i class="fas fa-times"></i></a>
                @endif
            </form>
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
                        <img src="{{ str_starts_with($order->product->image, 'http') ? $order->product->image : asset('storage/' . $order->product->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
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
                    @if($order->status == 'shipped')
                        <form action="{{ route('buyer.orders.confirm', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" style="background: #10b981; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 700; font-size: 0.9rem; cursor: pointer; width: 100%;">
                                <i class="fas fa-check-double"></i> Mark Received
                            </button>
                        </form>
                    @endif
                    <button onclick="openTrackingModal('{{ $order->id }}', '{{ $order->status }}', '{{ $order->created_at->format('M d') }}')" style="background: #1a2a6c; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer;">Track Package</button>
                    <button onclick="openInvoiceModal('{{ $order->id }}', '{{ $order->product->name }}', '{{ $order->quantity }}', '{{ $order->total_price }}', '{{ $order->created_at->format('M d, Y') }}', '{{ $order->payment_method }}')" style="background: white; color: #1e293b; border: 1px solid #e2e8f0; padding: 10px 24px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer;">View Invoice</button>
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

    <!-- Tracking Modal -->
    <div id="trackingModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: white; width: 500px; border-radius: 24px; padding: 40px; box-shadow: var(--shadow-lg);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
                <h2 style="font-size: 1.5rem; font-weight: 800; color: #1a2a6c;">Track Shipment</h2>
                <button onclick="closeModal('trackingModal')" style="background: none; border: none; font-size: 1.5rem; color: #94a3b8; cursor: pointer;"><i class="fas fa-times"></i></button>
            </div>
            <div style="position: relative; padding-left: 40px; border-left: 3px solid #f1f5f9; margin-left: 10px;">
                <div style="margin-bottom: 32px; position: relative;">
                    <div style="position: absolute; left: -53px; width: 24px; height: 24px; border-radius: 50%; background: #1a2a6c; border: 4px solid white; box-shadow: 0 0 0 3px #1a2a6c;"></div>
                    <h4 style="color: #1a2a6c; font-weight: 700; margin-bottom: 4px;">Order Placed</h4>
                    <p style="font-size: 0.85rem; color: #94a3b8;" id="trackDate">Jan 12</p>
                </div>
                <div style="margin-bottom: 32px; position: relative;">
                    <div id="stepPaid" style="position: absolute; left: -53px; width: 24px; height: 24px; border-radius: 50%; background: #cbd5e1; border: 4px solid white;"></div>
                    <h4 id="textPaid" style="color: #94a3b8; font-weight: 700; margin-bottom: 4px;">Payment Confirmed</h4>
                    <p style="font-size: 0.85rem; color: #94a3b8;">Processing at facility</p>
                </div>
                <div style="margin-bottom: 32px; position: relative;">
                    <div id="stepShipped" style="position: absolute; left: -53px; width: 24px; height: 24px; border-radius: 50%; background: #cbd5e1; border: 4px solid white;"></div>
                    <h4 id="textShipped" style="color: #94a3b8; font-weight: 700; margin-bottom: 4px;">Shipped</h4>
                    <p style="font-size: 0.85rem; color: #94a3b8;">In transit to hub</p>
                </div>
                <div style="position: relative;">
                    <div id="stepDelivered" style="position: absolute; left: -53px; width: 24px; height: 24px; border-radius: 50%; background: #cbd5e1; border: 4px solid white;"></div>
                    <h4 id="textDelivered" style="color: #94a3b8; font-weight: 700; margin-bottom: 4px;">Delivered</h4>
                    <p style="font-size: 0.85rem; color: #94a3b8;">Out for delivery</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Modal -->
    <div id="invoiceModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: white; width: 600px; border-radius: 24px; padding: 50px; box-shadow: var(--shadow-lg);" id="invoiceContent">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px;">
                <div>
                    <h1 style="color: #1a2a6c; font-weight: 900; letter-spacing: -1px; margin-bottom: 8px;">E-PORTAL</h1>
                    <p style="color: #94a3b8; font-size: 0.85rem;">Ministry of Textiles, Govt. of India</p>
                </div>
                <div style="text-align: right;">
                    <h2 style="font-weight: 800; color: #1e293b;">INVOICE</h2>
                    <p style="color: #94a3b8; font-size: 0.85rem;" id="invNumber">#ORD-123</p>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px; padding-bottom: 30px; border-bottom: 2px solid #f1f5f9;">
                <div>
                    <h4 style="text-transform: uppercase; font-size: 0.75rem; color: #94a3b8; letter-spacing: 1px; margin-bottom: 12px;">Billed To</h4>
                    <p style="font-weight: 700; color: #1e293b;">{{ auth()->user()->name }}</p>
                    <p style="color: #64748b; font-size: 0.9rem; line-height: 1.5;">{{ auth()->user()->address }}</p>
                </div>
                <div style="text-align: right;">
                    <h4 style="text-transform: uppercase; font-size: 0.75rem; color: #94a3b8; letter-spacing: 1px; margin-bottom: 12px;">Invoice Date</h4>
                    <p style="font-weight: 700; color: #1e293b;" id="invDate">May 10, 2026</p>
                </div>
            </div>

            <table style="width: 100%; border-collapse: collapse; margin-bottom: 40px;">
                <thead>
                    <tr style="border-bottom: 2px solid #f1f5f9;">
                        <th style="padding: 12px 0; text-align: left; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase;">Description</th>
                        <th style="padding: 12px 0; text-align: center; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase;">Qty</th>
                        <th style="padding: 12px 0; text-align: right; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 20px 0; font-weight: 700; color: #1e293b;" id="invProduct">Silk Saree</td>
                        <td style="padding: 20px 0; text-align: center; color: #1e293b;" id="invQty">1</td>
                        <td style="padding: 20px 0; text-align: right; font-weight: 800; color: #1a2a6c;" id="invTotal">₹4,500.00</td>
                    </tr>
                </tbody>
            </table>

            <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 24px; border-radius: 16px;">
                <div>
                    <p style="font-size: 0.8rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Payment Method</p>
                    <p style="font-weight: 800; color: #1a2a6c; font-size: 0.95rem;" id="invMethod">COD</p>
                </div>
                <div style="text-align: right;">
                    <p style="font-size: 0.8rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Amount Due</p>
                    <p style="font-weight: 900; color: #1a2a6c; font-size: 1.5rem;" id="invGrandTotal">₹4,500.00</p>
                </div>
            </div>

            <div style="margin-top: 40px; display: flex; justify-content: flex-end; gap: 12px;">
                <button onclick="closeModal('invoiceModal')" style="padding: 12px 24px; border: 1px solid #e2e8f0; background: white; border-radius: 12px; font-weight: 700; cursor: pointer;">Close</button>
                <button onclick="window.print()" style="padding: 12px 24px; background: #1a2a6c; color: white; border: none; border-radius: 12px; font-weight: 700; cursor: pointer;">Print Invoice</button>
            </div>
        </div>
    </div>

    <script>
        function openTrackingModal(id, status, date) {
            document.getElementById('trackDate').innerText = date;
            const steps = ['Paid', 'Shipped', 'Delivered'];
            const statusIdx = status == 'pending' ? -1 : (status == 'shipped' ? 1 : 2);
            
            // Default reset
            steps.forEach(s => {
                document.getElementById('step'+s).style.background = '#cbd5e1';
                document.getElementById('step'+s).style.boxShadow = 'none';
                document.getElementById('text'+s).style.color = '#94a3b8';
            });

            // Highlight steps
            if(statusIdx >= -1) { // Assuming payment confirmed once order is placed for tracking simplicity or based on payment_status
                document.getElementById('stepPaid').style.background = '#1a2a6c';
                document.getElementById('textPaid').style.color = '#1a2a6c';
            }
            if(statusIdx >= 1) {
                document.getElementById('stepShipped').style.background = '#1a2a6c';
                document.getElementById('textShipped').style.color = '#1a2a6c';
            }
            if(statusIdx >= 2) {
                document.getElementById('stepDelivered').style.background = '#1a2a6c';
                document.getElementById('textDelivered').style.color = '#1a2a6c';
            }

            document.getElementById('trackingModal').style.display = 'flex';
        }

        function openInvoiceModal(id, name, qty, total, date, method) {
            document.getElementById('invNumber').innerText = '#ORD-' + id;
            document.getElementById('invDate').innerText = date;
            document.getElementById('invProduct').innerText = name;
            document.getElementById('invQty').innerText = qty;
            document.getElementById('invTotal').innerText = '₹' + parseFloat(total).toLocaleString();
            document.getElementById('invGrandTotal').innerText = '₹' + parseFloat(total).toLocaleString();
            document.getElementById('invMethod').innerText = method.toUpperCase();
            document.getElementById('invoiceModal').style.display = 'flex';
        }

        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>
@endsection
