@extends('layouts.admin')
@section('title','Food Items')
@section('page-title','Food Items')

@section('content')
<div class="page-header">
    <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a><span class="sep">/</span><span>Food Items</span></div>
    <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;">
        <div><h1>🍔 Food Items</h1><p>Manage your complete menu</p></div>
        <a href="{{ route('admin.foods.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Food</a>
    </div>
</div>

{{-- Filters --}}
<div class="card" style="margin-bottom:20px;">
    <div class="card-body" style="padding:16px 22px;">
        <form method="GET" action="{{ route('admin.foods.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
            <div style="flex:1;min-width:180px;">
                <label class="form-label" style="margin-bottom:5px;">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Food name..." value="{{ request('search') }}">
            </div>
            <div style="min-width:160px;">
                <label class="form-label" style="margin-bottom:5px;">Category</label>
                <select name="category" class="form-control">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category')==$cat->id?'selected':'' }}>{{ $cat->icon }} {{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="min-width:140px;">
                <label class="form-label" style="margin-bottom:5px;">Status</label>
                <select name="status" class="form-control">
                    <option value="">All</option>
                    <option value="available" {{ request('status')==='available'?'selected':'' }}>✅ Available</option>
                    <option value="unavailable" {{ request('status')==='unavailable'?'selected':'' }}>❌ Unavailable</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">🔍 Filter</button>
            @if(request()->hasAny(['search','category','status']))
            <a href="{{ route('admin.foods.index') }}" class="btn btn-secondary">✕ Clear</a>
            @endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>{{ $foods->total() }} Items Found</h3>
        <span style="font-size:0.82rem;color:var(--gray);">Showing {{ $foods->firstItem() }}–{{ $foods->lastItem() }}</span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Item</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Orders</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($foods as $food)
            <tr>
                <td>
                    <img src="{{ $food->image_url }}" style="width:48px;height:48px;border-radius:10px;object-fit:cover;"
                        onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=80'">
                </td>
                <td>
                    <div style="font-weight:700;">{{ $food->name }}</div>
                    <div style="font-size:0.78rem;color:var(--gray);">{{ $food->cuisine }} • {{ $food->spicy_icon }}</div>
                    <div style="display:flex;gap:4px;margin-top:3px;">
                        @if($food->is_featured)<span class="badge badge-orange" style="font-size:0.68rem;padding:2px 7px;">⭐</span>@endif
                        @if($food->is_popular)<span class="badge badge-success" style="font-size:0.68rem;padding:2px 7px;">🔥</span>@endif
                        @if($food->is_halal)<span class="badge badge-success" style="font-size:0.68rem;padding:2px 7px;">✓Halal</span>@endif
                    </div>
                </td>
                <td><span class="badge badge-gray">{{ $food->category->icon ?? '' }} {{ $food->category->name ?? 'N/A' }}</span></td>
                <td>
                    <div style="font-weight:700;color:var(--primary);">Rs.{{ number_format($food->price) }}</div>
                    @if($food->discount_price)<div style="font-size:0.78rem;color:var(--success);">Sale: Rs.{{ number_format($food->discount_price) }}</div>@endif
                </td>
                <td style="font-weight:600;">{{ number_format($food->total_orders) }}</td>
                <td>
                    <span style="color:#F59E0B;font-weight:700;">⭐ {{ number_format($food->rating,1) }}</span>
                    <div style="font-size:0.75rem;color:var(--gray);">({{ $food->rating_count }})</div>
                </td>
                <td>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span class="badge {{ $food->is_available ? 'badge-success' : 'badge-danger' }}">
                            {{ $food->is_available ? '✅ Active' : '❌ Off' }}
                        </span>
                        <button onclick="toggleAvail({{ $food->id }},this)"
                            style="background:none;border:1px solid var(--border);border-radius:6px;padding:3px 8px;cursor:pointer;font-size:0.75rem;font-family:'DM Sans',sans-serif;"
                            title="Toggle availability">
                            {{ $food->is_available ? 'Disable' : 'Enable' }}
                        </button>
                    </div>
                </td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('admin.foods.edit',$food->id) }}" class="btn btn-secondary btn-sm btn-icon" title="Edit">✏️</a>
                        <form method="POST" action="{{ route('admin.foods.destroy',$food->id) }}" onsubmit="return confirm('Delete this food item?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Delete">🗑️</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;padding:50px;color:var(--gray);">
                <div style="font-size:2.5rem;margin-bottom:12px;">🍽️</div>
                No food items found. <a href="{{ route('admin.foods.create') }}" style="color:var(--primary);">Add one now!</a>
            </td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($foods->hasPages())
    <div style="padding:16px 22px;border-top:1px solid var(--border);">
        {{ $foods->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function toggleAvail(id, btn) {
    btn.disabled = true; btn.textContent = '...';
    fetch(`/admin/foods/${id}/toggle`, {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': csrf, 'Content-Type': 'application/json'}
    }).then(r => r.json()).then(d => {
        if(d.success) {
            showToast('Availability updated!', 'success');
            setTimeout(() => location.reload(), 800);
        }
    }).catch(() => { btn.disabled=false; });
}
</script>
@endpush
