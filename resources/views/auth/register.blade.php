<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register — Shajahan Tandoori Grills</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'DM Sans',sans-serif; min-height:100vh; display:flex; background:#fff; overflow-x:hidden; }

    /* LEFT */
    .left { width:44%; position:relative; overflow:hidden; background:#fff; flex-shrink:0; }
    .blob-top { position:absolute; top:-120px; right:-120px; width:520px; height:520px; background:#F5A623; border-radius:50%; z-index:0; }
    .blob-bottom { position:absolute; bottom:-130px; left:-80px; width:340px; height:340px; background:#F5A623; border-radius:50%; z-index:0; opacity:0.85; }
    .left-dark-strip { position:absolute; bottom:0; left:0; right:0; height:120px; background:#1C1C1C; z-index:1; }
    .left-logo { position:absolute; top:22px; left:22px; z-index:20; display:flex; align-items:center; gap:8px; }
    .left-logo-ico { width:36px; height:36px; background:#1C1C1C; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:1rem; }
    .left-logo-txt { font-family:'Playfair Display',serif; font-size:0.95rem; font-weight:700; color:#1C1C1C; line-height:1.2; }
    .left-logo-txt small { display:block; font-family:'DM Sans',sans-serif; font-size:0.62rem; font-weight:500; color:#555; letter-spacing:0.04em; }
    .bolt { position:absolute; font-size:1.5rem; font-weight:900; z-index:20; line-height:1; user-select:none; }
    .bolt-tl { top:22px; left:120px; color:#1C1C1C; font-size:1.2rem; }
    .bolt-tr { top:18px; right:18px; color:#1C1C1C; font-size:1.4rem; }
    .bolt-br { bottom:135px; right:22px; color:#F5A623; font-size:1.3rem; }
    .bolt-bl { bottom:90px; left:22px; color:#1C1C1C; font-size:1.1rem; }
    .food-col { position:absolute; top:0; left:0; bottom:0; width:62%; z-index:10; display:flex; flex-direction:column; padding:70px 0 0 28px; gap:14px; }
    .food-col .fi { border-radius:20px; overflow:hidden; box-shadow:0 12px 40px rgba(0,0,0,0.18); flex-shrink:0; }
    .food-col .fi:nth-child(1) { height:175px; width:90%; border-radius:22px 22px 22px 6px; }
    .food-col .fi:nth-child(2) { height:150px; width:80%; border-radius:6px 22px 22px 22px; align-self:flex-end; margin-right:18px; }
    .food-col .fi:nth-child(3) { height:135px; width:84%; border-radius:22px 6px 22px 22px; }
    .food-col .fi img { width:100%; height:100%; object-fit:cover; display:block; }
    .doodle { position:absolute; right:-10px; top:50%; transform:translateY(-50%); z-index:5; opacity:0.18; width:200px; height:200px; }
    .doodle svg { width:100%; height:100%; }

    /* RIGHT */
    .right { flex:1; background:#fff; display:flex; flex-direction:column; justify-content:center; padding:40px 52px; position:relative; overflow-y:auto; }
    .right-bolt-tr { position:absolute; top:28px; right:32px; font-size:1.3rem; color:#1C1C1C; font-weight:900; opacity:0.15; user-select:none; }
    .right-bolt-bl { position:absolute; bottom:28px; left:28px; font-size:1.1rem; color:#F5A623; font-weight:900; opacity:0.4; user-select:none; }
    .right h1 { font-family:'Playfair Display',serif; font-size:2.1rem; font-weight:900; color:#1C1C1C; margin-bottom:6px; letter-spacing:-0.01em; line-height:1.1; }
    .right-sub { color:#8A8277; font-size:0.9rem; margin-bottom:20px; line-height:1.6; }

    /* Bonus tag */
    .bonus-tag { display:flex; align-items:center; gap:10px; background:#FFF8EE; border:1.5px solid #F5D490; border-radius:12px; padding:11px 16px; margin-bottom:20px; font-size:0.85rem; color:#7A5200; }
    .bonus-tag strong { color:#C47D00; }

    /* Form */
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px; }
    .form-grid .full { grid-column:1/-1; }
    .field { position:relative; }
    .field label { display:block; font-size:0.78rem; font-weight:700; color:#4A4440; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.05em; }
    .field input, .field select {
        width:100%; padding:13px 14px 13px 42px;
        background:#F5F4F1; border:1.5px solid #F5F4F1;
        border-radius:50px; font-size:0.88rem;
        font-family:'DM Sans',sans-serif; color:#1C1C1C;
        outline:none; transition:all 0.2s; appearance:none;
    }
    .field input::placeholder { color:#B0A898; }
    .field input:focus, .field select:focus { border-color:#F5A623; background:#fff; box-shadow:0 0 0 3px rgba(245,166,35,0.12); }
    .field input.err-inp { border-color:#EF4444; background:#FFF5F5; }
    .field input.ok-inp { border-color:#52B44B; }
    .fi-icon { position:absolute; left:15px; bottom:13px; color:#C0B8AD; font-size:0.85rem; pointer-events:none; }
    .eye-btn { position:absolute; right:14px; bottom:12px; color:#C0B8AD; cursor:pointer; background:none; border:none; font-size:0.9rem; }
    .eye-btn:hover { color:#F5A623; }
    .err-msg { color:#EF4444; font-size:0.75rem; margin-top:4px; padding-left:14px; }
    .strength-bar { height:3px; border-radius:2px; background:#E8E4DC; margin-top:6px; overflow:hidden; }
    .strength-fill { height:100%; border-radius:2px; transition:all 0.3s; width:0%; }
    .strength-text { font-size:0.72rem; margin-top:3px; padding-left:14px; }

    /* Terms */
    .terms-row { display:flex; align-items:flex-start; gap:10px; margin:4px 0 16px; }
    .terms-row input[type=checkbox] { accent-color:#F5A623; width:17px; height:17px; margin-top:2px; flex-shrink:0; cursor:pointer; }
    .terms-row label { font-size:0.82rem; color:#8A8277; line-height:1.55; cursor:pointer; }
    .terms-row label a { color:#F5A623; font-weight:600; text-decoration:none; }

    /* Button */
    .btn-reg { width:100%; background:#52B44B; color:#fff; border:none; border-radius:50px; padding:15px; font-size:1rem; font-weight:700; cursor:pointer; font-family:'DM Sans',sans-serif; transition:all 0.22s; display:flex; align-items:center; justify-content:center; gap:9px; }
    .btn-reg:hover { background:#3D9438; transform:translateY(-2px); box-shadow:0 8px 28px rgba(82,180,75,0.38); }
    .btn-reg:disabled { opacity:0.65; cursor:not-allowed; transform:none; box-shadow:none; }

    .alert { display:flex; align-items:flex-start; gap:10px; padding:11px 16px; border-radius:12px; font-size:0.85rem; margin-bottom:18px; }
    .alert-error { background:#FFF5F5; color:#EF4444; border:1px solid #FECACA; }

    .switch-txt { text-align:center; margin-top:18px; font-size:0.875rem; color:#8A8277; }
    .switch-txt a { color:#F5A623; font-weight:700; text-decoration:none; }

    @media(max-width:820px) { .left{display:none;} .right{padding:32px 24px;} .form-grid{grid-template-columns:1fr;} }
    </style>
</head>
<body>

<div class="left">
    <div class="blob-top"></div>
    <div class="blob-bottom"></div>
    <div class="left-dark-strip"></div>
    <div class="left-logo">
        <div class="left-logo-ico">🔥</div>
        <div class="left-logo-txt">Shajahan Tandoori<small>Restaurant · Multan</small></div>
    </div>
    <span class="bolt bolt-tl">⚡</span>
    <span class="bolt bolt-tr">⚡</span>
    <span class="bolt bolt-br">⚡</span>
    <span class="bolt bolt-bl">⚡</span>
    <div class="food-col">
        <div class="fi"><img src="https://images.unsplash.com/photo-1631515243349-e0cb75fb8d3a?w=500" alt="Biryani" onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500'"></div>
        <div class="fi"><img src="https://images.unsplash.com/photo-1574894709920-11b28e7367e3?w=500" alt="Naan" onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500'"></div>
        <div class="fi"><img src="https://images.unsplash.com/photo-1544025162-d76694265947?w=500" alt="BBQ" onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500'"></div>
    </div>
    <div class="doodle"><svg viewBox="0 0 200 200" fill="none"><circle cx="100" cy="100" r="80" stroke="#F5A623" stroke-width="2.5" stroke-dasharray="8 5"/><circle cx="100" cy="100" r="55" stroke="#F5A623" stroke-width="1.5" stroke-dasharray="5 4"/><path d="M100 20 Q130 60 100 100 Q70 140 100 180" stroke="#F5A623" stroke-width="2" fill="none"/><path d="M20 100 Q60 70 100 100 Q140 130 180 100" stroke="#F5A623" stroke-width="2" fill="none"/></svg></div>
</div>

<div class="right">
    <span class="right-bolt-tr">⚡</span>
    <span class="right-bolt-bl">⚡</span>

    <h1>Create Account 🎉</h1>
    <p class="right-sub">Join Shajahan Tandoori and start ordering in minutes</p>

    <div class="bonus-tag">🎁 <div><strong>Welcome Bonus:</strong> Use <strong>WELCOME20</strong> for 20% OFF your first order!</div></div>

    @if($errors->any())
    <div class="alert alert-error"><i class="fas fa-exclamation-circle" style="margin-top:2px;flex-shrink:0;"></i><div>{{ $errors->first() }}</div></div>
    @endif

    <form method="POST" action="{{ route('register.post') }}" id="regForm" novalidate>
        @csrf
        <div class="form-grid">

            <div class="field full">
                <label>Full Name *</label>
                <i class="fas fa-user fi-icon"></i>
                <input type="text" name="name" placeholder="Enter your full name" value="{{ old('name') }}" required class="{{ $errors->has('name') ? 'err-inp' : '' }}">
                @error('name')<p class="err-msg">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label>Email Address *</label>
                <i class="fas fa-envelope fi-icon"></i>
                <input type="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required class="{{ $errors->has('email') ? 'err-inp' : '' }}">
                @error('email')<p class="err-msg">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label>Phone (Pakistan) *</label>
                <i class="fas fa-phone fi-icon"></i>
                <input type="tel" name="phone" id="phoneInp" placeholder="03001234567" value="{{ old('phone') }}" maxlength="13" required class="{{ $errors->has('phone') ? 'err-inp' : '' }}">
                @error('phone')<p class="err-msg">{{ $message }}</p>@enderror
                <p class="err-msg" id="phoneErr" style="display:none;">Enter valid Pakistani number (03XXXXXXXXX)</p>
            </div>

            <div class="field">
                <label>Password *</label>
                <i class="fas fa-lock fi-icon"></i>
                <input type="password" name="password" id="passInp" placeholder="Min. 8 characters" required oninput="checkStr(this.value)" class="{{ $errors->has('password') ? 'err-inp' : '' }}">
                <button type="button" class="eye-btn" onclick="tp('passInp','e1')"><i class="fas fa-eye" id="e1"></i></button>
                <div class="strength-bar"><div class="strength-fill" id="strFill"></div></div>
                <p class="strength-text" id="strTxt" style="color:#8A8277;"></p>
                @error('password')<p class="err-msg">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label>Confirm Password *</label>
                <i class="fas fa-lock fi-icon"></i>
                <input type="password" name="password_confirmation" id="confInp" placeholder="Repeat password" required>
                <button type="button" class="eye-btn" onclick="tp('confInp','e2')"><i class="fas fa-eye" id="e2"></i></button>
                <p class="err-msg" id="matchErr" style="display:none;">Passwords do not match</p>
            </div>

        </div>

        <div class="terms-row">
            <input type="checkbox" name="terms" id="termsChk" {{ old('terms') ? 'checked' : '' }} required>
            <label for="termsChk">I agree to Shajahan Tandoori's <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>. I confirm I am 13+ years old.</label>
        </div>
        @error('terms')<p class="err-msg" style="margin-bottom:10px;">{{ $message }}</p>@enderror

        <button type="submit" class="btn-reg" id="regBtn">
            <i class="fas fa-user-plus"></i> Create Free Account
        </button>
    </form>

    <p class="switch-txt">Already have an account? <a href="{{ route('login') }}">Login here →</a></p>
</div>

<script>
function tp(id, ico) {
    const i = document.getElementById(id), e = document.getElementById(ico);
    i.type = i.type === 'password' ? 'text' : 'password';
    e.className = i.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
}
function checkStr(v) {
    const f = document.getElementById('strFill'), t = document.getElementById('strTxt');
    let s=0;
    if(v.length>=8)s++; if(/[A-Z]/.test(v))s++; if(/[0-9]/.test(v))s++; if(/[^A-Za-z0-9]/.test(v))s++;
    const map = [[25,'#EF4444','Weak'],[50,'#F59E0B','Fair'],[75,'#3B82F6','Good'],[100,'#52B44B','Strong ✓']];
    const [w,c,m] = map[Math.max(0,s-1)];
    f.style.width = v.length>0 ? w+'%' : '0%';
    f.style.background = c;
    t.textContent = v.length>0 ? 'Strength: '+m : '';
    t.style.color = c;
}
document.getElementById('phoneInp').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g,'');
    const ok = /^(03\d{9}|923\d{9})$/.test(this.value);
    document.getElementById('phoneErr').style.display = this.value.length>4 && !ok ? 'block' : 'none';
    this.className = this.value.length>4 && !ok ? 'err-inp' : this.value.length>=11 ? 'ok-inp' : '';
});
document.getElementById('confInp').addEventListener('input', function() {
    const ok = this.value === document.getElementById('passInp').value;
    document.getElementById('matchErr').style.display = this.value && !ok ? 'block' : 'none';
    this.className = this.value && !ok ? 'err-inp' : ok && this.value ? 'ok-inp' : '';
});
document.getElementById('regForm').addEventListener('submit', function(e) {
    if(document.getElementById('passInp').value !== document.getElementById('confInp').value) {
        e.preventDefault(); document.getElementById('matchErr').style.display='block'; return;
    }
    const b = document.getElementById('regBtn');
    b.disabled=true; b.innerHTML='<i class="fas fa-spinner fa-spin"></i> Creating account...';
});
</script>
</body>
</html>