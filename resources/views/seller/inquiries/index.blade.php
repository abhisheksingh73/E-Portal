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
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Customer Inquiries</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Respond to messages from buyers interested in your textiles.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <form action="{{ route('seller.inquiries') }}" method="GET" style="display: flex; gap: 12px;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search messages..." style="padding: 12px 16px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; width: 220px;">
                <select name="status" onchange="this.form.submit()" style="padding: 12px 16px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; background: white; cursor: pointer; color: #64748b; font-weight: 600;">
                    <option value="">All Statuses</option>
                    <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                    <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                    <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
                </select>
                @if(request()->filled('search') || request()->filled('status'))
                    <a href="{{ route('seller.inquiries') }}" style="background: white; color: #ef4444; border: 1px solid #ef4444; padding: 12px; border-radius: 12px; display: flex; align-items: center; text-decoration: none;"><i class="fas fa-times"></i></a>
                @endif
            </form>
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
                            <button onclick="openReplyModal({{ json_encode($inquiry) }}, '{{ $inquiry->buyer->name }}')" style="background: #1a2a6c; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 0.8rem; cursor: pointer;">View & Reply</button>
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

    <!-- Reply Modal -->
    <div id="replyModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: white; width: 650px; max-height: 90vh; border-radius: 28px; padding: 40px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative; display: flex; flex-direction: column;">
            <button onclick="document.getElementById('replyModal').style.display='none'" style="position: absolute; top: 24px; right: 24px; background: #f1f5f9; border: none; width: 36px; height: 36px; border-radius: 50%; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10;"><i class="fas fa-times"></i></button>
            
            <div style="margin-bottom: 24px;">
                <h2 style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-bottom: 4px;">Inquiry Thread</h2>
                <p style="color: #64748b; font-size: 0.95rem;">Buyer: <b id="replyBuyerName"></b></p>
            </div>

            <!-- Chat Area -->
            <div id="sellerChatMessages" style="flex: 1; overflow-y: auto; padding: 20px; background: #f8fafc; border-radius: 20px; border: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 16px; margin-bottom: 24px;">
                <!-- Messages will be injected here -->
            </div>

            <form id="replyForm" method="POST" style="margin-top: auto;">
                @csrf
                <div style="display: flex; gap: 12px; align-items: flex-end;">
                    <textarea name="reply_message" id="reply_message" required rows="3" placeholder="Type your response to the buyer..." style="flex: 1; padding: 16px; border-radius: 16px; border: 1px solid #e2e8f0; outline: none; font-family: inherit; font-size: 0.95rem; resize: none; min-height: 80px;"></textarea>
                    <button type="submit" style="background: #1a2a6c; color: white; border: none; width: 50px; height: 50px; border-radius: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openReplyModal(inquiry, buyerName) {
            document.getElementById('replyBuyerName').innerText = buyerName;
            const chatContainer = document.getElementById('sellerChatMessages');
            chatContainer.innerHTML = '';
            
            // Set form action
            document.getElementById('replyForm').action = `/seller/inquiries/${inquiry.id}/reply`;

            const messages = inquiry.messages || [];
            
            if (messages.length === 0) {
                // Fallback for older data
                addMessageToSellerChat(inquiry.message, 'buyer', inquiry.created_at);
                if (inquiry.reply_message) {
                    addMessageToSellerChat(inquiry.reply_message, 'seller', inquiry.updated_at);
                }
            } else {
                messages.forEach(msg => {
                    const type = msg.sender_id == {{ auth()->id() }} ? 'seller' : 'buyer';
                    addMessageToSellerChat(msg.body, type, msg.created_at);
                });
            }
            
            document.getElementById('replyModal').style.display = 'flex';
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        function addMessageToSellerChat(text, type, time) {
            const container = document.getElementById('sellerChatMessages');
            const msgDiv = document.createElement('div');
            
            const isSeller = type === 'seller';
            const bgColor = isSeller ? '#1a2a6c' : '#ffffff';
            const textColor = isSeller ? '#ffffff' : '#1e293b';
            const align = isSeller ? 'flex-end' : 'flex-start';
            const border = isSeller ? 'none' : '1px solid #e2e8f0';
            const date = new Date(time).toLocaleDateString([], { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });

            msgDiv.style.cssText = `
                display: flex;
                flex-direction: column;
                align-self: ${align};
                max-width: 80%;
            `;

            msgDiv.innerHTML = `
                <div style="background: ${bgColor}; color: ${textColor}; padding: 14px 18px; border-radius: 18px; border-bottom-${isSeller ? 'right' : 'left'}-radius: 4px; border: ${border}; font-size: 0.95rem; line-height: 1.5; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                    ${text}
                </div>
                <span style="font-size: 0.65rem; color: #94a3b8; margin-top: 6px; align-self: ${align}; font-weight: 600;">${date}</span>
            `;

            container.appendChild(msgDiv);
        }
    </script>
@endsection
