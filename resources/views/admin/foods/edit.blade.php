@extends('layouts.admin')
@section('title','Edit Food')
@section('page-title','Edit Food Item')

@section('content')
<div class="page-header">
    <div class="breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a><span class="sep">/</span><a href="{{ route('admin.foods.index') }}">Foods</a><span class="sep">/</span><span>Edit</span></div>
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
        <h1>✏️ Edit: {{ $food->name }}</h1>
        <a href="{{ route('admin.foods.index') }}" class="btn btn-secondary">← Back</a>
    </div>
</div>

<form method="POST" action="{{ route('admin.foods.update',$food->id) }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start;">
    <div>
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h3>📝 Basic Information</h3></div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group full">
                        <label class="form-label">Food Name *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name',$food->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-control" required>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id',$food->category_id)==$cat->id?'selected':'' }}>{{ $cat->icon }} {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cuisine *</label>
                        <select name="cuisine" class="form-control" required>
                            @foreach(['Pakistani','Chinese','Italian','American','Mexican','BBQ','Seafood','Indian','Turkish','Continental','Dessert','Drinks','Breakfast'] as $c)
                            <option value="{{ $c }}" {{ old('cuisine',$food->cuisine)===$c?'selected':'' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Description *</label>
                        <textarea name="description" class="form-control" required>{{ old('description',$food->description) }}</textarea>
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
                        <input type="number" name="price" class="form-control" value="{{ old('price',$food->price) }}" min="0" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sale Price (Rs.)</label>
                        <input type="number" name="discount_price" class="form-control" value="{{ old('discount_price',$food->discount_price) }}" min="0" step="0.01">
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
                            @foreach(['mild'=>'🌶️ Mild','medium'=>'🌶️🌶️ Medium','hot'=>'🌶️🌶️🌶️ Hot','extra_hot'=>'🌶️×4 Extra Hot'] as $v=>$l)
                            <option value="{{ $v }}" {{ old('spicy_level',$food->spicy_level)===$v?'selected':'' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Prep Time (min)</label>
                        <input type="number" name="prep_time" class="form-control" value="{{ old('prep_time',$food->prep_time) }}" min="1">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Calories</label>
                        <input type="number" name="calories" class="form-control" value="{{ old('calories',$food->calories) }}" min="0">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h3>🖼️ Food Image</h3></div>
            <div class="card-body" style="text-align:center;">
                <div id="imgPreview" style="width:100%;height:180px;background:var(--light);border-radius:12px;overflow:hidden;margin-bottom:14px;">
                    <img id="imgThumb" src="{{ $food->image_url }}" style="width:100%;height:100%;object-fit:cover;"
                        onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400'">
                </div>
                <input type="file" name="image" id="imageInput" accept="image/*" style="display:none;" onchange="previewImg(this)">
                <button type="button" onclick="document.getElementById('imageInput').click()" class="btn btn-secondary" style="width:100%;">
                    📤 Change Image
                </button>
            </div>
        </div>

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h3>⚙️ Settings</h3></div>
            <div class="card-body">
                @foreach([
                    ['is_available','Available','Active for ordering'],
                    ['is_featured','Featured','Show on homepage'],
                    ['is_popular','Popular','Show in popular section'],
                    ['is_halal','Halal Certified','Halal certified'],
                    ['is_vegetarian','Vegetarian','Vegetarian dish'],
                ] as [$name,$label,$hint])
                <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);">
                    <div>
                        <div style="font-size:0.875rem;font-weight:600;">{{ $label }}</div>
                        <div style="font-size:0.75rem;color:var(--gray);">{{ $hint }}</div>
                    </div>
                    <input type="checkbox" name="{{ $name }}" value="1"
                        {{ old($name, $food->$name) ? 'checked' : '' }}
                        style="width:20px;height:20px;accent-color:var(--primary);cursor:pointer;">
                </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;padding:14px;font-size:1rem;justify-content:center;">
            💾 Update Food Item
        </button>
    </div>
</div>
</form>
@endsection
@push('scripts')
<script>
function previewImg(input) {
    if(input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('imgThumb').src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
