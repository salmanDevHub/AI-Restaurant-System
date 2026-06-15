{{-- ORDER SUCCESS PAGE --}}
{{-- resources/views/user/orders/success.blade.php --}}
@extends('layouts.app')
@section('title','Order Placed! - FoodieHub')
@section('content')
<div style="max-width:560px;margin:60px auto;padding:0 20px;text-align:center;">
    <div style="background:white;border-radius:24px;padding:50px 40px;box-shadow:0 20px 60px rgba(0,0,0,0.1);border:1px solid var(--border);">
        <div style="font-size:5rem;margin-bottom:20px;animation:bounce 0.6s ease;">🎉</div>
        <h1 style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:900;color:var(--dark);margin-bottom:10px;">Order Placed!</h1>
        <p style="color:var(--gray);font-size:1rem;line-height:1.7;margin-bottom:24px;">
            Your order has been received and our chef is getting started!<br>
            Estimated delivery: <strong style="color:var(--dark);">40-50 minutes</strong> 🚴
        </p>
        @if($order)
        <div style="background:linear-gradient(135deg,#FFF8F5,#FFF0E0);border:1px solid #FFD7B5;border-radius:16px;padding:20px;margin-bottom:28px;">
            <div style="font-size:0.82rem;color:var(--gray);margin-bottom:6px;">Order Number</div>
            <div style="font-size:1.5rem;font-weight:900;color:var(--primary);font-family:'Playfair Display',serif;">{{ $order->order_number }}</div>
            <div style="margin-top:12px;font-size:0.9rem;color:var(--dark);">
                Total: <strong>Rs. {{ number_format($order->total) }}</strong> •
                {{ ucfirst($order->payment_method) }} •
                ⭐ +{{ $order->loyalty_points_earned }} points earned!
            </div>
        </div>
        <div style="display:flex;gap:12px;justify-content:center;">
            <a href="{{ route('user.order.track', $order->id) }}" style="flex:1;padding:13px;background:var(--primary);color:white;border-radius:12px;text-decoration:none;font-weight:700;display:flex;align-items:center;justify-content:center;gap:8px;">
                📍 Track Order
            </a>
            <a href="{{ route('user.orders') }}" style="flex:1;padding:13px;background:var(--light);color:var(--dark);border-radius:12px;text-decoration:none;font-weight:700;border:1.5px solid var(--border);display:flex;align-items:center;justify-content:center;gap:8px;">
                📋 My Orders
            </a>
        </div>
        @endif
        <a href="{{ route('user.menu') }}" style="display:block;margin-top:16px;color:var(--gray);font-size:0.875rem;text-decoration:none;">Order more food →</a>
    </div>
</div>
<style>@keyframes bounce{0%,100%{transform:scale(1)}50%{transform:scale(1.2)}}</style>
@endsection
