@extends('layouts.dashboard')

@section('title', 'Shopping Cart')

@section('sidebar_links')
    <a href="{{ route('buyer.dashboard') }}" class="nav-item">
        <i class="fas fa-home"></i>
        <span>My Home</span>
    </a>
    <a href="{{ route('buyer.marketplace') }}" class="nav-item">
        <i class="fas fa-shopping-bag"></i>
        <span>Marketplace</span>
    </a>
    <a href="{{ route('buyer.cart') }}" class="nav-item active">
        <i class="fas fa-shopping-cart"></i>
        <span>Shopping Cart</span>
    </a>
    <a href="{{ route('buyer.orders') }}" class="nav-item">
        <i class="fas fa-history"></i>
        <span>My Orders</span>
    </a>
    <a href="{{ route('buyer.wishlist') }}" class="nav-item">
        <i class="fas fa-heart"></i>
        <span>Wishlist</span>
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
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Shopping Cart</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Review your items and proceed to bulk checkout.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('buyer.marketplace') }}" style="background: white; color: #1a2a6c; border: 1.5px solid #1a2a6c; padding: 12px 24px; border-radius: 12px; font-weight: 600; text-decoration: none;">
                <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Continue Shopping
            </a>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; color: #059669; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-weight: 600; border: 1px solid #10b981;">
            <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fef2f2; color: #ef4444; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-weight: 600; border: 1px solid #ef4444;">
            <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i> {{ session('error') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px; align-items: start;">
        <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; background: #f8fafc; border-bottom: 1px solid #f1f5f9;">
                        <th style="padding: 16px 32px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Product</th>
                        <th style="padding: 16px 32px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Price</th>
                        <th style="padding: 16px 32px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Quantity</th>
                        <th style="padding: 16px 32px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700; text-align: center;">Total</th>
                        <th style="padding: 16px 32px; text-align: center;"></th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @forelse($cartItems as $item)
                    @php $grandTotal += $item->product->price * $item->quantity; @endphp
                    <tr style="border-bottom: 1px solid #f8fafc;">
                        <td style="padding: 24px 32px;">
                            <div style="display: flex; align-items: center; gap: 20px;">
                                <div style="width: 70px; height: 70px; background: #f1f5f9; border-radius: 12px; overflow: hidden;">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="fas fa-image" style="font-size: 1.5rem; color: #cbd5e1; display: flex; align-items: center; justify-content: center; height: 100%;"></i>
                                    @endif
                                </div>
                                <div>
                                    <div style="font-weight: 700; font-size: 1rem; color: #1e293b;">{{ $item->product->name }}</div>
                                    <div style="font-size: 0.85rem; color: #94a3b8;">{{ $item->product->category }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 24px 32px; font-weight: 600; color: #1e293b;">₹{{ number_format($item->product->price) }}</td>
                        <td style="padding: 24px 32px;">
                            <form action="{{ route('buyer.cart.update', $item) }}" method="POST" style="display: flex; align-items: center; border: 1px solid #e2e8f0; border-radius: 8px; width: fit-content; overflow: hidden;">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" onchange="this.form.submit()" style="width: 50px; padding: 8px; border: none; text-align: center; font-weight: 700; outline: none;">
                            </form>
                        </td>
                        <td style="padding: 24px 32px; font-weight: 800; color: #1a2a6c; text-align: center;">₹{{ number_format($item->product->price * $item->quantity) }}</td>
                        <td style="padding: 24px 32px; text-align: center;">
                            <form action="{{ route('buyer.wishlist.toggle') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                <button type="submit" style="background: none; border: none; color: #cbd5e1; cursor: pointer; font-size: 1rem; margin-right: 12px;" title="Move to Wishlist"><i class="far fa-heart"></i></button>
                            </form>
                            <form action="{{ route('buyer.cart.destroy', $item) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1rem;"><i class="far fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 80px; text-align: center; color: #94a3b8;">
                            <i class="fas fa-shopping-basket" style="font-size: 4rem; margin-bottom: 24px; opacity: 0.2;"></i>
                            <p>Your shopping cart is empty.</p>
                            <a href="{{ route('buyer.marketplace') }}" style="color: #1a2a6c; font-weight: 700; text-decoration: none; margin-top: 12px; display: inline-block;">Start Shopping <i class="fas fa-arrow-right"></i></a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="display: grid; gap: 24px;">
            <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 32px;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #1a2a6c; margin-bottom: 24px;">Order Summary</h3>
                <div style="display: grid; gap: 16px; margin-bottom: 24px;">
                    <div style="display: flex; justify-content: space-between; color: #64748b; font-weight: 600;">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($grandTotal) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; color: #64748b; font-weight: 600;">
                        <span>Estimated Shipping</span>
                        <span style="color: #059669;">FREE</span>
                    </div>
                    <div style="height: 1px; background: #f1f5f9; margin: 8px 0;"></div>
                    <div style="display: flex; justify-content: space-between; color: #1a2a6c; font-size: 1.4rem; font-weight: 800;">
                        <span>Total</span>
                        <span>₹{{ number_format($grandTotal) }}</span>
                    </div>
                </div>

                @if($cartItems->isNotEmpty())
                <form action="{{ route('buyer.cart.checkout') }}" method="POST">
                    @csrf
                    
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 12px; font-size: 0.9rem;">Shipping Address</label>
                        
                        <div style="display: flex; gap: 12px; margin-bottom: 12px;">
                            <label style="flex: 1; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; text-align: center; font-size: 0.8rem; font-weight: 700;" id="labelSaved" onclick="toggleAddress('saved')">
                                <input type="radio" name="address_type" value="saved" checked style="display: none;"> Saved Address
                            </label>
                            <label style="flex: 1; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; text-align: center; font-size: 0.8rem; font-weight: 700;" id="labelNew" onclick="toggleAddress('new')">
                                <input type="radio" name="address_type" value="new" style="display: none;"> New Address
                            </label>
                        </div>

                        <textarea name="shipping_address" id="addressInput" required rows="3" placeholder="Enter full delivery address..." style="width: 100%; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-family: inherit; font-size: 0.95rem; resize: none; transition: all 0.3s;">{{ auth()->user()->address }}</textarea>
                        
                        @error('shipping_address')
                            <div style="color: #ef4444; font-size: 0.8rem; font-weight: 700; margin-top: 8px;">
                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <script>
                        const savedAddr = `{{ auth()->user()->address }}`;
                        function toggleAddress(type) {
                            const input = document.getElementById('addressInput');
                            const lSaved = document.getElementById('labelSaved');
                            const lNew = document.getElementById('labelNew');
                            
                            if(type === 'saved') {
                                input.value = savedAddr;
                                input.readOnly = true;
                                input.style.background = '#f8fafc';
                                lSaved.style.borderColor = '#1a2a6c'; lSaved.style.background = '#eef2ff';
                                lNew.style.borderColor = '#e2e8f0'; lNew.style.background = 'white';
                            } else {
                                input.value = '';
                                input.readOnly = false;
                                input.style.background = 'white';
                                input.focus();
                                lNew.style.borderColor = '#1a2a6c'; lNew.style.background = '#eef2ff';
                                lSaved.style.borderColor = '#e2e8f0'; lSaved.style.background = 'white';
                            }
                        }
                        // Init
                        toggleAddress('saved');
                    </script>

                    <div style="margin-bottom: 32px;">
                        <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 12px; font-size: 0.9rem;">Payment Method</label>
                        <div style="display: grid; gap: 12px;">
                            <label style="display: flex; align-items: center; gap: 12px; padding: 16px; border: 2px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.3s;" class="pay-method" onclick="selectMethod(this)">
                                <input type="radio" name="payment_method" value="cod" checked style="accent-color: #1a2a6c; width: 20px; height: 20px;">
                                <div>
                                    <div style="font-weight: 700; color: #1e293b;">Cash on Delivery (COD)</div>
                                    <div style="font-size: 0.8rem; color: #64748b;">Pay when you receive the package</div>
                                </div>
                            </label>
                            <label style="display: flex; align-items: center; gap: 12px; padding: 16px; border: 2px solid #e2e8f0; border-radius: 12px; cursor: pointer; transition: all 0.3s;" class="pay-method" onclick="selectMethod(this)">
                                <input type="radio" name="payment_method" value="online" style="accent-color: #1a2a6c; width: 20px; height: 20px;">
                                <div>
                                    <div style="font-weight: 700; color: #1e293b;">Online Payment</div>
                                    <div style="font-size: 0.8rem; color: #64748b;">Credit/Debit Card, UPI, Net Banking</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" style="width: 100%; background: #1a2a6c; color: white; border: none; padding: 18px; border-radius: 14px; font-weight: 800; cursor: pointer; font-size: 1.1rem; box-shadow: 0 10px 15px -3px rgba(26, 42, 108, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                        Secure Checkout
                    </button>
                </form>

                <script>
                    function selectMethod(el) {
                        document.querySelectorAll('.pay-method').forEach(m => m.style.borderColor = '#e2e8f0');
                        el.style.borderColor = '#1a2a6c';
                        el.querySelector('input').checked = true;
                    }
                    // Initialize first one
                    document.querySelector('.pay-method').style.borderColor = '#1a2a6c';
                </script>
                @else
                <button disabled style="width: 100%; background: #cbd5e1; color: white; border: none; padding: 18px; border-radius: 14px; font-weight: 800; cursor: not-allowed;">
                    Cart is Empty
                </button>
                @endif
            </div>

            <div style="text-align: center; color: #94a3b8; font-size: 0.85rem;">
                <i class="fas fa-lock" style="margin-right: 5px;"></i> SSL Secure Payment
            </div>
        </div>
    </div>
@endsection
