@extends('layouts.dashboard')

@section('title', 'System Settings')

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
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Portal Settings</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Configure your profile and system preferences.</p>
        </div>
    </div>

    <div style="max-width: 800px;">
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 32px; padding: 32px;">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 24px; color: #1e293b;">Account Information</h3>
            <form method="post" action="{{ route('profile.update') }}" style="display: grid; gap: 20px;">
                @csrf
                @method('patch')
                
                <div style="display: grid; gap: 8px;">
                    <label style="font-size: 0.85rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Full Name</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem;">
                </div>

                <div style="display: grid; gap: 8px;">
                    <label style="font-size: 0.85rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Email Address</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem;">
                </div>

                <div style="margin-top: 10px;">
                    <button type="submit" style="background: #1a2a6c; color: white; border: none; padding: 12px 32px; border-radius: 10px; font-weight: 700; cursor: pointer;">Save Changes</button>
                </div>
            </form>
        </div>

        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 32px; padding: 32px;">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 24px; color: #1e293b;">Security</h3>
            <form method="post" action="{{ route('password.update') }}" style="display: grid; gap: 20px;">
                @csrf
                @method('put')

                <div style="display: grid; gap: 8px;">
                    <label style="font-size: 0.85rem; font-weight: 600; color: #64748b; text-transform: uppercase;">Current Password</label>
                    <input type="password" name="current_password" style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem;">
                </div>

                <div style="display: grid; gap: 8px;">
                    <label style="font-size: 0.85rem; font-weight: 600; color: #64748b; text-transform: uppercase;">New Password</label>
                    <input type="password" name="password" style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem;">
                </div>

                <div style="margin-top: 10px;">
                    <button type="submit" style="background: white; color: #1a2a6c; border: 2px solid #1a2a6c; padding: 10px 32px; border-radius: 10px; font-weight: 700; cursor: pointer;">Update Security</button>
                </div>
            </form>
        </div>

        <div class="card" style="border: 1px solid #fee2e2; box-shadow: 0 10px 30px rgba(239, 68, 68, 0.05); padding: 32px; background: #fffcfc;">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 12px; color: #ef4444;">Danger Zone</h3>
            <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 24px;">Once you delete your account, there is no going back. Please be certain.</p>
            <button style="background: #ef4444; color: white; border: none; padding: 12px 32px; border-radius: 10px; font-weight: 700; cursor: pointer;">Delete Account</button>
        </div>
    </div>
@endsection
