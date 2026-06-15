@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard')

@push('styles')
<style>
.chart-bar-wrap{display:flex;align-items:flex-end;gap:8px;height:120px;padding:10px 0;}
.chart-bar{flex:1;border-radius:6px 6px 0 0;background:linear-gradient(to top,var(--primary),#FF8C42);min-width:28px;position:relative;cursor:pointer;transition:opacity 0.2s;}
.chart-bar:hover{opacity:0.8;}
.chart-bar-label{position:absolute;bottom:-22px;left:50%;transform:translateX(-50%);font-size:0.7rem;color:var(--gray);white-space:nowrap;}
.chart-bar-val{position:absolute;top:-22px;left:50%;transform:translateX(-50%);font-size:0.7rem;font-weight:700;color:var(--dark);white-space:nowrap;}
.order-status-circle{display:flex;gap:20px;flex-wrap:wrap;}
.status-dot-row{display:flex;align-items:center;gap:8px;font-size:0.875rem;}
.dot{width:12px;height:12px;border-radius:50%;}
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="breadcrumb"><a href="#">Home</a><span class="sep">/</span><span>Dashboard</span></div>
    <h1>Welcome back, {{ Auth::user()->name }}! 👋</h1>
    <p>Here's what's happening at FoodieHub today — {{ now()->format('l, d M Y') }}</p>
</div>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon orange">📋</div>
        <div>
            <div class="stat-val">{{ number_format($stats['total_orders']) }}</div>
            <div class="stat-lbl">Total Orders</div>
            <div class="stat-change up">↑ {{ $stats['today_orders'] }} today</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">💰</div>
        <div>
            <div class="stat-val">Rs.{{ number_format($stats['total_revenue']) }}</div>
            <div class="stat-lbl">Total Revenue</div>
            <div class="stat-change up">↑ Rs.{{ number_format($stats['today_revenue']) }} today</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">👥</div>
        <div>
            <div class="stat-val">{{ number_format($stats['total_users']) }}</div>
            <div class="stat-lbl">Total Customers</div>
            <div class="stat-change up">↑ {{ $stats['new_users_today'] }} new today</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow">🍔</div>
        <div>
            <div class="stat-val">{{ $stats['active_foods'] }}</div>
            <div class="stat-lbl">Active Menu Items</div>
            <div class="stat-change" style="color:var(--gray);">{{ $stats['total_foods'] }} total</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">⏳</div>
        <div>
            <div class="stat-val" style="color:var(--warning);">{{ $stats['pending_orders'] }}</div>
            <div class="stat-lbl">Pending Orders</div>
            <div class="stat-change" style="color:var(--gray);">Need attention</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">🚴</div>
        <div>
            <div class="stat-val" style="color:var(--info);">{{ $stats['active_orders'] }}</div>
            <div class="stat-lbl">Active Deliveries</div>
            <div class="stat-change" style="color:var(--gray);">In progress</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;margin-bottom:24px;">
    {{-- Revenue Chart --}}
    <div class="card">
        <div class="card-header">
            <h3>📈 Revenue — Last 7 Days</h3>
        </div>
        <div class="card-body">
            <div class="chart-bar-wrap" id="revenueChart"></div>
        </div>
    </div>

    {{-- Order Status Donut --}}
    <div class="card">
        <div class="card-header"><h3>📊 Order Status</h3></div>
        <div class="card-body">
            @php $total = array_sum($orderStatusCounts) ?: 1; @endphp
            @foreach([['pending','⏳ Pending','#F59E0B'],['preparing','👨‍🍳 Preparing','#3B82F6'],['delivered','✅ Delivered','#10B981'],['cancelled','❌ Cancelled','#EF4444']] as [$k,$lbl,$color])
            <div style="margin-bottom:12px;">
                <div style="display:flex;justify-content:space-between;font-size:0.82rem;margin-bottom:4px;">
                    <span>{{ $lbl }}</span>
                    <span style="font-weight:700;">{{ $orderStatusCounts[$k] }}</span>
                </div>
                <div style="height:8px;background:var(--light);border-radius:4px;overflow:hidden;">
                    <div style="height:100%;background:{{ $color }};border-radius:4px;width:{{ round($orderStatusCounts[$k]/$total*100) }}%;"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
    {{-- Recent Orders --}}
    <div class="card">
        <div class="card-header">
            <h3>🆕 Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Order</th><th>Customer</th><th>Total</th><th>Status</th><th></th></tr></thead>
                <tbody>
                @forelse($recentOrders as $order)
                <tr>
                    <td><span style="font-weight:700;color:var(--primary);">#{{ $order->order_number }}</span><br><span style="font-size:0.75rem;color:var(--gray);">{{ $order->created_at->diffForHumans() }}</span></td>
                    <td>{{ $order->user->name ?? 'N/A' }}<br><span style="font-size:0.75rem;color:var(--gray);">{{ $order->user->phone ?? '' }}</span></td>
                    <td style="font-weight:700;">Rs.{{ number_format($order->total) }}</td>
                    <td>
                        @php $b=$order->status_badge; @endphp
                        <span class="badge badge-{{ $b['color'] === 'green' ? 'success' : ($b['color']==='red'?'danger':($b['color']==='yellow'?'warning':($b['color']==='blue'?'info':'gray'))) }}">{{ $b['icon'] }} {{ $b['label'] }}</span>
                    </td>
                    <td><a href="{{ route('admin.orders.show',$order->id) }}" class="btn btn-secondary btn-sm btn-icon">👁</a></td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;color:var(--gray);padding:30px;">No orders yet</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Top Foods --}}
    <div class="card">
        <div class="card-header">
            <h3>🔥 Top Selling Items</h3>
            <a href="{{ route('admin.foods.index') }}" class="btn btn-secondary btn-sm">Manage</a>
        </div>
        <div class="card-body" style="padding:12px 22px;">
            @forelse($topFoods as $i => $food)
            <div style="display:flex;align-items:center;gap:14px;padding:10px 0;border-bottom:1px solid var(--border);">
                <span style="width:28px;height:28px;background:{{ $i===0?'#FFD700':($i===1?'#C0C0C0':($i===2?'#CD7F32':'var(--light)')) }};border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:0.85rem;font-weight:800;flex-shrink:0;">{{ $i+1 }}</span>
                <img src="{{ $food->image_url }}" style="width:44px;height:44px;border-radius:10px;object-fit:cover;flex-shrink:0;" onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=80'">
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:600;font-size:0.875rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $food->name }}</div>
                    <div style="font-size:0.78rem;color:var(--gray);">{{ $food->total_orders }} orders</div>
                </div>
                <div style="font-weight:800;color:var(--primary);">Rs.{{ number_format($food->price) }}</div>
            </div>
            @empty
            <p style="text-align:center;color:var(--gray);padding:30px;">No data yet</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const data = @json($revenueData);
const maxRev = Math.max(...data.map(d=>d.revenue),1);
const chart = document.getElementById('revenueChart');
if(chart){
    data.forEach(d=>{
        const pct = Math.max((d.revenue/maxRev)*100,4);
        const bar = document.createElement('div');
        bar.className='chart-bar';
        bar.style.height=pct+'%';
        bar.title=d.date+': Rs.'+d.revenue;
        bar.innerHTML=`<span class="chart-bar-val">${d.revenue>0?'Rs.'+Math.round(d.revenue/1000)+'k':''}</span><span class="chart-bar-label">${d.date}</span>`;
        chart.appendChild(bar);
    });
}
</script>
@endpush
