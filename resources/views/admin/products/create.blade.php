@extends('layouts.dashboard')

@section('title', 'Add New Product')

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
                <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Add Official <span style="color: #111827;">Product</span></h1>
                <p style="color: var(--text-muted);">List a new textile item in the national catalog.</p>
            </div>
        </div>

        <div class="card" style="border: none; box-shadow: 0 20px 40px rgba(0,0,0,0.05); padding: 40px;">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" style="display: grid; gap: 24px;">
                @csrf
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div style="display: grid; gap: 8px;">
                        <label style="font-size: 0.85rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Product Name</label>
                        <input type="text" name="name" required placeholder="e.g. Pure Banarasi Silk Saree" style="padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem;">
                    </div>
                    <div style="display: grid; gap: 8px;">
                        <label style="font-size: 0.85rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Category</label>
                        <select name="category" required style="padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem; background: white; cursor: pointer;">
                            <option value="Silk">Silk</option>
                            <option value="Cotton">Cotton</option>
                            <option value="Woolen">Woolen</option>
                            <option value="Hand-dyed">Hand-dyed</option>
                            <option value="Ikat">Ikat</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div style="display: grid; gap: 8px;">
                        <label style="font-size: 0.85rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Price (₹)</label>
                        <input type="number" name="price" required placeholder="0.00" style="padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem;">
                    </div>
                    <div style="display: grid; gap: 8px;">
                        <label style="font-size: 0.85rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Assigned Seller</label>
                        <select name="user_id" required style="padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem; background: white; cursor: pointer;">
                            @foreach($sellers as $seller)
                                <option value="{{ $seller->id }}">{{ $seller->name }} ({{ $seller->email }})</option>
                            @endforeach
                            @if(count($sellers) == 0)
                                <option value="{{ auth()->id() }}">Assign to Me (Admin)</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div style="display: grid; gap: 8px;">
                    <label style="font-size: 0.85rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Product Description</label>
                    <textarea name="description" required rows="5" placeholder="Describe the material, weave, and history of this piece..." style="padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem; resize: none; font-family: inherit;"></textarea>
                </div>

                <div style="display: grid; gap: 8px;">
                    <label style="font-size: 0.85rem; font-weight: 800; color: #64748b; text-transform: uppercase;">Product Image</label>
                    <div style="border: 2px dashed #e2e8f0; padding: 32px; border-radius: 16px; text-align: center; position: relative; transition: all 0.2s;" onmouseover="this.style.borderColor='#1a2a6c'" onmouseout="this.style.borderColor='#e2e8f0'">
                        <i class="fas fa-cloud-upload-alt" style="font-size: 2.5rem; color: #cbd5e1; margin-bottom: 12px;"></i>
                        <div style="color: #64748b; font-size: 0.9rem;">Click to select or drag and drop</div>
                        <input type="file" name="image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                    </div>
                </div>

                <div style="margin-top: 12px;">
                    <button type="submit" style="width: 100%; background: #1a2a6c; color: white; border: none; padding: 18px; border-radius: 12px; font-weight: 800; font-size: 1.1rem; cursor: pointer; box-shadow: 0 10px 20px rgba(26, 42, 108, 0.2); transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 30px rgba(26, 42, 108, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 20px rgba(26, 42, 108, 0.2)'">
                        Publish to National Catalog
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
