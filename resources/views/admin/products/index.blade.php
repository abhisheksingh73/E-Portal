@extends('layouts.dashboard')

@section('title', 'Textile Catalog')

@section('sidebar_links')
    <a href="{{ route('admin.dashboard') }}" class="nav-item">
        <i class="fas fa-chart-pie"></i>
        <span>Overview</span>
    </a>
    <a href="{{ route('admin.users') }}" class="nav-item">
        <i class="fas fa-users"></i>
        <span>User Management</span>
    </a>
    <a href="{{ route('admin.products') }}" class="nav-item active">
        <i class="fas fa-box"></i>
        <span>Textile Catalog</span>
    </a>
    <a href="{{ route('admin.orders') }}" class="nav-item">
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
    @if(session('success'))
        <div style="background: #ecfdf5; color: #059669; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-weight: 600; border: 1px solid #10b981;">
            <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
        </div>
    @endif

    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Textile Catalog</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Monitor and manage textile listings across the portal.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <form action="{{ route('admin.products') }}" method="GET" style="display: flex; gap: 12px;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." style="padding: 12px 16px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; width: 250px;">
                <select name="category" onchange="this.form.submit()" style="padding: 12px 16px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; background: white; cursor: pointer;">
                    <option value="">All Categories</option>
                    <option value="Silk" {{ request('category') == 'Silk' ? 'selected' : '' }}>Silk</option>
                    <option value="Cotton" {{ request('category') == 'Cotton' ? 'selected' : '' }}>Cotton</option>
                    <option value="Woolen" {{ request('category') == 'Woolen' ? 'selected' : '' }}>Woolen</option>
                    <option value="Hand-dyed" {{ request('category') == 'Hand-dyed' ? 'selected' : '' }}>Hand-dyed</option>
                    <option value="Ikat" {{ request('category') == 'Ikat' ? 'selected' : '' }}>Ikat</option>
                </select>
                @if(request()->has('search') || request()->has('category'))
                    <a href="{{ route('admin.products') }}" style="background: white; color: #ef4444; border: 1px solid #ef4444; padding: 12px; border-radius: 12px; display: flex; align-items: center;"><i class="fas fa-times"></i></a>
                @endif
            </form>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
        @forelse($products as $product)
        <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 20px rgba(0,0,0,0.05); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="height: 180px; background: #f1f5f9; position: relative; display: flex; align-items: center; justify-content: center; color: #cbd5e1; font-size: 3rem;">
                <div style="position: absolute; top: 12px; right: 12px; background: white; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; color: #4338ca; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    ₹{{ number_format($product->price) }}
                </div>
                @php
                    $categoryImages = [
                        'Silk' => 'https://images.unsplash.com/photo-1582298538104-fe2e74c27f59?auto=format&fit=crop&q=80&w=600',
                        'Cotton' => 'https://images.unsplash.com/photo-1596468138838-97d4989e4726?auto=format&fit=crop&q=80&w=600',
                        'Woolen' => 'https://images.unsplash.com/photo-1444312645910-ffa973656eba?auto=format&fit=crop&q=80&w=600',
                        'Hand-dyed' => 'https://images.unsplash.com/photo-1528642463367-12acd4974751?auto=format&fit=crop&q=80&w=600',
                    ];
                    $displayImage = $product->image ? asset('storage/' . $product->image) : ($categoryImages[$product->category] ?? 'https://images.unsplash.com/photo-1620783770629-1225728a6c32?auto=format&fit=crop&q=80&w=600');
                @endphp
                <img src="{{ $displayImage }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                <div style="position: absolute; top: 12px; left: 12px; background: rgba(26, 42, 108, 0.9); color: white; padding: 2px 10px; border-radius: 4px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; backdrop-filter: blur(4px);">{{ $product->category }}</div>
            </div>
            <div style="padding: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b;">{{ $product->name }}</h3>
                    <span style="background: {{ $product->status == 'active' ? '#ecfdf5' : '#fffbeb' }}; color: {{ $product->status == 'active' ? '#059669' : '#b45309' }}; font-size: 0.7rem; font-weight: 800; padding: 2px 8px; border-radius: 4px; text-transform: uppercase;">{{ $product->status }}</span>
                </div>
                <p style="color: #64748b; font-size: 0.85rem; margin-bottom: 16px; line-height: 1.5;">{{ Str::limit($product->description, 80) }}</p>
                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 16px; border-top: 1px solid #f1f5f9;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 24px; height: 24px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 0.6rem; font-weight: 700; color: #4338ca;">
                            {{ strtoupper(substr($product->seller->name ?? 'U', 0, 1)) }}
                        </div>
                        <span style="font-size: 0.8rem; font-weight: 600; color: #475569;">{{ $product->seller->name ?? 'Unknown' }}</span>
                    </div>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <button title="Quick View" onclick="showProductDetails({{ json_encode($product->name) }}, {{ json_encode($product->description) }}, {{ json_encode($product->price) }}, {{ json_encode($product->category) }}, {{ json_encode($product->seller->name ?? 'Unknown') }})" style="background: white; border: 1px solid #e2e8f0; color: #1a2a6c; width: 32px; height: 32px; border-radius: 6px; font-size: 0.85rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='white'">
                            <i class="fas fa-info-circle"></i>
                        </button>
                        @if($product->status == 'pending')
                            <form action="{{ route('admin.products.update', $product) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="name" value="{{ $product->name }}">
                                <input type="hidden" name="description" value="{{ $product->description }}">
                                <input type="hidden" name="price" value="{{ $product->price }}">
                                <input type="hidden" name="category" value="{{ $product->category }}">
                                <input type="hidden" name="status" value="active">
                                <button type="submit" style="background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 4px;">
                                    <i class="fas fa-check"></i> Approve
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Moderation: Are you sure you want to PERMANENTLY DELETE this product from the portal?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Moderation: Delete" style="background: #fef2f2; border: 1px solid #fee2e2; color: #ef4444; padding: 6px 10px; border-radius: 6px; font-size: 0.85rem; cursor: pointer;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 100px 0;">
            <i class="fas fa-box-open" style="font-size: 4rem; color: #e2e8f0; margin-bottom: 24px;"></i>
            <h2 style="color: #64748b; font-weight: 600;">No products found</h2>
            <p style="color: #94a3b8;">Try adjusting your search or filters.</p>
        </div>
        @endforelse
    </div>

    <!-- Product Details Modal -->
    <div id="productModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: white; width: 600px; border-radius: 24px; padding: 40px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative;">
            <button onclick="document.getElementById('productModal').style.display='none'" style="position: absolute; top: 24px; right: 24px; background: #f1f5f9; border: none; width: 36px; height: 36px; border-radius: 50%; color: #64748b; cursor: pointer;"><i class="fas fa-times"></i></button>
            <div id="modalProductCategory" style="font-size: 0.75rem; font-weight: 800; color: #4338ca; text-transform: uppercase; margin-bottom: 8px;"></div>
            <h2 id="modalProductName" style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-bottom: 16px;"></h2>
            <div style="display: flex; gap: 24px; margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid #f1f5f9;">
                <div>
                    <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 700; text-transform: uppercase;">Price</div>
                    <div id="modalProductPrice" style="font-size: 1.25rem; font-weight: 800; color: #1e293b;"></div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: #94a3b8; font-weight: 700; text-transform: uppercase;">Seller</div>
                    <div id="modalProductSeller" style="font-size: 1.25rem; font-weight: 800; color: #1e293b;"></div>
                </div>
            </div>
            <p id="modalProductDescription" style="color: #475569; line-height: 1.8; font-size: 1.05rem; margin-bottom: 32px;"></p>
            <button onclick="document.getElementById('productModal').style.display='none'" style="width: 100%; background: #1a2a6c; color: white; border: none; padding: 16px; border-radius: 12px; font-weight: 700; cursor: pointer;">Close Details</button>
        </div>
    </div>

    <script>
        function showProductDetails(name, description, price, category, seller) {
            document.getElementById('modalProductName').innerText = name;
            document.getElementById('modalProductDescription').innerText = description;
            document.getElementById('modalProductPrice').innerText = '₹' + new Intl.NumberFormat().format(price);
            document.getElementById('modalProductCategory').innerText = category;
            document.getElementById('modalProductSeller').innerText = seller;
            document.getElementById('productModal').style.display = 'flex';
        }
    </script>
@endsection
