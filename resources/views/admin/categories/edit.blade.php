@extends('layouts.admin')
@section('title','Edit Category')
@section('page-title','Edit Category')

@section('content')
<div class="page-header">
    <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a><span class="sep">/</span><a href="{{ route('admin.categories.index') }}">Categories</a><span class="sep">/</span><span>Edit</span></div>
    <div style="display:flex;justify-content:space-between;align-items:center;"><h1>✏️ Edit: {{ $category->name }}</h1><a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">← Back</a></div>
</div>

<div style="max-width:700px;">
<form method="POST" action="{{ route('admin.categories.update',$category->id) }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="card">
    <div class="card-header"><h3>Category Details</h3></div>
    <div class="card-body">
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Category Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name',$category->name) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Emoji Icon</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon',$category->icon) }}" maxlength="4">
            </div>
            <div class="form-group">
                <label class="form-label">Cuisine Type</label>
                <input type="text" name="cuisine_type" class="form-control" value="{{ old('cuisine_type',$category->cuisine_type) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',$category->sort_order) }}" min="0">
            </div>
            <div class="form-group full">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control">{{ old('description',$category->description) }}</textarea>
            </div>
            @if($category->image)
            <div class="form-group full">
                <label class="form-label">Current Image</label>
                <img src="{{ $category->image_url }}" style="height:80px;border-radius:10px;object-fit:cover;">
            </div>
            @endif
            <div class="form-group full">
                <label class="form-label">Change Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="form-group full">
                <div style="display:flex;align-items:center;gap:12px;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active',$category->is_active)?'checked':'' }} style="width:18px;height:18px;accent-color:var(--primary);">
                    <label style="font-weight:600;">Active (visible to customers)</label>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="margin-top:16px;display:flex;gap:12px;">
    <button type="submit" class="btn btn-primary">💾 Update Category</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
</div>
</form>
</div>
@endsection
