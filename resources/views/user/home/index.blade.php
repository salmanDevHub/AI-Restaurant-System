@extends('layouts.app')
@section('title', 'Shajahan Tandoori Grills - Multan\'s Finest')

@push('styles')
<style>
/* ── THEME OVERRIDE ── */
:root {
    --stg-cream: #F5F0E8;
    --stg-cream2: #EDE8DC;
    --stg-warm: #E8B89A;
    --stg-red: #C94B2C;
    --stg-red-dark: #A33820;
    --stg-yellow: #E8A020;
    --stg-black: #1A1208;
    --stg-dark: #2C1F0E;
    --stg-gray: #7A6E5F;
    --stg-light: #FAF7F2;
    --stg-border: #D9D0C0;
    --stg-card-bg: #FFFFFF;
}

/* ── NAVBAR OVERRIDE ── */
.navbar {
    background: rgba(250,247,242,0.97) !important;
    border-bottom: 1px solid var(--stg-border) !important;
}
.nav-brand { color: var(--stg-red) !important; }
.nav-brand span { color: var(--stg-black) !important; }

body { background: var(--stg-cream) !important; }

/* ── HERO ── */
.stg-hero {
    background: var(--stg-cream);
    min-height: 88vh;
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    padding: 60px 6%;
    gap: 40px;
    position: relative;
    overflow: hidden;
}
.stg-hero::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(232,184,154,0.35) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}
.stg-hero-left { position: relative; z-index: 2; }
.stg-hero-tag {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--stg-black); color: var(--stg-cream);
    padding: 7px 18px; border-radius: 50px;
    font-size: 0.78rem; font-weight: 700;
    letter-spacing: 0.06em; margin-bottom: 28px;
    text-transform: uppercase;
}
.stg-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.8rem, 4.5vw, 4.4rem);
    font-weight: 900;
    line-height: 1.08;
    color: var(--stg-black);
    margin-bottom: 22px;
    letter-spacing: -0.02em;
}
.stg-hero h1 em {
    font-style: normal;
    color: var(--stg-red);
    position: relative;
}
.stg-hero h1 em::after {
    content: '';
    position: absolute;
    bottom: 2px; left: 0; right: 0;
    height: 4px;
    background: var(--stg-red);
    opacity: 0.25;
    border-radius: 2px;
}
.stg-hero-sub {
    color: var(--stg-gray);
    font-size: 1.05rem;
    line-height: 1.75;
    margin-bottom: 38px;
    max-width: 440px;
}
.stg-hero-btns { display: flex; gap: 14px; flex-wrap: wrap; }
.stg-btn-solid {
    background: var(--stg-red);
    color: white;
    padding: 15px 32px;
    border-radius: 50px;
    font-weight: 700; font-size: 0.95rem;
    text-decoration: none;
    display: inline-flex; align-items: center; gap: 10px;
    transition: all 0.3s;
    box-shadow: 0 8px 28px rgba(201,75,44,0.35);
}
.stg-btn-solid:hover { background: var(--stg-red-dark); transform: translateY(-2px); box-shadow: 0 12px 36px rgba(201,75,44,0.45); }
.stg-btn-outline {
    background: transparent;
    color: var(--stg-black);
    padding: 15px 32px;
    border-radius: 50px;
    font-weight: 700; font-size: 0.95rem;
    border: 2px solid var(--stg-black);
    text-decoration: none;
    display: inline-flex; align-items: center; gap: 10px;
    transition: all 0.3s;
}
.stg-btn-outline:hover { background: var(--stg-black); color: white; }

/* Hero stats row */
.stg-hero-stats {
    display: flex; gap: 32px;
    margin-top: 44px;
    padding-top: 36px;
    border-top: 1px solid var(--stg-border);
}
.stg-stat-val {
    font-family: 'Playfair Display', serif;
    font-size: 2rem; font-weight: 900;
    color: var(--stg-red);
}
.stg-stat-lbl { color: var(--stg-gray); font-size: 0.8rem; margin-top: 2px; }

