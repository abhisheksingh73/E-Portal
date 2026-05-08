@extends('layouts.dashboard')

@section('title', 'Customer Inquiries')

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
    <a href="{{ route('seller.inquiries') }}" class="nav-item active">
        <i class="fas fa-comments"></i>
        <span>Customer Inquiries</span>
    </a>
    <a href="{{ route('seller.settings') }}" class="nav-item">
        <i class="fas fa-store"></i>
        <span>Shop Settings</span>
    </a>
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Customer Inquiries</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Respond to messages from buyers interested in your textiles.</p>
        </div>
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
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Customer</th>
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Product</th>
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Message</th>
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Date</th>
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Status</th>
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inquiries as $inquiry)
                <tr style="border-bottom: 1px solid #f8fafc; transition: background 0.3s;" onmouseover="this.style.background='#fcfdff'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 20px 24px;">
                        <div style="font-weight: 700; color: #1e293b;">{{ $inquiry->buyer->name }}</div>
                        <div style="font-size: 0.8rem; color: #94a3b8;">{{ $inquiry->buyer->email }}</div>
                    </td>
                    <td style="padding: 20px 24px;">
                        @if($inquiry->product)
                            <div style="font-weight: 600; color: #1a2a6c;">{{ $inquiry->product->name }}</div>
                        @else
                            <span style="color: #94a3b8; font-style: italic;">General Inquiry</span>
                        @endif
                    </td>
                    <td style="padding: 20px 24px; max-width: 300px;">
                        <p style="font-size: 0.9rem; color: #475569; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $inquiry->message }}</p>
                    </td>
                    <td style="padding: 20px 24px; color: #94a3b8; font-size: 0.85rem;">
                        {{ $inquiry->created_at->format('M d, H:i') }}
                    </td>
                    <td style="padding: 20px 24px;">
                        <span style="
                            padding: 4px 10px; 
                            border-radius: 20px; 
                            font-size: 0.75rem; 
                            font-weight: 800; 
                            text-transform: uppercase;
                            {{ $inquiry->status == 'unread' ? 'background: #fef2f2; color: #ef4444;' : ($inquiry->status == 'read' ? 'background: #eff6ff; color: #1d4ed8;' : 'background: #ecfdf5; color: #059669;') }}
                        ">
                            {{ $inquiry->status }}
                        </span>
                    </td>
                    <td style="padding: 20px 24px; text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 8px;">
                            <form action="{{ route('seller.inquiries.updateStatus', $inquiry) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="read">
                                <button type="submit" style="background: #f1f5f9; color: #1e293b; border: none; padding: 8px; border-radius: 8px; cursor: pointer;" title="Mark as Read"><i class="fas fa-check"></i></button>
                            </form>
                            <button onclick="alert('Inquiry Message:\n\n{{ addslashes($inquiry->message) }}')" style="background: #1a2a6c; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 0.8rem; cursor: pointer;">View & Reply</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 60px; text-align: center; color: #94a3b8;">
                        <i class="fas fa-comment-slash" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.2;"></i>
                        <p>No customer inquiries yet.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
