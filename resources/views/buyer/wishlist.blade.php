@extends('layouts.dashboard')

@section('title', 'My Wishlist')

@section('sidebar_links')
    <a href="{{ route('buyer.dashboard') }}" class="nav-item">
        <i class="fas fa-home"></i>
        <span>My Home</span>
    </a>
    <a href="{{ route('buyer.marketplace') }}" class="nav-item">
        <i class="fas fa-shopping-bag"></i>
        <span>Marketplace</span>
    </a>
    <a href="{{ route('buyer.orders') }}" class="nav-item">
        <i class="fas fa-history"></i>
        <span>My Orders</span>
    </a>
    <a href="{{ route('buyer.cart') }}" class="nav-item">
        <i class="fas fa-shopping-cart"></i>
        <span>Shopping Cart</span>
    </a>
    <a href="{{ route('buyer.wishlist') }}" class="nav-item active">
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
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">My Wishlist</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">You have {{ $wishlistItems->count() }} items saved in your collection.</p>
        </div>
        <a href="{{ route('buyer.marketplace') }}" style="background: #1a2a6c; color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; cursor: pointer; text-decoration: none;">
            <i class="fas fa-shopping-bag" style="margin-right: 8px;"></i> Continue Shopping
        </a>
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
                    <th style="padding: 16px 32px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Product</th>
                    <th style="padding: 16px 32px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Price</th>
                    <th style="padding: 16px 32px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Availability</th>
                    <th style="padding: 16px 32px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($wishlistItems as $item)
                <tr style="border-bottom: 1px solid #f8fafc; transition: background 0.3s;" onmouseover="this.style.background='#fcfdff'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 24px 32px;">
                        <div style="display: flex; align-items: center; gap: 20px;">
                            <div style="width: 70px; height: 70px; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <i class="fas fa-image" style="font-size: 1.5rem; color: #cbd5e1;"></i>
                                @endif
                            </div>
                            <div>
                                <div style="font-weight: 700; font-size: 1rem; color: #1e293b;">{{ $item->product->name }}</div>
                                <div style="font-size: 0.85rem; color: #94a3b8;">{{ $item->product->category }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 24px 32px; font-weight: 800; color: #1a2a6c; font-size: 1.1rem;">₹{{ number_format($item->product->price) }}</td>
                    <td style="padding: 24px 32px;">
                        <div style="display: flex; align-items: center; gap: 8px; color: #059669; font-weight: 700; font-size: 0.85rem;">
                            <i class="fas fa-check-circle"></i> IN STOCK
                        </div>
                    </td>
                    <td style="padding: 24px 32px; text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 12px;">
                            <form action="{{ route('buyer.cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" style="background: #1a2a6c; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer;">Add to Cart</button>
                            </form>
                            <form action="{{ route('buyer.wishlist.destroy', $item) }}" method="POST" onsubmit="return confirm('Remove this item from your wishlist?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: 1px solid #fee2e2; color: #ef4444; width: 40px; height: 40px; border-radius: 8px; cursor: pointer;"><i class="far fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 60px; text-align: center; color: #94a3b8;">
                        <i class="fas fa-heart-broken" style="font-size: 4rem; margin-bottom: 24px; opacity: 0.2;"></i>
                        <p>Your wishlist is currently empty.</p>
                        <a href="{{ route('buyer.marketplace') }}" style="color: #1a2a6c; font-weight: 700; text-decoration: none; margin-top: 12px; display: inline-block;">Discover Treasures <i class="fas fa-arrow-right"></i></a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Checkout Modal (Reused from Marketplace) -->
    <div id="checkoutModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: white; width: 500px; border-radius: 24px; padding: 40px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative; border: 1px solid rgba(255,255,255,0.1);">
            <button onclick="document.getElementById('checkoutModal').style.display='none'" style="position: absolute; top: 24px; right: 24px; background: #f1f5f9; border: none; width: 36px; height: 36px; border-radius: 50%; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center;"><i class="fas fa-times"></i></button>
            <div style="margin-bottom: 32px;">
                <h2 style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-bottom: 8px;">Complete Your Purchase</h2>
                <p style="color: #64748b; font-size: 1rem;" id="checkoutProductName"></p>
            </div>
            <form action="{{ route('buyer.orders.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" id="checkoutProductId">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                    <div>
                        <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 10px; font-size: 0.9rem;">Quantity</label>
                        <div style="display: flex; align-items: center; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; height: 48px;">
                            <button type="button" onclick="updateQty(-1)" style="flex: 1; height: 100%; border: none; background: #f8fafc; color: #1a2a6c; cursor: pointer; font-weight: 800;">-</button>
                            <input type="number" name="quantity" id="checkoutQty" value="1" min="1" readonly style="width: 50px; text-align: center; border: none; font-weight: 700; font-size: 1.1rem; outline: none;">
                            <button type="button" onclick="updateQty(1)" style="flex: 1; height: 100%; border: none; background: #f8fafc; color: #1a2a6c; cursor: pointer; font-weight: 800;">+</button>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; justify-content: center; text-align: right;">
                        <span style="font-size: 0.85rem; color: #94a3b8; font-weight: 600;">Total Price</span>
                        <span style="font-size: 1.5rem; font-weight: 800; color: #1a2a6c;" id="checkoutTotalPrice">₹0</span>
                    </div>
                </div>
                <div style="margin-bottom: 32px;">
                    <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 10px; font-size: 0.9rem;">Shipping Address</label>
                    <textarea name="shipping_address" required rows="4" placeholder="Enter your full street address..." style="width: 100%; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-family: inherit; font-size: 0.95rem; resize: none;">{{ auth()->user()->address }}</textarea>
                </div>
                <button type="submit" style="width: 100%; background: #1a2a6c; color: white; border: none; padding: 18px; border-radius: 14px; font-weight: 800; cursor: pointer; font-size: 1.1rem; transition: all 0.3s;">Place Order Now</button>
            </form>
        </div>
    </div>

    <script>
        let currentProductPrice = 0;

        function openCheckoutModal(id, name, price) {
            currentProductPrice = parseFloat(price);
            document.getElementById('checkoutProductId').value = id;
            document.getElementById('checkoutProductName').innerText = name;
            document.getElementById('checkoutQty').value = 1;
            updateTotalDisplay();
            document.getElementById('checkoutModal').style.display = 'flex';
        }

        function updateQty(delta) {
            const qtyInput = document.getElementById('checkoutQty');
            let newQty = parseInt(qtyInput.value) + delta;
            if (newQty < 1) newQty = 1;
            qtyInput.value = newQty;
            updateTotalDisplay();
        }

        function updateTotalDisplay() {
            const qty = parseInt(document.getElementById('checkoutQty').value);
            const total = qty * currentProductPrice;
            document.getElementById('checkoutTotalPrice').innerText = '₹' + total.toLocaleString();
        }
    </script>
@endsection
