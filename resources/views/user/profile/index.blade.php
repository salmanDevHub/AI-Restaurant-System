@extends('layouts.app')
@section('title','My Profile - FoodieHub')
@push('styles')
<style>
.profile-page{max-width:960px;margin:0 auto;padding:40px 20px;}
.profile-grid{display:grid;grid-template-columns:300px 1fr;gap:24px;align-items:start;}
.profile-card{background:white;border-radius:20px;box-shadow:0 2px 12px rgba(0,0,0,0.06);border:1px solid var(--border);overflow:hidden;}
.profile-card-header{background:linear-gradient(135deg,var(--primary),#FF8C42);padding:28px;text-align:center;color:white;}
.profile-avatar-wrap{position:relative;display:inline-block;margin-bottom:14px;}
.profile-avatar{width:90px;height:90px;border-radius:50%;object-fit:cover;border:4px solid rgba(255,255,255,0.5);}
.change-avatar{position:absolute;bottom:0;right:0;background:white;border-radius:50%;width:28px;height:28px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:0.85rem;box-shadow:0 2px 8px rgba(0,0,0,0.2);}
.profile-name{font-family:'Playfair Display',serif;font-size:1.3rem;font-weight:900;}
.profile-email{opacity:0.85;font-size:0.85rem;margin-top:4px;}
.tier-badge-big{margin-top:12px;background:rgba(255,255,255,0.2);padding:6px 16px;border-radius:50px;font-size:0.85rem;font-weight:700;display:inline-block;}
.profile-stats{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--border);}
.pstat{background:white;padding:16px;text-align:center;}
.pstat-val{font-size:1.3rem;font-weight:900;color:var(--primary);}
.pstat-lbl{font-size:0.75rem;color:var(--gray);margin-top:2px;}
.profile-nav{padding:12px;}
.pnav-item{display:flex;align-items:center;gap:10px;padding:11px 14px;border-radius:10px;cursor:pointer;font-size:0.9rem;font-weight:500;color:var(--dark);text-decoration:none;transition:all 0.15s;}
.pnav-item:hover,.pnav-item.active{background:#FFF0EB;color:var(--primary);}
.section-card{background:white;border-radius:20px;box-shadow:0 2px 12px rgba(0,0,0,0.06);border:1px solid var(--border);padding:24px;margin-bottom:20px;}
.section-title{font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:800;color:var(--dark);margin-bottom:20px;padding-bottom:12px;border-bottom:1px solid var(--border);}
.form-grid2{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.form-grid2 .full{grid-column:1/-1;}
.form-label{display:block;font-size:0.82rem;font-weight:600;color:var(--dark);margin-bottom:7px;}
.form-control{width:100%;padding:11px 14px;border:1.5px solid var(--border);border-radius:11px;font-size:0.9rem;font-family:'DM Sans',sans-serif;outline:none;color:var(--dark);background:var(--light);transition:all 0.2s;}
.form-control:focus{border-color:var(--primary);background:white;}
.btn-save{background:var(--primary);color:white;border:none;border-radius:11px;padding:12px 28px;font-size:0.95rem;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all 0.2s;}
.btn-save:hover{background:var(--primary-dark);}
.loyalty-progress{background:var(--light);border-radius:12px;padding:16px;margin-bottom:20px;}
@media(max-width:768px){.profile-grid{grid-template-columns:1fr;}.form-grid2{grid-template-columns:1fr;}}
</style>
@endpush

@section('content')
<div class="profile-page">
    <div style="margin-bottom:24px;">
        <h1 style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:900;color:var(--dark);">My Profile</h1>
        <p style="color:var(--gray);">Manage your account and preferences</p>
    </div>

    <div class="profile-grid">
        {{-- Left Sidebar --}}
        <div>
            <div class="profile-card" style="margin-bottom:16px;">
                <div class="profile-card-header">
                    <div class="profile-avatar-wrap">
                        <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="profile-avatar" id="avatarImg">
                        <label for="avatarFileInput" class="change-avatar" title="Change photo">📷</label>
                    </div>
                    <div class="profile-name">{{ Auth::user()->name }}</div>
                    <div class="profile-email">{{ Auth::user()->email }}</div>
                    @php $icons=['bronze'=>'🥉','silver'=>'🥈','gold'=>'🥇','platinum'=>'💎']; @endphp
                    <div class="tier-badge-big">{{ $icons[Auth::user()->loyalty_tier] ?? '🥉' }} {{ ucfirst(Auth::user()->loyalty_tier) }} Member</div>
                </div>
                <div class="profile-stats">
                    <div class="pstat"><div class="pstat-val">{{ $stats['total_orders'] }}</div><div class="pstat-lbl">Orders</div></div>
                    <div class="pstat"><div class="pstat-val">{{ Auth::user()->loyalty_points }}</div><div class="pstat-lbl">Points</div></div>
                    <div class="pstat"><div class="pstat-val" style="font-size:1rem;">Rs.{{ number_format($stats['total_spent']) }}</div><div class="pstat-lbl">Total Spent</div></div>
                    <div class="pstat"><div class="pstat-val">{{ ucfirst(Auth::user()->loyalty_tier) }}</div><div class="pstat-lbl">Tier</div></div>
                </div>
                <div class="profile-nav">
                    <a href="{{ route('user.orders') }}" class="pnav-item">📋 My Orders</a>
                    <a href="{{ route('user.notifications') }}" class="pnav-item">🔔 Notifications</a>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="pnav-item" style="width:100%;background:none;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;color:#EF4444;">🚪 Logout</button></form>
                </div>
            </div>
        </div>

        {{-- Right Content --}}
        <div>
            {{-- Loyalty Progress --}}
            <div class="section-card">
                <div class="section-title">⭐ Loyalty Status</div>
                @php
                $tiers = ['bronze'=>['min'=>0,'next_name'=>'Silver','next_req'=>5],'silver'=>['min'=>5,'next_name'=>'Gold','next_req'=>20],'gold'=>['min'=>20,'next_name'=>'Platinum','next_req'=>50],'platinum'=>['min'=>50,'next_name'=>null,'next_req'=>null]];
                $ct = $tiers[Auth::user()->loyalty_tier];
                $orders = Auth::user()->total_orders;
                @endphp
                <div class="loyalty-progress">
                    <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:0.875rem;">
                        <span style="font-weight:700;">{{ ucfirst(Auth::user()->loyalty_tier) }} — {{ Auth::user()->discount_percentage }}% discount</span>
                        @if($ct['next_name'])<span style="color:var(--gray);">{{ $orders }}/{{ $ct['next_req'] }} orders to {{ $ct['next_name'] }}</span>@endif
                    </div>
                    @if($ct['next_req'])
                    <div style="height:10px;background:var(--border);border-radius:5px;overflow:hidden;">
                        <div style="height:100%;background:linear-gradient(to right,var(--primary),var(--secondary));border-radius:5px;width:{{ min(100,($orders/$ct['next_req'])*100) }}%;transition:width 1s ease;"></div>
                    </div>
                    <div style="font-size:0.78rem;color:var(--gray);margin-top:6px;">{{ max(0,$ct['next_req']-$orders) }} more orders to reach {{ $ct['next_name'] ?? 'max tier' }}</div>
                    @else
                    <div style="text-align:center;color:var(--primary);font-weight:700;padding:8px;">💎 You've reached the highest tier!</div>
                    @endif
                </div>
            </div>

            {{-- Edit Profile --}}
            <div class="section-card">
                <div class="section-title">✏️ Edit Profile</div>
                @if(session('success'))
                <div style="background:#F0FDF4;border:1px solid #BBF7D0;color:#166534;padding:11px 14px;border-radius:10px;font-size:0.875rem;margin-bottom:16px;">✅ {{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <input type="file" id="avatarFileInput" name="avatar" style="display:none;" accept="image/*" onchange="previewAvatar(this)">
                    <div class="form-grid2">
                        <div class="form-group">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name',Auth::user()->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone Number *</label>
                            <input type="tel" name="phone" class="form-control" value="{{ old('phone',Auth::user()->phone) }}" required>
                        </div>
                        <div class="form-group full">
                            <label class="form-label">Email Address *</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email',Auth::user()->email) }}" required>
                        </div>
                        <div class="form-group full">
                            <label class="form-label">Street Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address',Auth::user()->address) }}" placeholder="House #, Street, Area">
                        </div>
                        <div class="form-group">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city',Auth::user()->city) }}" placeholder="Lahore">
                        </div>
                    </div>
                    <button type="submit" class="btn-save">💾 Save Changes</button>
                </form>
            </div>

            {{-- Change Password --}}
            <div class="section-card">
                <div class="section-title">🔒 Change Password</div>
                <form method="POST" action="{{ route('user.profile.password') }}">
                    @csrf @method('PUT')
                    <div class="form-grid2">
                        <div class="form-group full">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
                            @error('current_password')<p style="color:var(--danger);font-size:0.8rem;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Min 8 characters" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-save" style="background:var(--dark);">🔒 Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function previewAvatar(input) {
    if(input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('avatarImg').src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
