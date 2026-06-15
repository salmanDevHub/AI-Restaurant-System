<div class="fl-card">
    <div class="fl-card-img">
        <img src="{{ $food->image_url }}" alt="{{ $food->name }}" loading="lazy"
            onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400'">
        <div class="fl-badges">
            @if($food->is_featured)<span class="fl-badge fl-badge-pop">⭐ Featured</span>@endif
            @if($food->is_popular)<span class="fl-badge fl-badge-pop">🔥 Popular</span>@endif
            @if($food->discount_price)<span class="fl-badge fl-badge-disc">{{ $food->discount_percentage }}% OFF</span>@endif
            @if($food->is_vegetarian)<span class="fl-badge fl-badge-veg">🥦 Veg</span>@endif
        </div>
        @auth
        <button class="fl-wish" onclick="toggleWish({{ $food->id }},this)">🤍</button>
        @endauth
    </div>
    <div class="fl-card-body">
        <div class="fl-card-meta">
            <span class="fl-cuisine">{{ $food->category->icon ?? '' }} {{ $food->cuisine }}</span>
            <span class="fl-rating">⭐ {{ number_format($food->rating,1) }}</span>
        </div>
        <a href="{{ route('user.food.show', $food->slug) }}" class="fl-food-name">{{ $food->name }}</a>
        <p class="fl-food-desc">{{ $food->description }}</p>
        <div class="fl-card-pills">
            <span class="fl-pill">{{ $food->spicy_icon }} {{ ucfirst($food->spicy_level) }}</span>
            <span class="fl-pill">🕐 {{ $food->prep_time }}min</span>
            @if($food->calories)<span class="fl-pill">🔥 {{ $food->calories }}cal</span>@endif
            @if($food->is_halal)<span class="fl-pill" style="color:#16A34A;">✓ Halal</span>@endif
        </div>
        <div class="fl-card-foot">
            <div>
                <span class="fl-price">Rs. {{ number_format($food->effective_price) }}</span>
                @if($food->discount_price)<span class="fl-price-old">{{ number_format($food->price) }}</span>@endif
            </div>
            @auth
            <button class="fl-btn-add" onclick="addToCart({{ $food->id }},this)">+ Add</button>
            @else
            <a href="{{ route('login') }}" class="fl-btn-add">Order</a>
            @endauth
        </div>
    </div>
</div>