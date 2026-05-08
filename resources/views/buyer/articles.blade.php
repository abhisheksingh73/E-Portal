@extends('layouts.dashboard')

@section('title', 'Textile Stories & Articles')

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
    <a href="{{ route('buyer.schemes') }}" class="nav-item">
        <i class="fas fa-file-invoice"></i>
        <span>Govt Schemes</span>
    </a>
    <a href="{{ route('buyer.articles') }}" class="nav-item active">
        <i class="fas fa-bullhorn"></i>
        <span>Textile Articles</span>
    </a>
    <a href="{{ route('buyer.settings') }}" class="nav-item">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
    </a>
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <div>
            <h1 style="font-size: 2.5rem; font-weight: 800; color: #1a2a6c; font-family: 'Playfair Display', serif;">The Textile Chronicles</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Discover the heritage, innovation, and stories behind Indian fabrics.</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 40px;">
        @forelse($articles as $article)
        <div style="cursor: pointer; group" onmouseover="this.querySelector('img').style.transform='scale(1.05)'" onmouseout="this.querySelector('img').style.transform='scale(1)'">
            <div style="border-radius: 24px; overflow: hidden; height: 350px; position: relative; margin-bottom: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                @if($article->image)
                    <img src="{{ asset('storage/' . $article->image) }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);">
                @else
                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #1a2a6c, #b21f1f); display: flex; align-items: center; justify-content: center; color: white;">
                        <i class="fas fa-newspaper" style="font-size: 4rem; opacity: 0.2;"></i>
                    </div>
                @endif
                <div style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 32px; background: linear-gradient(transparent, rgba(0,0,0,0.8)); color: white;">
                    <span style="display: inline-block; background: rgba(255,255,255,0.2); backdrop-filter: blur(8px); padding: 4px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 700; margin-bottom: 12px; text-transform: uppercase;">{{ $article->category }}</span>
                    <h3 style="font-size: 1.4rem; font-weight: 700; line-height: 1.2;">{{ $article->title }}</h3>
                </div>
            </div>
            <p style="color: var(--text-muted); line-height: 1.6; font-size: 0.95rem; margin-bottom: 16px;">{{ Str::limit($article->content, 120) }}</p>
            <a href="#" style="color: #1a2a6c; font-weight: 800; text-decoration: none; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;">Read Full Story <i class="fas fa-arrow-right"></i></a>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 100px 0;">
            <i class="fas fa-feather-alt" style="font-size: 4rem; color: #e2e8f0; margin-bottom: 24px;"></i>
            <h2 style="color: #64748b; font-weight: 600;">No articles published yet.</h2>
            <p style="color: #94a3b8; margin-top: 8px;">Check back soon for new stories from the Ministry.</p>
        </div>
        @endforelse
    </div>
@endsection
