@extends('layouts.dashboard')

@section('title', 'Government Schemes for Producers')

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
    <a href="{{ route('seller.settings') }}" class="nav-item">
        <i class="fas fa-store"></i>
        <span>Shop Settings</span>
    </a>
    <a href="{{ route('seller.schemes') }}" class="nav-item active">
        <i class="fas fa-file-invoice"></i>
        <span>Govt Schemes</span>
    </a>
    <a href="{{ route('seller.articles') }}" class="nav-item">
        <i class="fas fa-bullhorn"></i>
        <span>Textile Articles</span>
    </a>
@endsection

@section('content')
    @if(session('success'))
        <div style="background: #ecfdf5; color: #059669; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-weight: 600;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fef2f2; color: #ef4444; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-weight: 600;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 32px;">
        @forelse($schemes as $scheme)
        @php
            $hasApplied = \App\Models\SchemeApplication::where('scheme_id', $scheme->id)->where('user_id', auth()->id())->first();
        @endphp
        <div class="card" style="padding: 0; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: transform 0.3s; min-height: 280px;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="display: flex; flex-direction: column; md-flex-direction: row; min-height: 280px;">
                <div style="width: 100%; height: 200px; position: relative;">
                    @if($scheme->image)
                        <img src="{{ asset('storage/' . $scheme->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; background: #1a2a6c; display: flex; align-items: center; justify-content: center; color: white;">
                            <i class="fas fa-landmark" style="font-size: 4rem; opacity: 0.2;"></i>
                        </div>
                    @endif
                    <div style="position: absolute; top: 20px; left: 20px; background: #fdbb2d; color: #1a1a1a; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase;">
                        @if($hasApplied)
                            Application {{ ucfirst($hasApplied->status) }}
                        @else
                            Active
                        @endif
                    </div>
                </div>
                <div style="padding: 24px; display: flex; flex-direction: column; justify-content: space-between; flex: 1;">
                    <div>
                        <h3 style="font-size: 1.3rem; font-weight: 800; color: #1a2a6c; margin-bottom: 8px; line-height: 1.2;">{{ $scheme->title }}</h3>
                        <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.5; margin-bottom: 20px;">{{ Str::limit($scheme->description, 100) }}</p>
                    </div>
                    <div style="display: flex; gap: 12px; margin-top: auto;">
                        @if($hasApplied)
                            <button disabled style="flex: 1; background: #f1f5f9; color: #94a3b8; border: none; padding: 12px; border-radius: 10px; font-weight: 700; font-size: 0.85rem; cursor: not-allowed;">Already Applied</button>
                        @else
                            <button onclick="openApplyModal('{{ $scheme->id }}', '{{ addslashes($scheme->title) }}')" style="flex: 1; background: #1a2a6c; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 700; font-size: 0.85rem; cursor: pointer;">Apply Now</button>
                        @endif
                        <button title="View Details" onclick="showSchemeDetails({{ json_encode($scheme->title) }}, {{ json_encode($scheme->description) }})" style="width: 44px; height: 44px; background: white; border: 1px solid #e2e8f0; border-radius: 10px; color: #1a2a6c; cursor: pointer;"><i class="fas fa-info-circle"></i></button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 100px 0;">
            <i class="fas fa-landmark" style="font-size: 4rem; color: #e2e8f0; margin-bottom: 24px;"></i>
            <h2 style="color: #64748b; font-weight: 600;">No active schemes at the moment.</h2>
            <p style="color: #94a3b8; margin-top: 8px;">Check back later for new Ministry updates.</p>
        </div>
        @endforelse
    </div>

    <!-- Apply Modal -->
    <div id="applyModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: white; width: 500px; border-radius: 24px; padding: 40px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
            <h2 id="applyModalTitle" style="font-size: 1.5rem; font-weight: 800; color: #1a2a6c; margin-bottom: 24px;">Apply for Scheme</h2>
            <form id="applyForm" method="POST">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Application Notes / Background</label>
                    <textarea name="notes" placeholder="Tell us why you are applying and any relevant details..." required rows="4" style="width: 100%; padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-family: inherit; resize: none;"></textarea>
                </div>
                <div style="display: flex; gap: 12px;">
                    <button type="button" onclick="document.getElementById('applyModal').style.display='none'" style="flex: 1; background: #f1f5f9; color: #64748b; border: none; padding: 14px; border-radius: 12px; font-weight: 700; cursor: pointer;">Cancel</button>
                    <button type="submit" style="flex: 2; background: #1a2a6c; color: white; border: none; padding: 14px; border-radius: 12px; font-weight: 700; cursor: pointer;">Submit Application</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scheme Details Modal -->
    <div id="schemeModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
        <div style="background: white; width: 600px; border-radius: 24px; padding: 40px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative;">
            <button onclick="document.getElementById('schemeModal').style.display='none'" style="position: absolute; top: 24px; right: 24px; background: #f1f5f9; border: none; width: 36px; height: 36px; border-radius: 50%; color: #64748b; cursor: pointer;"><i class="fas fa-times"></i></button>
            <h2 id="modalSchemeTitle" style="font-size: 1.75rem; font-weight: 800; color: #1a2a6c; margin-bottom: 16px;"></h2>
            <div style="height: 4px; width: 60px; background: #fdbb2d; border-radius: 2px; margin-bottom: 24px;"></div>
            <p id="modalSchemeDescription" style="color: #475569; line-height: 1.8; font-size: 1.1rem; margin-bottom: 32px;"></p>
            <button onclick="document.getElementById('schemeModal').style.display='none'" style="width: 100%; background: #1a2a6c; color: white; border: none; padding: 16px; border-radius: 12px; font-weight: 700; cursor: pointer;">Close Details</button>
        </div>
    </div>

    <script>
        function openApplyModal(schemeId, schemeTitle) {
            const modal = document.getElementById('applyModal');
            const form = document.getElementById('applyForm');
            const title = document.getElementById('applyModalTitle');
            
            title.innerText = `Apply for: ${schemeTitle}`;
            form.action = `/seller/schemes/${schemeId}/apply`;
            modal.style.display = 'flex';
        }

        function showSchemeDetails(title, description) {
            document.getElementById('modalSchemeTitle').innerText = title;
            document.getElementById('modalSchemeDescription').innerText = description;
            document.getElementById('schemeModal').style.display = 'flex';
        }
    </script>
@endsection
