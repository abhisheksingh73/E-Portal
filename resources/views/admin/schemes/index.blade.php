@extends('layouts.dashboard')

@section('title', 'Government Schemes')

@section('sidebar_links')
    <a href="{{ route('admin.dashboard') }}" class="nav-item">
        <i class="fas fa-chart-pie"></i>
        <span>Overview</span>
    </a>
    <a href="{{ route('admin.users') }}" class="nav-item">
        <i class="fas fa-users"></i>
        <span>User Management</span>
    </a>
    <a href="{{ route('admin.products') }}" class="nav-item">
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
    <a href="{{ route('admin.schemes') }}" class="nav-item active">
        <i class="fas fa-file-invoice"></i>
        <span>Govt Schemes</span>
    </a>
    <a href="{{ route('admin.articles') }}" class="nav-item">
        <i class="fas fa-bullhorn"></i>
        <span>Marketing Content</span>
    </a>
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Government Schemes</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Post and manage Ministry initiatives for weavers and businesses.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.schemes.applications') }}" style="background: #f1f5f9; color: #1a2a6c; text-decoration: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-inbox"></i> View Applications
            </a>
            <button onclick="document.getElementById('addSchemeModal').style.display='flex'" style="background: #1a2a6c; color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 12px rgba(26, 42, 108, 0.2);">
                <i class="fas fa-plus" style="margin-right: 8px;"></i> Add New Scheme
            </button>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; color: #059669; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-weight: 600;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 24px;">
        @forelse($schemes as $scheme)
        <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            @if($scheme->image)
                <img src="{{ asset('storage/' . $scheme->image) }}" style="width: 100%; height: 200px; object-fit: cover;">
            @else
                <div style="width: 100%; height: 200px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                    <i class="fas fa-file-invoice" style="font-size: 3rem;"></i>
                </div>
            @endif
            <div style="padding: 24px;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 12px;">{{ $scheme->title }}</h3>
                <p style="color: var(--text-muted); line-height: 1.6; font-size: 0.95rem; margin-bottom: 20px;">{{ Str::limit($scheme->description, 150) }}</p>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="padding: 4px 12px; background: #ecfdf5; color: #059669; border-radius: 50px; font-size: 0.75rem; font-weight: 700;">{{ strtoupper($scheme->status) }}</span>
                    <div style="display: flex; gap: 8px;">
                        <button onclick="editScheme({{ $scheme }})" style="background: none; border: 1px solid #e2e8f0; color: var(--text-dark); padding: 8px 16px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='none'">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('admin.schemes.destroy', $scheme) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this scheme?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #fef2f2; border: 1px solid #fee2e2; color: #ef4444; padding: 8px 12px; border-radius: 8px; font-size: 0.85rem; cursor: pointer;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px; background: white; border-radius: 20px;">
            <i class="fas fa-folder-open" style="font-size: 3rem; color: #e2e8f0; margin-bottom: 16px;"></i>
            <h3 style="color: #64748b;">No schemes posted yet.</h3>
        </div>
        @endforelse
    </div>

    <!-- Add Scheme Modal -->
    <div id="addSchemeModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        <div style="background: white; width: 500px; border-radius: 20px; padding: 32px; box-shadow: 0 20px 50px rgba(0,0,0,0.2);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h2 style="font-size: 1.5rem; font-weight: 800; color: #1a2a6c;">Add Govt Scheme</h2>
                <button onclick="document.getElementById('addSchemeModal').style.display='none'" style="background: none; border: none; font-size: 1.5rem; color: #94a3b8; cursor: pointer;"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('admin.schemes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Scheme Title</label>
                    <input type="text" name="title" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; font-family: inherit;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Description</label>
                    <textarea name="description" required rows="4" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; font-family: inherit; resize: none;"></textarea>
                </div>
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Cover Image</label>
                    <input type="file" name="image" style="width: 100%;">
                </div>
                <button type="submit" style="width: 100%; background: #1a2a6c; color: white; border: none; padding: 14px; border-radius: 12px; font-weight: 700; cursor: pointer; font-size: 1rem;">Publish Scheme</button>
            </form>
        </div>
    </div>
    <!-- Edit Scheme Modal -->
    <div id="editSchemeModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
        <div style="background: white; width: 500px; border-radius: 20px; padding: 32px; box-shadow: 0 20px 50px rgba(0,0,0,0.2);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h2 style="font-size: 1.5rem; font-weight: 800; color: #1a2a6c;">Edit Govt Scheme</h2>
                <button onclick="document.getElementById('editSchemeModal').style.display='none'" style="background: none; border: none; font-size: 1.5rem; color: #94a3b8; cursor: pointer;"><i class="fas fa-times"></i></button>
            </div>
            <form id="editSchemeForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Scheme Title</label>
                    <input type="text" name="title" id="edit_title" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; font-family: inherit;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Description</label>
                    <textarea name="description" id="edit_description" required rows="4" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; font-family: inherit; resize: none;"></textarea>
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Status</label>
                    <select name="status" id="edit_status" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; font-family: inherit;">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Cover Image (Optional)</label>
                    <input type="file" name="image" style="width: 100%;">
                </div>
                <button type="submit" style="width: 100%; background: #1a2a6c; color: white; border: none; padding: 14px; border-radius: 12px; font-weight: 700; cursor: pointer; font-size: 1rem;">Update Scheme</button>
            </form>
        </div>
    </div>

    <script>
        function editScheme(scheme) {
            const modal = document.getElementById('editSchemeModal');
            const form = document.getElementById('editSchemeForm');
            
            // Set values
            document.getElementById('edit_title').value = scheme.title;
            document.getElementById('edit_description').value = scheme.description;
            document.getElementById('edit_status').value = scheme.status;
            
            // Set action URL
            form.action = `/admin/schemes/${scheme.id}`;
            
            modal.style.display = 'flex';
        }
    </script>
@endsection
