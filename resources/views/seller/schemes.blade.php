@extends('layouts.dashboard')

@section('title', 'Government Schemes for Producers')

@section('sidebar_links')
    <a href="{{ route('seller.dashboard') }}" class="nav-item">
        <i class="fas fa-chart-line"></i>
        <span>Dashboard</span>
    </a>
    <a href="{{ route('seller.products') }}" class="nav-item">
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
    <a href="{{ route('seller.schemes') }}" class="nav-item active">
        <i class="fas fa-file-invoice"></i>
        <span>Govt Schemes</span>
    </a>
    <a href="{{ route('seller.articles') }}" class="nav-item">
        <i class="fas fa-bullhorn"></i>
        <span>Textile Articles</span>
    </a>
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Government Schemes</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Financial support and welfare initiatives for textile producers and artisans.</p>
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
                    <div style="position: absolute; top: 20px; left: 20px; background: #fdbb2d; color: #1a1a1a; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase;">Active</div>
                </div>
                <div style="flex: 1.2; padding: 32px; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <h3 style="font-size: 1.4rem; font-weight: 800; color: #1a2a6c; margin-bottom: 12px; line-height: 1.2;">{{ $scheme->title }}</h3>
                        <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 24px;">{{ Str::limit($scheme->description, 120) }}</p>
                    </div>
                    <div style="display: flex; gap: 12px;">
                        <button style="flex: 1; background: #1a2a6c; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 700; font-size: 0.85rem; cursor: pointer;">Apply Now</button>
                        <button style="width: 44px; height: 44px; background: white; border: 1px solid #e2e8f0; border-radius: 10px; color: #1a2a6c; cursor: pointer;"><i class="fas fa-file-pdf"></i></button>
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
@endsection
