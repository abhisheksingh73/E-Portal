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
            <a href="{{ route('admin.products.create') }}" style="background: #1a2a6c; color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; text-decoration: none; display: flex; align-items: center; box-shadow: 0 4px 12px rgba(26, 42, 108, 0.2);">
                <i class="fas fa-plus" style="margin-right: 8px;"></i> Add Product
            </a>
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
                    $displayImage = $product->image ?: ($categoryImages[$product->category] ?? 'https://images.unsplash.com/photo-1620783770629-1225728a6c32?auto=format&fit=crop&q=80&w=600');
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
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('admin.products.edit', $product) }}" style="color: #94a3b8; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#4338ca'" onmouseout="this.style.color='#94a3b8'"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product permanently?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 0;"><i class="fas fa-trash"></i></button>
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

    <div style="margin-top: 40px; text-align: center;">
        <p style="color: #64748b; font-size: 0.9rem;">System monitoring enabled. All deletions are logged in the <a href="#" style="color: #1a2a6c; font-weight: 700; text-decoration: none;">Security Audit Trail</a></p>
    </div>
@endsection
