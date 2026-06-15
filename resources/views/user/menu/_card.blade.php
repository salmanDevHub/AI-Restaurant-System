<div class="fc">
    <div class="fc-img">
        <img src="{{ $food->image_url }}" alt="{{ $food->name }}" loading="lazy"
            onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400'">
        @if($food->is_featured)<span class="fc-badge fc-pop">⭐ Featured</span>@endif
        @if($food->is_popular)<span class="fc-badge fc-pop" style="{{ $food->is_featured ? 'top:34px;' : '' }}">🔥 Popular</span>@endif
        @if($food->discount_price)<span class="fc-badge fc-disc" style="top:{{ ($food->is_featured || $food->is_popular) ? '58px' : '8px' }};">{{ $food->discount_percentage }}% OFF</span>@endif
        @auth
        <button class="fc-wish" onclick="toggleWish({{ $food->id }},this)">🤍</button>
        @endauth
    </div>
    <div class="fc-body">
        <div class="fc-cat">{{ $food->category->icon ?? '' }} {{ $food->cuisine }}</div>
        <a href="{{ route('user.food.show', $food->slug) }}" class="fc-name">{{ $food->name }}</a>
        <div class="fc-stars">★★★★★ <span>({{ number_format($food->rating,1) }})</span></div>
        <div class="fc-foot">
            <div class="fc-pills">
                <span class="fc-pill">{{ $food->spicy_icon ?? '🌶️' }} Heat</span>
                <span class="fc-pill" onclick="toggleWish({{ $food->id }},this)" style="cursor:pointer;">🤍 Fav</span>
            </div>
            <div style="display:flex;align-items:center;gap:6px;">
                <div>
                    <span class="fc-price">Rs.{{ number_format($food->effective_price) }}</span>
                    @if($food->discount_price)<span class="fc-price-old">{{ number_format($food->price) }}</span>@endif
                </div>
                @auth
                <button class="btn-cart" onclick="addToCart({{ $food->id }},this)" title="Add to cart">🛒</button>
                @else
                <a href="{{ route('login') }}" class="btn-cart" title="Login to order">🛒</a>
                @endauth
            </div>
        </div>
    </div>
</div>