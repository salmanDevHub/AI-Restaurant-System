@extends('layouts.admin')
@section('title','Add Food')
@section('page-title','Add Food Item')

@section('content')
<div class="page-header">
    <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a><span class="sep">/</span><a href="{{ route('admin.foods.index') }}">Foods</a><span class="sep">/</span><span>Add New</span></div>
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
        <h1>➕ Add New Food Item</h1>
        <a href="{{ route('admin.foods.index') }}" class="btn btn-secondary">← Back to List</a>
    </div>
</div>

<form method="POST" action="{{ route('admin.foods.store') }}" enctype="multipart/form-data">
@csrf
<div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start;">
    {{-- Main Details --}}
    <div>
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h3>📝 Basic Information</h3></div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group full">
                        <label class="form-label">Food Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Chicken Biryani" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id?'selected':'' }}>{{ $cat->icon }} {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cuisine *</label>
                        <select name="cuisine" class="form-control" required>
                            <option value="">Select Cuisine</option>
                            @foreach(['Pakistani','Chinese','Italian','American','Mexican','BBQ','Seafood','Indian','Turkish','Continental','Dessert','Drinks','Breakfast'] as $c)
                            <option value="{{ $c }}" {{ old('cuisine')===$c?'selected':'' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Description *</label>
                        <textarea name="description" class="form-control" placeholder="Describe the dish, its flavors, ingredients..." required>{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h3>💰 Pricing</h3></div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Regular Price (Rs.) *</label>
                        <input type="number" name="price" class="form-control" placeholder="450" min="0" step="0.01" value="{{ old('price') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sale Price (Rs.) <span style="color:var(--gray);">optional</span></label>
                        <input type="number" name="discount_price" class="form-control" placeholder="380" min="0" step="0.01" value="{{ old('discount_price') }}">
                        <p class="form-hint">Leave blank for no discount</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3>📊 Details</h3></div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Spice Level *</label>
                        <select name="spicy_level" class="form-control" required>
                            <option value="mild" {{ old('spicy_level')==='mild'?'selected':'' }}>🌶️ Mild</option>
                            <option value="medium" {{ old('spicy_level')==='medium'?'selected':'' }} selected>🌶️🌶️ Medium</option>
                            <option value="hot" {{ old('spicy_level')==='hot'?'selected':'' }}>🌶️🌶️🌶️ Hot</option>
                            <option value="extra_hot" {{ old('spicy_level')==='extra_hot'?'selected':'' }}>🌶️×4 Extra Hot</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Prep Time (minutes)</label>
                        <input type="number" name="prep_time" class="form-control" placeholder="15" min="1" max="120" value="{{ old('prep_time',15) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Calories</label>
                        <input type="number" name="calories" class="form-control" placeholder="500" min="0" value="{{ old('calories') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Sidebar --}}
    <div>
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h3>🖼️ Food Image</h3></div>
            <div class="card-body" style="text-align:center;">
                <div id="imgPreview" style="width:100%;height:180px;background:var(--light);border-radius:12px;border:2px dashed var(--border);display:flex;align-items:center;justify-content:center;margin-bottom:14px;overflow:hidden;">
                    <div id="imgPlaceholder" style="color:var(--gray);font-size:0.875rem;"><div style="font-size:2rem;margin-bottom:6px;">🖼️</div>No image selected</div>
                    <img id="imgThumb" style="width:100%;height:100%;object-fit:cover;display:none;">
                </div>
                <input type="file" name="image" id="imageInput" accept="image/*" style="display:none;" onchange="previewImg(this)">
                <button type="button" onclick="document.getElementById('imageInput').click()" class="btn btn-secondary" style="width:100%;">
                    📤 Upload Image
                </button>
                <p class="form-hint" style="text-align:center;margin-top:8px;">JPG, PNG, WEBP • Max 3MB</p>
            </div>
        </div>

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h3>⚙️ Settings</h3></div>
            <div class="card-body">
                @foreach([
                    ['is_available','Available for Order','Make this item orderable',true],
                    ['is_featured','Featured Item','Show on homepage featured',false],
                    ['is_popular','Popular Item','Show in popular section',false],
                    ['is_halal','Halal Certified','Mark as Halal certified',true],
                    ['is_vegetarian','Vegetarian','Mark as vegetarian',false],
                ] as [$name,$label,$hint,$default])
                <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);">
                    <div>
                        <div style="font-size:0.875rem;font-weight:600;">{{ $label }}</div>
                        <div style="font-size:0.75rem;color:var(--gray);">{{ $hint }}</div>
                    </div>
                    <input type="checkbox" name="{{ $name }}" value="1" {{ old($name,$default)?'checked':'' }}
                        style="width:20px;height:20px;accent-color:var(--primary);cursor:pointer;">
                </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;padding:14px;font-size:1rem;justify-content:center;">
            ✅ Save Food Item
        </button>
        <a href="{{ route('admin.foods.index') }}" class="btn btn-secondary" style="width:100%;padding:14px;justify-content:center;margin-top:10px;">
            Cancel
        </a>
    </div>
</div>
</form>
@endsection

@push('scripts')
<script>
function previewImg(input) {
    if(input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('imgThumb').src = e.target.result;
            document.getElementById('imgThumb').style.display = 'block';
            document.getElementById('imgPlaceholder').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