/* Hero right — magazine mosaic */
.stg-hero-mosaic {
    display: grid;
    grid-template-columns: 1.3fr 1fr;
    grid-template-rows: 260px 200px;
    gap: 14px;
    position: relative; z-index: 2;
}
.stg-mosaic-img {
    border-radius: 22px;
    overflow: hidden;
    position: relative;
}
.stg-mosaic-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.stg-mosaic-img:hover img { transform: scale(1.06); }
.stg-mosaic-img:nth-child(1) { grid-row: span 2; border-radius: 28px; }
.stg-mosaic-label {
    position: absolute; bottom: 12px; left: 12px;
    background: rgba(26,18,8,0.78);
    backdrop-filter: blur(6px);
    color: white; padding: 6px 14px;
    border-radius: 50px; font-size: 0.78rem; font-weight: 700;
}
.stg-mosaic-label span { color: var(--stg-yellow); margin-left: 4px; }

/* ── TICKER ── */
.stg-ticker {
    background: var(--stg-black);
    overflow: hidden; padding: 12px 0;
}
.stg-ticker-track {
    display: flex; gap: 64px;
    white-space: nowrap;
    animation: tickerMove 28s linear infinite;
    width: max-content;
}
.stg-ticker-track span {
    color: var(--stg-cream); font-size: 0.85rem; font-weight: 600;
    display: flex; align-items: center; gap: 8px;
}
.stg-ticker-track span b { color: var(--stg-yellow); }
@keyframes tickerMove { from{transform:translateX(0)} to{transform:translateX(-50%)} }

/* ── SECTIONS ── */
.stg-section { padding: 80px 6%; }
.stg-sec-head { margin-bottom: 44px; }
.stg-sec-label {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--stg-cream2);
    color: var(--stg-red);
    padding: 5px 14px; border-radius: 50px;
    font-size: 0.75rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.07em;
    margin-bottom: 12px;
}
.stg-sec-title {
    font-family: 'Playfair Display', serif;
    font-size: 2.1rem; font-weight: 900;
    color: var(--stg-black);
    line-height: 1.2; margin-bottom: 10px;
}
.stg-sec-sub { color: var(--stg-gray); font-size: 1rem; }

/* ── CATEGORIES ── */
.stg-cats-strip {
    display: flex; gap: 12px;
    overflow-x: auto; padding-bottom: 8px;
    scrollbar-width: none;
}
.stg-cats-strip::-webkit-scrollbar { display: none; }
.stg-cat-pill {
    flex-shrink: 0;
    display: flex; align-items: center; gap: 10px;
    background: white;
    border: 1.5px solid var(--stg-border);
    border-radius: 50px; padding: 10px 20px;
    text-decoration: none; color: var(--stg-dark);
    font-weight: 600; font-size: 0.88rem;
    transition: all 0.25s;
    white-space: nowrap;
}
.stg-cat-pill img {
    width: 34px; height: 34px;
    border-radius: 50%; object-fit: cover;
}
.stg-cat-pill:hover {
    background: var(--stg-black); color: white;
    border-color: var(--stg-black);
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(26,18,8,0.18);
}

