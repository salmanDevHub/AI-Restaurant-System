@extends('layouts.app')
@section('title','Checkout - FoodieHub')
@push('styles')
<style>
.checkout-page { max-width:1060px; margin:0 auto; padding:40px 20px; }
.checkout-grid { display:grid; grid-template-columns:1fr 380px; gap:28px; align-items:start; }
.section-card { background:white; border-radius:20px; box-shadow:0 2px 12px rgba(0,0,0,0.06); border:1px solid var(--border); padding:28px; margin-bottom:20px; }
.sec-title { font-family:'Playfair Display',serif; font-size:1.2rem; font-weight:800; color:var(--dark); margin-bottom:20px; display:flex; align-items:center; gap:10px; }
.form-grid2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
.form-grid2 .full { grid-column:1/-1; }
.form-group { }
.form-label { display:block; font-size:0.82rem; font-weight:600; color:var(--dark); margin-bottom:7px; }
.form-control {
    width:100%; padding:12px 14px; border:1.5px solid var(--border);
    border-radius:11px; font-size:0.9rem; font-family:'DM Sans',sans-serif;
    outline:none; color:var(--dark); background:var(--light); transition:all 0.2s;
}
.form-control:focus { border-color:var(--primary); background:white; box-shadow:0 0 0 3px rgba(255,69,0,0.07); }
textarea.form-control { resize:vertical; min-height:90px; }

