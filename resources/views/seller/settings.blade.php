@extends('layouts.dashboard')

@section('title', 'Shop Settings')

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
    <a href="{{ route('seller.settings') }}" class="nav-item active">
        <i class="fas fa-store"></i>
        <span>Shop Settings</span>
    </a>
    <a href="{{ route('seller.schemes') }}" class="nav-item">
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
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Shop Configuration</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Manage your shop identity and business preferences.</p>
        </div>
    </div>

    <div style="max-width: 900px; display: grid; gap: 32px;">
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 32px;">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 24px; color: #1e293b; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-info-circle" style="color: #1a2a6c;"></i> Public Shop Profile
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 40px;">
                <div style="text-align: center;">
                    <div style="width: 120px; height: 120px; border-radius: 20px; background: #f1f5f9; margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: #cbd5e1; border: 2px dashed #e2e8f0;">
                        <i class="fas fa-store"></i>
                    </div>
                    <button style="background: none; border: 1px solid #e2e8f0; padding: 8px 16px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; color: #1a2a6c; cursor: pointer;">Upload Logo</button>
                </div>
                <form style="display: grid; gap: 20px;">
                    <div style="display: grid; gap: 8px;">
                        <label style="font-size: 0.85rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Shop Name</label>
                        <input type="text" value="Heritage Weavers Co." style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem;">
                    </div>
                    <div style="display: grid; gap: 8px;">
                        <label style="font-size: 0.85rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Shop Bio</label>
                        <textarea style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem; height: 80px; resize: none;">Traditional handloom weavers specializing in authentic Banarasi silk and intricate zari work.</textarea>
                    </div>
                    <div>
                        <button type="submit" style="background: #1a2a6c; color: white; border: none; padding: 12px 32px; border-radius: 10px; font-weight: 700; cursor: pointer;">Save Shop Info</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 32px;">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 24px; color: #1e293b; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-university" style="color: #1a2a6c;"></i> Payout Information
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <div style="display: grid; gap: 8px;">
                    <label style="font-size: 0.85rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Bank Name</label>
                    <input type="text" placeholder="State Bank of India" style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none;">
                </div>
                <div style="display: grid; gap: 8px;">
                    <label style="font-size: 0.85rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Account Number</label>
                    <input type="text" placeholder="XXXX XXXX 4567" style="padding: 12px 16px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none;">
                </div>
            </div>
            <div style="margin-top: 24px;">
                <button style="background: white; color: #1a2a6c; border: 2px solid #1a2a6c; padding: 10px 32px; border-radius: 10px; font-weight: 700; cursor: pointer;">Update Payout Method</button>
            </div>
        </div>
    </div>
@endsection
