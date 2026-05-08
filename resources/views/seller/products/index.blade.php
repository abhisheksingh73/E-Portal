@extends('layouts.dashboard')

@section('title', 'My Textile Inventory')

@section('sidebar_links')
    <a href="{{ route('seller.dashboard') }}" class="nav-item">
        <i class="fas fa-chart-line"></i>
        <span>Dashboard</span>
    </a>
    <a href="{{ route('seller.products') }}" class="nav-item active">
        <i class="fas fa-boxes"></i>
        <span>My Inventory</span>
    </a>
    <a href="{{ route('seller.orders') }}" class="nav-item">
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
@endsection

@section('content')
    @if(session('success'))
        <div style="background: #ecfdf5; color: #059669; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-weight: 600; border: 1px solid #10b981;">
            <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
        </div>
    @endif

    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">My Inventory</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Manage your listed textiles and stock levels.</p>
        </div>
        <a href="{{ route('seller.products.create') }}" style="background: #1a2a6c; color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; cursor: pointer; text-decoration: none; box-shadow: 0 4px 12px rgba(26, 42, 108, 0.2); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <i class="fas fa-plus" style="margin-right: 8px;"></i> Add New Product
        </a>
    </div>

    <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 32px;">
        <div style="padding: 24px; border-bottom: 1px solid #f1f5f9; background: #fafbfc;">
            <form action="{{ route('seller.products') }}" method="GET" style="display: flex; gap: 16px;">
                <div style="flex: 1; position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by product name..." style="width: 100%; padding: 10px 10px 10px 40px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; font-size: 0.9rem;">
                </div>
                <select name="category" style="padding: 10px 16px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; background: white; font-size: 0.9rem; color: #64748b;">
                    <option value="">All Categories</option>
                    <option value="Silk" {{ request('category') == 'Silk' ? 'selected' : '' }}>Silk</option>
                    <option value="Cotton" {{ request('category') == 'Cotton' ? 'selected' : '' }}>Cotton</option>
                    <option value="Woolen" {{ request('category') == 'Woolen' ? 'selected' : '' }}>Woolen</option>
                    <option value="Linen" {{ request('category') == 'Linen' ? 'selected' : '' }}>Linen</option>
                    <option value="Embroidered" {{ request('category') == 'Embroidered' ? 'selected' : '' }}>Embroidered</option>
                    <option value="Hand-dyed" {{ request('category') == 'Hand-dyed' ? 'selected' : '' }}>Hand-dyed</option>
                </select>
                <button type="submit" style="background: white; border: 1px solid #1a2a6c; color: #1a2a6c; padding: 10px 20px; border-radius: 10px; font-weight: 600; cursor: pointer;">Apply Filters</button>
                @if(request()->has('search') || request()->has('category'))
                    <a href="{{ route('seller.products') }}" style="padding: 10px; color: #ef4444; text-decoration: none; display: flex; align-items: center;"><i class="fas fa-times-circle"></i></a>
                @endif
            </form>
        </div>

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; background: #f8fafc; border-bottom: 1px solid #f1f5f9;">
                    <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Product Details</th>
                    <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Price</th>
                    <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Category</th>
                    <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Status</th>
                    <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr style="border-bottom: 1px solid #f8fafc; transition: background 0.3s;" onmouseover="this.style.background='#fcfdff'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 20px 24px;">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 44px; height: 44px; border-radius: 10px; object-fit: cover; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                            @else
                                <div style="width: 44px; height: 44px; border-radius: 10px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #4338ca; font-weight: 700;">
                                    {{ strtoupper(substr($product->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div style="font-weight: 700; color: #1e293b;">{{ $product->name }}</div>
                                <div style="font-size: 0.8rem; color: #94a3b8;">ID: #TXN-{{ $product->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 20px 24px; font-weight: 700; color: #1a2a6c;">₹{{ number_format($product->price, 2) }}</td>
                    <td style="padding: 20px 24px; color: #64748b; font-weight: 500;">{{ $product->category }}</td>
                    <td style="padding: 20px 24px;">
                        <span style="padding: 4px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; 
                            {{ $product->status == 'active' ? 'background: #ecfdf5; color: #059669;' : ($product->status == 'pending' ? 'background: #fffbeb; color: #b45309;' : 'background: #fef2f2; color: #ef4444;') }}
                            text-transform: uppercase; border: 1px solid currentColor;">
                            {{ str_replace('_', ' ', $product->status) }}
                        </span>
                    </td>
                    <td style="padding: 20px 24px; text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 8px;">
                            <a href="{{ route('seller.products.edit', $product) }}" style="width: 32px; height: 32px; border-radius: 8px; border: 1px solid #e2e8f0; background: white; color: #4338ca; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#f5f7ff'" onmouseout="this.style.background='white'">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('seller.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this listing?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="width: 32px; height: 32px; border-radius: 8px; border: 1px solid #fee2e2; background: white; color: #ef4444; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='white'">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #64748b;">
                        <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.3;"></i>
                        <p>No textiles found matching your criteria.</p>
                        <a href="{{ route('seller.products.create') }}" style="color: #1a2a6c; font-weight: 700; text-decoration: none; margin-top: 8px; display: inline-block;">List your first product <i class="fas fa-arrow-right"></i></a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
