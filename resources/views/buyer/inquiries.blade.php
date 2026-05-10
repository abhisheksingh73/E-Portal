@extends('layouts.dashboard')

@section('title', 'My Inquiries')

@section('sidebar_links')
    <a href="{{ route('buyer.dashboard') }}" class="nav-item">
        <i class="fas fa-home"></i>
        <span>My Home</span>
    </a>
    <a href="{{ route('buyer.marketplace') }}" class="nav-item">
        <i class="fas fa-shopping-bag"></i>
        <span>Marketplace</span>
    </a>
    <a href="{{ route('buyer.orders') }}" class="nav-item">
        <i class="fas fa-history"></i>
        <span>My Orders</span>
    </a>
    <a href="{{ route('buyer.cart') }}" class="nav-item">
        <i class="fas fa-shopping-cart"></i>
        <span>Shopping Cart</span>
    </a>
    <a href="{{ route('buyer.wishlist') }}" class="nav-item">
        <i class="fas fa-heart"></i>
        <span>Wishlist</span>
    </a>
    <a href="{{ route('buyer.inquiries') }}" class="nav-item active">
        <i class="fas fa-comments"></i>
        <span>My Inquiries</span>
    </a>
    <a href="{{ route('buyer.articles') }}" class="nav-item">
        <i class="fas fa-bullhorn"></i>
        <span>Textile Articles</span>
    </a>
    <a href="{{ route('buyer.schemes') }}" class="nav-item">
        <i class="fas fa-file-invoice"></i>
        <span>Govt Schemes</span>
    </a>
    <a href="{{ route('buyer.settings') }}" class="nav-item">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
    </a>
@endsection

