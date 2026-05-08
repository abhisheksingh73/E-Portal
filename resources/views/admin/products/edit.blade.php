@extends('layouts.dashboard')

@section('title', 'Admin: Edit Product')

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
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Admin: Edit Listing</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Modifying listing: <b>{{ $product->name }}</b></p>
        </div>
        <a href="{{ route('admin.products') }}" style="color: #64748b; text-decoration: none; font-weight: 600;">
            <i class="fas fa-arrow-left"></i> Back to Catalog
        </a>
    </div>

    <div class="card" style="max-width: 800px; margin: 0 auto; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 40px;">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div style="display: grid; gap: 24px;">
                <div style="display: grid; gap: 8px;">
                    <label style="font-weight: 700; color: #1e293b;">Product Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;">
                    @error('name') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>

                <div style="display: grid; gap: 8px;">
                    <label style="font-weight: 700; color: #1e293b;">Product Image</label>
                    @if($product->image)
                        <div id="current-image-container" style="margin-bottom: 12px;">
                            <p style="font-size: 0.8rem; color: #64748b; margin-bottom: 8px;">Current Image:</p>
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 200px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        </div>
                    @endif
                    <div style="border: 2px dashed #e2e8f0; padding: 20px; border-radius: 12px; text-align: center; cursor: pointer; transition: border-color 0.3s;" onmouseover="this.style.borderColor='#1a2a6c'" onmouseout="this.style.borderColor='#e2e8f0'" onclick="document.getElementById('image-upload').click()">
                        <i class="fas fa-sync-alt" style="font-size: 2rem; color: #94a3b8; margin-bottom: 8px;"></i>
                        <p style="margin: 0; color: #64748b; font-size: 0.9rem;">Click to change image or drag and drop</p>
                        <p style="margin: 4px 0 0; color: #94a3b8; font-size: 0.8rem;">PNG, JPG, GIF up to 2MB</p>
                        <input type="file" id="image-upload" name="image" accept="image/*" style="display: none;" onchange="previewImage(this)">
                    </div>
                    <div id="image-preview-container" style="display: none; margin-top: 12px;">
                        <p style="font-size: 0.8rem; color: #64748b; margin-bottom: 8px;">New Image Preview:</p>
                        <img id="image-preview" src="#" alt="Preview" style="max-width: 200px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    </div>
                    @error('image') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
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
                            <option value="Hand-dyed" {{ $product->category == 'Hand-dyed' ? 'selected' : '' }}>Hand-dyed</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; gap: 8px;">
                    <label style="font-weight: 700; color: #1e293b;">Status Control</label>
                    <select name="status" required style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem; background: white;">
                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active / Approved</option>
                        <option value="pending" {{ $product->status == 'pending' ? 'selected' : '' }}>Pending Approval</option>
                        <option value="out_of_stock" {{ $product->status == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>

                <div style="display: grid; gap: 8px;">
                    <label style="font-weight: 700; color: #1e293b;">Description</label>
                    <textarea name="description" rows="4" required style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem; resize: none;">{{ $product->description }}</textarea>
                </div>

                <div style="padding-top: 16px;">
                    <button type="submit" style="width: 100%; padding: 14px; background: #1a2a6c; color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 1.1rem; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(26, 42, 108, 0.2);" onmouseover="this.style.background='#243b55'" onmouseout="this.style.background='#1a2a6c'">
                        Apply Administrative Changes
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            const container = document.getElementById('image-preview-container');
            const preview = document.getElementById('image-preview');
            const currentContainer = document.getElementById('current-image-container');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.style.display = 'block';
                    if (currentContainer) currentContainer.style.opacity = '0.5';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                container.style.display = 'none';
                if (currentContainer) currentContainer.style.opacity = '1';
            }
        }
    </script>
@endsection