/* ── FOOD CARDS ── */
.stg-foods-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
    gap: 22px;
}
.stg-food-card {
    background: white;
    border-radius: 22px;
    overflow: hidden;
    border: 1.5px solid var(--stg-border);
    transition: all 0.35s cubic-bezier(.175,.885,.32,1.275);
    position: relative;
}
.stg-food-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 24px 56px rgba(26,18,8,0.14);
    border-color: var(--stg-warm);
}
.stg-food-img { height: 195px; overflow: hidden; position: relative; }
.stg-food-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
}
.stg-food-card:hover .stg-food-img img { transform: scale(1.08); }
.stg-food-badge {
    position: absolute; top: 12px; left: 12px;
    padding: 4px 12px; border-radius: 50px;
    font-size: 0.72rem; font-weight: 700;
}
.stg-food-badge.popular { background: var(--stg-red); color: white; }
.stg-food-badge.discount { background: var(--stg-yellow); color: var(--stg-black); }
.stg-food-body { padding: 18px; }
.stg-food-meta {
    display: flex; justify-content: space-between;
    align-items: center; margin-bottom: 8px;
}
.stg-cuisine-tag {
    background: var(--stg-cream); color: var(--stg-gray);
    padding: 3px 10px; border-radius: 50px;
    font-size: 0.72rem; font-weight: 600;
}
.stg-rating { font-size: 0.82rem; font-weight: 700; color: var(--stg-yellow); }
.stg-food-name {
    font-size: 1.05rem; font-weight: 800;
    color: var(--stg-black); margin-bottom: 5px;
    text-decoration: none;
}
.stg-food-name:hover { color: var(--stg-red); }
.stg-food-desc {
    color: var(--stg-gray); font-size: 0.82rem;
    line-height: 1.55; margin-bottom: 14px;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.stg-food-footer {
    display: flex; align-items: center;
    justify-content: space-between;
}
.stg-price { font-size: 1.2rem; font-weight: 900; color: var(--stg-red); }
.stg-price-old { font-size: 0.8rem; color: var(--stg-gray); text-decoration: line-through; margin-left: 5px; }
.stg-btn-add {
    background: var(--stg-black); color: white;
    border: none; border-radius: 50px;
    padding: 9px 18px; font-size: 0.82rem; font-weight: 700;
    cursor: pointer; transition: all 0.2s;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
}
.stg-btn-add:hover { background: var(--stg-red); transform: scale(1.05); }

/* ── EDITORIAL BANNER ── */
.stg-editorial {
    background: var(--stg-black);
    margin: 0 6%;
    border-radius: 28px;
    padding: 60px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 48px;
    align-items: center;
    position: relative;
    overflow: hidden;
}
.stg-editorial::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 350px; height: 350px;
    background: radial-gradient(circle, rgba(201,75,44,0.22) 0%, transparent 70%);
    border-radius: 50%;
}
.stg-editorial-tag {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,0.08);
    color: var(--stg-yellow);
    padding: 5px 14px; border-radius: 50px;
    font-size: 0.75rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.08em;
    margin-bottom: 18px;
}
.stg-editorial h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2.4rem; font-weight: 900;
    color: white; line-height: 1.15;
    margin-bottom: 16px;
}
.stg-editorial h2 em { font-style: normal; color: var(--stg-yellow); }
.stg-editorial p { color: #B0A090; font-size: 0.95rem; line-height: 1.75; margin-bottom: 28px; }
.stg-editorial-imgs {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px; border-radius: 18px; overflow: hidden;
}
.stg-editorial-imgs img {
    width: 100%; height: 160px;
    object-fit: cover; border-radius: 14px;
    transition: transform 0.4s;
}
.stg-editorial-imgs img:hover { transform: scale(1.04); }

/* ── FEATURES STRIP ── */
.stg-feats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(185px, 1fr));
    gap: 20px;
}
.stg-feat {
    background: white;
    border-radius: 18px;
    padding: 28px 20px;
    text-align: center;
    border: 1.5px solid var(--stg-border);
    transition: all 0.3s;
}
.stg-feat:hover {
    border-color: var(--stg-red);
    transform: translateY(-6px);
    box-shadow: 0 18px 44px rgba(201,75,44,0.12);
}
.stg-feat-icon { font-size: 2.2rem; margin-bottom: 12px; }
.stg-feat-title { font-size: 0.95rem; font-weight: 800; color: var(--stg-black); margin-bottom: 7px; }
.stg-feat-desc { color: var(--stg-gray); font-size: 0.82rem; line-height: 1.6; }

/* ── LOYALTY ── */
.stg-loyalty { background: var(--stg-cream2); }
.stg-tiers {
    display: flex; gap: 16px;
    flex-wrap: wrap; justify-content: center;
    margin-top: 32px;
}
.stg-tier {
    background: white;
    border-radius: 20px;
    padding: 28px 24px;
    text-align: center;
    min-width: 165px;
    border: 2px solid var(--stg-border);
    transition: all 0.3s;
}
.stg-tier:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 44px rgba(26,18,8,0.1);
}
.stg-tier-ico { font-size: 2.4rem; margin-bottom: 10px; }
.stg-tier-name { font-weight: 800; font-size: 1rem; margin-bottom: 6px; }
.stg-tier-pct { font-size: 1.6rem; font-weight: 900; color: var(--stg-red); }
.stg-tier-req { font-size: 0.76rem; color: var(--stg-gray); margin-top: 6px; }

/* ── RESPONSIVE ── */
@media(max-width: 900px) {
    .stg-hero { grid-template-columns: 1fr; min-height: auto; padding: 50px 5%; }
    .stg-hero-mosaic { display: none; }
    .stg-editorial { grid-template-columns: 1fr; padding: 36px; margin: 0 4%; }
    .stg-editorial-imgs { display: none; }
}
@media(max-width: 640px) {
    .stg-foods-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
    .stg-food-img { height: 145px; }
    .stg-hero h1 { font-size: 2.3rem; }
    .stg-hero-stats { gap: 18px; }
}
</style>
@endpush

