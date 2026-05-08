@extends('layouts.dashboard')

@section('title', 'User Management')

@section('sidebar_links')
    <a href="{{ route('admin.dashboard') }}" class="nav-item">
        <i class="fas fa-chart-pie"></i>
        <span>Overview</span>
    </a>
    <a href="{{ route('admin.users') }}" class="nav-item active">
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
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">User Directory</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Manage ministry stakeholders and portal access.</p>
        </div>
        <button style="background: #1a2a6c; color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 12px rgba(26, 42, 108, 0.2);">
            <i class="fas fa-user-plus" style="margin-right: 8px;"></i> Add New User
        </button>
    </div>

    <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <div style="padding: 24px; border-bottom: 1px solid #f1f5f9; background: #fafbfc; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; gap: 16px;">
                <div style="position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem;"></i>
                    <input type="text" placeholder="Search by name or email..." style="padding: 10px 10px 10px 40px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; width: 300px; font-size: 0.9rem; transition: all 0.3s;" onfocus="this.style.borderColor='#4338ca'; this.style.boxShadow='0 0 0 3px rgba(67, 56, 202, 0.1)';">
                </div>
                <select style="padding: 10px 16px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; background: white; font-size: 0.9rem; color: #64748b; cursor: pointer;">
                    <option value="">All Roles</option>
                    <option value="seller">Sellers</option>
                    <option value="buyer">Buyers</option>
                    <option value="admin">Administrators</option>
                </select>
            </div>
            <div style="color: var(--text-muted); font-size: 0.9rem;">
                Showing <b>{{ $users->firstItem() ?? 0 }}</b> to <b>{{ $users->lastItem() ?? 0 }}</b> of <b>{{ $users->total() }}</b> users
            </div>
        </div>
        
        <div style="padding: 0;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; background: #f8fafc; border-bottom: 1px solid #f1f5f9;">
                        <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700;">Stakeholder</th>
                        <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700;">Access Level</th>
                        <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700;">Status</th>
                        <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700;">Registration</th>
                        <th style="padding: 16px 24px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr style="border-bottom: 1px solid #f8fafc; transition: all 0.2s;" onmouseover="this.style.background='#fcfdff'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 20px 24px;">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <div style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #4338ca, #6366f1); display: flex; align-items: center; justify-content: center; font-weight: 700; color: white; font-size: 1.1rem; box-shadow: 0 4px 10px rgba(67, 56, 202, 0.2);">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 700; font-size: 1rem; color: #1e293b;">{{ $user->name }}</div>
                                    <div style="font-size: 0.85rem; color: #64748b;">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 20px 24px;">
                            <span style="
                                padding: 6px 14px; 
                                border-radius: 8px; 
                                font-size: 0.75rem; 
                                font-weight: 700; 
                                text-transform: uppercase;
                                letter-spacing: 0.5px;
                                {{ $user->role == 'admin' ? 'background: #eef2ff; color: #4338ca; border: 1px solid #c7d2fe;' : ($user->role == 'seller' ? 'background: #fffbeb; color: #b45309; border: 1px solid #fde68a;' : 'background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;') }}
                            ">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td style="padding: 20px 24px;">
                            <div style="display: flex; align-items: center; gap: 8px; color: {{ $user->is_approved ? '#059669' : '#b45309' }}; font-weight: 600; font-size: 0.9rem;">
                                <div style="width: 8px; height: 8px; border-radius: 50%; background: {{ $user->is_approved ? '#10b981' : '#fdbb2d' }};"></div> 
                                {{ $user->is_approved ? 'Approved' : 'Pending' }}
                            </div>
                        </td>
                        <td style="padding: 20px 24px; color: #64748b; font-size: 0.95rem;">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td style="padding: 20px 24px; text-align: center;">
                            <div style="display: flex; justify-content: center; gap: 10px;">
                                @if(!$user->is_approved)
                                <form action="{{ route('admin.users.approve', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button title="Approve User" style="width: 32px; height: 32px; border-radius: 8px; border: 1px solid #10b981; background: #ecfdf5; color: #059669; cursor: pointer; transition: all 0.2s;">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif
                                
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button title="Delete User" type="submit" style="width: 32px; height: 32px; border-radius: 8px; border: 1px solid #fee2e2; background: white; color: #ef4444; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='white'">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div style="padding: 24px; background: #fafbfc; border-top: 1px solid #f1f5f9;">
            {{ $users->links() }}
        </div>
    </div>
@endsection
