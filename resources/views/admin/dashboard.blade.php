@extends('layouts.dashboard')

@section('title', 'Ministry Overview')

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
        <span>Marketing Content</span>
    </a>
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <div>
            <h1 style="font-size: 2.2rem; font-weight: 800; color: #1a2a6c;">Dashboard <span style="color: #111827;">Overview</span></h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Operational oversight of the National Textile E-Portal.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('admin.analytics') }}" style="background: white; border: 1px solid #e2e8f0; color: #1a2a6c; padding: 12px 24px; border-radius: 12px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-chart-line"></i> Market Insights
            </a>
            <a href="{{ route('admin.schemes.applications') }}" style="background: #1a2a6c; color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 700; text-decoration: none; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(26, 42, 108, 0.2);">
                <i class="fas fa-inbox"></i> Application In-box
            </a>
        </div>
    </div>

    <!-- Key Metrics Row -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 40px;">
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 24px;">
            <div style="width: 40px; height: 40px; background: #eef2ff; color: #4338ca; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                <i class="fas fa-users"></i>
            </div>
            <div style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Total Stakeholders</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-top: 4px;">{{ $stats['total_users'] }}</div>
        </div>
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 24px;">
            <div style="width: 40px; height: 40px; background: #fffbeb; color: #b45309; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                <i class="fas fa-store"></i>
            </div>
            <div style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Verified Sellers</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-top: 4px;">{{ $stats['active_sellers'] }}</div>
        </div>
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 24px;">
            <div style="width: 40px; height: 40px; background: #ecfdf5; color: #059669; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Total Products</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-top: 4px;">{{ $stats['total_products'] }}</div>
        </div>
        <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 24px;">
            <div style="width: 40px; height: 40px; background: #fef2f2; color: #ef4444; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                <i class="fas fa-clock"></i>
            </div>
            <div style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Pending Approvals</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #ef4444; margin-top: 4px;">{{ $stats['pending_approvals'] }}</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
        <div>
            <!-- Priority Seller Approvals (Collapsing Style Sections) -->
            <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 0; overflow: hidden; margin-bottom: 32px;">
                <div style="padding: 24px 32px; background: #fafafa; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 1.2rem; font-weight: 800; color: #1a2a6c; display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-user-shield"></i> Pending Seller Authorizations
                    </h3>
                    <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 50px; font-weight: 800; font-size: 0.75rem;">{{ $pendingSellers->count() }} ACTION REQUIRED</span>
                </div>
                <div style="padding: 20px 32px;">
                    @forelse($pendingSellers as $seller)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px; background: #f8fafc; border-radius: 16px; margin-bottom: 12px; border: 1px solid #f1f5f9; transition: all 0.2s;" onmouseover="this.style.borderColor='#1a2a6c'" onmouseout="this.style.borderColor='#f1f5f9'">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="width: 48px; height: 48px; border-radius: 12px; background: white; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #1a2a6c; border: 1px solid #e2e8f0; font-size: 1.2rem;">
                                {{ strtoupper(substr($seller->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 700; color: #1e293b; font-size: 1.1rem;">{{ $seller->name }}</div>
                                <div style="font-size: 0.85rem; color: #64748b;">Registered on: {{ $seller->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 12px;">
                            <form action="{{ route('admin.users.approve', $seller) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="background: #1a2a6c; color: white; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-check-circle"></i> Authorize Seller
                                </button>
                            </form>
                            <form action="{{ route('admin.users.destroy', $seller) }}" method="POST" onsubmit="return confirm('Moderation: Reject and delete this seller request?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: white; color: #ef4444; border: 1px solid #fee2e2; padding: 10px; border-radius: 10px; cursor: pointer;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 40px; color: #94a3b8;">
                        <i class="fas fa-check-double" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.2;"></i>
                        <p style="font-weight: 600;">No pending seller authorizations.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Stakeholders -->
            <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 0; overflow: hidden;">
                <div style="padding: 24px 32px; background: #fafafa; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 1.2rem; font-weight: 800; color: #1a2a6c;">Recently Joined</h3>
                    <a href="{{ route('admin.users') }}" style="color: #1a2a6c; font-weight: 700; text-decoration: none; font-size: 0.85rem;">View Full Directory <i class="fas fa-arrow-right" style="margin-left: 4px; font-size: 0.7rem;"></i></a>
                </div>
                <div style="padding: 0 32px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tbody>
                            @foreach($recentUsers as $user)
                            <tr style="border-bottom: 1px solid #f8fafc;">
                                <td style="padding: 20px 0;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 36px; height: 36px; border-radius: 8px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #1a2a6c; font-size: 0.8rem;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: #1e293b; font-size: 0.95rem;">{{ $user->name }}</div>
                                            <div style="font-size: 0.8rem; color: #94a3b8;">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 20px 0; text-align: right;">
                                    <span style="padding: 4px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; {{ $user->role == 'seller' ? 'background: #fffbeb; color: #b45309;' : 'background: #ecfdf5; color: #059669;' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div>
            <!-- System Intelligence Feed -->
            <div class="card" style="border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 0; overflow: hidden; position: sticky; top: 32px;">
                <div style="padding: 24px; border-bottom: 1px solid #f1f5f9; background: #fafafa;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #1a2a6c; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-stream"></i> Intelligence Feed
                    </h3>
                </div>
                <div style="padding: 24px; max-height: 600px; overflow-y: auto;">
                    @forelse($activities as $activity)
                    <div style="display: flex; gap: 16px; margin-bottom: 24px; position: relative;">
                        <div style="flex-shrink: 0; width: 36px; height: 36px; border-radius: 10px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #1a2a6c; font-size: 0.9rem; border: 1px solid #e2e8f0;">
                            <i class="fas {{ $activity->type == 'approval' ? 'fa-check' : ($activity->type == 'registration' ? 'fa-user-plus' : 'fa-info-circle') }}"></i>
                        </div>
                        <div style="flex: 1;">
                            <p style="font-size: 0.9rem; color: #1e293b; line-height: 1.4; font-weight: 500;">{{ $activity->message }}</p>
                            <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 600; display: block; margin-top: 4px;">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @empty
                    <div style="text-align: center; padding: 40px 0; color: #94a3b8;">
                        <p style="font-size: 0.9rem;">No recent activities.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection