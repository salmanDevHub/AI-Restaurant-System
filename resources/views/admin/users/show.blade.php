@extends('layouts.admin')
@section('title','User Profile')
@section('page-title','Customer Profile')

@section('content')
<div class="page-header">
    <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a><span class="sep">/</span><a href="{{ route('admin.users.index') }}">Users</a><span class="sep">/</span><span>{{ $user->name }}</span></div>
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
        <h1>👤 {{ $user->name }}</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">← Back</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:320px 1fr;gap:20px;align-items:start;">
    <div>
        <div class="card" style="margin-bottom:16px;">
            <div class="card-body" style="text-align:center;padding:28px;">
                <img src="{{ $user->avatar_url }}" style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid var(--primary);margin-bottom:14px;">
                <div style="font-size:1.2rem;font-weight:800;">{{ $user->name }}</div>
                <div style="color:var(--gray);font-size:0.875rem;margin-bottom:16px;">{{ $user->email }}</div>
                @php $tierIcons=['bronze'=>'🥉','silver'=>'🥈','gold'=>'🥇','platinum'=>'💎']; @endphp
                <span class="badge badge-orange" style="font-size:0.9rem;padding:6px 16px;">
                    {{ $tierIcons[$user->loyalty_tier]??'🥉' }} {{ ucfirst($user->loyalty_tier) }} Member
                </span>
                <div style="margin-top:16px;">
                    <span class="badge {{ $user->is_blocked?'badge-danger':($user->is_active?'badge-success':'badge-warning') }}">
                        {{ $user->is_blocked?'🚫 Blocked':($user->is_active?'✅ Active':'⚠️ Inactive') }}
                    </span>
                </div>
                <form method="POST" action="{{ route('admin.users.block',$user->id) }}" style="margin-top:14px;">
                    @csrf
                    <button type="submit" class="btn {{ $user->is_blocked?'btn-success':'btn-danger' }}" style="width:100%;justify-content:center;"
                        onclick="return confirm('{{ $user->is_blocked?'Unblock':'Block' }} this user?')">
                        {{ $user->is_blocked?'🔓 Unblock User':'🚫 Block User' }}
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3>ℹ️ Account Info</h3></div>
            <div class="card-body" style="font-size:0.875rem;">
                @foreach([
                    ['📞 Phone', $user->phone],
                    ['✅ Email Verified', $user->email_verified?'Yes':'No'],
                    ['📱 Phone Verified', $user->phone_verified?'Yes':'No'],
                    ['📍 City', $user->city??'N/A'],
                    ['⭐ Points', number_format($user->loyalty_points).' pts'],
                    ['📅 Joined', $user->created_at->format('M d, Y')],
                ] as [$lbl,$val])
                <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid var(--border);">
                    <span style="color:var(--gray);">{{ $lbl }}</span>
                    <span style="font-weight:600;">{{ $val }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div>
        <div class="stats-grid" style="grid-template-columns:1fr 1fr 1fr;margin-bottom:20px;">
            <div class="stat-card">
                <div class="stat-icon orange">📋</div>
                <div><div class="stat-val">{{ $user->total_orders }}</div><div class="stat-lbl">Total Orders</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">💰</div>
                <div><div class="stat-val">Rs.{{ number_format($user->total_spent) }}</div><div class="stat-lbl">Total Spent</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow">⭐</div>
                <div><div class="stat-val">{{ number_format($user->loyalty_points) }}</div><div class="stat-lbl">Loyalty Points</div></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>📋 Recent Orders</h3>
                <a href="{{ route('admin.orders.index',['search'=>$user->name]) }}" class="btn btn-secondary btn-sm">View All</a>
            </div>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Order</th><th>Items</th><th>Total</th><th>Status</th><th>Date</th><th></th></tr></thead>
                    <tbody>
                    @forelse($user->orders as $order)
                    <tr>
                        <td style="font-weight:700;color:var(--primary);">#{{ $order->order_number }}</td>
                        <td>{{ count($order->items) }} items</td>
                        <td style="font-weight:700;">Rs.{{ number_format($order->total) }}</td>
                        <td>
                            @php $b=$order->status_badge; @endphp
                            <span class="badge badge-{{ $b['color']==='green'?'success':($b['color']==='red'?'danger':($b['color']==='yellow'?'warning':'info')) }}">{{ $b['icon'] }} {{ $b['label'] }}</span>
                        </td>
                        <td style="font-size:0.8rem;color:var(--gray);">{{ $order->created_at->format('M d, Y') }}</td>
                        <td><a href="{{ route('admin.orders.show',$order->id) }}" class="btn btn-secondary btn-sm btn-icon">👁</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;padding:24px;color:var(--gray);">No orders yet</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
