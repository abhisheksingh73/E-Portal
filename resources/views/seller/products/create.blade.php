@extends('layouts.dashboard')

@section('title', 'List New Textile')

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
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">List New Textile</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Add a new handcrafted product to the marketplace.</p>
        </div>
        <a href="{{ route('seller.products') }}" style="color: #64748b; text-decoration: none; font-weight: 600;">
            <i class="fas fa-arrow-left"></i> Back to Inventory
        </a>
    </div>

    <div class="card" style="max-width: 800px; margin: 0 auto; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 40px;">
        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; gap: 24px;">
                <div style="background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #eef2ff; display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <div>
                        <h4 style="margin: 0; color: #1a2a6c; font-size: 0.95rem;">Promote this work</h4>
                        <p style="margin: 4px 0 0; font-size: 0.8rem; color: #64748b;">Featured products appear at the top of buyer recommendations.</p>
                    </div>
                    <label style="position: relative; display: inline-block; width: 50px; height: 26px;">
                        <input type="checkbox" name="is_featured" value="1" style="width: 20px; height: 20px; accent-color: #1a2a6c; cursor: pointer;">
                    </label>
                </div>

                <div style="display: grid; gap: 8px;">
                    <label style="font-weight: 700; color: #1e293b;">Product Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Hand-woven Banarasi Silk Saree" required style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;">
                    @error('name') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>

                <div style="display: grid; gap: 8px;">
                    <label style="font-weight: 700; color: #1e293b;">Product Image</label>
                    <div style="border: 2px dashed #e2e8f0; padding: 20px; border-radius: 12px; text-align: center; cursor: pointer; transition: border-color 0.3s;" onmouseover="this.style.borderColor='#1a2a6c'" onmouseout="this.style.borderColor='#e2e8f0'" onclick="document.getElementById('image-upload').click()">
                        <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #94a3b8; margin-bottom: 8px;"></i>
                        <p style="margin: 0; color: #64748b; font-size: 0.9rem;">Click to upload or drag and drop</p>
                        <p style="margin: 4px 0 0; color: #94a3b8; font-size: 0.8rem;">PNG, JPG, GIF up to 2MB</p>
                        <input type="file" id="image-upload" name="image" accept="image/*" style="display: none;" onchange="previewImage(this)">
                    </div>
                    <div id="image-preview-container" style="display: none; margin-top: 12px;">
                        <img id="image-preview" src="#" alt="Preview" style="max-width: 200px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    </div>
                    @error('image') <span style="color: #ef4444; font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div style="display: grid; gap: 8px;">
                        <label style="font-weight: 700; color: #1e293b;">Price (₹)</label>
                        <input type="number" name="price" placeholder="0.00" step="0.01" required style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem;">
                    </div>
                    <div style="display: grid; gap: 8px;">
                        <label style="font-weight: 700; color: #1e293b;">Category</label>
                        <select name="category" required style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem; background: white;">
                            <option value="Silk">Silk</option>
                            <option value="Cotton">Cotton</option>
                            <option value="Woolen">Woolen</option>
                            <option value="Linen">Linen</option>
                            <option value="Embroidered">Embroidered</option>
                            <option value="Hand-dyed">Hand-dyed</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; gap: 8px;">
                    <label style="font-weight: 700; color: #1e293b;">Description</label>
                    <textarea name="description" rows="5" placeholder="Describe the heritage, weave pattern, and material details..." required style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; font-size: 1rem; resize: none;"></textarea>
                </div>

                <div style="padding-top: 16px;">
                    <button type="submit" style="width: 100%; padding: 14px; background: #1a2a6c; color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 1.1rem; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 15px rgba(26, 42, 108, 0.2);" onmouseover="this.style.background='#243b55'" onmouseout="this.style.background='#1a2a6c'">
                        Publish to Marketplace
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            const container = document.getElementById('image-preview-container');
            const preview = document.getElementById('image-preview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                container.style.display = 'none';
            }
        }
    </script>
@endsection
