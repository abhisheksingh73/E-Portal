@extends('layouts.dashboard')

@section('title', 'Edit Textile Listing')

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
    <a href="{{ route('seller.settings') }}" class="nav-item">
        <i class="fas fa-store"></i>
        <span>Shop Settings</span>
    </a>
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Edit Listing</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Update details for: <b>{{ $product->name }}</b></p>
        </div>
        <a href="{{ route('seller.products') }}" style="color: #64748b; text-decoration: none; font-weight: 600;">
            <i class="fas fa-arrow-left"></i> Back to Inventory
        </a>
    </div>

    <div class="card" style="max-width: 800px; margin: 0 auto; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 40px;">
        <form action="{{ route('seller.products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="display: grid; gap: 24px;">
                <div style="display: grid; gap: 8px;">
                    <label style="font-weight: 700; color: #1e293b;">Product Name</label>
                    <input type="text" name="name" value="{{ $product->name }}" required style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div style="display: grid; gap: 8px;">
                        <label style="font-weight: 700; color: #1e293b;">Price (₹)</label>
                        <input type="number" name="price" value="{{ $product->price }}" step="0.01" required style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;">
                    </div>
                    <div style="display: grid; gap: 8px;">
                        <label style="font-weight: 700; color: #1e293b;">Category</label>
                        <select name="category" required style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem; background: white;">
                            <option value="Silk" {{ $product->category == 'Silk' ? 'selected' : '' }}>Silk</option>
                            <option value="Cotton" {{ $product->category == 'Cotton' ? 'selected' : '' }}>Cotton</option>
                            <option value="Woolen" {{ $product->category == 'Woolen' ? 'selected' : '' }}>Woolen</option>
                            <option value="Linen" {{ $product->category == 'Linen' ? 'selected' : '' }}>Linen</option>
                            <option value="Embroidered" {{ $product->category == 'Embroidered' ? 'selected' : '' }}>Embroidered</option>
                            <option value="Hand-dyed" {{ $product->category == 'Hand-dyed' ? 'selected' : '' }}>Hand-dyed</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; gap: 8px;">
                    <label style="font-weight: 700; color: #1e293b;">Inventory Status</label>
                    <select name="status" required style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem; background: white;">
                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active / In Stock</option>
                        <option value="out_of_stock" {{ $product->status == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                        <option value="pending" {{ $product->status == 'pending' ? 'selected' : '' }}>Under Review</option>
                    </select>
                </div>

                <div style="display: grid; gap: 8px;">
                    <label style="font-weight: 700; color: #1e293b;">Description</label>
                    <textarea name="description" rows="5" required style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem; resize: none;">{{ $product->description }}</textarea>
                </div>

                <div style="padding-top: 16px;">
                    <button type="submit" style="width: 100%; padding: 14px; background: #1a2a6c; color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 1.1rem; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(26, 42, 108, 0.2);" onmouseover="this.style.background='#243b55'" onmouseout="this.style.background='#1a2a6c'">
                        Update Listing
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
