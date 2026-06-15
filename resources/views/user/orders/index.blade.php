@extends('layouts.app')
@section('title','My Orders - FoodieHub')
@push('styles')
<style>
.orders-page { max-width:900px; margin:0 auto; padding:40px 20px; }
.page-header { margin-bottom:32px; }
.page-header h1 { font-family:'Playfair Display',serif; font-size:2rem; font-weight:900; color:var(--dark); margin-bottom:6px; }
.page-header p { color:var(--gray); }

.order-card {
    background:white; border-radius:18px; border:1.5px solid var(--border);
    margin-bottom:16px; overflow:hidden; transition:all 0.2s;
    box-shadow:0 2px 8px rgba(0,0,0,0.04);
}
.order-card:hover { border-color:var(--primary); box-shadow:0 8px 24px rgba(255,69,0,0.08); }
.order-header {
    padding:18px 22px; display:flex; align-items:center;
    gap:16px; flex-wrap:wrap; border-bottom:1px solid var(--border);
    background:var(--light);
}
.order-num { font-weight:800; color:var(--dark); font-size:1rem; }
.order-date { color:var(--gray); font-size:0.85rem; }
.order-status {
    padding:5px 14px; border-radius:50px; font-size:0.78rem; font-weight:700;
    margin-left:auto;
}
.status-pending { background:#FEF9C3; color:#854D0E; }
.status-confirmed { background:#DBEAFE; color:#1E40AF; }
.status-preparing { background:#FED7AA; color:#9A3412; }
.status-ready { background:#E9D5FF; color:#6B21A8; }
.status-on_the_way { background:#CFFAFE; color:#155E75; }
.status-delivered { background:#DCFCE7; color:#166534; }
.status-cancelled { background:#FEE2E2; color:#991B1B; }
.order-body { padding:18px 22px; }
.order-items-preview { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:14px; }
.order-item-chip {
    background:var(--light); border:1px solid var(--border);
    padding:5px 12px; border-radius:50px; font-size:0.8rem; color:var(--dark);
    display:flex; align-items:center; gap:6px;
}
.order-item-chip img { width:20px; height:20px; border-radius:50%; object-fit:cover; }
.order-footer { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
.order-total { font-size:1.1rem; font-weight:800; color:var(--primary); }
.order-actions { display:flex; gap:8px; }
.action-btn {
    padding:8px 16px; border-radius:10px; font-size:0.82rem; font-weight:700;
    text-decoration:none; cursor:pointer; border:none; font-family:'DM Sans',sans-serif;
    display:flex; align-items:center; gap:6px; transition:all 0.15s;
}
.action-btn.track { background:var(--primary); color:white; }
.action-btn.track:hover { background:var(--primary-dark); }
.action-btn.detail { background:var(--light); color:var(--dark); border:1.5px solid var(--border); }
.action-btn.detail:hover { border-color:var(--primary); color:var(--primary); }

.empty-state { text-align:center; padding:80px 20px; color:var(--gray); }
.empty-state .icon { font-size:4rem; margin-bottom:16px; }
</style>
@endpush

@section('content')
<div class="orders-page">
    <div class="page-header">
        <h1>📋 My Orders</h1>
        <p>Track and manage all your past orders</p>
    </div>

    @if($orders->isEmpty())
    <div class="empty-state">
        <div class="icon">📋</div>
        <h3 style="color:var(--dark);margin-bottom:8px;">No orders yet!</h3>
        <p>Your order history will appear here</p>
        <a href="{{ route('user.menu') }}" style="display:inline-block;margin-top:20px;padding:12px 28px;background:var(--primary);color:white;border-radius:12px;text-decoration:none;font-weight:700;">Start Ordering 🍽️</a>
    </div>
    @else
    @foreach($orders as $order)
    <div class="order-card">
        <div class="order-header">
            <div>
                <div class="order-num">#{{ $order->order_number }}</div>
                <div class="order-date">{{ $order->created_at->format('M d, Y • h:i A') }}</div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <span style="font-size:0.85rem;color:var(--gray);">{{ count($order->items) }} item(s)</span>
                <span style="font-size:0.85rem;color:var(--gray);">{{ ucfirst($order->type) }}</span>
                <span class="order-status status-{{ $order->status }}">
                    {{ $order->status_badge['icon'] }} {{ $order->status_badge['label'] }}
                </span>
            </div>
        </div>
        <div class="order-body">
            <div class="order-items-preview">
                @foreach(array_slice($order->items, 0, 4) as $item)
                <div class="order-item-chip">
                    <span>{{ $item['name'] }}</span>
                    <span style="color:var(--gray);">×{{ $item['quantity'] }}</span>
                </div>
                @endforeach
                @if(count($order->items) > 4)
                <div class="order-item-chip" style="background:#FFF0EB;color:var(--primary);">
                    +{{ count($order->items) - 4 }} more
                </div>
                @endif
            </div>
            <div class="order-footer">
                <div>
                    <div class="order-total">Rs. {{ number_format($order->total) }}</div>
                    <div style="font-size:0.78rem;color:var(--gray);">
                        {{ ucfirst($order->payment_method) }} • {{ ucfirst($order->payment_status) }}
                        @if($order->loyalty_points_earned) • +{{ $order->loyalty_points_earned }} pts @endif
                    </div>
                </div>
                <div class="order-actions">
                    @if(in_array($order->status, ['pending','confirmed','preparing','ready','picked_up','on_the_way']))
                    <a href="{{ route('user.order.track', $order->id) }}" class="action-btn track">📍 Track</a>
                    @endif
                    <a href="{{ route('user.order.show', $order->id) }}" class="action-btn detail">📄 Details</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div style="margin-top:20px;">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