@section('content')

{{-- ── HERO ── --}}
<section class="stg-hero">
    <div class="stg-hero-left">
        <div class="stg-hero-tag">🔥 Multan's Finest Tandoor Since 1992</div>
        <h1>Authentic Tandoori,<br><em>Crafted</em> With<br>Passion & Flame</h1>
        <p class="stg-hero-sub">From smoky seekh kababs to slow-cooked nihari — every dish carries the rich heritage of Multan's royal cuisine, prepared fresh daily in our clay tandoor.</p>
        <div class="stg-hero-btns">
            <a href="{{ route('user.menu') }}" class="stg-btn-solid">🍽️ Explore Menu</a>
            <a href="#" onclick="toggleChat();return false;" class="stg-btn-outline">🤖 AI Food Guide</a>
        </div>
        <div class="stg-hero-stats">
            <div>
                <div class="stg-stat-val">54+</div>
                <div class="stg-stat-lbl">Dishes</div>
            </div>
            <div>
                <div class="stg-stat-val">12</div>
                <div class="stg-stat-lbl">Categories</div>
            </div>
            <div>
                <div class="stg-stat-val">45min</div>
                <div class="stg-stat-lbl">Delivery</div>
            </div>
            <div>
                <div class="stg-stat-val">4.9⭐</div>
                <div class="stg-stat-lbl">Rating</div>
            </div>
        </div>
    </div>

    {{-- Mosaic --}}
    <div class="stg-hero-mosaic">
        @php
        $mosaicImgs = [
            ['https://images.unsplash.com/photo-1631515243349-e0cb75fb8d3a?w=600', 'Chicken Biryani', 'Rs.450'],
            ['https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=400', 'Seekh Kabab', 'Rs.320'],
            ['https://images.unsplash.com/photo-1574894709920-11b28e7367e3?w=400', 'Naan Platter', 'Rs.180'],
        ];
        @endphp
        @foreach($mosaicImgs as $img)
        <div class="stg-mosaic-img">
            <img src="{{ $img[0] }}" alt="{{ $img[1] }}" loading="lazy"
                onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=600'">
            <div class="stg-mosaic-label">{{ $img[1] }} <span>{{ $img[2] }}</span></div>
        </div>
        @endforeach
    </div>
</section>

{{-- ── TICKER ── --}}
<div class="stg-ticker">
    <div class="stg-ticker-track">
        @foreach(range(1,2) as $_)
        <span>🎉 <b>WELCOME20</b> — 20% OFF your first order!</span>
        <span>🛵 Free delivery above <b>Rs.1000</b></span>
        <span>⭐ Earn loyalty points on every order</span>
        <span>🔥 100% Wood-fired Clay Tandoor</span>
        <span>✅ <b>Certified Halal</b> — Always</span>
        <span>🤖 Ask Zara AI for food suggestions</span>
        @endforeach
    </div>
</div>

{{-- ── CATEGORIES ── --}}
<section class="stg-section" style="background: var(--stg-light); padding-bottom: 40px;">
    <div class="stg-sec-head">
        <div class="stg-sec-label">🌍 Our Menu</div>
        <h2 class="stg-sec-title">Browse by Category</h2>
        <p class="stg-sec-sub">Authentic flavors across every category — from Tandoor to Desserts</p>
    </div>
    <div class="stg-cats-strip">
        @foreach($categories as $cat)
        <a href="{{ route('user.menu', ['category' => $cat->slug]) }}" class="stg-cat-pill">
            <img src="{{ $cat->image_url }}" alt="{{ $cat->name }}"
                onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=80'">
            {{ $cat->icon }} {{ $cat->name }}
        </a>
        @endforeach
    </div>
</section>

