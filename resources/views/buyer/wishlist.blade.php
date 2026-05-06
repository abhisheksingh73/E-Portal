@extends('layouts.dashboard')

@section('title', 'My Wishlist')

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
    <a href="{{ route('buyer.wishlist') }}" class="nav-item active">
        <i class="fas fa-heart"></i>
        <span>Wishlist</span>
    </a>
    <a href="{{ route('buyer.settings') }}" class="nav-item">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
    </a>
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">My Wishlist</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">You have 15 items saved in your collection.</p>
        </div>
        <button style="background: #ef4444; color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; cursor: pointer;">
            <i class="fas fa-trash-alt" style="margin-right: 8px;"></i> Clear All
        </button>
    </div>

    <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; background: #f8fafc; border-bottom: 1px solid #f1f5f9;">
                    <th style="padding: 16px 32px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Product</th>
                    <th style="padding: 16px 32px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Price</th>
                    <th style="padding: 16px 32px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Availability</th>
                    <th style="padding: 16px 32px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 1; $i <= 5; $i++)
                <tr style="border-bottom: 1px solid #f8fafc; transition: background 0.3s;" onmouseover="this.style.background='#fcfdff'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 24px 32px;">
                        <div style="display: flex; align-items: center; gap: 20px;">
                            <div style="width: 70px; height: 70px; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #cbd5e1;">
                                <i class="fas fa-image"></i>
                            </div>
                            <div>
                                <div style="font-weight: 700; font-size: 1rem; color: #1e293b;">Indigo Cotton Saree {{ $i }}</div>
                                <div style="font-size: 0.85rem; color: #94a3b8;">Crafted in Rajasthan</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 24px 32px; font-weight: 800; color: #1a2a6c; font-size: 1.1rem;">₹4,250</td>
                    <td style="padding: 24px 32px;">
                        <div style="display: flex; align-items: center; gap: 8px; color: #059669; font-weight: 700; font-size: 0.85rem;">
                            <i class="fas fa-check-circle"></i> IN STOCK
                        </div>
                    </td>
                    <td style="padding: 24px 32px; text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 12px;">
                            <button style="background: #1a2a6c; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer;">Add to Cart</button>
                            <button style="background: none; border: 1px solid #fee2e2; color: #ef4444; width: 40px; height: 40px; border-radius: 8px; cursor: pointer;"><i class="far fa-trash-alt"></i></button>
                        </div>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
@endsection
