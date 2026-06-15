@extends('layouts.app')
@section('title','Notifications - FoodieHub')
@section('content')
<div style="max-width:700px;margin:0 auto;padding:40px 20px;">
    <h1 style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:900;margin-bottom:6px;">🔔 Notifications</h1>
    <p style="color:var(--gray);margin-bottom:28px;">All updates about your orders and offers</p>

    @forelse($notifications as $notif)
    <div style="background:white;border-radius:16px;padding:18px 20px;margin-bottom:12px;border:1.5px solid {{ $notif->is_read ? 'var(--border)' : '#FFD0C0' }};display:flex;gap:14px;align-items:flex-start;box-shadow:{{ $notif->is_read?'none':'0 2px 10px rgba(255,69,0,0.08)' }};">
        <div style="font-size:1.8rem;flex-shrink:0;">
            @if($notif->type==='order_update') 📦
            @elseif($notif->type==='welcome') 🎉
            @elseif($notif->type==='promotion') 🎁
            @else 🔔 @endif
        </div>
        <div style="flex:1;">
            <div style="font-weight:700;margin-bottom:4px;">{{ $notif->title }}</div>
            <div style="color:var(--gray);font-size:0.875rem;line-height:1.6;">{{ $notif->message }}</div>
            <div style="font-size:0.78rem;color:var(--gray);margin-top:6px;">{{ $notif->created_at->diffForHumans() }}</div>
            @if(isset($notif->data['order_id']))
            <a href="{{ route('user.order.show',$notif->data['order_id']) }}" style="color:var(--primary);font-size:0.82rem;font-weight:600;text-decoration:none;margin-top:6px;display:inline-block;">View Order →</a>
            @endif
        </div>
        @if(!$notif->is_read)
        <div style="width:9px;height:9px;border-radius:50%;background:var(--primary);flex-shrink:0;margin-top:5px;"></div>
        @endif
    </div>
    @empty
    <div style="text-align:center;padding:80px 20px;color:var(--gray);">
        <div style="font-size:4rem;margin-bottom:16px;">🔔</div>
        <h3 style="color:var(--dark);margin-bottom:8px;">No notifications yet</h3>
        <p>We'll notify you about order updates and special offers</p>
    </div>
    @endforelse

    @if($notifications->hasPages())
    <div style="margin-top:20px;">{{ $notifications->links() }}</div>
    @endif
</div>
@endsection