{{-- ── CHEF'S SPECIALS ── --}}
<section class="stg-section" style="background: var(--stg-light);">
    <div class="stg-sec-head">
        <div class="stg-sec-label">⭐ Chef's Choice</div>
        <h2 class="stg-sec-title">Shajahan's Specials</h2>
        <p class="stg-sec-sub">Our most acclaimed, award-winning dishes — cooked to perfection</p>
    </div>
    <div class="stg-foods-grid">
        @foreach($featuredFoods as $food)
        <div class="stg-food-card">
            <div class="stg-food-img">
                <img src="{{ $food->image_url }}" alt="{{ $food->name }}" loading="lazy"
                    onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400'">
                @if($food->is_popular)<span class="stg-food-badge popular">🔥 Popular</span>@endif
                @if($food->discount_price)<span class="stg-food-badge discount" style="top:42px;">{{ $food->discount_percentage }}% OFF</span>@endif
            </div>
            <div class="stg-food-body">
                <div class="stg-food-meta">
                    <span class="stg-cuisine-tag">{{ $food->cuisine }}</span>
                    <span class="stg-rating">⭐ {{ number_format($food->rating, 1) }}</span>
                </div>
                <a href="{{ route('user.food.show', $food->slug) }}" class="stg-food-name">{{ $food->name }}</a>
                <p class="stg-food-desc">{{ $food->description }}</p>
                <div style="display:flex;gap:8px;margin-bottom:14px;font-size:0.77rem;color:var(--stg-gray);">
                    <span>{{ $food->spicy_icon }}</span>
                    <span>🕐 {{ $food->prep_time }}min</span>
                    @if($food->calories)<span>🔥 {{ $food->calories }}cal</span>@endif
                    @if($food->is_halal)<span style="color:#10B981;font-weight:600;">✓ Halal</span>@endif
                </div>
                <div class="stg-food-footer">
                    <div>
                        <span class="stg-price">Rs. {{ number_format($food->effective_price) }}</span>
                        @if($food->discount_price)<span class="stg-price-old">{{ number_format($food->price) }}</span>@endif
                    </div>
                    @auth
                    <button class="stg-btn-add" onclick="addToCart({{ $food->id }},this)">+ Add</button>
                    @else
                    <a href="{{ route('login') }}" class="stg-btn-add">Order</a>
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div style="text-align:center;margin-top:44px;">
        <a href="{{ route('user.menu') }}" class="stg-btn-solid" style="display:inline-flex;">View Full Menu →</a>
    </div>
</section>

{{-- ── EDITORIAL DARK BANNER ── --}}
<section style="padding: 0 0 80px;">
    <div class="stg-editorial">
        <div style="position:relative;z-index:2;">
            <div class="stg-editorial-tag">🏆 Our Story</div>
            <h2>Where <em>Heritage</em><br>Meets the Flame</h2>
            <p>Since 1992, Shajahan Tandoori Grills has been serving Multan's most beloved tandoor cuisine. Our clay ovens burn at 480°C, sealing in flavors that no modern stove can replicate. Every recipe is a family secret, passed down through generations.</p>
            <a href="{{ route('user.menu') }}" class="stg-btn-solid" style="display:inline-flex;">Explore Our Menu →</a>
        </div>
        <div class="stg-editorial-imgs" style="position:relative;z-index:2;">
            <img src="https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=400" alt="Tandoor"
                onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400'">
            <img src="https://images.unsplash.com/photo-1631515243349-e0cb75fb8d3a?w=400" alt="Biryani"
                onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400'">
            <img src="https://images.unsplash.com/photo-1574894709920-11b28e7367e3?w=400" alt="Naan"
                onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400'">
            <img src="https://images.unsplash.com/photo-1544025162-d76694265947?w=400" alt="BBQ"
                onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400'">
        </div>
    </div>
</section>

{{-- ── POPULAR ── --}}
<section class="stg-section" style="background: white; padding-top: 60px;">
    <div class="stg-sec-head">
        <div class="stg-sec-label">🔥 Trending</div>
        <h2 class="stg-sec-title">Most Popular Right Now</h2>
        <p class="stg-sec-sub">What everyone in Multan is ordering today</p>
    </div>
    <div class="stg-foods-grid">
        @foreach($popularFoods->take(8) as $food)
        <div class="stg-food-card">
            <div class="stg-food-img">
                <img src="{{ $food->image_url }}" alt="{{ $food->name }}" loading="lazy"
                    onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400'">
                <span class="stg-food-badge discount">{{ number_format($food->total_orders) }}+ orders</span>
            </div>
            <div class="stg-food-body">
                <div class="stg-food-meta">
                    <span class="stg-cuisine-tag">{{ $food->category->icon ?? '' }} {{ $food->cuisine }}</span>
                    <span class="stg-rating">⭐ {{ number_format($food->rating,1) }}</span>
                </div>
                <a href="{{ route('user.food.show', $food->slug) }}" class="stg-food-name">{{ $food->name }}</a>
                <p class="stg-food-desc">{{ $food->description }}</p>
                <div class="stg-food-footer">
                    <span class="stg-price">Rs. {{ number_format($food->effective_price) }}</span>
                    @auth
                    <button class="stg-btn-add" onclick="addToCart({{ $food->id }},this)">+ Add</button>
                    @else
                    <a href="{{ route('login') }}" class="stg-btn-add">Order</a>
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ── WHY US ── --}}
<section class="stg-section" style="background: var(--stg-cream);">
    <div class="stg-sec-head">
        <div class="stg-sec-label">💛 Why Us</div>
        <h2 class="stg-sec-title">Why Shajahan Tandoori?</h2>
        <p class="stg-sec-sub">More than a restaurant — a 30-year legacy of taste and trust</p>
    </div>
    <div class="stg-feats-grid">
        @foreach([
            ['🔥','Clay Tandoor','480°C wood-fired clay ovens that seal in authentic smoky flavors.'],
            ['🚴','45-Min Delivery','GPS-tracked delivery from our kitchen to your doorstep. Always hot.'],
            ['👨‍🍳','Master Chefs','Generational recipes, refined over 30+ years of culinary mastery.'],
            ['🤖','Zara AI Guide','Our AI assistant detects your mood and picks the perfect dish for you.'],
            ['⭐','Loyalty Rewards','Earn points every order. Unlock exclusive tiers and discounts.'],
            ['✅','100% Halal','Certified halal — always. Your faith and safety come first.'],
        ] as [$ico, $title, $desc])
        <div class="stg-feat">
            <div class="stg-feat-icon">{{ $ico }}</div>
            <div class="stg-feat-title">{{ $title }}</div>
            <div class="stg-feat-desc">{{ $desc }}</div>
        </div>
        @endforeach
    </div>
