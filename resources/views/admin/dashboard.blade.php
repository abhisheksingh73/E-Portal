@extends('layouts.dashboard')

@section('title', 'Ministry Control Center')

@section('extra_css')
<style>
    .stat-badge {
        font-size: 0.75rem;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 50px;
        text-transform: uppercase;
    }
</style>
@endsection

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
    <a href="{{ route('admin.schemes') }}" class="nav-item">
        <i class="fas fa-file-invoice"></i>
        <span>Govt Schemes</span>
    </a>
    <a href="{{ route('admin.articles') }}" class="nav-item">
        <i class="fas fa-bullhorn"></i>
        <span>Textile Articles</span>
    </a>
    <a href="{{ route('profile.edit') }}" class="nav-item">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
    </a>
@endsection

@section('content')
    <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(at 0% 0%, rgba(253, 187, 45, 0.05) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(26, 42, 108, 0.05) 0px, transparent 50%); z-index: -1;"></div>

    <div class="header-flex stagger-item" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; animation-delay: 0.1s;">
        <div>
            <h1 style="font-size: 2.5rem; font-weight: 900; color: #111827; letter-spacing: -1px; margin-bottom: 8px;">Ministry <span style="color: var(--primary);">Intelligence</span></h1>
            <p style="color: var(--text-muted); font-size: 1.1rem; font-weight: 500;">Welcome back, Administrator. Here's your system overview for today.</p>
        </div>
        <div style="display: flex; gap: 15px;">
            <button class="action-btn">
                <i class="fas fa-download"></i> Export Reports
            </button>
            <button class="action-btn" style="background: var(--primary); color: white; border: none;">
                <i class="fas fa-plus"></i> New Initiative
            </button>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card stagger-item" style="animation-delay: 0.2s;">
            <div class="stat-icon" style="background: linear-gradient(135deg, #4338ca, #6366f1); color: white; box-shadow: 0 10px 15px rgba(67, 56, 202, 0.2);">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>Total Stakeholders</h3>
                <p>{{ $stats['total_users'] }}</p>
                <div style="display: flex; align-items: center; gap: 6px; margin-top: 4px;">
                    <span class="stat-badge" style="background: #ecfdf5; color: #059669;">+12.5%</span>
                    <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">vs last month</span>
                </div>
            </div>
        </div>
        <div class="stat-card stagger-item" style="animation-delay: 0.3s;">
            <div class="stat-icon" style="background: linear-gradient(135deg, #b45309, #d97706); color: white; box-shadow: 0 10px 15px rgba(180, 83, 9, 0.2);">
                <i class="fas fa-store"></i>
            </div>
            <div class="stat-info">
                <h3>Registered Sellers</h3>
                <p>{{ $stats['active_sellers'] }}</p>
                <div style="display: flex; align-items: center; gap: 6px; margin-top: 4px;">
                    <span class="stat-badge" style="background: #fffbeb; color: #b45309;">Verified</span>
                    <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 600;">Full compliance</span>
                </div>
            </div>
        </div>
        <div class="stat-card stagger-item" style="animation-delay: 0.4s;">
            <div class="stat-icon" style="background: linear-gradient(135deg, #047857, #10b981); color: white; box-shadow: 0 10px 15px rgba(4, 120, 87, 0.2);">
                <i class="fas fa-hand-holding-heart"></i>
            </div>
            <div class="stat-info">
                <h3>Active Buyers</h3>
                <p>{{ $stats['active_buyers'] }}</p>
                <div style="display: flex; align-items: center; gap: 6px; margin-top: 4px;">
                    <span class="stat-badge" style="background: #ecfdf5; color: #059669;">High Traffic</span>
                </div>
            </div>
        </div>
        <div class="stat-card stagger-item" style="animation-delay: 0.5s;">
            <div class="stat-icon" style="background: linear-gradient(135deg, #b91c1c, #ef4444); color: white; box-shadow: 0 10px 15px rgba(185, 28, 28, 0.2);">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>Pending Actions</h3>
                <p>{{ $stats['pending_approvals'] }}</p>
                <div style="display: flex; align-items: center; gap: 6px; margin-top: 4px;">
                    <span class="stat-badge" style="background: #fef2f2; color: #ef4444;">Urgent</span>
                </div>
            </div>
        </div>
    </div>

    @if($pendingSellers->count() > 0)
    <div class="card stagger-item" style="padding: 0; overflow: hidden; border: 2px solid #fffbeb; animation-delay: 0.6s;">
        <div style="padding: 32px; background: linear-gradient(to right, #fffbeb, transparent); border-bottom: 1px solid #fef3c7; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2 style="font-size: 1.4rem; font-weight: 800; color: #92400e; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-user-shield"></i> Priority Seller Approvals
                </h2>
                <p style="font-size: 0.9rem; color: #b45309; font-weight: 500; margin-top: 4px;">These artisans are waiting for portal verification.</p>
            </div>
            <span style="background: #fef3c7; color: #92400e; padding: 6px 16px; border-radius: 50px; font-weight: 800; font-size: 0.8rem;">{{ $pendingSellers->count() }} PENDING</span>
        </div>
        <div style="padding: 0 32px 32px 32px;">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0 12px;">
                <tbody>
                    @foreach($pendingSellers as $seller)
                    <tr style="background: #fafaf9; border-radius: 16px;">
                        <td style="padding: 20px; border-radius: 16px 0 0 16px;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 44px; height: 44px; border-radius: 12px; background: white; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #b45309; border: 1px solid #fde68a;">
                                    {{ strtoupper(substr($seller->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: #1e293b;">{{ $seller->name }}</div>
                                    <div style="font-size: 0.85rem; color: #64748b;">{{ $seller->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 20px; text-align: right; border-radius: 0 16px 16px 0;">
                            <form action="{{ route('admin.users.approve', $seller) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="background: #1a2a6c; color: white; border: none; padding: 10px 24px; border-radius: 12px; font-weight: 700; cursor: pointer; transition: var(--transition);" onmouseover="this.style.background='#243b55'" onmouseout="this.style.background='#1a2a6c'">
                                    Verify Account
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

    <div style="display: grid; grid-template-columns: 2fr 1.2fr; gap: 40px;">
        <div class="card stagger-item" style="padding: 0; overflow: hidden; animation-delay: 0.7s;">
            <div style="padding: 32px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <h2 style="font-size: 1.4rem; font-weight: 800; color: #111827;">Ecosystem Growth</h2>
                <a href="{{ route('admin.users') }}" style="color: var(--primary); font-weight: 700; text-decoration: none; font-size: 0.9rem;">Full Directory <i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i></a>
            </div>
            <div style="padding: 0 32px 32px 32px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left;">
                            <th style="padding: 20px 12px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">Stakeholder</th>
                            <th style="padding: 20px 12px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">Role & Clearance</th>
                            <th style="padding: 20px 12px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 800; letter-spacing: 1px; text-align: right;">Onboarded</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentUsers as $user)
                        <tr style="border-top: 1px solid #f8fafc;">
                            <td style="padding: 20px 12px;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <div style="width: 40px; height: 40px; border-radius: 12px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--primary); font-size: 0.9rem;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: #1e293b; font-size: 1rem;">{{ $user->name }}</div>
                                        <div style="font-size: 0.85rem; color: #94a3b8;">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 20px 12px;">
                                <span style="
                                    padding: 6px 14px; 
                                    border-radius: 8px; 
                                    font-size: 0.7rem; 
                                    font-weight: 800; 
                                    text-transform: uppercase;
                                    {{ $user->role == 'admin' ? 'background: #eef2ff; color: #4338ca;' : ($user->role == 'seller' ? 'background: #fffbeb; color: #b45309;' : 'background: #ecfdf5; color: #047857;') }}
                                ">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td style="padding: 20px 12px; color: #64748b; font-weight: 600; font-size: 0.9rem; text-align: right;">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 32px;">
            <div class="card stagger-item" style="padding: 0; overflow: hidden; animation-delay: 0.8s;">
                <div style="padding: 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #111827; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-satellite-dish" style="color: var(--primary);"></i> Intelligence Feed
                    </h3>
                    <span style="font-size: 0.65rem; font-weight: 900; background: #ecfdf5; color: #059669; padding: 4px 10px; border-radius: 50px; text-transform: uppercase; border: 1px solid #d1fae5;">Live</span>
                </div>
                <div style="padding: 24px; max-height: 400px; overflow-y: auto;">
                    @forelse($activities as $activity)
                    <div style="display: flex; gap: 16px; margin-bottom: 24px; position: relative;">
                        <div style="flex-shrink: 0; width: 40px; height: 40px; border-radius: 12px; background: {{ $activity->type == 'registration' ? '#eef2ff' : ($activity->type == 'approval' ? '#ecfdf5' : '#fffbeb') }}; display: flex; align-items: center; justify-content: center; color: {{ $activity->type == 'registration' ? '#4338ca' : ($activity->type == 'approval' ? '#059669' : '#b45309') }}; font-size: 1rem;">
                            <i class="fas {{ $activity->type == 'registration' ? 'fa-user-plus' : ($activity->type == 'approval' ? 'fa-check-double' : 'fa-box-open') }}"></i>
                        </div>
                        <div style="flex: 1;">
                            <p style="font-size: 0.95rem; color: #1e293b; line-height: 1.5; font-weight: 500;">{{ $activity->message }}</p>
                            <span style="font-size: 0.8rem; color: #94a3b8; font-weight: 600; display: flex; align-items: center; gap: 5px; margin-top: 4px;">
                                <i class="far fa-clock"></i> {{ $activity->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 40px 0;">
                        <i class="fas fa-history" style="font-size: 2.5rem; color: #e2e8f0; margin-bottom: 16px;"></i>
                        <p style="color: #94a3b8; font-size: 1rem; font-weight: 600;">System is waiting for signals...</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="card stagger-item" style="background: linear-gradient(135deg, #1a2a6c, #243b55); border: none; color: white; position: relative; overflow: hidden; animation-delay: 0.9s;">
                <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
                <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 16px; position: relative;">System Health</h3>
                <div style="display: grid; gap: 20px; position: relative;">
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; font-weight: 700; margin-bottom: 8px; opacity: 0.8;">
                            <span>Operational Uptime</span>
                            <span>99.98%</span>
                        </div>
                        <div style="height: 6px; background: rgba(255,255,255,0.1); border-radius: 10px; overflow: hidden;">
                            <div style="width: 99.98%; height: 100%; background: var(--accent); border-radius: 10px;"></div>
                        </div>
                    </div>
                    <div style="background: rgba(255,255,255,0.1); padding: 16px; border-radius: 16px;">
                        <div style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; opacity: 0.6; margin-bottom: 8px;">Market Signal</div>
                        <div style="font-size: 1rem; font-weight: 700;">High demand detected in <span style="color: var(--accent);">Silk Weaves</span>.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection