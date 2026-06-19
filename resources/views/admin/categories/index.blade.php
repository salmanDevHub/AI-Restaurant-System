@extends('layouts.admin')
@section('title','Categories')
@section('page-title','Categories')

@section('content')
<div class="page-header">
    <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a><span class="sep">/</span><span>Categories</span></div>
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
        <div><h1>📂 Menu Categories</h1><p>Organize your menu by cuisine type</p></div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">➕ Add Category</a>
    </div>
</div>

<div class="card">
    <div class="card-header"><h3>{{ $categories->count() }} Categories</h3></div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Category</th><th>Cuisine</th><th>Foods</th><th>Status</th><th>Order</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($categories as $cat)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:12px;">
                        <img src="{{ $cat->image_url }}" style="width:44px;height:44px;border-radius:10px;object-fit:cover;" onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=80'">
                        <div>
                            <div style="font-weight:700;">{{ $cat->icon }} {{ $cat->name }}</div>
                            <div style="font-size:0.78rem;color:var(--gray);">{{ Str::limit($cat->description,40) }}</div>
                        </div>
                    </div>
                </td>
                <td><span class="badge badge-gray">{{ $cat->cuisine_type ?? 'N/A' }}</span></td>
                <td style="font-weight:700;">{{ $cat->foods_count ?? 0 }}</td>
                <td><span class="badge {{ $cat->is_active?'badge-success':'badge-danger' }}">{{ $cat->is_active?'✅ Active':'❌ Hidden' }}</span></td>
                <td>{{ $cat->sort_order }}</td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('admin.categories.edit',$cat->id) }}" class="btn btn-secondary btn-sm btn-icon">✏️</a>
                        <form method="POST" action="{{ route('admin.categories.destroy',$cat->id) }}" onsubmit="return confirm('Delete this category?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-icon">🗑️</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--gray);">No categories yet</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