</section>

{{-- ── LOYALTY ── --}}
<section class="stg-section stg-loyalty">
    <div class="stg-sec-head">
        <div class="stg-sec-label">💎 Rewards</div>
        <h2 class="stg-sec-title">Loyalty Program</h2>
        <p class="stg-sec-sub">Order more, save more — exclusive rewards for our most loyal guests</p>
    </div>
    <div class="stg-tiers">
        @foreach([
            ['🥉','Bronze','0%','New members','#CD7F32'],
            ['🥈','Silver','5%','5+ orders / Rs.5,000','#9CA3AF'],
            ['🥇','Gold','10%','20+ orders / Rs.20,000','#F59E0B'],
            ['💎','Platinum','15%','50+ orders / Rs.50,000','#7C3AED'],
        ] as [$ico,$name,$disc,$req,$color])
        <div class="stg-tier" style="border-color:{{ $color }}30;">
            <div class="stg-tier-ico">{{ $ico }}</div>
            <div class="stg-tier-name" style="color:{{ $color }};">{{ $name }}</div>
            <div class="stg-tier-pct">{{ $disc }} OFF</div>
            <div class="stg-tier-req">{{ $req }}</div>
        </div>
        @endforeach
    </div>
    @auth
    <div style="text-align:center;margin-top:28px;">
        <p style="color:var(--stg-gray);font-size:0.9rem;">Your tier: <strong style="color:var(--stg-red);">{{ ucfirst(Auth::user()->loyalty_tier) }}</strong> — Points: <strong>{{ Auth::user()->loyalty_points }}</strong></p>
    </div>
    @else
    <div style="text-align:center;margin-top:32px;">
        <a href="{{ route('register') }}" class="stg-btn-solid" style="display:inline-flex;">Join Free & Get 20% OFF 🎉</a>
    </div>
    @endauth
</section>

@endsection

@push('scripts')
<script>
// Mouse parallax on food cards
document.querySelectorAll('.stg-food-card').forEach(card => {
    card.addEventListener('mousemove', e => {
        const r = card.getBoundingClientRect();
        const x = (e.clientX - r.left) / r.width - 0.5;
        const y = (e.clientY - r.top) / r.height - 0.5;
        card.style.transform = `translateY(-10px) rotateY(${x * 8}deg) rotateX(${-y * 6}deg)`;
    });
    card.addEventListener('mouseleave', () => { card.style.transform = ''; });
});
</script>
@endpush
