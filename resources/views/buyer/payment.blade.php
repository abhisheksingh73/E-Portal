@extends('layouts.dashboard')

@section('title', 'Secure Payment')

@section('content')
<div style="max-width: 600px; margin: 0 auto; padding: 40px 0;">
    <div class="card" style="border: none; box-shadow: var(--shadow-lg); padding: 40px; border-radius: 32px; background: white;">
        <div style="text-align: center; margin-bottom: 32px;">
            <div style="width: 80px; height: 80px; background: rgba(26, 42, 108, 0.1); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <i class="fas fa-shield-alt" style="font-size: 2.5rem; color: #1a2a6c;"></i>
            </div>
            <h1 style="font-size: 1.8rem; font-weight: 800; color: #1a2a6c;">Secure Payment Gateway</h1>
            <p style="color: #64748b; font-weight: 500;">Textile Ministry Encrypted Checkout</p>
        </div>

        <div style="background: #f8fafc; padding: 24px; border-radius: 20px; margin-bottom: 32px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <div style="font-size: 0.85rem; color: #94a3b8; font-weight: 700; text-transform: uppercase;">Amount to Pay</div>
                <div style="font-size: 1.5rem; font-weight: 800; color: #1e293b;">₹{{ number_format($total_amount, 2) }}</div>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 0.85rem; color: #94a3b8; font-weight: 700; text-transform: uppercase;">Items</div>
                <div style="font-size: 1.1rem; font-weight: 700; color: #1a2a6c;">{{ count($items) }} Products</div>
            </div>
        </div>

        <form action="{{ route('buyer.cart.process_payment') }}" method="POST">
            @csrf
            <input type="hidden" name="shipping_address" value="{{ $shipping_address }}">
            @foreach($items as $item)
                <input type="hidden" name="items[]" value="{{ json_encode(['id' => $item->product->id, 'qty' => $item->quantity]) }}">
            @endforeach
            
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 0.9rem;">Cardholder Name</label>
                <input type="text" required placeholder="John Doe" style="width: 100%; padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem;">
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 0.9rem;">Card Number</label>
                <div style="position: relative;">
                    <input type="text" name="card_number" required placeholder="xxxx xxxx xxxx xxxx" maxlength="16" style="width: 100%; padding: 14px 14px 14px 50px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem;">
                    <i class="far fa-credit-card" style="position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 32px;">
                <div>
                    <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 0.9rem;">Expiry Date</label>
                    <input type="text" required placeholder="MM / YY" style="width: 100%; padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem; text-align: center;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 0.9rem;">CVV</label>
                    <input type="password" required placeholder="***" maxlength="3" style="width: 100%; padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; font-size: 1rem; text-align: center;">
                </div>
            </div>

            <button type="submit" style="width: 100%; background: linear-gradient(45deg, #1a2a6c, #b21f1f); color: white; border: none; padding: 18px; border-radius: 16px; font-weight: 800; font-size: 1.1rem; cursor: pointer; box-shadow: 0 10px 20px rgba(178, 31, 31, 0.2); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                Pay Now & Confirm Order
            </button>
        </form>

        <div style="margin-top: 32px; display: flex; justify-content: center; gap: 20px; filter: grayscale(1); opacity: 0.5;">
            <i class="fab fa-cc-visa" style="font-size: 2rem;"></i>
            <i class="fab fa-cc-mastercard" style="font-size: 2rem;"></i>
            <i class="fab fa-cc-apple-pay" style="font-size: 2rem;"></i>
            <i class="fab fa-cc-amazon-pay" style="font-size: 2rem;"></i>
        </div>
    </div>
</div>
@endsection
