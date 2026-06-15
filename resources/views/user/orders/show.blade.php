@extends('layouts.app')
@section('title','Order #'.$order->order_number.' - FoodieHub')
@section('content')
<div style="max-width:760px;margin:0 auto;padding:40px 20px;">
    <a href="{{ route('user.orders') }}" style="display:inline-flex;align-items:center;gap:8px;color:var(--gray);text-decoration:none;margin-bottom:24px;font-size:0.875rem;">← Back to Orders</a>

    <div style="background:white;border-radius:20px;box-shadow:0 4px 20px rgba(0,0,0,0.08);border:1px solid var(--border);padding:28px;margin-bottom:20px;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;margin-bottom:20px;">
            <div>
                <h1 style="font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:900;">#{{ $order->order_number }}</h1>
                <p style="color:var(--gray);font-size:0.875rem;">Placed {{ $order->created_at->format('M d, Y h:i A') }}</p>
            </div>
            @php $b=$order->status_badge; @endphp
            <span style="padding:8px 20px;border-radius:50px;font-weight:700;font-size:0.9rem;background:{{ match($b['color']){'green'=>'#DCFCE7','red'=>'#FEE2E2','yellow'=>'#FEF9C3','blue'=>'#DBEAFE',default=>'#F3F4F6'} }};color:{{ match($b['color']){'green'=>'#166534','red'=>'#991B1B','yellow'=>'#854D0E','blue'=>'#1E40AF',default=>'#374151'} }};">{{ $b['icon'] }} {{ $b['label'] }}</span>
        </div>

        {{-- Items --}}
        <h3 style="font-weight:700;margin-bottom:14px;">🍽️ Items Ordered</h3>
        @foreach($order->items as $item)
        <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border);">
            <div style="font-weight:600;">{{ $item['name'] }} <span style="color:var(--gray);font-weight:400;">× {{ $item['quantity'] }}</span></div>
            <div style="font-weight:700;color:var(--primary);">Rs.{{ number_format($item['price']*$item['quantity']) }}</div>
        </div>
        @endforeach
        <div style="margin-top:16px;max-width:260px;margin-left:auto;">
            <div style="display:flex;justify-content:space-between;padding:6px 0;font-size:0.875rem;color:var(--gray);"><span>Subtotal</span><span>Rs.{{ number_format($order->subtotal) }}</span></div>
            @if($order->discount>0)<div style="display:flex;justify-content:space-between;padding:6px 0;font-size:0.875rem;color:var(--success);"><span>Discount</span><span>-Rs.{{ number_format($order->discount) }}</span></div>@endif
            <div style="display:flex;justify-content:space-between;padding:6px 0;font-size:0.875rem;color:var(--gray);"><span>Delivery</span><span>{{ $order->delivery_fee==0?'FREE':'Rs.'.$order->delivery_fee }}</span></div>
            <div style="display:flex;justify-content:space-between;padding:6px 0;font-size:0.875rem;color:var(--gray);"><span>Tax</span><span>Rs.{{ number_format($order->tax) }}</span></div>
            <div style="display:flex;justify-content:space-between;padding:12px 0;font-size:1.15rem;font-weight:800;color:var(--primary);border-top:2px solid var(--border);margin-top:6px;"><span>Total</span><span>Rs.{{ number_format($order->total) }}</span></div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        <div style="background:white;border-radius:16px;border:1px solid var(--border);padding:20px;">
            <h3 style="font-weight:700;margin-bottom:14px;">📍 Delivery Info</h3>
            <div style="font-size:0.875rem;display:flex;flex-direction:column;gap:8px;">
                <div><span style="color:var(--gray);">Name: </span><strong>{{ $order->delivery_name }}</strong></div>
                <div><span style="color:var(--gray);">Phone: </span><strong>{{ $order->delivery_phone }}</strong></div>
                <div><span style="color:var(--gray);">Address: </span><strong>{{ $order->delivery_address }}, {{ $order->delivery_city }}</strong></div>
                <div><span style="color:var(--gray);">Type: </span><strong>{{ ucfirst($order->type) }}</strong></div>
                @if($order->special_instructions)<div><span style="color:var(--gray);">Note: </span>{{ $order->special_instructions }}</div>@endif
            </div>
        </div>
        <div style="background:white;border-radius:16px;border:1px solid var(--border);padding:20px;">
            <h3 style="font-weight:700;margin-bottom:14px;">💳 Payment</h3>
            <div style="font-size:0.875rem;display:flex;flex-direction:column;gap:8px;">
                <div><span style="color:var(--gray);">Method: </span><strong>{{ ucfirst($order->payment_method) }}</strong></div>
                <div><span style="color:var(--gray);">Status: </span><strong style="color:{{ $order->payment_status==='paid'?'var(--success)':'var(--warning)' }};">{{ ucfirst($order->payment_status) }}</strong></div>
                <div><span style="color:var(--gray);">Points Earned: </span><strong style="color:var(--primary);">+{{ $order->loyalty_points_earned }}</strong></div>
            </div>
        </div>
    </div>

    <div style="display:flex;gap:12px;margin-top:20px;flex-wrap:wrap;">
        @if(in_array($order->status,['pending','confirmed','preparing','ready','picked_up','on_the_way']))
        <a href="{{ route('user.order.track',$order->id) }}" style="flex:1;padding:13px;background:var(--primary);color:white;border-radius:12px;text-decoration:none;font-weight:700;display:flex;align-items:center;justify-content:center;gap:8px;min-width:140px;">📍 Track Order</a>
        @endif
        <a href="{{ route('user.orders') }}" style="flex:1;padding:13px;background:var(--light);color:var(--dark);border-radius:12px;text-decoration:none;font-weight:700;border:1.5px solid var(--border);display:flex;align-items:center;justify-content:center;min-width:140px;">← All Orders</a>
        <a href="{{ route('user.menu') }}" style="flex:1;padding:13px;background:var(--dark);color:white;border-radius:12px;text-decoration:none;font-weight:700;display:flex;align-items:center;justify-content:center;gap:8px;min-width:140px;">🍽️ Order Again</a>
    </div>
</div>
@endsection
