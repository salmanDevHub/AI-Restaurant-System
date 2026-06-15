@extends('layouts.admin')
@section('title','Orders')
@section('page-title','All Orders')

@section('content')
<div class="page-header">
    <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a><span class="sep">/</span><span>Orders</span></div>
    <h1>📋 All Orders</h1>
    <p>Manage and track all customer orders</p>
</div>

{{-- Filters --}}
<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="padding:16px 22px;">
        <form method="GET" action="{{ route('admin.orders.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
            <div style="flex:1;min-width:180px;">
                <label class="form-label" style="margin-bottom:5px;">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Order # or customer name..." value="{{ request('search') }}">
            </div>
            <div style="min-width:160px;">
                <label class="form-label" style="margin-bottom:5px;">Status</label>
                <select name="status" class="form-control">
                    <option value="">All Status</option>
                    @foreach(['pending'=>'⏳ Pending','confirmed'=>'✅ Confirmed','preparing'=>'👨‍🍳 Preparing','ready'=>'📦 Ready','picked_up'=>'🛵 Picked Up','on_the_way'=>'🚴 On the Way','delivered'=>'🎉 Delivered','cancelled'=>'❌ Cancelled'] as $v=>$l)
                    <option value="{{ $v }}" {{ request('status')===$v?'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div style="min-width:160px;">
                <label class="form-label" style="margin-bottom:5px;">Date</label>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <button type="submit" class="btn btn-primary">🔍 Filter</button>
            @if(request()->hasAny(['search','status','date']))
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">✕ Clear</a>
            @endif
        </form>
    </div>
</div>

{{-- Quick Status Tabs --}}
<div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap;">
    @foreach([''=> '📋 All','pending'=>'⏳ Pending','confirmed'=>'✅ Confirmed','preparing'=>'👨‍🍳 Preparing','delivered'=>'🎉 Delivered','cancelled'=>'❌ Cancelled'] as $v=>$l)
    <a href="{{ route('admin.orders.index', array_merge(request()->all(), ['status'=>$v])) }}"
       style="padding:8px 16px;border-radius:10px;font-size:0.82rem;font-weight:600;text-decoration:none;border:1.5px solid var(--border);
              background:{{ request('status')===$v?'var(--primary)':'white' }};
              color:{{ request('status')===$v?'white':'var(--dark)' }};">
        {{ $l }}
    </a>
    @endforeach
</div>

<div class="card">
    <div class="card-header">
        <h3>{{ $orders->total() }} Orders</h3>
        <span style="font-size:0.82rem;color:var(--gray);">Page {{ $orders->currentPage() }} of {{ $orders->lastPage() }}</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Order</th><th>Customer</th><th>Items</th><th>Total</th><th>Type</th><th>Payment</th><th>Status</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @forelse($orders as $order)
            <tr>
                <td>
                    <span style="font-weight:800;color:var(--primary);">#{{ $order->order_number }}</span>
                </td>
                <td>
                    <div style="font-weight:600;">{{ $order->user->name ?? 'N/A' }}</div>
                    <div style="font-size:0.78rem;color:var(--gray);">{{ $order->delivery_phone }}</div>
                </td>
                <td>
                    <span style="font-weight:600;">{{ count($order->items) }}</span>
                    <span style="color:var(--gray);font-size:0.82rem;"> items</span>
                </td>
                <td style="font-weight:800;color:var(--primary);">Rs.{{ number_format($order->total) }}</td>
                <td><span class="badge badge-gray">{{ ucfirst($order->type) }}</span></td>
                <td>
                    <span class="badge {{ $order->payment_status==='paid'?'badge-success':'badge-warning' }}">
                        {{ ucfirst($order->payment_method) }}
                    </span>
                </td>
                <td>
                    @php $b=$order->status_badge; $map=['green'=>'success','red'=>'danger','yellow'=>'warning','blue'=>'info','orange'=>'orange','purple'=>'purple','cyan'=>'info','gray'=>'gray']; @endphp
                    <select onchange="quickStatus({{ $order->id }},this.value,this)"
                        style="border:1.5px solid var(--border);border-radius:8px;padding:5px 8px;font-size:0.78rem;font-family:'DM Sans',sans-serif;font-weight:600;cursor:pointer;outline:none;">
                        @foreach(['pending','confirmed','preparing','ready','picked_up','on_the_way','delivered','cancelled'] as $s)
                        <option value="{{ $s }}" {{ $order->status===$s?'selected':'' }}>{{ $order->status_badge['icon'] }} {{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </td>
                <td style="font-size:0.8rem;color:var(--gray);">{{ $order->created_at->format('M d') }}<br>{{ $order->created_at->format('h:i A') }}</td>
                <td>
                    <a href="{{ route('admin.orders.show',$order->id) }}" class="btn btn-secondary btn-sm btn-icon" title="View Details">👁</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center;padding:50px;color:var(--gray);">
                <div style="font-size:2.5rem;margin-bottom:12px;">📋</div>No orders found
            </td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div style="padding:16px 22px;border-top:1px solid var(--border);">
        {{ $orders->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function quickStatus(id, status, sel) {
    if(!confirm('Update order status to "'+status+'"?')) { sel.value = sel.dataset.old||sel.value; return; }
    sel.dataset.old = status;
    fetch(`/admin/orders/${id}/status`, {
        method: 'PUT',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN': csrf},
        body: JSON.stringify({status})
    }).then(r=>r.json()).then(d => {
        if(d.success) showToast('Status updated to '+status+'!','success');
    }).catch(()=> showToast('Error updating status','error'));
}
</script>
@endpush
