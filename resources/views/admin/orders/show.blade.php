@extends('layouts.admin')
@section('title','Order Details')
@section('page-title','Order Details')

@section('content')
<div class="page-header">
    <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a><span class="sep">/</span><a href="{{ route('admin.orders.index') }}">Orders</a><span class="sep">/</span><span>#{{ $order->order_number }}</span></div>
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
        <div>
            <h1>Order #{{ $order->order_number }}</h1>
            <p>Placed {{ $order->created_at->format('M d, Y h:i A') }} • {{ $order->created_at->diffForHumans() }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">← Back to Orders</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start;">
    <div>
        {{-- Status Update --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h3>🔄 Update Status</h3></div>
            <div class="card-body">
                <div style="display:flex;gap:10px;flex-wrap:wrap;">
                    @foreach(['confirmed'=>'✅ Confirm','preparing'=>'👨‍🍳 Preparing','ready'=>'📦 Ready','picked_up'=>'🛵 Picked Up','on_the_way'=>'🚴 On the Way','delivered'=>'🎉 Delivered','cancelled'=>'❌ Cancel'] as $s=>$l)
                    <form method="POST" action="{{ route('admin.orders.status',$order->id) }}" style="display:inline;">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="{{ $s }}">
                        <button type="submit" class="btn btn-sm {{ $order->status===$s ? 'btn-primary' : 'btn-secondary' }}"
                            style="{{ $s==='cancelled'?'background:#FEE2E2;color:var(--danger);border-color:#FECACA;':'' }}">
                            {{ $l }}
                        </button>
                    </form>
                    @endforeach
                </div>
                @php $b=$order->status_badge; @endphp
                <div style="margin-top:14px;padding:12px 16px;background:var(--light);border-radius:10px;font-size:0.9rem;">
                    Current Status: <strong>{{ $b['icon'] }} {{ $b['label'] }}</strong>
                </div>
            </div>
        </div>

        {{-- Assign Delivery --}}
        @if(in_array($order->status,['confirmed','preparing','ready']))
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h3>🛵 Assign Delivery Person</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.assign',$order->id) }}" style="display:flex;gap:12px;">
                    @csrf @method('PUT')
                    <select name="delivery_person_id" class="form-control">
                        <option value="">Select Rider</option>
                        @foreach($deliveryPersons as $dp)
                        <option value="{{ $dp->id }}" {{ $order->delivery_person_id==$dp->id?'selected':'' }}>{{ $dp->name }} — {{ $dp->phone }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Assign</button>
                </form>
            </div>
        </div>
        @endif

        {{-- Order Items --}}
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h3>🍽️ Order Items ({{ count($order->items) }})</h3></div>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Item</th><th>Price</th><th>Qty</th><th>Total</th></tr></thead>
                    <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td><div style="font-weight:600;">{{ $item['name'] }}</div></td>
                        <td>Rs.{{ number_format($item['price']) }}</td>
                        <td>× {{ $item['quantity'] }}</td>
                        <td style="font-weight:700;color:var(--primary);">Rs.{{ number_format($item['price']*$item['quantity']) }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div style="padding:16px 22px;border-top:1px solid var(--border);">
                <div style="max-width:260px;margin-left:auto;">
                    <div style="display:flex;justify-content:space-between;padding:6px 0;font-size:0.875rem;color:var(--gray);"><span>Subtotal</span><span>Rs.{{ number_format($order->subtotal) }}</span></div>
                    @if($order->discount>0)<div style="display:flex;justify-content:space-between;padding:6px 0;font-size:0.875rem;color:var(--success);"><span>Discount</span><span>-Rs.{{ number_format($order->discount) }}</span></div>@endif
                    <div style="display:flex;justify-content:space-between;padding:6px 0;font-size:0.875rem;color:var(--gray);"><span>Delivery</span><span>{{ $order->delivery_fee==0?'FREE':'Rs.'.$order->delivery_fee }}</span></div>
                    <div style="display:flex;justify-content:space-between;padding:6px 0;font-size:0.875rem;color:var(--gray);"><span>Tax</span><span>Rs.{{ number_format($order->tax) }}</span></div>
                    <div style="display:flex;justify-content:space-between;padding:10px 0;font-size:1.1rem;font-weight:800;color:var(--primary);border-top:2px solid var(--border);margin-top:6px;"><span>Total</span><span>Rs.{{ number_format($order->total) }}</span></div>
                </div>
            </div>
        </div>

        {{-- Tracking History --}}
        <div class="card">
            <div class="card-header"><h3>📍 Tracking History</h3></div>
            <div class="card-body">
                @forelse($order->tracking as $track)
                <div style="display:flex;gap:14px;padding:10px 0;border-bottom:1px solid var(--border);">
                    <div style="font-size:1.4rem;flex-shrink:0;">{{ $order->status_badge['icon'] }}</div>
                    <div>
                        <div style="font-weight:600;font-size:0.875rem;">{{ ucfirst(str_replace('_',' ',$track->status)) }}</div>
                        <div style="font-size:0.8rem;color:var(--gray);">{{ $track->message }}</div>
                        <div style="font-size:0.75rem;color:var(--gray);margin-top:2px;">{{ $track->tracked_at->format('M d, h:i A') }}</div>
                    </div>
                </div>
                @empty
                <p style="color:var(--gray);font-size:0.875rem;">No tracking history</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Right: Customer & Delivery Info --}}
    <div>
        <div class="card" style="margin-bottom:16px;">
            <div class="card-header"><h3>👤 Customer</h3></div>
            <div class="card-body">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                    <img src="{{ $order->user->avatar_url ?? 'https://ui-avatars.com/api/?name=User' }}" style="width:44px;height:44px;border-radius:50%;object-fit:cover;">
                    <div>
                        <div style="font-weight:700;">{{ $order->user->name }}</div>
                        <div style="font-size:0.78rem;color:var(--gray);">{{ $order->user->email }}</div>
                    </div>
                </div>
                <div style="font-size:0.875rem;">
                    <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid var(--border);"><span style="color:var(--gray);">Phone</span><span style="font-weight:600;">{{ $order->user->phone }}</span></div>
                    <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid var(--border);"><span style="color:var(--gray);">Tier</span><span class="badge badge-orange">{{ ucfirst($order->user->loyalty_tier) }}</span></div>
                    <div style="display:flex;justify-content:space-between;padding:7px 0;"><span style="color:var(--gray);">Total Orders</span><span style="font-weight:600;">{{ $order->user->total_orders }}</span></div>
                </div>
                <a href="{{ route('admin.users.show',$order->user_id) }}" class="btn btn-secondary btn-sm" style="width:100%;justify-content:center;margin-top:12px;">View Profile</a>
            </div>
        </div>

        <div class="card" style="margin-bottom:16px;">
            <div class="card-header"><h3>📍 Delivery Info</h3></div>
            <div class="card-body" style="font-size:0.875rem;">
                <div style="padding:7px 0;border-bottom:1px solid var(--border);"><span style="color:var(--gray);display:block;font-size:0.78rem;">Name</span><span style="font-weight:600;">{{ $order->delivery_name }}</span></div>
                <div style="padding:7px 0;border-bottom:1px solid var(--border);"><span style="color:var(--gray);display:block;font-size:0.78rem;">Phone</span><span style="font-weight:600;">{{ $order->delivery_phone }}</span></div>
                <div style="padding:7px 0;border-bottom:1px solid var(--border);"><span style="color:var(--gray);display:block;font-size:0.78rem;">Address</span><span style="font-weight:600;">{{ $order->delivery_address }}</span></div>
                <div style="padding:7px 0;border-bottom:1px solid var(--border);"><span style="color:var(--gray);display:block;font-size:0.78rem;">City</span><span style="font-weight:600;">{{ $order->delivery_city }}</span></div>
                @if($order->special_instructions)
                <div style="padding:7px 0;"><span style="color:var(--gray);display:block;font-size:0.78rem;">Instructions</span><span>{{ $order->special_instructions }}</span></div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3>💳 Payment</h3></div>
            <div class="card-body" style="font-size:0.875rem;">
                <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid var(--border);"><span style="color:var(--gray);">Method</span><span style="font-weight:600;">{{ ucfirst($order->payment_method) }}</span></div>
                <div style="display:flex;justify-content:space-between;padding:7px 0;border-bottom:1px solid var(--border);"><span style="color:var(--gray);">Status</span><span class="badge {{ $order->payment_status==='paid'?'badge-success':'badge-warning' }}">{{ ucfirst($order->payment_status) }}</span></div>
                <div style="display:flex;justify-content:space-between;padding:7px 0;"><span style="color:var(--gray);">Points Earned</span><span style="font-weight:600;color:var(--primary);">+{{ $order->loyalty_points_earned }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection
