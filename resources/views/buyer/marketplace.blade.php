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
    <a href="{{ route('buyer.wishlist') }}" class="nav-item">
        <i class="fas fa-heart"></i>
        <span>Wishlist</span>
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
                    $displayImage = $product->image ?: ($categoryImages[$product->category] ?? 'https://images.unsplash.com/photo-1620783770629-1225728a6c32?auto=format&fit=crop&q=80&w=600');
                @endphp
                <img src="{{ $displayImage }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                <div style="position: absolute; top: 15px; left: 15px; background: rgba(26, 42, 108, 0.9); color: white; padding: 5px 15px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; backdrop-filter: blur(4px);">{{ $product->category }}</div>
                <button style="position: absolute; top: 15px; right: 15px; width: 40px; height: 40px; border-radius: 50%; border: none; background: white; color: #ef4444; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.1);"><i class="far fa-heart"></i></button>
            </div>
            <div style="padding: 24px;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 8px;">{{ $product->name }}</h3>
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 20px;">
                    <div style="width: 24px; height: 24px; border-radius: 50%; background: #eef2ff; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; color: #4338ca;">
                        {{ strtoupper(substr($product->seller->name ?? 'S', 0, 1)) }}
                    </div>
                    <span style="font-size: 0.85rem; color: #64748b; font-weight: 600;">{{ $product->seller->name ?? 'Premium Seller' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span style="font-size: 1.3rem; font-weight: 800; color: #1a2a6c;">₹{{ number_format($product->price) }}</span>
                    </div>
                    <button style="background: #1a2a6c; color: white; border: none; padding: 12px 20px; border-radius: 12px; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#243b55'" onmouseout="this.style.background='#1a2a6c'">Buy Now</button>
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
@endsection
