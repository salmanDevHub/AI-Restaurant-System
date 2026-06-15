@extends('layouts.app')
@section('title','Menu — Shajahan Tandoori Grills')

@push('styles')
<style>
:root{--red:#C8341A;--red2:#A02810;--dark:#1A1208;--gray:#6B6357;--border:#E8E0D4;--cream:#FAF7F2;--yellow:#E8A020;--green:#52B44B;}

/* HERO */
.mh{position:relative;overflow:hidden;background:#0F1923;min-height:280px;display:flex;align-items:center;}
.mh-bg{position:absolute;inset:0;display:grid;grid-template-columns:repeat(5,1fr);opacity:.25;}
.mh-bg img{width:100%;height:100%;object-fit:cover;}
.mh-ov{position:absolute;inset:0;background:linear-gradient(90deg,rgba(15,25,35,.97) 35%,rgba(15,25,35,.55));}
.mh-body{position:relative;z-index:2;padding:44px 6%;width:100%;}
.mh-body h1{font-family:'Playfair Display',serif;font-size:clamp(1.8rem,3.5vw,2.8rem);font-weight:900;color:#fff;margin-bottom:8px;line-height:1.1;}
.mh-body h1 span{color:#E8A020;}
.mh-body p{color:#9AA5B0;font-size:.9rem;margin-bottom:22px;}
.mh-search{display:flex;max-width:500px;background:rgba(255,255,255,.1);border:1.5px solid rgba(255,255,255,.2);border-radius:50px;overflow:hidden;backdrop-filter:blur(8px);}
.mh-search input{flex:1;background:transparent;border:none;padding:13px 20px;color:#fff;font-size:.9rem;font-family:'DM Sans',sans-serif;outline:none;}
.mh-search input::placeholder{color:rgba(255,255,255,.4);}
.mh-search button{background:var(--red);color:#fff;border:none;padding:13px 26px;font-weight:700;font-size:.88rem;cursor:pointer;font-family:'DM Sans',sans-serif;border-radius:0 50px 50px 0;transition:background .2s;}
.mh-search button:hover{background:var(--red2);}

/* CATEGORY CIRCLES */
.cs{background:#fff;padding:36px 6% 28px;text-align:center;}
.cs h2{font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:900;color:var(--dark);margin-bottom:24px;}
.cc{display:flex;gap:18px;justify-content:center;flex-wrap:wrap;}
.ci{display:flex;flex-direction:column;align-items:center;gap:8px;text-decoration:none;transition:transform .25s;min-width:72px;}
.ci:hover{transform:translateY(-5px);}
.ci-img{width:72px;height:72px;border-radius:50%;overflow:hidden;border:3px solid var(--border);background:var(--dark);box-shadow:0 5px 18px rgba(0,0,0,.12);transition:border-color .25s,box-shadow .25s;display:flex;align-items:center;justify-content:center;font-size:1.6rem;}
.ci:hover .ci-img,.ci.active .ci-img{border-color:var(--red);box-shadow:0 8px 24px rgba(200,52,26,.25);}
.ci-img img{width:100%;height:100%;object-fit:cover;}
.ci span{font-size:.72rem;font-weight:700;color:var(--dark);text-align:center;line-height:1.3;}
.ci.active span{color:var(--red);}

/* SORT BAR */
.sb{background:#fff;padding:10px 6%;display:flex;align-items:center;gap:12px;border-bottom:1px solid var(--border);border-top:1px solid var(--border);}
.sb-info{color:var(--gray);font-size:.85rem;}
.sb-info strong{color:var(--dark);}
.sb-sel{border:1.5px solid var(--border);border-radius:10px;padding:7px 12px;font-size:.82rem;font-family:'DM Sans',sans-serif;color:var(--dark);background:#fff;cursor:pointer;outline:none;margin-left:auto;}
.sb-sel:focus{border-color:var(--red);}
.sb-clear{color:var(--red);font-size:.82rem;font-weight:600;text-decoration:none;}

/* SECTION HEADER */
.sec-wrap{padding:32px 6%;}
.sec-hd{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;padding-bottom:12px;border-bottom:2px solid var(--border);}
.sec-hd h2{font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:900;color:var(--dark);display:flex;align-items:center;gap:8px;}
.sec-hd a{color:var(--red);font-size:.82rem;font-weight:700;text-decoration:none;}

/* FOOD GRID */
.fg{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;}

/* FOOD CARD */
.fc{background:#fff;border-radius:14px;overflow:hidden;border:1px solid var(--border);transition:all .3s cubic-bezier(.175,.885,.32,1.275);position:relative;}
.fc:hover{transform:translateY(-7px);box-shadow:0 20px 48px rgba(26,18,8,.14);}
.fc-img{height:170px;overflow:hidden;position:relative;}
.fc-img img{width:100%;height:100%;object-fit:cover;transition:transform .45s;}
.fc:hover .fc-img img{transform:scale(1.07);}
.fc-wish{position:absolute;top:8px;right:8px;width:30px;height:30px;border-radius:50%;background:rgba(255,255,255,.92);border:none;cursor:pointer;font-size:.9rem;display:flex;align-items:center;justify-content:center;transition:transform .15s;box-shadow:0 2px 8px rgba(0,0,0,.12);}
.fc-wish:hover{transform:scale(1.2);}
.fc-badge{position:absolute;top:8px;left:8px;padding:3px 9px;border-radius:50px;font-size:.65rem;font-weight:700;}
.fc-pop{background:var(--red);color:#fff;}
.fc-disc{background:var(--yellow);color:var(--dark);}
.fc-body{padding:12px 13px 13px;}
.fc-cat{font-size:.68rem;color:var(--gray);font-weight:600;margin-bottom:4px;}
.fc-name{font-weight:800;font-size:.9rem;color:var(--dark);text-decoration:none;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:4px;}
.fc-name:hover{color:var(--red);}
.fc-stars{color:var(--yellow);font-size:.72rem;margin-bottom:6px;}
.fc-stars span{color:var(--gray);font-size:.68rem;margin-left:2px;}
.fc-foot{display:flex;align-items:center;justify-content:space-between;margin-top:8px;padding-top:8px;border-top:1px solid var(--border);}
.fc-price{font-size:.98rem;font-weight:900;color:var(--red);}
.fc-price-old{font-size:.72rem;color:var(--gray);text-decoration:line-through;margin-left:3px;}
.fc-pills{display:flex;gap:8px;}
.fc-pill{font-size:.68rem;color:var(--gray);display:flex;align-items:center;gap:2px;cursor:pointer;}
.fc-pill:hover{color:var(--red);}
.btn-cart{width:30px;height:30px;border-radius:50%;background:var(--red);color:#fff;border:none;font-size:.88rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .2s;}
.btn-cart:hover{background:var(--red2);transform:scale(1.12);}

/* OFFER CARD */
.offer-c{grid-column:span 2;background:linear-gradient(135deg,#C8341A,#E85A1A);border-radius:14px;padding:22px 24px;display:flex;align-items:center;justify-content:space-between;color:#fff;position:relative;overflow:hidden;}
.offer-c::before{content:'';position:absolute;right:-25px;top:-25px;width:140px;height:140px;background:rgba(255,255,255,.07);border-radius:50%;}
.offer-c::after{content:'🍗';position:absolute;right:90px;top:50%;transform:translateY(-50%);font-size:3rem;opacity:.3;}
.offer-lbl{font-size:.68rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;opacity:.8;margin-bottom:5px;}
.offer-title{font-family:'Playfair Display',serif;font-size:1.2rem;font-weight:900;margin-bottom:4px;}
.offer-code{font-size:.78rem;opacity:.85;}
.offer-code strong{background:rgba(255,255,255,.18);padding:2px 8px;border-radius:50px;}
.offer-btn{background:#fff;color:var(--red);padding:9px 18px;border-radius:50px;font-weight:800;font-size:.82rem;text-decoration:none;flex-shrink:0;transition:transform .2s;z-index:1;}
.offer-btn:hover{transform:scale(1.04);}

/* DESSERT SPECIAL GRID */
.dessert-section{background:var(--cream);padding:32px 6%;}
.dessert-grid{display:grid;grid-template-columns:200px 1fr;gap:16px;margin-top:16px;}
.dessert-sidebar{display:flex;flex-direction:column;gap:0;}
.dessert-side-item{display:flex;align-items:center;gap:10px;padding:10px 12px;background:#fff;border:1px solid var(--border);cursor:pointer;transition:all .2s;text-decoration:none;}
.dessert-side-item:first-child{border-radius:10px 10px 0 0;}
.dessert-side-item:last-child{border-radius:0 0 10px 10px;}
.dessert-side-item:hover,.dessert-side-item.active{background:var(--red);border-color:var(--red);}
.dessert-side-item:hover *,.dessert-side-item.active *{color:#fff !important;}
.dessert-side-img{width:44px;height:44px;border-radius:8px;overflow:hidden;flex-shrink:0;}
.dessert-side-img img{width:100%;height:100%;object-fit:cover;}
.dessert-side-name{font-size:.8rem;font-weight:700;color:var(--dark);}
.dessert-side-price{font-size:.72rem;color:var(--red);}
.dessert-main{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;}
.dessert-card{background:#fff;border-radius:12px;overflow:hidden;border:1px solid var(--border);transition:all .3s;position:relative;}
.dessert-card:hover{transform:translateY(-5px);box-shadow:0 14px 36px rgba(26,18,8,.12);}
.dessert-card img{width:100%;height:140px;object-fit:cover;}
.dessert-body{padding:10px 11px;}
.dessert-name{font-size:.85rem;font-weight:800;color:var(--dark);margin-bottom:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.dessert-price{font-size:.88rem;font-weight:900;color:var(--red);}
.dessert-badge{position:absolute;top:8px;right:8px;background:var(--yellow);color:var(--dark);padding:2px 8px;border-radius:50px;font-size:.62rem;font-weight:800;}
.dessert-footer{display:flex;align-items:center;justify-content:space-between;margin-top:8px;}
.btn-dessert-add{background:var(--red);color:#fff;border:none;border-radius:50px;padding:6px 14px;font-size:.75rem;font-weight:700;cursor:pointer;transition:all .2s;font-family:'DM Sans',sans-serif;}
.btn-dessert-add:hover{background:var(--red2);transform:scale(1.04);}

/* TODAY'S DEALS countdown */
.deals-section{background:#fff;padding:32px 6%;}
.deals-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-top:16px;}
.deal-card{background:var(--cream);border-radius:12px;overflow:hidden;border:1px solid var(--border);position:relative;transition:all .3s;}
.deal-card:hover{transform:translateY(-4px);box-shadow:0 12px 30px rgba(26,18,8,.1);}
.deal-card img{width:100%;height:140px;object-fit:cover;}
.deal-body{padding:10px 12px;}
.deal-name{font-size:.82rem;font-weight:800;color:var(--dark);margin-bottom:4px;}
.deal-timer{display:flex;gap:4px;margin-bottom:8px;}
.dt-block{background:var(--dark);color:#fff;border-radius:5px;padding:3px 6px;font-size:.72rem;font-weight:700;min-width:30px;text-align:center;}
.dt-sep{color:var(--dark);font-weight:900;line-height:2;}
.deal-price{display:flex;align-items:center;gap:6px;}
.deal-price .new{font-size:.95rem;font-weight:900;color:var(--red);}
.deal-price .old{font-size:.75rem;color:var(--gray);text-decoration:line-through;}
.deal-badge{position:absolute;top:8px;left:8px;background:var(--red);color:#fff;padding:3px 9px;border-radius:50px;font-size:.65rem;font-weight:800;}

/* BEST SELLERS */
.bs-section{background:var(--cream);padding:32px 6%;}
.bs-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-top:16px;}

/* EMPTY */
.empty{text-align:center;padding:60px 20px;color:var(--gray);}
.empty .ico{font-size:3.5rem;margin-bottom:12px;}
.empty h3{font-size:1.2rem;color:var(--dark);margin-bottom:6px;}

/* PAGINATION */
.pages{display:flex;align-items:center;justify-content:center;gap:7px;margin-top:28px;}
.pg{width:36px;height:36px;border-radius:9px;border:1.5px solid var(--border);background:#fff;color:var(--dark);font-weight:600;font-size:.85rem;cursor:pointer;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all .15s;}
.pg:hover{border-color:var(--red);color:var(--red);}
.pg.active{background:var(--red);border-color:var(--red);color:#fff;}

/* TOAST */
.toast{position:fixed;bottom:24px;right:24px;background:var(--dark);color:#fff;padding:12px 20px;border-radius:12px;font-size:.88rem;font-weight:600;z-index:9999;transform:translateY(80px);opacity:0;transition:all .3s;max-width:280px;}
.toast.show{transform:translateY(0);opacity:1;}
.toast.success{border-left:4px solid var(--green);}
.toast.error{border-left:4px solid #EF4444;}

/* CART FLOATING */
.cart-float{position:fixed;bottom:80px;right:24px;background:var(--red);color:#fff;width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.3rem;text-decoration:none;box-shadow:0 6px 24px rgba(200,52,26,.45);z-index:999;transition:all .2s;}
.cart-float:hover{background:var(--red2);transform:scale(1.08);}
.cart-float .cnt{position:absolute;top:-4px;right:-4px;background:#fff;color:var(--red);width:20px;height:20px;border-radius:50%;font-size:.7rem;font-weight:900;display:flex;align-items:center;justify-content:center;}

@media(max-width:1024px){.fg{grid-template-columns:repeat(3,1fr);}.deals-grid,.bs-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:768px){.fg{grid-template-columns:repeat(2,1fr);}.offer-c{grid-column:span 2;flex-direction:column;gap:12px;}.offer-c::after{display:none;}.cc{gap:12px;}.ci-img{width:58px;height:58px;}.dessert-grid{grid-template-columns:1fr;}.dessert-sidebar{display:grid;grid-template-columns:repeat(3,1fr);}}
@media(max-width:480px){.fg{grid-template-columns:repeat(2,1fr);gap:10px;}.fc-img{height:130px;}}
</style>
@endpush

@section('content')

{{-- HERO --}}
<div class="mh">
    <div class="mh-bg">
        @foreach(['https://images.unsplash.com/photo-1631515243349-e0cb75fb8d3a?w=400','https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=400','https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=400','https://images.unsplash.com/photo-1544025162-d76694265947?w=400','https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=400'] as $bg)
        <img src="{{ $bg }}" alt="" loading="lazy">
        @endforeach
    </div>
    <div class="mh-ov"></div>
    <div class="mh-body">
        <h1>Our <span>Full Menu</span> 🍽️</h1>
        <p>{{ $foods->total() }} delicious items — fresh daily from our clay tandoor</p>
        <div class="mh-search">
            <form method="GET" action="{{ route('user.menu') }}" style="display:flex;width:100%;">
                @foreach(request()->except('search','page') as $k=>$v)
                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                @endforeach
                <input type="text" name="search" id="srch" placeholder="Search biryani, burger, pizza..." value="{{ request('search') }}">
                <button type="submit">🔍 Search</button>
            </form>
        </div>
    </div>
</div>

{{-- CATEGORIES --}}
<div class="cs">
    <h2>Browse Categories</h2>
    <div class="cc">
        <a href="{{ route('user.menu', request()->except('category','page')) }}" class="ci {{ !request('category') ? 'active' : '' }}">
            <div class="ci-img">🍽️</div>
            <span>All Items</span>
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('user.menu', array_merge(request()->except('page'), ['category'=>$cat->slug])) }}" class="ci {{ request('category')===$cat->slug ? 'active' : '' }}">
            <div class="ci-img">
                @if(!empty($cat->image_url) || !empty($cat->image))
                    <img src="{{ $cat->image_url ?: $cat->image }}" alt="{{ $cat->name }}">
                @else
                    {{ $cat->icon }}
                @endif
            </div>
            <span>{{ $cat->name }}</span>
        </a>
        @endforeach
    </div>
</div>

{{-- SORT BAR --}}
<div class="sb">
    <span class="sb-info">
        <strong>{{ $foods->total() }}</strong> items found
        @if(request('category'))
            in <strong>{{ ucwords(str_replace('-',' ',request('category'))) }}</strong>
        @endif
    </span>
    @if(request()->hasAny(['category','search','spicy']))
        <a href="{{ route('user.menu') }}" class="sb-clear">✕ Clear</a>
    @endif
    <form method="GET" action="{{ route('user.menu') }}">
        @foreach(request()->except('sort') as $k=>$v)
            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <select name="sort" class="sb-sel" onchange="this.form.submit()">
            <option value="">Sort: Default</option>
            <option value="popular" {{ request('sort')==='popular' ? 'selected' : '' }}>🔥 Most Popular</option>
            <option value="rating" {{ request('sort')==='rating' ? 'selected' : '' }}>⭐ Top Rated</option>
            <option value="price_asc" {{ request('sort')==='price_asc' ? 'selected' : '' }}>💰 Price: Low–High</option>
            <option value="price_desc" {{ request('sort')==='price_desc' ? 'selected' : '' }}>💸 Price: High–Low</option>
        </select>
    </form>
</div>

{{-- MAIN FOODS --}}
@if($foods->isEmpty())
<div class="empty">
    <div class="ico">🔍</div>
    <h3>No items found</h3>
    <p>Try different filters or <a href="{{ route('user.menu') }}" style="color:var(--red);">clear all filters</a></p>
</div>
@else

@if(!request('search') && !request('category') && !request('spicy'))
{{-- ===== DEFAULT HOME VIEW ===== --}}

{{-- Popular Dishes --}}
@php $popular = $foods->getCollection()->where('is_popular',true)->take(8); @endphp
@if($popular->isNotEmpty())
<div class="sec-wrap" style="background:var(--cream);">
    <div class="sec-hd">
        <h2>🔥 Popular Dishes</h2>
        <a href="{{ route('user.menu',['sort'=>'popular']) }}">View All →</a>
    </div>
    <div class="fg">
        @foreach($popular as $i=>$food)
        @if($i===4)
        <div class="offer-c">
            <div>
                <div class="offer-lbl">🎉 Limited Time Offer</div>
                <div class="offer-title">SPECIAL OFFERS<br>ENJOY 20% OFF!</div>
                <div class="offer-code">Use code: <strong>WELCOME20</strong></div>
            </div>
            <a href="{{ route('register') }}" class="offer-btn">Claim Now →</a>
        </div>
        @endif
        @include('user.menu._card',['food'=>$food])
        @endforeach
    </div>
</div>
@endif

{{-- TODAY'S DEALS --}}
@php $deals = $foods->getCollection()->filter(fn($f)=>$f->discount_price)->take(4); @endphp
@if($deals->isNotEmpty())
<div class="deals-section">
    <div class="sec-hd">
        <h2>⏰ Today's Deals</h2>
        <a href="{{ route('user.menu',['sort'=>'popular']) }}">View All →</a>
    </div>
    <div class="deals-grid">
        @foreach($deals as $food)
        <div class="deal-card">
            <img src="{{ $food->image_url }}" alt="{{ $food->name }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400'">
            <span class="deal-badge">{{ $food->discount_percentage }}% OFF</span>
            <div class="deal-body">
                <div class="deal-name">{{ $food->name }}</div>
                <div class="deal-timer">
                    <div class="dt-block" data-h>04</div><span class="dt-sep">:</span>
                    <div class="dt-block" data-m>{{ str_pad(rand(10,59),2,'0',STR_PAD_LEFT) }}</div><span class="dt-sep">:</span>
                    <div class="dt-block" data-s>{{ str_pad(rand(10,59),2,'0',STR_PAD_LEFT) }}</div>
                </div>
                <div class="deal-price">
                    <span class="new">Rs. {{ number_format($food->effective_price) }}</span>
                    <span class="old">Rs. {{ number_format($food->price) }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- DESSERTS SPECIAL SECTION --}}
@php
$dessertCat = $categories->firstWhere('slug','desserts-sweets');
$desserts = $dessertCat ? \App\Models\Food::where('category_id',$dessertCat->id)->where('is_available',true)->orderByDesc('is_featured')->limit(7)->get() : collect();
@endphp
@if($desserts->isNotEmpty())
<div class="dessert-section">
    <div class="sec-hd">
        <h2>🍰 Desserts & Sweets</h2>
        <a href="{{ route('user.menu',['category'=>'desserts-sweets']) }}">View All →</a>
    </div>
    <div class="dessert-grid">
        {{-- Sidebar list --}}
        <div class="dessert-sidebar">
            @foreach($desserts->take(4) as $i=>$d)
            <div class="dessert-side-item {{ $i===0 ? 'active' : '' }}">
                <div class="dessert-side-img">
                    <img src="{{ $d->image_url }}" alt="{{ $d->name }}" onerror="this.src='https://images.unsplash.com/photo-1551024506-0bccd828d307?w=100'">
                </div>
                <div>
                    <div class="dessert-side-name">{{ Str::limit($d->name,20) }}</div>
                    <div class="dessert-side-price">Rs. {{ number_format($d->effective_price) }}</div>
                </div>
            </div>
            @endforeach
        </div>
        {{-- Main cards --}}
        <div class="dessert-main">
            @foreach($desserts->skip(0)->take(6) as $d)
            <div class="dessert-card">
                <img src="{{ $d->image_url }}" alt="{{ $d->name }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1551024506-0bccd828d307?w=400'">
                @if($d->is_featured)
                    <span class="dessert-badge">⭐ Chef's Pick</span>
                @endif
                <div class="dessert-body">
                    <div class="dessert-name">{{ $d->name }}</div>
                    <div class="dessert-footer">
                        <div>
                            <span class="dessert-price">Rs. {{ number_format($d->effective_price) }}</span>
                            @if($d->discount_price)
                                <span style="font-size:.68rem;color:var(--gray);text-decoration:line-through;margin-left:3px;">{{ number_format($d->price) }}</span>
                            @endif
                        </div>
                        @auth
                        <button class="btn-dessert-add" onclick="addToCart({{ $d->id }},this)">+ Add</button>
                        @else
                        <a href="{{ route('login') }}" class="btn-dessert-add">Order</a>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- BEST SELLERS --}}
@php $bestSellers = $foods->getCollection()->sortByDesc('total_orders')->take(8); @endphp
<div class="bs-section">
    <div class="sec-hd">
        <h2>🏆 Best Sellers</h2>
        <a href="{{ route('user.menu',['sort'=>'popular']) }}">View All →</a>
    </div>
    <div class="fg">
        @foreach($bestSellers as $food)
        @include('user.menu._card',['food'=>$food])
        @endforeach
    </div>
</div>

{{-- NEW ARRIVALS --}}
@php $newArrivals = $foods->getCollection()->sortByDesc('created_at')->take(4); @endphp
<div class="sec-wrap">
    <div class="sec-hd">
        <h2>✨ New Arrivals</h2>
        <a href="{{ route('user.menu') }}">View All →</a>
    </div>
    <div class="fg">
        @foreach($newArrivals as $food)
        @include('user.menu._card',['food'=>$food])
        @endforeach
    </div>
</div>

@else
{{-- ===== FILTERED VIEW ===== --}}
<div class="sec-wrap">
    <div class="fg">
        @foreach($foods as $i=>$food)
        @if($i===6 && !request('search'))
        <div class="offer-c">
            <div>
                <div class="offer-lbl">🎉 Special Offer</div>
                <div class="offer-title">ENJOY 20% OFF<br>YOUR FIRST ORDER!</div>
                <div class="offer-code">Use code: <strong>WELCOME20</strong></div>
            </div>
            <a href="{{ route('register') }}" class="offer-btn">Claim →</a>
        </div>
        @endif
        @include('user.menu._card',['food'=>$food])
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($foods->hasPages())
    <div class="pages">
        @if($foods->onFirstPage())
            <span class="pg" style="opacity:.35;cursor:not-allowed;">‹</span>
        @else
            <a href="{{ $foods->previousPageUrl() }}" class="pg">‹</a>
        @endif
        @foreach($foods->getUrlRange(max(1,$foods->currentPage()-2),min($foods->lastPage(),$foods->currentPage()+2)) as $p=>$url)
            <a href="{{ $url }}" class="pg {{ $p==$foods->currentPage() ? 'active' : '' }}">{{ $p }}</a>
        @endforeach
        @if($foods->hasMorePages())
            <a href="{{ $foods->nextPageUrl() }}" class="pg">›</a>
        @else
            <span class="pg" style="opacity:.35;cursor:not-allowed;">›</span>
        @endif
    </div>
    @endif
</div>
@endif {{-- end: filtered vs default view --}}
@endif {{-- end: foods isEmpty --}}

{{-- CART FLOAT --}}
@auth
<a href="{{ route('user.cart') }}" class="cart-float">
    🛒 <span class="cnt" id="cartFloatCount">{{ session('cart_count',0) }}</span>
</a>
@endauth

{{-- TOAST --}}
<div class="toast" id="toast"></div>

@endsection

@push('scripts')
<script>
// ── TOAST ──
function showToast(msg, type='success') {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className = 'toast show ' + type;
    setTimeout(() => t.className = 'toast', 3000);
}

// ── ADD TO CART ──
function addToCart(foodId, btn) {
    const orig = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '⏳';

    fetch('{{ route("user.cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
        },
        body: JSON.stringify({ food_id: foodId, quantity: 1 })
    })
    .then(r => r.json())
    .then(d => {
        if(d.success) {
            btn.innerHTML = '✓';
            btn.style.background = '#52B44B';
            showToast(d.message || 'Added to cart! 🛒', 'success');
            const cc = document.getElementById('cartFloatCount');
            if(cc && d.cart_count !== undefined) cc.textContent = d.cart_count;
            setTimeout(() => { btn.innerHTML = orig; btn.style.background = ''; btn.disabled = false; }, 1500);
        } else {
            showToast(d.message || 'Error adding to cart', 'error');
            btn.innerHTML = orig; btn.disabled = false;
        }
    })
    .catch(() => {
        showToast('Please login to add items', 'error');
        btn.innerHTML = orig; btn.disabled = false;
        setTimeout(() => window.location = '{{ route("login") }}', 1200);
    });
}

// ── WISHLIST ──
function toggleWish(id, btn) {
    btn.textContent = btn.textContent.trim() === '🤍' ? '❤️' : '🤍';
    @auth
    fetch('/wishlist/toggle', {
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},
        body:JSON.stringify({food_id:id})
    }).then(r=>r.json()).then(d=>showToast(d.message,'success')).catch(()=>{});
    @else
    btn.textContent = '🤍';
    window.location = '{{ route("login") }}';
    @endauth
}

// ── LIVE SEARCH ──
let st;
document.getElementById('srch').addEventListener('input', function() {
    clearTimeout(st);
    st = setTimeout(() => this.closest('form').submit(), 600);
});

// ── COUNTDOWN TIMERS ──
document.querySelectorAll('.deal-timer').forEach(timer => {
    let h = parseInt(timer.querySelector('[data-h]').textContent);
    let m = parseInt(timer.querySelector('[data-m]').textContent);
    let s = parseInt(timer.querySelector('[data-s]').textContent);
    setInterval(() => {
        s--;
        if(s < 0) { s = 59; m--; }
        if(m < 0) { m = 59; h--; }
        if(h < 0) { h = 23; }
        timer.querySelector('[data-h]').textContent = String(h).padStart(2,'0');
        timer.querySelector('[data-m]').textContent = String(m).padStart(2,'0');
        timer.querySelector('[data-s]').textContent = String(s).padStart(2,'0');
    }, 1000);
});
</script>
@endpush