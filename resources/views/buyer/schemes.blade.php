@extends('layouts.dashboard')

@section('title', 'Government Schemes')

@section('sidebar_links')
    <a href="{{ route('buyer.dashboard') }}" class="nav-item">
        <i class="fas fa-home"></i>
        <span>My Home</span>
    </a>
    <a href="{{ route('buyer.marketplace') }}" class="nav-item">
        <i class="fas fa-shopping-bag"></i>
        <span>Marketplace</span>
    </a>
    <a href="{{ route('buyer.orders') }}" class="nav-item">
        <i class="fas fa-history"></i>
        <span>My Orders</span>
    </a>
    <a href="{{ route('buyer.cart') }}" class="nav-item">
        <i class="fas fa-shopping-cart"></i>
        <span>Shopping Cart</span>
    </a>
    <a href="{{ route('buyer.wishlist') }}" class="nav-item">
        <i class="fas fa-heart"></i>
        <span>Wishlist</span>
    </a>
    <a href="{{ route('buyer.schemes') }}" class="nav-item active">
        <i class="fas fa-file-invoice"></i>
        <span>Govt Schemes</span>
    </a>
    <a href="{{ route('buyer.articles') }}" class="nav-item">
        <i class="fas fa-bullhorn"></i>
        <span>Textile Articles</span>
    </a>
    <a href="{{ route('buyer.settings') }}" class="nav-item">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
    </a>
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Government Schemes</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Discover Ministry initiatives designed to support and empower you.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 32px;">
        @forelse($schemes as $scheme)
        <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="display: flex; height: 250px;">
                <div style="flex: 1; position: relative;">
                    @if($scheme->image)
                        <img src="{{ asset('storage/' . $scheme->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background: #1a2a6c; display: flex; align-items: center; justify-content: center; color: white;">
                            <i class="fas fa-landmark" style="font-size: 4rem; opacity: 0.2;"></i>
                        </div>
                    @endif
                    <div style="position: absolute; top: 20px; left: 20px; background: #fdbb2d; color: #1a1a1a; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase;">New Scheme</div>
                </div>
                <div style="flex: 1.2; padding: 32px; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <h3 style="font-size: 1.4rem; font-weight: 800; color: #1a2a6c; margin-bottom: 12px; line-height: 1.2;">{{ $scheme->title }}</h3>
                        <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 24px;">{{ Str::limit($scheme->description, 120) }}</p>
                    </div>
                    <div style="display: flex; gap: 12px;">
                        <button onclick="showSchemeDetails('{{ addslashes($scheme->title) }}', '{{ addslashes($scheme->description) }}')" style="flex: 1; background: #1a2a6c; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 700; font-size: 0.85rem; cursor: pointer;">Learn More</button>
                        <button onclick="alert('Scheme document downloading...')" style="width: 44px; height: 44px; background: white; border: 1px solid #e2e8f0; border-radius: 10px; color: #1a2a6c; cursor: pointer;"><i class="fas fa-download"></i></button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 100px 0;">
            <i class="fas fa-landmark" style="font-size: 4rem; color: #e2e8f0; margin-bottom: 24px;"></i>
            <h2 style="color: #64748b; font-weight: 600;">No active schemes at the moment.</h2>
            <p style="color: #94a3b8; margin-top: 8px;">Check back later for new Ministry updates.</p>
        </div>
        @endforelse
    </div>

    <!-- Scheme Details Modal -->
    <div id="schemeModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: white; width: 600px; border-radius: 24px; padding: 40px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative;">
            <button onclick="document.getElementById('schemeModal').style.display='none'" style="position: absolute; top: 24px; right: 24px; background: #f1f5f9; border: none; width: 36px; height: 36px; border-radius: 50%; color: #64748b; cursor: pointer;"><i class="fas fa-times"></i></button>
            <h2 id="modalSchemeTitle" style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-bottom: 16px;"></h2>
            <div style="height: 4px; width: 60px; background: #fdbb2d; border-radius: 2px; margin-bottom: 24px;"></div>
            <p id="modalSchemeDescription" style="color: #475569; line-height: 1.8; font-size: 1.1rem; margin-bottom: 32px;"></p>
            <button onclick="document.getElementById('schemeModal').style.display='none'" style="width: 100%; background: #1a2a6c; color: white; border: none; padding: 16px; border-radius: 12px; font-weight: 700; cursor: pointer;">Close Details</button>
        </div>
    </div>

    <script>
        function showSchemeDetails(title, description) {
            document.getElementById('modalSchemeTitle').innerText = title;
            document.getElementById('modalSchemeDescription').innerText = description;
            document.getElementById('schemeModal').style.display = 'flex';
        }
    </script>
@endsection
