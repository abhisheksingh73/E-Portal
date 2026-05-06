@extends('layouts.dashboard')

@section('title', 'Market Orders')

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
    <a href="{{ route('admin.orders') }}" class="nav-item active">
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
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Market Orders</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Track and manage transactions across the e-portal.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <button style="background: white; color: #1e293b; border: 1px solid #e2e8f0; padding: 12px 20px; border-radius: 12px; font-weight: 600; cursor: pointer;">
                <i class="fas fa-download" style="margin-right: 8px;"></i> Download Report
            </button>
        </div>
    </div>

    <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <div style="padding: 24px; border-bottom: 1px solid #f1f5f9; background: #fafbfc; display: flex; gap: 20px;">
            <div style="flex: 1; position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                <input type="text" placeholder="Search Order ID, Buyer, or Seller..." style="width: 100%; padding: 10px 10px 10px 40px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none;">
            </div>
            <select style="padding: 10px 16px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; background: white;">
                <option>All Status</option>
                <option>Pending</option>
                <option>Processing</option>
                <option>Shipped</option>
                <option>Delivered</option>
                <option>Cancelled</option>
            </select>
        </div>

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; background: #f8fafc; border-bottom: 1px solid #f1f5f9;">
                    <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Order ID</th>
                    <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Stakeholders</th>
                    <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Total Amount</th>
                    <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Status</th>
                    <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Date</th>
                    <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; font-weight: 700; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 1; $i <= 5; $i++)
                <tr style="border-bottom: 1px solid #f8fafc;">
                    <td style="padding: 20px 24px; font-weight: 700; color: #1e293b;">#TXN-{{ rand(10000, 99999) }}</td>
                    <td style="padding: 20px 24px;">
                        <div style="font-size: 0.9rem; font-weight: 600; color: #1e293b;">B: Global Retailers</div>
                        <div style="font-size: 0.8rem; color: #64748b;">S: Weaver United</div>
                    </td>
                    <td style="padding: 20px 24px; font-weight: 700; color: #1a2a6c;">₹{{ number_format(rand(10000, 100000)) }}</td>
                    <td style="padding: 20px 24px;">
                        <span style="background: #eef2ff; color: #4338ca; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">Processing</span>
                    </td>
                    <td style="padding: 20px 24px; color: #64748b; font-size: 0.9rem;">May 0{{ $i }}, 2026</td>
                    <td style="padding: 20px 24px; text-align: center;">
                        <button style="background: #f1f5f9; border: none; color: #1e293b; padding: 6px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; cursor: pointer;">Details</button>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
        
        <div style="padding: 24px; background: #fafbfc; text-align: center; border-top: 1px solid #f1f5f9;">
            <button style="background: none; border: 1px solid #e2e8f0; padding: 8px 16px; border-radius: 8px; font-size: 0.9rem; font-weight: 600; color: #64748b; cursor: pointer;">Load More Orders</button>
        </div>
    </div>
@endsection
