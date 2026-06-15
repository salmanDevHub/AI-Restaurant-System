@extends('layouts.app')
@section('title','Track Order - FoodieHub')
@push('styles')
<style>
.track-page { max-width:700px; margin:0 auto; padding:40px 20px; }
.order-card { background:white; border-radius:20px; box-shadow:0 4px 20px rgba(0,0,0,0.08); border:1px solid var(--border); padding:28px; margin-bottom:24px; }
.order-info-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px; flex-wrap:wrap; gap:12px; }
.order-num-big { font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:900; color:var(--dark); }
.order-status-big { padding:8px 20px; border-radius:50px; font-weight:700; font-size:0.9rem; }
.status-pending { background:#FEF9C3; color:#854D0E; }
.status-confirmed { background:#DBEAFE; color:#1E40AF; }
.status-preparing { background:#FED7AA; color:#9A3412; }
.status-ready { background:#E9D5FF; color:#6B21A8; }
.status-on_the_way { background:#CFFAFE; color:#155E75; }
.status-delivered { background:#DCFCE7; color:#166534; }
.status-cancelled { background:#FEE2E2; color:#991B1B; }

/* TRACKING STEPS */
.tracking-steps { position:relative; padding-left:32px; }
.tracking-steps::before { content:''; position:absolute; left:14px; top:20px; bottom:20px; width:2px; background:var(--border); }
.step { position:relative; padding:0 0 28px 28px; }
.step:last-child { padding-bottom:0; }
.step-dot {
    position:absolute; left:-32px; top:3px;
    width:28px; height:28px; border-radius:50%;
    background:var(--border); border:3px solid white;
    box-shadow:0 0 0 3px var(--border);
    display:flex; align-items:center; justify-content:center;
    font-size:0.9rem; z-index:1;
    transition:all 0.3s;
}
.step.done .step-dot { background:var(--success); box-shadow:0 0 0 3px #DCFCE7; }
.step.active .step-dot { background:var(--primary); box-shadow:0 0 0 4px #FFF0EB; animation:pulse-step 1.5s infinite; }
@keyframes pulse-step { 0%,100%{box-shadow:0 0 0 4px #FFF0EB}50%{box-shadow:0 0 0 8px rgba(255,69,0,0.1)} }
.step-content { }
.step-title { font-weight:700; color:var(--dark); font-size:0.95rem; }
.step.pending-step .step-title { color:var(--gray); }
.step-msg { font-size:0.83rem; color:var(--gray); margin-top:3px; }
.step-time { font-size:0.78rem; color:var(--gray); margin-top:2px; }

.delivery-info { background:var(--light); border-radius:14px; padding:18px; margin-top:16px; }
.delivery-info-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.dinfo-item { }
.dinfo-label { font-size:0.78rem; color:var(--gray); margin-bottom:3px; }
.dinfo-value { font-weight:600; color:var(--dark); font-size:0.9rem; }

.order-items-list { margin-top:16px; }
.order-item-row { display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid var(--border); }
.order-item-row:last-child { border-bottom:none; }
.order-item-row img { width:46px; height:46px; border-radius:10px; object-fit:cover; }
.order-item-row .item-name { flex:1; font-weight:600; font-size:0.875rem; color:var(--dark); }
.order-item-row .item-qty { font-size:0.8rem; color:var(--gray); }
.order-item-row .item-price { font-weight:700; color:var(--primary); font-size:0.9rem; }

.eta-box { background:linear-gradient(135deg,var(--primary),#FF8C42); color:white; border-radius:16px; padding:20px; text-align:center; margin-bottom:20px; }
.eta-time { font-family:'Playfair Display',serif; font-size:2rem; font-weight:900; }
.eta-label { font-size:0.875rem; opacity:0.9; margin-top:4px; }

@media(max-width:600px) { .delivery-info-grid { grid-template-columns:1fr; } .order-info-header { flex-direction:column; } }
</style>
@endpush

@section('content')
<div class="track-page">
    <a href="{{ route('user.orders') }}" style="display:inline-flex;align-items:center;gap:8px;color:var(--gray);text-decoration:none;margin-bottom:24px;font-size:0.875rem;">
        ← Back to Orders
    </a>

    @if($order->status !== 'delivered' && $order->status !== 'cancelled')
    <div class="eta-box">
        <div class="eta-time">~{{ $order->estimated_delivery_at ? $order->estimated_delivery_at->diffInMinutes(now()) : 40 }} min</div>
        <div class="eta-label">⏱ Estimated delivery time</div>
    </div>
    @endif

    <div class="order-card">
        <div class="order-info-header">
            <div>
                <div class="order-num-big">#{{ $order->order_number }}</div>
                <div style="color:var(--gray);font-size:0.875rem;margin-top:4px;">
                    Placed {{ $order->created_at->diffForHumans() }} • {{ count($order->items) }} item(s)
                </div>
            </div>
            <span class="order-status-big status-{{ $order->status }}" id="orderStatusBadge">
                {{ $order->status_badge['icon'] }} {{ $order->status_badge['label'] }}
            </span>
        </div>

        <!-- Tracking Steps -->
        <div class="tracking-steps" id="trackingSteps">
            @php
            $steps = [
                ['key'=>'pending', 'icon'=>'⏳', 'label'=>'Order Placed', 'desc'=>'Your order has been received'],
                ['key'=>'confirmed', 'icon'=>'✅', 'label'=>'Confirmed', 'desc'=>'Restaurant confirmed your order'],
                ['key'=>'preparing', 'icon'=>'👨‍🍳', 'label'=>'Preparing', 'desc'=>'Chef is cooking your meal'],
                ['key'=>'ready', 'icon'=>'📦', 'label'=>'Ready', 'desc'=>'Food is packed and ready'],
                ['key'=>'picked_up', 'icon'=>'🛵', 'label'=>'Picked Up', 'desc'=>'Rider picked up your order'],
                ['key'=>'on_the_way', 'icon'=>'🚴', 'label'=>'On the Way', 'desc'=>'Rider is heading to you'],
                ['key'=>'delivered', 'icon'=>'🎉', 'label'=>'Delivered', 'desc'=>'Enjoy your meal!'],
            ];
            $statusOrder = ['pending','confirmed','preparing','ready','picked_up','on_the_way','delivered'];
            $currentIdx = array_search($order->status, $statusOrder);
            @endphp

            @foreach($steps as $idx => $step)
            @php
                $stepIdx = array_search($step['key'], $statusOrder);
                $isDone = $stepIdx < $currentIdx;
                $isActive = $step['key'] === $order->status;
                $isPending = $stepIdx > $currentIdx;
                $tracking = $order->tracking->where('status', $step['key'])->first();
            @endphp
            <div class="step {{ $isDone ? 'done' : ($isActive ? 'active' : 'pending-step') }}">
                <div class="step-dot">{{ $isDone ? '✓' : ($isActive ? $step['icon'] : '') }}</div>
                <div class="step-content">
                    <div class="step-title">{{ $step['label'] }}</div>
                    <div class="step-msg">
                        @if($tracking) {{ $tracking->message }}
                        @elseif(!$isPending) {{ $step['desc'] }}
                        @else {{ $step['desc'] }}
                        @endif
                    </div>
                    @if($tracking)
                    <div class="step-time">{{ $tracking->tracked_at->format('h:i A') }}</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Delivery Info -->
    <div class="order-card">
        <h3 style="font-weight:700;color:var(--dark);margin-bottom:16px;">📍 Delivery Details</h3>
        <div class="delivery-info-grid">
            <div class="dinfo-item">
                <div class="dinfo-label">Name</div>
                <div class="dinfo-value">{{ $order->delivery_name }}</div>
            </div>
            <div class="dinfo-item">
                <div class="dinfo-label">Phone</div>
                <div class="dinfo-value">{{ $order->delivery_phone }}</div>
            </div>
            <div class="dinfo-item" style="grid-column:1/-1;">
                <div class="dinfo-label">Address</div>
                <div class="dinfo-value">{{ $order->delivery_address }}, {{ $order->delivery_city }}</div>
            </div>
            <div class="dinfo-item">
                <div class="dinfo-label">Payment</div>
                <div class="dinfo-value">{{ ucfirst($order->payment_method) }}</div>
            </div>
            <div class="dinfo-item">
                <div class="dinfo-label">Total</div>
                <div class="dinfo-value" style="color:var(--primary);">Rs. {{ number_format($order->total) }}</div>
            </div>
            @if($order->deliveryPerson)
            <div class="dinfo-item" style="grid-column:1/-1;">
                <div class="dinfo-label">🛵 Delivery Rider</div>
                <div class="dinfo-value">{{ $order->deliveryPerson->name }}</div>
            </div>
            @endif
        </div>
        @if($order->special_instructions)
        <div style="margin-top:14px;padding:12px;background:var(--light);border-radius:10px;font-size:0.875rem;">
            📝 <strong>Instructions:</strong> {{ $order->special_instructions }}
        </div>
        @endif
    </div>

    <!-- Order Items -->
    <div class="order-card">
        <h3 style="font-weight:700;color:var(--dark);margin-bottom:16px;">🍽️ Order Items</h3>
        <div class="order-items-list">
            @foreach($order->items as $item)
            <div class="order-item-row">
                <span style="font-size:1.5rem;">🍽️</span>
                <div class="item-name">{{ $item['name'] }}</div>
                <div class="item-qty">×{{ $item['quantity'] }}</div>
                <div class="item-price">Rs. {{ number_format($item['price'] * $item['quantity']) }}</div>
            </div>
            @endforeach
        </div>
        <div style="margin-top:16px;padding-top:14px;border-top:1px solid var(--border);">
            <div style="display:flex;justify-content:space-between;font-size:0.9rem;color:var(--gray);margin-bottom:6px;"><span>Subtotal</span><span>Rs. {{ number_format($order->subtotal) }}</span></div>
            @if($order->discount > 0)<div style="display:flex;justify-content:space-between;font-size:0.9rem;color:var(--success);margin-bottom:6px;"><span>Discount</span><span>- Rs. {{ number_format($order->discount) }}</span></div>@endif
            <div style="display:flex;justify-content:space-between;font-size:0.9rem;color:var(--gray);margin-bottom:6px;"><span>Delivery</span><span>{{ $order->delivery_fee == 0 ? 'FREE' : 'Rs. '.$order->delivery_fee }}</span></div>
            <div style="display:flex;justify-content:space-between;font-weight:800;font-size:1.1rem;color:var(--primary);border-top:1px solid var(--border);padding-top:12px;margin-top:8px;"><span>Total</span><span>Rs. {{ number_format($order->total) }}</span></div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
// Auto-refresh tracking status every 30 seconds for active orders
@if(in_array($order->status, ['confirmed','preparing','ready','picked_up','on_the_way']))
setInterval(() => {
    fetch('{{ route("user.order.track", $order->id) }}', {
        headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'}
    }).then(r => r.json()).then(d => {
        if(d.status !== '{{ $order->status }}') {
            location.reload();
        }
    }).catch(() => {});
}, 30000);
@endif
</script>
@endpush
