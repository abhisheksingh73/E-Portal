@extends('layouts.dashboard')

@section('title', 'Admin Overview')

@section('sidebar_links')
    <a href="{{ route('admin.dashboard') }}" class="nav-item active">
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
    @if(session('success'))
        <div style="background: #ecfdf5; color: #059669; padding: 15px; border-radius: 12px; margin-bottom: 24px; font-weight: 600;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fef2f2; color: #ef4444; padding: 15px; border-radius: 12px; margin-bottom: 24px; font-weight: 600;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Ministry Control Center</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Operational intelligence and system management.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <button style="background: white; color: var(--text-dark); border: 1px solid #e2e8f0; padding: 12px 20px; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                <i class="fas fa-calendar-alt" style="margin-right: 8px;"></i> Last 30 Days
            </button>
            <button style="background: #1a2a6c; color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 12px rgba(26, 42, 108, 0.2);">
                <i class="fas fa-plus" style="margin-right: 8px;"></i> New Action
            </button>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card" style="border-left: 4px solid #4338ca;">
            <div class="stat-icon" style="background: #eef2ff; color: #4338ca;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>Total Stakeholders</h3>
                <p>{{ $stats['total_users'] }}</p>
                <span style="color: #10b981; font-size: 0.8rem; font-weight: 600;"><i class="fas fa-trending-up"></i> +12% this month</span>
            </div>
        </div>
        <div class="stat-card" style="border-left: 4px solid #b45309;">
            <div class="stat-icon" style="background: #fffbeb; color: #b45309;">
                <i class="fas fa-store"></i>
            </div>
            <div class="stat-info">
                <h3>Registered Sellers</h3>
                <p>{{ $stats['active_sellers'] }}</p>
                <span style="color: #10b981; font-size: 0.8rem; font-weight: 600;"><i class="fas fa-check-circle"></i> Verified assets</span>
            </div>
        </div>
        <div class="stat-card" style="border-left: 4px solid #047857;">
            <div class="stat-icon" style="background: #ecfdf5; color: #047857;">
                <i class="fas fa-hand-holding-heart"></i>
            </div>
            <div class="stat-info">
                <h3>Active Buyers</h3>
                <p>{{ $stats['active_buyers'] }}</p>
                <span style="color: #10b981; font-size: 0.8rem; font-weight: 600;"><i class="fas fa-shopping-bag"></i> High activity</span>
            </div>
        </div>
        <div class="stat-card" style="border-left: 4px solid #b91c1c;">
            <div class="stat-icon" style="background: #fef2f2; color: #b91c1c;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>Pending Approvals</h3>
                <p>{{ $stats['pending_approvals'] }}</p>
                <span style="color: #ef4444; font-size: 0.8rem; font-weight: 600;">Attention required</span>
            </div>
        </div>
    </div>

    @if($pendingSellers->count() > 0)
    <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border-left: 4px solid #fdbb2d; margin-bottom: 32px;">
        <div class="card-header" style="padding: 24px; border-bottom: 1px solid #f1f5f9; background: #fffdf5;">
            <h2 class="card-title" style="font-weight: 700; color: #854d0e;"><i class="fas fa-user-clock"></i> Pending Seller Approvals</h2>
        </div>
        <div style="padding: 0 24px 24px 24px;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; border-bottom: 1px solid #f1f5f9;">
                        <th style="padding: 16px 12px; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Seller Name</th>
                        <th style="padding: 16px 12px; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Email</th>
                        <th style="padding: 16px 12px; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingSellers as $seller)
                    <tr style="border-bottom: 1px solid #f8fafc;">
                        <td style="padding: 16px 12px; font-weight: 600;">{{ $seller->name }}</td>
                        <td style="padding: 16px 12px; color: var(--text-muted);">{{ $seller->email }}</td>
                        <td style="padding: 16px 12px;">
                            <form action="{{ route('admin.users.approve', $seller) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="background: #10b981; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                    Approve Account
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
        <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <div class="card-header" style="padding: 24px; border-bottom: 1px solid #f1f5f9; margin-bottom: 0;">
                <h2 class="card-title" style="font-weight: 700;">Recent User Onboarding</h2>
                <a href="{{ route('admin.users') }}" style="color: #4338ca; font-size: 0.9rem; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                    View Directory <i class="fas fa-arrow-right" style="font-size: 0.7rem;"></i>
                </a>
            </div>
            <div style="padding: 0 24px 24px 24px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 1px solid #f1f5f9;">
                            <th style="padding: 16px 12px; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">User</th>
                            <th style="padding: 16px 12px; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Role</th>
                            <th style="padding: 16px 12px; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Joined</th>
                            <th style="padding: 16px 12px; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentUsers as $user)
                        <tr style="border-bottom: 1px solid #f8fafc; transition: background 0.3s;" onmouseover="this.style.background='#fcfdff'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 16px 12px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 36px; height: 36px; border-radius: 10px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #4338ca; font-size: 0.9rem;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 0.95rem;">{{ $user->name }}</div>
                                        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 16px 12px;">
                                <span style="
                                    padding: 6px 12px; 
                                    border-radius: 50px; 
                                    font-size: 0.75rem; 
                                    font-weight: 700; 
                                    text-transform: capitalize;
                                    {{ $user->role == 'admin' ? 'background: #eef2ff; color: #4338ca;' : ($user->role == 'seller' ? 'background: #fffbeb; color: #b45309;' : 'background: #ecfdf5; color: #047857;') }}
                                ">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td style="padding: 16px 12px; color: var(--text-muted); font-size: 0.9rem;">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td style="padding: 16px 12px;">
                                <button style="background: none; border: none; color: #94a3b8; cursor: pointer; transition: color 0.3s;" onmouseover="this.style.color='#4338ca'" onmouseout="this.style.color='#94a3b8'">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 24px;">
            <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); background: linear-gradient(135deg, #1a2a6c, #243b55); color: white;">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 16px;">System Performance</h3>
                <div style="margin-bottom: 24px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span style="font-size: 0.85rem; font-weight: 500; opacity: 0.8;">Cloud Processing</span>
                        <span style="font-size: 0.85rem; font-weight: 700;">88%</span>
                    </div>
                    <div style="height: 6px; background: rgba(255,255,255,0.1); border-radius: 3px; overflow: hidden;">
                        <div style="width: 88%; height: 100%; background: #fdbb2d; box-shadow: 0 0 10px rgba(253, 187, 45, 0.5);"></div>
                    </div>
                </div>
                <p style="font-size: 0.8rem; opacity: 0.7; line-height: 1.5;">The textile portal is currently operating at optimal capacity with no critical incidents reported in the last 24 hours.</p>
            </div>

            <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px;">Top Seller Categories</h3>
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: #4338ca;"></div>
                        <span style="flex: 1; font-size: 0.9rem; font-weight: 500;">Handloom Silk</span>
                        <span style="font-size: 0.9rem; font-weight: 700;">42%</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: #047857;"></div>
                        <span style="flex: 1; font-size: 0.9rem; font-weight: 500;">Cotton Weaves</span>
                        <span style="font-size: 0.9rem; font-weight: 700;">31%</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: #fdbb2d;"></div>
                        <span style="flex: 1; font-size: 0.9rem; font-weight: 500;">Synthetic Blends</span>
                        <span style="font-size: 0.9rem; font-weight: 700;">27%</span>
                    </div>
                </div>
                <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid #f1f5f9; text-align: center;">
                    <button style="background: none; border: none; color: #4338ca; font-weight: 700; font-size: 0.85rem; cursor: pointer;">Detailed Market Report</button>
                </div>
            </div>
        </div>
    </div>
@endsection