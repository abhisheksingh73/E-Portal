@extends('layouts.dashboard')

@section('title', 'Scheme Applications')

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
    <a href="{{ route('admin.schemes') }}" class="nav-item active">
        <i class="fas fa-file-invoice"></i>
        <span>Govt Schemes</span>
    </a>
    <a href="{{ route('admin.articles') }}" class="nav-item">
        <i class="fas fa-bullhorn"></i>
        <span>Marketing Content</span>
    </a>
@endsection

@section('content')
    <div style="display: flex; gap: 20px; margin-bottom: 32px; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
        <a href="{{ route('admin.schemes') }}" style="color: #64748b; text-decoration: none; font-weight: 600; padding: 8px 16px;">Active Schemes</a>
        <a href="{{ route('admin.schemes.applications') }}" style="color: #1a2a6c; text-decoration: none; font-weight: 800; padding: 8px 16px; border-bottom: 3px solid #1a2a6c;">Applications In-Box</a>
    </div>

    <div class="header-flex" style="margin-bottom: 32px;">
        <h1 style="font-size: 2rem; font-weight: 800; color: #111827;">Stakeholder <span style="color: #1a2a6c;">Applications</span></h1>
        <p style="color: #64748b;">Review and process requests for Ministry government schemes.</p>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; color: #059669; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-weight: 600;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; background: #f8fafc; border-bottom: 1px solid #f1f5f9;">
                    <th style="padding: 16px 24px; color: #64748b; font-size: 0.85rem; font-weight: 700;">Applicant</th>
                    <th style="padding: 16px 24px; color: #64748b; font-size: 0.85rem; font-weight: 700;">Applied For</th>
                    <th style="padding: 16px 24px; color: #64748b; font-size: 0.85rem; font-weight: 700;">Notes</th>
                    <th style="padding: 16px 24px; color: #64748b; font-size: 0.85rem; font-weight: 700;">Date</th>
                    <th style="padding: 16px 24px; color: #64748b; font-size: 0.85rem; font-weight: 700;">Status</th>
                    <th style="padding: 16px 24px; color: #64748b; font-size: 0.85rem; font-weight: 700; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                <tr style="border-bottom: 1px solid #f8fafc;">
                    <td style="padding: 20px 24px;">
                        <div style="font-weight: 700; color: #1e293b;">{{ $app->user->name }}</div>
                        <div style="font-size: 0.8rem; color: #64748b;">{{ strtoupper($app->user->role) }}</div>
                    </td>
                    <td style="padding: 20px 24px; font-weight: 600; color: #1a2a6c;">{{ $app->scheme->title }}</td>
                    <td style="padding: 20px 24px; color: #64748b; font-size: 0.9rem; max-width: 300px;">{{ $app->application_notes }}</td>
                    <td style="padding: 20px 24px; color: #64748b;">{{ $app->created_at->format('M d, Y') }}</td>
                    <td style="padding: 20px 24px;">
                        <span style="padding: 6px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; 
                            {{ $app->status == 'approved' ? 'background: #ecfdf5; color: #059669;' : ($app->status == 'rejected' ? 'background: #fef2f2; color: #ef4444;' : 'background: #fffbeb; color: #b45309;') }}">
                            {{ strtoupper($app->status) }}
                        </span>
                    </td>
                    <td style="padding: 20px 24px; text-align: right;">
                        @if($app->status == 'pending')
                        <div style="display: flex; justify-content: flex-end; gap: 8px;">
                            <form action="{{ route('admin.schemes.applications.status', $app) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button style="background: #059669; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer;">Approve</button>
                            </form>
                            <form action="{{ route('admin.schemes.applications.status', $app) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button style="background: #ef4444; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer;">Reject</button>
                            </form>
                        </div>
                        @else
                            <span style="color: #94a3b8; font-size: 0.85rem; font-style: italic;">Processed</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 60px; text-align: center; color: #94a3b8;">
                        <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.5;"></i>
                        <h3>No applications found.</h3>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
