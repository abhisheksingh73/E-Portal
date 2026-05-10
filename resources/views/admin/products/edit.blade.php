@extends('layouts.dashboard')

@section('title', 'Edit Product')

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
@endsection

@section('content')
    <div style="max-width: 800px; margin: 0 auto;">
        <div class="header-flex" style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px;">
            <a href="{{ route('admin.products') }}" style="width: 44px; height: 44px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #1a2a6c; text-decoration: none; border: 1px solid #e2e8f0; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Edit <span style="color: #111827;">Product</span></h1>
                <p style="color: var(--text-muted);">Modify textile details for product ID: #{{ $product->id }}</p>
            </div>
        </div>

        <div class="card" style="border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.05); padding: 40px;">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" style="display: grid; gap: 24px;">
                @csrf
                @method('PUT')
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div style="display: grid; gap: 8px;">
                        <label style="font-size: 0.85rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required style="padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem;">
                    </div>
                    <div style="display: grid; gap: 8px;">
                        <label style="font-size: 0.85rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Category</label>
                        <select name="category" required style="padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem; background: white; cursor: pointer;">
                            @foreach(['Silk', 'Cotton', 'Woolen', 'Hand-dyed', 'Ikat'] as $cat)
                                <option value="{{ $cat }}" {{ $product->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div style="display: grid; gap: 8px;">
                        <label style="font-size: 0.85rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Price (₹)</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required style="padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem;">
                    </div>
                    <div style="display: grid; gap: 8px;">
                        <label style="font-size: 0.85rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Status</label>
                        <select name="status" required style="padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem; background: white; cursor: pointer;">
                            <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active (Visible to public)</option>
                            <option value="pending" {{ $product->status == 'pending' ? 'selected' : '' }}>Pending (Needs approval)</option>
                            <option value="out_of_stock" {{ $product->status == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; gap: 8px;">
                    <label style="font-size: 0.85rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Product Description</label>
                    <textarea name="description" required rows="5" style="padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem; resize: none; font-family: inherit;">{{ old('description', $product->description) }}</textarea>
                </div>

                <div style="display: grid; gap: 16px;">
                    <label style="font-size: 0.85rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Product Image</label>
                    <div style="display: flex; gap: 24px; align-items: start;">
                        @if($product->image)
                            <div style="width: 120px; height: 120px; border-radius: 16px; overflow: hidden; border: 2px solid #f1f5f9; flex-shrink: 0;">
                                <img src="{{ asset('storage/' . $product->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        @endif
                        <div style="flex: 1; border: 2px dashed #e2e8f0; padding: 24px; border-radius: 16px; text-align: center; position: relative; transition: all 0.2s;" onmouseover="this.style.borderColor='#1a2a6c'" onmouseout="this.style.borderColor='#e2e8f0'">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #cbd5e1; margin-bottom: 8px;"></i>
                            <div style="color: #64748b; font-size: 0.85rem;">Upload new image to replace</div>
                            <input type="file" name="image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                        </div>
                    </div>
                </div>

                <div style="margin-top: 12px; display: grid; gap: 16px;">
                    <button type="submit" style="width: 100%; background: #1a2a6c; color: white; border: none; padding: 18px; border-radius: 12px; font-weight: 800; font-size: 1.1rem; cursor: pointer; box-shadow: 0 10px 20px rgba(26, 42, 108, 0.2); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 30px rgba(26, 42, 108, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 20px rgba(26, 42, 108, 0.2)'">
                        Update Product Records
                    </button>
                    <div style="text-align: center; font-size: 0.85rem; color: #94a3b8;">
                        Owned by: <span style="color: #475569; font-weight: 700;">{{ $product->seller->name ?? 'Unknown Seller' }}</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
