@extends('layouts.app')
@section('title','Cart - FoodieHub')
@push('styles')
<style>
.cart-page { max-width:1100px; margin:0 auto; padding:40px 20px; }
.page-title { font-family:'Playfair Display',serif; font-size:2rem; font-weight:900; color:var(--dark); margin-bottom:28px; }
.cart-grid { display:grid; grid-template-columns:1fr 360px; gap:28px; align-items:start; }

.cart-items-card { background:white; border-radius:20px; box-shadow:0 2px 12px rgba(0,0,0,0.06); border:1px solid var(--border); overflow:hidden; }
.cart-items-header { padding:20px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
.cart-items-header h3 { font-weight:700; color:var(--dark); }
.clear-cart { color:var(--danger); font-size:0.875rem; cursor:pointer; background:none; border:none; font-family:'DM Sans',sans-serif; font-weight:600; }

.cart-item { padding:20px 24px; border-bottom:1px solid var(--border); display:flex; gap:16px; align-items:center; }
.cart-item:last-child { border-bottom:none; }
.cart-item-img { width:80px; height:80px; border-radius:12px; object-fit:cover; flex-shrink:0; }
.cart-item-info { flex:1; min-width:0; }
.cart-item-name { font-weight:700; color:var(--dark); margin-bottom:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.cart-item-meta { font-size:0.8rem; color:var(--gray); margin-bottom:10px; }
.qty-ctrl { display:inline-flex; align-items:center; border:1.5px solid var(--border); border-radius:10px; overflow:hidden; }
.qty-btn { width:34px; height:34px; background:var(--light); border:none; font-size:1rem; cursor:pointer; transition:all 0.15s; font-family:'DM Sans',sans-serif; }
.qty-btn:hover { background:var(--primary); color:white; }
.qty-num { width:40px; text-align:center; font-weight:700; border:none; outline:none; font-size:0.9rem; font-family:'DM Sans',sans-serif; }
.cart-item-price { text-align:right; flex-shrink:0; }
.item-total { font-size:1.1rem; font-weight:800; color:var(--primary); }
.item-unit { font-size:0.78rem; color:var(--gray); margin-top:2px; }
.remove-btn { background:none; border:none; color:var(--danger); cursor:pointer; font-size:1rem; margin-top:8px; display:flex; align-items:center; gap:4px; font-size:0.8rem; font-family:'DM Sans',sans-serif; }

/* SUMMARY CARD */
.summary-card { background:white; border-radius:20px; box-shadow:0 2px 12px rgba(0,0,0,0.06); border:1px solid var(--border); padding:24px; position:sticky; top:90px; }
.summary-title { font-weight:800; font-size:1.1rem; color:var(--dark); margin-bottom:20px; }
.summary-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; font-size:0.9rem; }
.summary-row .label { color:var(--gray); }
.summary-row .value { font-weight:600; color:var(--dark); }
.summary-row.discount .value { color:var(--success); }
.summary-divider { border:none; border-top:1px solid var(--border); margin:16px 0; }
.summary-total { display:flex; justify-content:space-between; align-items:center; }
.summary-total .label { font-weight:700; font-size:1rem; color:var(--dark); }
.summary-total .value { font-size:1.3rem; font-weight:900; color:var(--primary); }

.coupon-section { margin:16px 0; }
.coupon-label { font-size:0.82rem; font-weight:600; color:var(--dark); margin-bottom:8px; }
.coupon-row { display:flex; gap:8px; }
.coupon-input {
    flex:1; padding:11px 14px; border:1.5px solid var(--border);
    border-radius:10px; font-size:0.875rem; outline:none;
    font-family:'DM Sans',sans-serif; text-transform:uppercase;
    transition:all 0.2s;
}
.coupon-input:focus { border-color:var(--primary); }
.coupon-btn {
    background:var(--dark); color:white; border:none; border-radius:10px;
    padding:11px 16px; font-size:0.875rem; font-weight:700; cursor:pointer;
    font-family:'DM Sans',sans-serif; transition:all 0.15s; white-space:nowrap;
}
.coupon-btn:hover { background:var(--primary); }
.coupon-msg { font-size:0.8rem; margin-top:6px; display:none; }
.coupon-msg.success { color:var(--success); display:block; }
.coupon-msg.error { color:var(--danger); display:block; }

.btn-checkout {
    width:100%; padding:15px; background:var(--primary); color:white;
    border:none; border-radius:12px; font-size:1rem; font-weight:700;
    cursor:pointer; font-family:'DM Sans',sans-serif; transition:all 0.2s;
    display:flex; align-items:center; justify-content:center; gap:10px;
    text-decoration:none; margin-top:16px;
}
.btn-checkout:hover { background:var(--primary-dark); transform:translateY(-1px); box-shadow:0 8px 24px rgba(255,69,0,0.3); }

.free-delivery-hint { background:linear-gradient(135deg,#F0FDF4,#DCFCE7); border-radius:10px; padding:12px 14px; font-size:0.82rem; color:#166534; margin-top:12px; display:flex; align-items:center; gap:8px; }

.empty-cart { text-align:center; padding:80px 20px; color:var(--gray); }
.empty-cart .icon { font-size:4rem; margin-bottom:16px; }
.empty-cart h3 { font-size:1.4rem; color:var(--dark); margin-bottom:10px; }
.empty-cart a { display:inline-block; margin-top:20px; padding:12px 28px; background:var(--primary); color:white; border-radius:12px; text-decoration:none; font-weight:700; }
</style>
@endpush

@section('content')
<div class="cart-page">
    <h1 class="page-title">🛒 Your Cart</h1>

    @if($cart->isEmpty())
    <div class="empty-cart">
        <div class="icon">🛒</div>
        <h3>Your cart is empty!</h3>
        <p>Add some delicious food to get started</p>
        <a href="{{ route('user.menu') }}">Browse Menu 🍽️</a>
    </div>
    @else
    <div class="cart-grid">
        <!-- Cart Items -->
        <div>
            <div class="cart-items-card">
                <div class="cart-items-header">
                    <h3>{{ $cart->count() }} item(s)</h3>
                    <button class="clear-cart" onclick="clearCart()">🗑️ Clear Cart</button>
                </div>
                <div id="cartItemsList">
                    @foreach($cart as $item)
                    <div class="cart-item" id="cartItem{{ $item->id }}">
                        <img src="{{ $item->food->image_url }}" alt="{{ $item->food->name }}"
                            class="cart-item-img"
                            onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=200'">
                        <div class="cart-item-info">
                            <div class="cart-item-name">{{ $item->food->name }}</div>
                            <div class="cart-item-meta">
                                {{ $item->food->category->icon ?? '' }} {{ $item->food->cuisine }}
                                • {{ $item->food->spicy_icon }}
                                @if($item->size) • Size: {{ $item->size }} @endif
                                @if($item->special_instructions)
                                <br>📝 {{ $item->special_instructions }}
                                @endif
                            </div>
                            <div class="qty-ctrl">
                                <button class="qty-btn" onclick="updateQty({{ $item->id }}, -1)">−</button>
                                <input type="text" class="qty-num" id="qty{{ $item->id }}" value="{{ $item->quantity }}" readonly>
                                <button class="qty-btn" onclick="updateQty({{ $item->id }}, 1)">+</button>
                            </div>
                        </div>
                        <div class="cart-item-price">
                            <div class="item-total" id="total{{ $item->id }}">Rs. {{ number_format($item->item_total) }}</div>
                            <div class="item-unit">Rs. {{ number_format($item->food->effective_price) }} each</div>
                            <button class="remove-btn" onclick="removeItem({{ $item->id }})">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div>
            <div class="summary-card">
                <div class="summary-title">Order Summary</div>

                <div class="summary-row">
                    <span class="label">Subtotal</span>
                    <span class="value" id="summarySubtotal">Rs. {{ number_format($subtotal) }}</span>
                </div>
                <div class="summary-row">
                    <span class="label">🚴 Delivery Fee</span>
                    <span class="value" id="summaryDelivery">
                        @if($deliveryFee == 0)
                        <span style="color:var(--success);font-weight:700;">FREE</span>
                        @else
                        Rs. {{ $deliveryFee }}
                        @endif
                    </span>
                </div>
                <div class="summary-row">
                    <span class="label">Tax (5%)</span>
                    <span class="value" id="summaryTax">Rs. {{ number_format($tax) }}</span>
                </div>
                <div class="summary-row discount" id="discountRow" style="{{ session('coupon_discount',0) > 0 ? '' : 'display:none;' }}">
                    <span class="label">🎁 Discount</span>
                    <span class="value" id="discountAmt">- Rs. {{ session('coupon_discount',0) }}</span>
                </div>
                <hr class="summary-divider">
                <div class="summary-total">
                    <span class="label">Total</span>
                    <span class="value" id="summaryTotal">Rs. {{ number_format($total) }}</span>
                </div>

                <!-- Coupon -->
                <div class="coupon-section">
                    <div class="coupon-label">🎟️ Have a coupon code?</div>
                    <div class="coupon-row">
                        <input type="text" class="coupon-input" id="couponInput" placeholder="e.g. WELCOME20" value="{{ session('applied_coupon','') }}">
                        <button class="coupon-btn" onclick="applyCoupon()">Apply</button>
                    </div>
                    <p class="coupon-msg" id="couponMsg"></p>
                    <p style="font-size:0.78rem;color:var(--gray);margin-top:6px;">Try: WELCOME20, SILVER100, GOLD15</p>
                </div>

                @if($subtotal < 1000)
                <div class="free-delivery-hint">
                    🚴 Add Rs. {{ number_format(1000 - $subtotal) }} more for <strong>FREE delivery!</strong>
                </div>
                @else
                <div class="free-delivery-hint">
                    🎉 You've got <strong>FREE delivery!</strong>
                </div>
                @endif

                <a href="{{ route('user.checkout') }}" class="btn-checkout">
                    💳 Proceed to Checkout
                </a>

                <a href="{{ route('user.menu') }}" style="display:block;text-align:center;color:var(--gray);font-size:0.875rem;margin-top:14px;text-decoration:none;">
                    + Add more items
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
@push('scripts')
<script>
function updateQty(id, delta) {
    const inp = document.getElementById(`qty${id}`);
    const newQty = Math.max(1, parseInt(inp.value) + delta);
    inp.value = newQty;
    fetch(`/cart/${id}`, {
        method:'PUT',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
        body:JSON.stringify({quantity: newQty})
    }).then(r=>r.json()).then(d=>{
        if(d.success) {
            document.getElementById(`total${id}`).textContent = 'Rs. ' + Math.round(d.item_total).toLocaleString();
            refreshSummary(d.subtotal);
        }
    });
}
function removeItem(id) {
    if(!confirm('Remove this item?')) return;
    fetch(`/cart/${id}`, {
        method:'DELETE',
        headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}
    }).then(r=>r.json()).then(d=>{
        if(d.success) {
            document.getElementById(`cartItem${id}`).remove();
            showToast('Item removed','success');
            updateCartCount();
            if(!document.querySelectorAll('.cart-item').length) location.reload();
        }
    });
}
function clearCart() {
    if(!confirm('Clear entire cart?')) return;
    // Remove all items one by one
    document.querySelectorAll('.cart-item').forEach(item => {
        const id = item.id.replace('cartItem','');
        fetch(`/cart/${id}`, { method:'DELETE', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}});
    });
    setTimeout(() => location.reload(), 500);
}
function applyCoupon() {
    const code = document.getElementById('couponInput').value.trim();
    if(!code) return;
    fetch('/cart/coupon', {
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
        body:JSON.stringify({coupon: code})
    }).then(r=>r.json()).then(d=>{
        const msg = document.getElementById('couponMsg');
        if(d.success) {
            msg.textContent = d.message; msg.className='coupon-msg success';
            document.getElementById('discountRow').style.display='flex';
            document.getElementById('discountAmt').textContent = '- Rs. ' + Math.round(d.discount).toLocaleString();
        } else {
            msg.textContent = d.message; msg.className='coupon-msg error';
        }
    });
}
function refreshSummary(subtotal) {
    const delivery = subtotal >= 1000 ? 0 : 99;
    const tax = subtotal * 0.05;
    const total = subtotal + delivery + tax;
    document.getElementById('summarySubtotal').textContent = 'Rs. ' + Math.round(subtotal).toLocaleString();
    document.getElementById('summaryDelivery').innerHTML = delivery === 0 ? '<span style="color:var(--success);font-weight:700;">FREE</span>' : 'Rs. ' + delivery;
    document.getElementById('summaryTax').textContent = 'Rs. ' + Math.round(tax).toLocaleString();
    document.getElementById('summaryTotal').textContent = 'Rs. ' + Math.round(total).toLocaleString();
}
</script>
@endpush
