@extends('layouts.dashboard')

@section('title', 'Account Settings')

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
    <a href="{{ route('buyer.wishlist') }}" class="nav-item">
        <i class="fas fa-heart"></i>
        <span>Wishlist</span>
    </a>
    <a href="{{ route('buyer.schemes') }}" class="nav-item">
        <i class="fas fa-file-invoice"></i>
        <span>Govt Schemes</span>
    </a>
    <a href="{{ route('buyer.articles') }}" class="nav-item">
        <i class="fas fa-bullhorn"></i>
        <span>Textile Articles</span>
    </a>
    <a href="{{ route('buyer.settings') }}" class="nav-item active">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
    </a>
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Account Settings</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Manage your personal information and preferences.</p>
        </div>
    </div>

    <div style="max-width: 800px; display: grid; gap: 32px;">
        @if(session('success'))
            <div style="background: #ecfdf5; color: #059669; padding: 16px; border-radius: 12px; font-weight: 600; border: 1px solid #10b981;">
                <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 32px;">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 24px; color: #1e293b; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-user-circle" style="color: #1a2a6c;"></i> Personal Profile
            </h3>
            <form action="{{ route('buyer.settings.update') }}" method="POST" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                @csrf
                @method('PATCH')
                <div style="display: grid; gap: 8px;">
                    <label style="font-size: 0.85rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Full Name</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" required style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem;">
                </div>
                <div style="display: grid; gap: 8px;">
                    <label style="font-size: 0.85rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Email Address</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" required style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem;">
                </div>
                <div style="display: grid; gap: 8px; grid-column: span 2;">
                    <label style="font-size: 0.85rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Default Shipping Address</label>
                    <textarea name="address" style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem; height: 100px; resize: none;">{{ auth()->user()->address }}</textarea>
                </div>
                <div style="grid-column: span 2;">
                    <button type="submit" style="background: #1a2a6c; color: white; border: none; padding: 12px 32px; border-radius: 10px; font-weight: 700; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#243b55'" onmouseout="this.style.background='#1a2a6c'">Update Profile</button>
                </div>
            </form>
        </div>

        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 32px;">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 24px; color: #1e293b; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-bell" style="color: #1a2a6c;"></i> Notification Preferences
            </h3>
            <div style="display: grid; gap: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9;">
                    <div>
                        <div style="font-weight: 700; color: #1e293b;">Order Updates</div>
                        <div style="font-size: 0.85rem; color: #64748b;">Get notified when your order is shipped or delivered.</div>
                    </div>
                    <div style="width: 50px; height: 26px; background: #1a2a6c; border-radius: 20px; position: relative; cursor: pointer;">
                        <div style="position: absolute; right: 4px; top: 4px; width: 18px; height: 18px; background: white; border-radius: 50%;"></div>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-weight: 700; color: #1e293b;">Promotional Emails</div>
                        <div style="font-size: 0.85rem; color: #64748b;">Receive updates about new collections and exclusive sales.</div>
                    </div>
                    <div style="width: 50px; height: 26px; background: #e2e8f0; border-radius: 20px; position: relative; cursor: pointer;">
                        <div style="position: absolute; left: 4px; top: 4px; width: 18px; height: 18px; background: white; border-radius: 50%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
