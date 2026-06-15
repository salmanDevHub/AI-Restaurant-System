@extends('layouts.app')
@section('title', $food->name . ' - FoodieHub')
@push('styles')
<style>
.food-detail-wrap { max-width:1100px; margin:0 auto; padding:40px 20px; }
.breadcrumb { display:flex; align-items:center; gap:8px; color:var(--gray); font-size:0.875rem; margin-bottom:32px; }
.breadcrumb a { color:var(--gray); text-decoration:none; } .breadcrumb a:hover { color:var(--primary); }
.breadcrumb span { color:var(--primary); }
.food-detail-grid { display:grid; grid-template-columns:1fr 1fr; gap:48px; align-items:start; }
.food-gallery { position:sticky; top:90px; }
.main-img { border-radius:24px; overflow:hidden; height:380px; }
.main-img img { width:100%; height:100%; object-fit:cover; }
.food-info {}
.food-header { margin-bottom:20px; }
.food-tags { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:12px; }
.tag { padding:4px 12px; border-radius:50px; font-size:0.78rem; font-weight:600; }
.tag-cuisine { background:#EFF6FF; color:#1D4ED8; }
.tag-halal { background:#F0FDF4; color:#16A34A; }
.tag-veg { background:#F0FDF4; color:#15803D; }
.tag-spicy { background:#FFF7ED; color:#C2410C; }
.food-name { font-family:'Playfair Display',serif; font-size:2rem; font-weight:900; color:var(--dark); margin-bottom:10px; line-height:1.2; }
.food-rating-row { display:flex; align-items:center; gap:16px; margin-bottom:16px; }
.stars { color:#F59E0B; font-size:1.1rem; }
.rating-val { font-weight:700; color:var(--dark); }
.rating-cnt { color:var(--gray); font-size:0.875rem; }
.food-desc { color:var(--gray); line-height:1.8; font-size:0.95rem; margin-bottom:24px; }
.food-meta-grid { display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; margin-bottom:24px; }
.meta-box { background:var(--light); border-radius:12px; padding:14px; text-align:center; }
.meta-box .icon { font-size:1.5rem; margin-bottom:4px; }
.meta-box .val { font-weight:700; color:var(--dark); font-size:0.9rem; }
.meta-box .lbl { font-size:0.75rem; color:var(--gray); }
.price-section { display:flex; align-items:center; justify-content:space-between; padding:20px; background:linear-gradient(135deg,#FFF8F5,#FFF0E8); border-radius:16px; margin-bottom:20px; }
.price-main { font-size:2rem; font-weight:900; color:var(--primary); }
.price-original { font-size:1rem; color:var(--gray); text-decoration:line-through; }
.discount-badge { background:var(--primary); color:white; padding:4px 12px; border-radius:50px; font-size:0.8rem; font-weight:700; }
.qty-row { display:flex; align-items:center; gap:16px; margin-bottom:20px; }
.qty-ctrl { display:flex; align-items:center; gap:0; border:2px solid var(--border); border-radius:12px; overflow:hidden; }
.qty-btn { width:44px; height:44px; background:var(--light); border:none; font-size:1.2rem; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.15s; font-family:'DM Sans',sans-serif; }
.qty-btn:hover { background:var(--primary); color:white; }
.qty-val { width:50px; text-align:center; font-weight:700; font-size:1rem; border:none; outline:none; font-family:'DM Sans',sans-serif; }
.btn-add-cart {
    flex:1; padding:14px; background:var(--primary); color:white;
    border:none; border-radius:12px; font-size:1rem; font-weight:700;
    cursor:pointer; font-family:'DM Sans',sans-serif; transition:all 0.2s;
    display:flex; align-items:center; justify-content:center; gap:10px;
}
.btn-add-cart:hover { background:var(--primary-dark); transform:translateY(-1px); }
.btn-wishlist {
    width:50px; height:50px; background:white; border:2px solid var(--border);
    border-radius:12px; font-size:1.4rem; cursor:pointer; display:flex;
    align-items:center; justify-content:center; transition:all 0.15s;
}
.btn-wishlist:hover { border-color:var(--primary); }

.section-title { font-family:'Playfair Display',serif; font-size:1.4rem; font-weight:700; color:var(--dark); margin-bottom:20px; }

/* Reviews */
.reviews-section { margin-top:60px; }
.review-card { padding:20px; background:white; border-radius:16px; border:1px solid var(--border); margin-bottom:14px; }
.review-header { display:flex; align-items:center; gap:12px; margin-bottom:10px; }
.reviewer-avatar { width:40px; height:40px; border-radius:50%; object-fit:cover; }
.reviewer-name { font-weight:600; color:var(--dark); font-size:0.9rem; }
.review-date { font-size:0.8rem; color:var(--gray); }
.review-stars { color:#F59E0B; font-size:0.9rem; }
.review-text { color:var(--gray); font-size:0.9rem; line-height:1.6; }

/* Related */
.related-section { margin-top:60px; }
.related-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:20px; }

@media(max-width:768px) {
    .food-detail-grid { grid-template-columns:1fr; gap:24px; }
    .food-gallery { position:static; }
    .main-img { height:260px; }
    .food-meta-grid { grid-template-columns:1fr 1fr; }
}
</style>
@endpush
@section('content')
<div class="food-detail-wrap">
    <div class="breadcrumb">
        <a href="{{ route('user.home') }}">Home</a> /
        <a href="{{ route('user.menu') }}">Menu</a> /
        <a href="{{ route('user.menu', ['category'=>$food->category->slug]) }}">{{ $food->category->name }}</a> /
        <span>{{ $food->name }}</span>
    </div>

    <div class="food-detail-grid">
        <!-- Gallery -->
        <div class="food-gallery">
            <div class="main-img">
                <img src="{{ $food->image_url }}" alt="{{ $food->name }}"
                    onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=600'">
            </div>
        </div>

        <!-- Info -->
        <div class="food-info">
            <div class="food-header">
                <div class="food-tags">
                    <span class="tag tag-cuisine">{{ $food->category->icon ?? '' }} {{ $food->cuisine }}</span>
                    @if($food->is_halal)<span class="tag tag-halal">✅ Halal</span>@endif
                    @if($food->is_vegetarian)<span class="tag tag-veg">🥦 Vegetarian</span>@endif
                    <span class="tag tag-spicy">{{ $food->spicy_icon }} {{ ucfirst($food->spicy_level) }}</span>
                    @if($food->is_popular)<span class="tag" style="background:#FFF0EB;color:var(--primary);">🔥 Popular</span>@endif
                </div>
                <h1 class="food-name">{{ $food->name }}</h1>
                <div class="food-rating-row">
                    <div class="stars">
                        @for($i=1;$i<=5;$i++)
                            @if($i <= floor($food->rating))⭐@elseif($i - $food->rating < 1)🌟@else☆@endif
                        @endfor
                    </div>
                    <span class="rating-val">{{ number_format($food->rating,1) }}</span>
                    <span class="rating-cnt">({{ $food->rating_count }} reviews)</span>
                    <span class="rating-cnt">•</span>
                    <span class="rating-cnt">{{ number_format($food->total_orders) }} orders</span>
                </div>
            </div>

            <p class="food-desc">{{ $food->description }}</p>

            <div class="food-meta-grid">
                <div class="meta-box">
                    <div class="icon">🕐</div>
                    <div class="val">{{ $food->prep_time }} min</div>
                    <div class="lbl">Prep Time</div>
                </div>
                @if($food->calories)
                <div class="meta-box">
                    <div class="icon">🔥</div>
                    <div class="val">{{ $food->calories }}</div>
                    <div class="lbl">Calories</div>
                </div>
                @endif
                <div class="meta-box">
                    <div class="icon">{{ $food->spicy_icon }}</div>
                    <div class="val">{{ ucfirst($food->spicy_level) }}</div>
                    <div class="lbl">Spice Level</div>
                </div>
            </div>

            <div class="price-section">
                <div>
                    <div class="price-main">Rs. {{ number_format($food->effective_price) }}</div>
                    @if($food->discount_price)
                    <div class="price-original">Rs. {{ number_format($food->price) }}</div>
                    @endif
                </div>
                @if($food->discount_percentage)
                <div class="discount-badge">{{ $food->discount_percentage }}% OFF 🎉</div>
                @endif
            </div>

            @auth
            <div class="qty-row">
                <div class="qty-ctrl">
                    <button class="qty-btn" onclick="changeQty(-1)">−</button>
                    <input type="text" class="qty-val" id="qtyInput" value="1" readonly>
                    <button class="qty-btn" onclick="changeQty(1)">+</button>
                </div>
                <button class="btn-add-cart" onclick="addToCartDetail({{ $food->id }}, this)">
                    🛒 Add to Cart
                </button>
                <button class="btn-wishlist" onclick="toggleWish({{ $food->id }}, this)" title="Wishlist">🤍</button>
            </div>

            <div style="display:flex;gap:10px;margin-bottom:12px;">
                <a href="{{ route('user.cart') }}" class="btn-add-cart" style="background:var(--dark);">
                    🛒 Go to Cart
                </a>
            </div>
            @else
            <a href="{{ route('login') }}" class="btn-add-cart" style="display:flex;align-items:center;justify-content:center;gap:10px;text-decoration:none;padding:14px;border-radius:12px;background:var(--primary);color:white;font-weight:700;font-size:1rem;margin-bottom:20px;">
                🔑 Login to Order
            </a>
            @endauth

            @if($food->ingredients && count($food->ingredients))
            <div style="margin-top:20px;">
                <div style="font-weight:700;margin-bottom:8px;">🧄 Key Ingredients:</div>
                <div style="display:flex;flex-wrap:wrap;gap:6px;">
                    @foreach($food->ingredients as $ing)
                    <span style="background:var(--light);padding:4px 12px;border-radius:50px;font-size:0.8rem;color:var(--gray);">{{ $ing }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Reviews -->
    <div class="reviews-section">
        <h2 class="section-title">Customer Reviews ({{ $food->reviews->count() }})</h2>
        @forelse($food->reviews->where('is_visible',true)->take(5) as $review)
        <div class="review-card">
            <div class="review-header">
                <img src="{{ $review->user->avatar_url }}" alt="{{ $review->user->name }}" class="reviewer-avatar">
                <div>
                    <div class="reviewer-name">{{ $review->user->name }}</div>
                    <div class="review-stars">{{ str_repeat('⭐',$review->rating) }}{{ str_repeat('☆',5-$review->rating) }}</div>
                </div>
                <div class="review-date" style="margin-left:auto;">{{ $review->created_at->diffForHumans() }}</div>
            </div>
            @if($review->comment)
            <p class="review-text">{{ $review->comment }}</p>
            @endif
        </div>
        @empty
        <div style="text-align:center;padding:40px;color:var(--gray);">
            <div style="font-size:2rem;margin-bottom:12px;">💬</div>
            <p>No reviews yet. Be the first to order and review!</p>
        </div>
        @endforelse
    </div>

    <!-- Related -->
    @if($related->count())
    <div class="related-section">
        <h2 class="section-title">You Might Also Like</h2>
        <div class="related-grid">
            @foreach($related as $r)
            <div style="background:white;border-radius:16px;overflow:hidden;border:1px solid var(--border);transition:all 0.2s;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
                <img src="{{ $r->image_url }}" alt="{{ $r->name }}" style="width:100%;height:150px;object-fit:cover;" onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=300'">
                <div style="padding:14px;">
                    <div style="font-weight:700;margin-bottom:4px;font-size:0.95rem;">{{ $r->name }}</div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="color:var(--primary);font-weight:700;">Rs. {{ number_format($r->effective_price) }}</span>
                        @auth
                        <button onclick="addToCart({{ $r->id }},this)" style="background:var(--primary);color:white;border:none;border-radius:8px;padding:6px 14px;font-size:0.8rem;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;">Add</button>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
@push('scripts')
<script>
function changeQty(delta) {
    const inp = document.getElementById('qtyInput');
    inp.value = Math.max(1, Math.min(20, parseInt(inp.value) + delta));
}
function addToCartDetail(foodId, btn) {
    const qty = parseInt(document.getElementById('qtyInput').value);
    btn.disabled = true; btn.innerHTML = '⏳ Adding...';
    fetch('/cart/add', {
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},
        body:JSON.stringify({food_id:foodId, quantity:qty})
    }).then(r=>r.json()).then(d=>{
        if(d.success){ showToast(`${qty}x added to cart! 🛒`,'success'); document.getElementById('cartCount').textContent=d.count; }
        else showToast(d.message,'error');
        btn.disabled=false; btn.innerHTML='🛒 Add to Cart';
    }).catch(()=>{ btn.disabled=false; btn.innerHTML='🛒 Add to Cart'; });
}
function toggleWish(foodId, btn) {
    btn.textContent = btn.textContent==='🤍' ? '❤️' : '🤍';
}
</script>
@endpush