/* ORDER TYPE */
.type-options { display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; margin-bottom:20px; }
.type-opt { cursor:pointer; }
.type-opt input { display:none; }
.type-opt-label {
    display:flex; flex-direction:column; align-items:center; gap:6px;
    padding:16px 12px; border:2px solid var(--border); border-radius:14px;
    transition:all 0.2s; background:var(--light);
}
.type-opt input:checked + .type-opt-label { border-color:var(--primary); background:#FFF0EB; }
.type-opt-label .ico { font-size:1.6rem; }
.type-opt-label .lbl { font-size:0.82rem; font-weight:600; color:var(--dark); }

/* PAYMENT */
.pay-options { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.pay-opt { cursor:pointer; }
.pay-opt input { display:none; }
.pay-opt-label {
    display:flex; align-items:center; gap:12px; padding:14px 16px;
    border:2px solid var(--border); border-radius:12px;
    transition:all 0.2s; background:var(--light);
}
.pay-opt input:checked + .pay-opt-label { border-color:var(--primary); background:#FFF0EB; }
.pay-opt-label .pay-ico { font-size:1.4rem; }
.pay-opt-label .pay-lbl { font-size:0.875rem; font-weight:600; color:var(--dark); }

/* ORDER ITEMS */
.order-item-row { display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid var(--border); }
.order-item-row:last-child { border-bottom:none; }
.order-item-img { width:52px; height:52px; border-radius:10px; object-fit:cover; }
.order-item-info { flex:1; }
.order-item-name { font-weight:600; font-size:0.9rem; color:var(--dark); }
.order-item-sub { font-size:0.78rem; color:var(--gray); }
.order-item-price { font-weight:700; color:var(--primary); font-size:0.95rem; }

.summary-row { display:flex; justify-content:space-between; align-items:center; padding:8px 0; font-size:0.9rem; }
.summary-row .lbl { color:var(--gray); }
.summary-row .val { font-weight:600; color:var(--dark); }
.summary-row.discount .val { color:var(--success); }
.divider { border:none; border-top:1px solid var(--border); margin:12px 0; }
.total-row { display:flex; justify-content:space-between; align-items:center; }
.total-row .lbl { font-weight:700; color:var(--dark); font-size:1rem; }
.total-row .val { font-size:1.4rem; font-weight:900; color:var(--primary); }

.loyalty-info { background:linear-gradient(135deg,#FFF9F0,#FFF0E0); border:1px solid #FFD7B5; border-radius:12px; padding:12px 14px; margin-top:16px; font-size:0.85rem; color:var(--dark); }

.btn-place {
    width:100%; padding:16px; background:var(--primary); color:white;
    border:none; border-radius:14px; font-size:1.05rem; font-weight:800;
    cursor:pointer; font-family:'DM Sans',sans-serif; transition:all 0.2s;
    display:flex; align-items:center; justify-content:center; gap:10px;
    margin-top:16px;
}
.btn-place:hover { background:var(--primary-dark); transform:translateY(-2px); box-shadow:0 10px 28px rgba(255,69,0,0.35); }
.btn-place:disabled { opacity:0.7; cursor:not-allowed; transform:none; }

@media(max-width:900px) { .checkout-grid { grid-template-columns:1fr; } .type-options { grid-template-columns:1fr 1fr; } .pay-options { grid-template-columns:1fr 1fr; } .form-grid2 { grid-template-columns:1fr; } }
</style>
@endpush

@section('content')
<div class="checkout-page">
    <h1 style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:900;color:var(--dark);margin-bottom:28px;">💳 Checkout</h1>

    <form method="POST" action="{{ route('user.order.place') }}" id="checkoutForm">
        @csrf
        <div class="checkout-grid">
            <!-- LEFT COLUMN -->
            <div>
                <!-- Order Type -->
                <div class="section-card">
                    <div class="sec-title">🚚 Order Type</div>
                    <div class="type-options">
                        <label class="type-opt">
                            <input type="radio" name="type" value="delivery" checked>
                            <div class="type-opt-label"><span class="ico">🚴</span><span class="lbl">Delivery</span></div>
                        </label>
                        <label class="type-opt">
                            <input type="radio" name="type" value="pickup">
                            <div class="type-opt-label"><span class="ico">🏪</span><span class="lbl">Pickup</span></div>
                        </label>
                        <label class="type-opt">
                            <input type="radio" name="type" value="dine_in">
                            <div class="type-opt-label"><span class="ico">🍽️</span><span class="lbl">Dine In</span></div>
                        </label>
                    </div>
                </div>

                <!-- Delivery Details -->
                <div class="section-card" id="deliverySection">
                    <div class="sec-title">📍 Delivery Address</div>
                    @if($errors->any())
                    <div style="background:#FFF5F5;border:1px solid #FECACA;color:var(--danger);padding:12px 16px;border-radius:10px;font-size:0.875rem;margin-bottom:16px;">
                        {{ $errors->first() }}
                    </div>
                    @endif
                    <div class="form-grid2">
                        <div class="form-group">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="delivery_name" class="form-control"
                                value="{{ old('delivery_name', Auth::user()->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone Number *</label>
                            <input type="tel" name="delivery_phone" class="form-control"
                                value="{{ old('delivery_phone', Auth::user()->phone) }}" required>
                        </div>
                        <div class="form-group full">
                            <label class="form-label">Street Address *</label>
                            <input type="text" name="delivery_address" class="form-control"
                                placeholder="House #, Street, Area" value="{{ old('delivery_address', Auth::user()->address) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">City *</label>
                            <input type="text" name="delivery_city" class="form-control"
                                value="{{ old('delivery_city', Auth::user()->city ?? 'Lahore') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="delivery_postal_code" class="form-control"
                                value="{{ old('delivery_postal_code', Auth::user()->postal_code) }}">
                        </div>
                        <div class="form-group full">
                            <label class="form-label">Special Instructions (optional)</label>
                            <textarea name="special_instructions" class="form-control" placeholder="Ring the bell, leave at door, no onions...">{{ old('special_instructions') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment -->
                <div class="section-card">
                    <div class="sec-title">💳 Payment Method</div>
                    <div class="pay-options">
                        <label class="pay-opt">
                            <input type="radio" name="payment_method" value="cash" checked>
                            <div class="pay-opt-label"><span class="pay-ico">💵</span><div><div class="pay-lbl">Cash on Delivery</div><div style="font-size:0.75rem;color:var(--gray);">Pay when delivered</div></div></div>
                        </label>
                        <label class="pay-opt">
                            <input type="radio" name="payment_method" value="card">
                            <div class="pay-opt-label"><span class="pay-ico">💳</span><div><div class="pay-lbl">Credit/Debit Card</div><div style="font-size:0.75rem;color:var(--gray);">Visa, Mastercard</div></div></div>
                        </label>
                        <label class="pay-opt">
                            <input type="radio" name="payment_method" value="online">
                            <div class="pay-opt-label"><span class="pay-ico">📱</span><div><div class="pay-lbl">Online Payment</div><div style="font-size:0.75rem;color:var(--gray);">EasyPaisa, JazzCash</div></div></div>
                        </label>
                        <label class="pay-opt">
                            <input type="radio" name="payment_method" value="wallet">
                            <div class="pay-opt-label"><span class="pay-ico">👛</span><div><div class="pay-lbl">Loyalty Wallet</div><div style="font-size:0.75rem;color:var(--gray);">Use loyalty points</div></div></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN - Order Summary -->
            <div>
                <div class="section-card" style="margin-bottom:0;">
                    <div class="sec-title">📋 Order Summary</div>
                    @foreach($cart as $item)
                    <div class="order-item-row">
                        <img src="{{ $item->food->image_url }}" alt="{{ $item->food->name }}"
                            class="order-item-img"
                            onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=100'">
                        <div class="order-item-info">
                            <div class="order-item-name">{{ $item->food->name }}</div>
                            <div class="order-item-sub">× {{ $item->quantity }}</div>
                        </div>
                        <div class="order-item-price">Rs. {{ number_format($item->item_total) }}</div>
                    </div>
                    @endforeach

                    <hr class="divider">

                    <div class="summary-row">
                        <span class="lbl">Subtotal</span>
                        <span class="val">Rs. {{ number_format($subtotal) }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="lbl">Delivery Fee</span>
                        <span class="val">
                            @if($deliveryFee == 0)
                            <span style="color:var(--success);font-weight:700;">FREE 🎉</span>
                            @else
                            Rs. {{ $deliveryFee }}
                            @endif
                        </span>
                    </div>
                    <div class="summary-row">
                        <span class="lbl">Tax (5%)</span>
                        <span class="val">Rs. {{ number_format($tax) }}</span>
                    </div>
                    @if($discount > 0)
                    <div class="summary-row discount">
                        <span class="lbl">🎁 Coupon Discount</span>
                        <span class="val">- Rs. {{ number_format($discount) }}</span>
                    </div>
                    @endif
                    <hr class="divider">
                    <div class="total-row">
                        <span class="lbl">Total</span>
                        <span class="val">Rs. {{ number_format($total) }}</span>
                    </div>

                    <div class="loyalty-info">
                        ⭐ You'll earn <strong>{{ floor($total/100) }} loyalty points</strong> with this order!
                        @if(Auth::user()->loyalty_tier !== 'bronze')
                        <br>💎 {{ ucfirst(Auth::user()->loyalty_tier) }} member benefit applied!
                        @endif
                    </div>

                    <div style="margin-top:16px;padding:12px;background:var(--light);border-radius:10px;font-size:0.82rem;color:var(--gray);">
                        🕐 Estimated delivery: <strong style="color:var(--dark);">40-50 minutes</strong>
                    </div>

                    <button type="submit" class="btn-place" id="placeBtn">
                        ✅ Place Order — Rs. {{ number_format($total) }}
                    </button>
                    <p style="text-align:center;font-size:0.78rem;color:var(--gray);margin-top:10px;">
                        🔒 Secure order. You agree to our terms.
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
// Toggle delivery section
document.querySelectorAll('[name=type]').forEach(radio => {
    radio.addEventListener('change', function() {
        const section = document.getElementById('deliverySection');
        section.style.display = this.value === 'delivery' ? 'block' : 'none';
        // Remove required from delivery fields if not delivery
        section.querySelectorAll('[required]').forEach(f => {
            f.required = this.value === 'delivery';
        });
    });
});
document.getElementById('checkoutForm').addEventListener('submit', function() {
    const btn = document.getElementById('placeBtn');
    btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Placing order...';
});
</script>
@endpush
