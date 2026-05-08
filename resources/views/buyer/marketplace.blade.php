@extends('layouts.dashboard')

@section('title', 'Textile Marketplace')

@section('sidebar_links')
    <a href="{{ route('buyer.dashboard') }}" class="nav-item">
        <i class="fas fa-home"></i>
        <span>My Home</span>
    </a>
    <a href="{{ route('buyer.marketplace') }}" class="nav-item active">
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
            <h1 style="font-size: 2.2rem; font-weight: 800; color: #1a2a6c;">Heritage Marketplace</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Discover authentic hand-woven textiles from across the country.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <form action="{{ route('buyer.marketplace') }}" method="GET" style="display: flex; gap: 12px;">
                <div style="position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search heritage weaves..." style="padding: 12px 12px 12px 40px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; width: 300px; font-size: 0.95rem;">
                </div>
                <select name="category" onchange="this.form.submit()" style="padding: 12px 16px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; background: white; cursor: pointer; color: #64748b; font-weight: 600;">
                    <option value="">All Categories</option>
                    <option value="Silk" {{ request('category') == 'Silk' ? 'selected' : '' }}>Silk</option>
                    <option value="Cotton" {{ request('category') == 'Cotton' ? 'selected' : '' }}>Cotton</option>
                    <option value="Woolen" {{ request('category') == 'Woolen' ? 'selected' : '' }}>Woolen</option>
                    <option value="Hand-dyed" {{ request('category') == 'Hand-dyed' ? 'selected' : '' }}>Hand-dyed</option>
                </select>
                @if(request()->has('search') || request()->has('category'))
                    <a href="{{ route('buyer.marketplace') }}" style="background: white; color: #ef4444; border: 1px solid #ef4444; padding: 12px; border-radius: 12px; display: flex; align-items: center; text-decoration: none;"><i class="fas fa-times"></i></a>
                @endif
            </form>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 32px;">
        @forelse($products as $product)
        <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="height: 220px; background: #f8fafc; position: relative; display: flex; align-items: center; justify-content: center; color: #cbd5e1; font-size: 4rem;">
                @php
                    $categoryImages = [
                        'Silk' => 'https://images.unsplash.com/photo-1582298538104-fe2e74c27f59?auto=format&fit=crop&q=80&w=600',
                        'Cotton' => 'https://images.unsplash.com/photo-1596468138838-97d4989e4726?auto=format&fit=crop&q=80&w=600',
                        'Woolen' => 'https://images.unsplash.com/photo-1444312645910-ffa973656eba?auto=format&fit=crop&q=80&w=600',
                        'Hand-dyed' => 'https://images.unsplash.com/photo-1528642463367-12acd4974751?auto=format&fit=crop&q=80&w=600',
                    ];
                    $displayImage = $product->image ? asset('storage/' . $product->image) : ($categoryImages[$product->category] ?? 'https://images.unsplash.com/photo-1620783770629-1225728a6c32?auto=format&fit=crop&q=80&w=600');
                @endphp
                <img src="{{ $displayImage }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                <div style="position: absolute; top: 15px; left: 15px; background: rgba(26, 42, 108, 0.9); color: white; padding: 5px 15px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; backdrop-filter: blur(4px);">{{ $product->category }}</div>
                <form action="{{ route('buyer.wishlist.toggle') }}" method="POST" style="position: absolute; top: 15px; right: 15px; z-index: 10;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    @php
                        $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                    @endphp
                    <button type="submit" style="width: 40px; height: 40px; border-radius: 50%; border: none; background: white; color: #ef4444; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="{{ $inWishlist ? 'fas' : 'far' }} fa-heart"></i>
                    </button>
                </form>
            </div>
            <div style="padding: 24px;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 8px;">{{ $product->name }}</h3>
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 20px;">
                    <div style="width: 24px; height: 24px; border-radius: 50%; background: #eef2ff; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; color: #4338ca;">
                        {{ strtoupper(substr($product->seller->name ?? 'S', 0, 1)) }}
                    </div>
                    <span style="font-size: 0.85rem; color: #64748b; font-weight: 600;">{{ $product->seller->name ?? 'Premium Seller' }}</span>
                </div>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <span style="font-size: 1.4rem; font-weight: 800; color: #1a2a6c;">₹{{ number_format($product->price) }}</span>
                        <span style="font-size: 0.8rem; color: #94a3b8; font-weight: 600;">Excl. Shipping</span>
                    </div>
                    
                    <div style="margin-bottom: 15px;">
                        <form action="{{ route('buyer.cart.add') }}" method="POST" style="display: flex; gap: 8px;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="number" name="quantity" value="1" min="1" style="width: 60px; padding: 10px; border-radius: 10px; border: 1px solid #e2e8f0; font-weight: 700; text-align: center;">
                            <button type="submit" style="flex: 1; background: #f8fafc; color: #1a2a6c; border: 1.5px solid #1a2a6c; padding: 12px; border-radius: 12px; font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 6px;" onmouseover="this.style.background='#eef2ff'" onmouseout="this.style.background='#f8fafc'">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                    
                    <button onclick="openCheckoutModal('{{ $product->id }}', '{{ $product->name }}', '{{ $product->price }}')" style="width: 100%; background: #1a2a6c; color: white; border: none; padding: 14px; border-radius: 12px; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 12px;" onmouseover="this.style.background='#243b55'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#1a2a6c'; this.style.transform='translateY(0)'">
                        <i class="fas fa-bolt"></i> Buy It Now
                    </button>
                    
                    <button onclick="openContactModal('{{ $product->user_id }}', '{{ $product->id }}', '{{ $product->name }}')" style="background: white; color: #64748b; border: 1px solid #e2e8f0; padding: 10px; border-radius: 12px; font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 6px;" onmouseover="this.style.borderColor='#1a2a6c'; this.style.color='#1a2a6c'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='#64748b'">
                        <i class="far fa-comment-dots"></i> Contact Seller
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 100px 0;">
            <i class="fas fa-search" style="font-size: 4rem; color: #e2e8f0; margin-bottom: 24px;"></i>
            <h2 style="color: #64748b; font-weight: 600;">No textiles match your search</h2>
            <p style="color: #94a3b8;">Try different keywords or categories.</p>
        </div>
        @endforelse
    </div>

    <!-- Checkout Modal -->
    <div id="checkoutModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: white; width: 500px; border-radius: 24px; padding: 40px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative; border: 1px solid rgba(255,255,255,0.1);">
            <button onclick="document.getElementById('checkoutModal').style.display='none'" style="position: absolute; top: 24px; right: 24px; background: #f1f5f9; border: none; width: 36px; height: 36px; border-radius: 50%; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='#e2e8f0'; this.style.color='#1e293b'" onmouseout="this.style.background='#f1f5f9'; this.style.color='#64748b'">
                <i class="fas fa-times"></i>
            </button>
            
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
                    <textarea name="shipping_address" required rows="4" placeholder="Enter your full street address, city, and state..." style="width: 100%; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-family: inherit; font-size: 0.95rem; transition: border-color 0.2s; resize: none;" onfocus="this.style.borderColor='#1a2a6c'"></textarea>
                </div>

                <button type="submit" style="width: 100%; background: #1a2a6c; color: white; border: none; padding: 18px; border-radius: 14px; font-weight: 800; cursor: pointer; font-size: 1.1rem; box-shadow: 0 10px 15px -3px rgba(26, 42, 108, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 20px 25px -5px rgba(26, 42, 108, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 15px -3px rgba(26, 42, 108, 0.3)'">
                    Place Order Now
                </button>
            </form>
        </div>
    </div>

    <!-- Contact Seller Modal -->
    <div id="contactModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: white; width: 450px; border-radius: 24px; padding: 32px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h2 style="font-size: 1.5rem; font-weight: 800; color: #1a2a6c;">Inquiry for <span id="modalProductName"></span></h2>
                <button onclick="document.getElementById('contactModal').style.display='none'" style="background: none; border: none; font-size: 1.5rem; color: #94a3b8; cursor: pointer;"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('buyer.contact.store') }}" method="POST">
                @csrf
                <input type="hidden" name="seller_id" id="modalSellerId">
                <input type="hidden" name="product_id" id="modalProductId">
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Your Message</label>
                    <textarea name="message" required rows="5" placeholder="Ask about fabric quality, bulk orders, or shipping..." style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-family: inherit; resize: none;"></textarea>
                </div>
                <button type="submit" style="width: 100%; background: #1a2a6c; color: white; border: none; padding: 14px; border-radius: 12px; font-weight: 700; cursor: pointer; font-size: 1rem;">Send Inquiry</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div style="position: fixed; bottom: 24px; right: 24px; background: #ecfdf5; color: #059669; padding: 16px 24px; border-radius: 12px; font-weight: 600; box-shadow: 0 10px 20px rgba(0,0,0,0.1); z-index: 1001; animation: slideIn 0.3s ease-out;">
            <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="position: fixed; bottom: 24px; right: 24px; background: #fef2f2; color: #ef4444; padding: 16px 24px; border-radius: 12px; font-weight: 600; box-shadow: 0 10px 20px rgba(0,0,0,0.1); z-index: 1001;">
            <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i> {{ $errors->first() }}
        </div>
    @endif

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

        function openContactModal(sellerId, productId, productName) {
            document.getElementById('modalSellerId').value = sellerId;
            document.getElementById('modalProductId').value = productId;
            document.getElementById('modalProductName').innerText = productName;
            document.getElementById('contactModal').style.display = 'flex';
        }

        @if(session('success') || $errors->any())
            setTimeout(() => {
                const alert = document.querySelector('[style*="position: fixed; bottom: 24px"]');
                if(alert) alert.style.opacity = '0';
            }, 5000);
        @endif
    </script>

    <style>
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .nav-item.active { background: #eef2ff; color: #1a2a6c; }
    </style>
@endsection