@section('content')
    <div class="header-flex" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #1a2a6c;">Inquiry History</h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Track your conversations and questions sent to artisans.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <form action="{{ route('buyer.inquiries') }}" method="GET" style="display: flex; gap: 12px;">
                <select name="status" onchange="this.form.submit()" style="padding: 12px 16px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; background: white; cursor: pointer; color: #64748b; font-weight: 600;">
                    <option value="">All Statuses</option>
                    <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Pending</option>
                    <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read by Artisan</option>
                    <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
                </select>
                @if(request()->filled('status'))
                    <a href="{{ route('buyer.inquiries') }}" style="background: white; color: #ef4444; border: 1px solid #ef4444; padding: 12px; border-radius: 12px; display: flex; align-items: center; text-decoration: none;"><i class="fas fa-times"></i></a>
                @endif
            </form>
        </div>
    </div>

    <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; background: #f8fafc; border-bottom: 1px solid #f1f5f9;">
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Artisan / Shop</th>
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Textile Item</th>
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">My Message</th>
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Sent Date</th>
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700;">Status</th>
                    <th style="padding: 16px 24px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; font-weight: 700; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inquiries as $inquiry)
                <tr style="border-bottom: 1px solid #f8fafc; transition: background 0.3s;" onmouseover="this.style.background='#fcfdff'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 20px 24px;">
                        <div style="font-weight: 700; color: #1e293b;">{{ $inquiry->seller->name }}</div>
                        <div style="font-size: 0.8rem; color: #94a3b8;">Authorized Artisan</div>
                    </td>
                    <td style="padding: 20px 24px;">
                        @if($inquiry->product)
                            <div style="font-weight: 600; color: #1a2a6c;">{{ $inquiry->product->name }}</div>
                        @else
                            <span style="color: #94a3b8; font-style: italic;">General Question</span>
                        @endif
                    </td>
                    <td style="padding: 20px 24px; max-width: 250px;">
                        <p style="font-size: 0.9rem; color: #475569; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $inquiry->message }}</p>
                    </td>
                    <td style="padding: 20px 24px; color: #94a3b8; font-size: 0.85rem;">
                        {{ $inquiry->created_at->format('M d, Y') }}
                    </td>
                    <td style="padding: 20px 24px;">
                        @php
                            $statusLabel = [
                                'unread' => ['bg' => '#fef2f2', 'text' => '#ef4444', 'label' => 'Sent'],
                                'read' => ['bg' => '#eff6ff', 'text' => '#1d4ed8', 'label' => 'Seen'],
                                'replied' => ['bg' => '#ecfdf5', 'text' => '#059669', 'label' => 'Replied'],
                            ];
                            $status = $statusLabel[$inquiry->status] ?? $statusLabel['unread'];
                        @endphp
                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; background: {{ $status['bg'] }}; color: {{ $status['text'] }};">
                            {{ $status['label'] }}
                        </span>
                    </td>
                    <td style="padding: 20px 24px; text-align: center;">
                        <button onclick="openInquiryDetail({{ json_encode($inquiry) }}, '{{ $inquiry->seller->name }}')" style="background: #1a2a6c; color: white; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 0.8rem; cursor: pointer;">View Details</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 60px; text-align: center; color: #94a3b8;">
                        <i class="fas fa-comment-slash" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.2;"></i>
                        <p>You haven't sent any inquiries yet.</p>
                        <a href="{{ route('buyer.marketplace') }}" style="color: #1a2a6c; font-weight: 700; text-decoration: none; margin-top: 12px; display: inline-block;">Browse Marketplace <i class="fas fa-arrow-right"></i></a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 24px;">
        {{ $inquiries->links() }}
    </div>

    <!-- Inquiry Detail Modal -->
    <div id="detailModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: white; width: 650px; max-height: 90vh; border-radius: 28px; padding: 40px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative; display: flex; flex-direction: column;">
            <button onclick="document.getElementById('detailModal').style.display='none'" style="position: absolute; top: 24px; right: 24px; background: #f1f5f9; border: none; width: 36px; height: 36px; border-radius: 50%; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10;"><i class="fas fa-times"></i></button>
            
            <div style="margin-bottom: 24px;">
                <h2 style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-bottom: 4px;">Conversation Thread</h2>
                <p style="color: #64748b; font-size: 0.95rem;">Artisan: <b id="detailSellerName"></b></p>
            </div>

            <!-- Chat Area -->
            <div id="chatMessages" style="flex: 1; overflow-y: auto; padding: 20px; background: #f8fafc; border-radius: 20px; border: 1px solid #e2e8f0; display: flex; flex-direction: column; gap: 16px; margin-bottom: 24px;">
                <!-- Messages will be injected here -->
            </div>

            <!-- Reply Form (Counter Question) -->
            <form id="counterQuestForm" method="POST" style="margin-top: auto;">
                @csrf
                <div style="display: flex; gap: 12px; align-items: flex-end;">
                    <textarea name="message" required placeholder="Type your follow-up question here..." style="flex: 1; padding: 16px; border-radius: 16px; border: 1px solid #e2e8f0; outline: none; font-family: inherit; font-size: 0.95rem; resize: none; min-height: 80px;"></textarea>
                    <button type="submit" style="background: #1a2a6c; color: white; border: none; width: 50px; height: 50px; border-radius: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                <p style="font-size: 0.7rem; color: #94a3b8; margin-top: 10px; text-align: center;">Your message will be sent directly to the artisanCluster dashboard.</p>
            </form>
        </div>
    </div>

    <script>
        function openInquiryDetail(inquiry, sellerName) {
            document.getElementById('detailSellerName').innerText = sellerName;
            const chatContainer = document.getElementById('chatMessages');
            chatContainer.innerHTML = '';
            
            // Set form action
            document.getElementById('counterQuestForm').action = `/buyer/inquiries/${inquiry.id}/reply`;

            // Load messages (inquiry model now has 'messages' loaded via controller)
            // But since we pass inquiry as JSON, we need to make sure 'messages' was Eager Loaded in Controller
            const messages = inquiry.messages || [];
            
            if (messages.length === 0) {
                // Fallback for older data that only has message/reply_message
                addMessageToChat(inquiry.message, 'buyer', inquiry.created_at);
                if (inquiry.reply_message) {
                    addMessageToChat(inquiry.reply_message, 'seller', inquiry.updated_at);
                }
            } else {
                messages.forEach(msg => {
                    const type = msg.sender_id == {{ auth()->id() }} ? 'buyer' : 'seller';
                    addMessageToChat(msg.body, type, msg.created_at);
                });
            }
            
            document.getElementById('detailModal').style.display = 'flex';
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        function addMessageToChat(text, type, time) {
            const container = document.getElementById('chatMessages');
            const msgDiv = document.createElement('div');
            
            const isBuyer = type === 'buyer';
            const bgColor = isBuyer ? '#1a2a6c' : '#ffffff';
            const textColor = isBuyer ? '#ffffff' : '#1e293b';
            const align = isBuyer ? 'flex-end' : 'flex-start';
            const border = isBuyer ? 'none' : '1px solid #e2e8f0';
            const date = new Date(time).toLocaleDateString([], { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });

            msgDiv.style.cssText = `
                display: flex;
                flex-direction: column;
                align-self: ${align};
                max-width: 80%;
            `;

            msgDiv.innerHTML = `
                <div style="background: ${bgColor}; color: ${textColor}; padding: 14px 18px; border-radius: 18px; border-bottom-${isBuyer ? 'right' : 'left'}-radius: 4px; border: ${border}; font-size: 0.95rem; line-height: 1.5; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
                    ${text}
                </div>
                <span style="font-size: 0.65rem; color: #94a3b8; margin-top: 6px; align-self: ${align}; font-weight: 600;">${date}</span>
            `;

            container.appendChild(msgDiv);
        }
    </script>
@endsection
