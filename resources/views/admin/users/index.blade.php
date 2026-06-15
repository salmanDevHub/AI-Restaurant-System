@extends('layouts.admin')
@section('title','Users')
@section('page-title','Customers')

@section('content')
<div class="page-header">
    <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a><span class="sep">/</span><span>Users</span></div>
    <h1>👥 Customers</h1>
    <p>Manage all registered customers</p>
</div>

<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="padding:16px 22px;">
        <form method="GET" action="{{ route('admin.users.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
            <div style="flex:1;min-width:200px;">
                <label class="form-label" style="margin-bottom:5px;">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Name, email or phone..." value="{{ request('search') }}">
            </div>
            <div style="min-width:160px;">
                <label class="form-label" style="margin-bottom:5px;">Loyalty Tier</label>
                <select name="tier" class="form-control">
                    <option value="">All Tiers</option>
                    <option value="bronze" {{ request('tier')==='bronze'?'selected':'' }}>🥉 Bronze</option>
                    <option value="silver" {{ request('tier')==='silver'?'selected':'' }}>🥈 Silver</option>
                    <option value="gold" {{ request('tier')==='gold'?'selected':'' }}>🥇 Gold</option>
                    <option value="platinum" {{ request('tier')==='platinum'?'selected':'' }}>💎 Platinum</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">🔍 Search</button>
            @if(request()->hasAny(['search','tier']))
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">✕ Clear</a>
            @endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>{{ $users->total() }} Customers</h3>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Customer</th><th>Phone</th><th>Orders</th><th>Spent</th><th>Tier</th><th>Joined</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <img src="{{ $user->avatar_url }}" style="width:38px;height:38px;border-radius:50%;object-fit:cover;">
                        <div>
                            <div style="font-weight:600;">{{ $user->name }}</div>
                            <div style="font-size:0.78rem;color:var(--gray);">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $user->phone }}</td>
                <td style="font-weight:700;">{{ $user->total_orders }}</td>
                <td style="font-weight:700;color:var(--primary);">Rs.{{ number_format($user->total_spent) }}</td>
                <td>
                    @php $tierIcons=['bronze'=>'🥉','silver'=>'🥈','gold'=>'🥇','platinum'=>'💎']; @endphp
                    <span class="badge badge-orange">{{ $tierIcons[$user->loyalty_tier]??'🥉' }} {{ ucfirst($user->loyalty_tier) }}</span>
                </td>
                <td style="font-size:0.82rem;color:var(--gray);">{{ $user->created_at->format('M d, Y') }}</td>
                <td>
                    <span class="badge {{ $user->is_blocked?'badge-danger':($user->is_active?'badge-success':'badge-warning') }}">
                        {{ $user->is_blocked?'🚫 Blocked':($user->is_active?'✅ Active':'⚠️ Inactive') }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('admin.users.show',$user->id) }}" class="btn btn-secondary btn-sm btn-icon" title="View">👁</a>
                        <form method="POST" action="{{ route('admin.users.block',$user->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $user->is_blocked?'btn-success':'btn-danger' }}" title="{{ $user->is_blocked?'Unblock':'Block' }}"
                                onclick="return confirm('{{ $user->is_blocked?'Unblock':'Block' }} this user?')">
                                {{ $user->is_blocked?'🔓':'🚫' }}
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;padding:50px;color:var(--gray);">
                <div style="font-size:2.5rem;margin-bottom:12px;">👥</div>No customers found
            </td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div style="padding:16px 22px;border-top:1px solid var(--border);">
        {{ $users->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
