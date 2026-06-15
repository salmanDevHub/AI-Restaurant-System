@extends('layouts.admin')
@section('title','Add Category')
@section('page-title','Add Category')

@section('content')
<div class="page-header">
    <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a><span class="sep">/</span><a href="{{ route('admin.categories.index') }}">Categories</a><span class="sep">/</span><span>Add</span></div>
    <div style="display:flex;justify-content:space-between;align-items:center;"><h1>➕ Add Category</h1><a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">← Back</a></div>
</div>

<div style="max-width:700px;">
<form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
@csrf
<div class="card">
    <div class="card-header"><h3>Category Details</h3></div>
    <div class="card-body">
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Category Name *</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Pakistani Cuisine" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Emoji Icon</label>
                <input type="text" name="icon" class="form-control" placeholder="🇵🇰" value="{{ old('icon') }}" maxlength="4">
                <p class="form-hint">Paste an emoji for this category</p>
            </div>
            <div class="form-group">
                <label class="form-label">Cuisine Type</label>
                <input type="text" name="cuisine_type" class="form-control" placeholder="Pakistani" value="{{ old('cuisine_type') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" placeholder="0" value="{{ old('sort_order',0) }}" min="0">
            </div>
            <div class="form-group full">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" placeholder="Brief description of this category...">{{ old('description') }}</textarea>
            </div>
            <div class="form-group full">
                <label class="form-label">Category Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="form-group full">
                <div style="display:flex;align-items:center;gap:12px;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active',true)?'checked':'' }} style="width:18px;height:18px;accent-color:var(--primary);">
                    <label style="font-weight:600;">Active (visible to customers)</label>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="margin-top:16px;display:flex;gap:12px;">
    <button type="submit" class="btn btn-primary">✅ Save Category</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
</div>
</form>
</div>
@endsection
