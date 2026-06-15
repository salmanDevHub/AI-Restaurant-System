<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — Shajahan Tandoori Grills</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    *,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:'DM Sans',sans-serif;min-height:100vh;display:flex;overflow:hidden;background:#fff;}

    .left{width:46%;position:relative;overflow:hidden;flex-shrink:0;}
    .left-bg{position:absolute;inset:0;background:url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=900') center/cover no-repeat;z-index:0;}
    .left-overlay{position:absolute;inset:0;background:linear-gradient(160deg,rgba(245,166,35,0.82) 0%,rgba(220,100,10,0.88) 100%);z-index:1;}
    .left-dark{position:absolute;bottom:0;left:0;right:0;height:100px;background:linear-gradient(to top,#1C1C1C 60%,transparent);z-index:2;}

    .logo{position:absolute;top:28px;left:28px;z-index:10;display:flex;align-items:center;gap:10px;}
    .logo-ico{width:42px;height:42px;background:#1C1C1C;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;box-shadow:0 4px 16px rgba(0,0,0,.3);}
    .logo-txt{font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:#fff;line-height:1.2;text-shadow:0 1px 6px rgba(0,0,0,.3);}
    .logo-txt small{display:block;font-family:'DM Sans',sans-serif;font-size:.65rem;font-weight:500;color:rgba(255,255,255,.75);letter-spacing:.05em;}

    .bolt{position:absolute;font-weight:900;z-index:10;user-select:none;color:#fff;opacity:.6;}
    .b1{top:26px;right:26px;font-size:1.4rem;}
    .b2{bottom:110px;right:26px;font-size:1.2rem;opacity:.9;}
    .b3{bottom:66px;left:26px;font-size:1rem;opacity:.8;}

    .food-mosaic{position:absolute;inset:0;z-index:3;display:flex;flex-direction:column;padding:100px 28px 130px;gap:16px;}
    .fm-row{display:flex;gap:14px;flex:1;}
    .fm-card{border-radius:20px;overflow:hidden;box-shadow:0 16px 48px rgba(0,0,0,.35);position:relative;flex:1;}
    .fm-card img{width:100%;height:100%;object-fit:cover;display:block;}
    .fm-label{position:absolute;bottom:0;left:0;right:0;background:linear-gradient(to top,rgba(0,0,0,.72) 0%,transparent);padding:20px 14px 12px;color:#fff;font-size:.78rem;font-weight:700;}
    .fm-price{color:#F5A623;font-size:.85rem;font-weight:900;}
    .doodle{position:absolute;right:20px;top:50%;transform:translateY(-50%);z-index:4;opacity:.1;width:180px;height:180px;}
    .doodle svg{width:100%;height:100%;}
    .left-tagline{position:absolute;bottom:24px;left:28px;right:28px;z-index:10;color:rgba(255,255,255,.7);font-size:.72rem;text-align:center;letter-spacing:.04em;}
    .left-tagline strong{color:#F5A623;}

    .right{flex:1;background:#fff;display:flex;flex-direction:column;justify-content:center;padding:60px 64px;position:relative;overflow-y:auto;}
    .rb1{position:absolute;top:28px;right:32px;font-size:1.2rem;color:#1C1C1C;font-weight:900;opacity:.08;}
    .rb2{position:absolute;bottom:28px;left:28px;font-size:1rem;color:#F5A623;font-weight:900;opacity:.35;}

    .right h1{font-family:'Playfair Display',serif;font-size:2.6rem;font-weight:900;color:#1C1C1C;margin-bottom:8px;letter-spacing:-.02em;line-height:1.1;}
    .right-sub{color:#8A8277;font-size:.93rem;margin-bottom:36px;line-height:1.65;}

    .field{margin-bottom:14px;position:relative;}
    .field input{width:100%;padding:15px 18px 15px 48px;background:#F2F4F7;border:1.5px solid #F2F4F7;border-radius:50px;font-size:.93rem;font-family:'DM Sans',sans-serif;color:#1C1C1C;outline:none;transition:all .22s;}
    .field input::placeholder{color:#B8BEC8;}
    .field input:focus{border-color:#F5A623;background:#fff;box-shadow:0 0 0 4px rgba(245,166,35,.12);}
    .ico{position:absolute;left:17px;top:50%;transform:translateY(-50%);color:#B8BEC8;font-size:.9rem;pointer-events:none;}
    .eye{position:absolute;right:16px;top:50%;transform:translateY(-50%);color:#B8BEC8;cursor:pointer;background:none;border:none;font-size:.95rem;}
    .eye:hover{color:#F5A623;}
    .err-msg{color:#EF4444;font-size:.75rem;margin-top:4px;padding-left:16px;}

    .forgot-row{display:flex;justify-content:flex-end;margin:-4px 0 20px;}
    .forgot-row a{color:#F5A623;font-size:.84rem;font-weight:600;text-decoration:none;}
    .forgot-row a:hover{text-decoration:underline;}

    .btn-login{width:50%;background:#52B44B;color:#fff;border:none;border-radius:50px;padding:15px;font-size:1rem;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .22s;display:block;margin:0 auto 6px;letter-spacing:.01em;box-shadow:0 6px 20px rgba(82,180,75,.3);}
    .btn-login:hover{background:#3D9438;transform:translateY(-2px);box-shadow:0 10px 28px rgba(82,180,75,.42);}
    .btn-login:disabled{opacity:.65;cursor:not-allowed;transform:none;box-shadow:none;}

    .divider{display:flex;align-items:center;gap:14px;margin:20px 0;color:#C0B8AD;font-size:.8rem;}
    .divider::before,.divider::after{content:'';flex:1;height:1px;background:#EDEAE4;}

    .alts{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
    .btn-alt{display:flex;align-items:center;justify-content:center;gap:9px;padding:13px 16px;border:1.5px solid #E8E4DC;border-radius:50px;background:#fff;font-size:.87rem;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;color:#1C1C1C;text-decoration:none;transition:all .2s;}
    .btn-alt:hover{background:#F9F7F3;border-color:#C0B8AD;transform:translateY(-1px);}
    .btn-alt.admin{background:#1C1C1C;color:#fff;border-color:#1C1C1C;}
    .btn-alt.admin:hover{background:#2E2E2E;}

    .switch{text-align:center;margin-top:22px;font-size:.875rem;color:#8A8277;}
    .switch a{color:#F5A623;font-weight:700;text-decoration:none;}

    .alert{display:flex;align-items:center;gap:10px;padding:12px 18px;border-radius:14px;font-size:.875rem;margin-bottom:18px;}
    .alert-error{background:#FFF5F5;color:#EF4444;border:1px solid #FECACA;}
    .alert-success{background:#F0FDF4;color:#16A34A;border:1px solid #BBF7D0;}

    /* Demo fill indicator */
    .demo-hint{background:#FFF8EE;border:1px solid #F5D490;border-radius:10px;padding:8px 14px;font-size:.78rem;color:#7A5200;margin-bottom:14px;display:none;}
    .demo-hint.show{display:flex;align-items:center;gap:8px;}

    @media(max-width:860px){.left{display:none;}.right{padding:40px 28px;}.btn-login{width:100%;}.alts{grid-template-columns:1fr;}}
    </style>
</head>
<body>

<!-- LEFT -->
<div class="left">
    <div class="left-bg"></div>
    <div class="left-overlay"></div>
    <div class="left-dark"></div>
    <div class="logo">
        <div class="logo-ico">🔥</div>
        <div class="logo-txt">Shajahan Tandoori<small>Restaurant · Multan</small></div>
    </div>
    <span class="bolt b1">⚡</span>
    <span class="bolt b2">⚡</span>
    <span class="bolt b3">⚡</span>
    <div class="food-mosaic">
        <div class="fm-row" style="flex:1.2;">
            <div class="fm-card" style="border-radius:24px;">
                <img src="https://images.unsplash.com/photo-1631515243349-e0cb75fb8d3a?w=800" alt="Biryani" onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800'">
                <div class="fm-label">Chicken Biryani<div class="fm-price">Rs. 450</div></div>
            </div>
        </div>
        <div class="fm-row" style="flex:1;">
            <div class="fm-card" style="border-radius:20px 8px 8px 20px;">
                <img src="https://flavornest.net/wp-content/uploads/2025/05/image_2025-05-24_202008832.webp" alt="Kabab" onerror="this.src='https://flavornest.net/wp-content/uploads/2025/05/image_2025-05-24_202008832.webp'">
                <div class="fm-label">Seekh Kabab<div class="fm-price">Rs. 380</div></div>
            </div>
            <div class="fm-card" style="border-radius:8px 20px 20px 8px;">
                <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=500" alt="Pizza" onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500'">
                <div class="fm-label">Margherita Pizza<div class="fm-price">Rs. 580</div></div>
            </div>
        </div>
    </div>
    <div class="doodle"><svg viewBox="0 0 200 200" fill="none"><circle cx="100" cy="100" r="82" stroke="#fff" stroke-width="2" stroke-dasharray="8 5"/><circle cx="100" cy="100" r="55" stroke="#fff" stroke-width="1.5" stroke-dasharray="5 4"/></svg></div>
    <div class="left-tagline"><strong>54+ dishes</strong> · Authentic Tandoor · Free delivery above Rs.1000</div>
</div>

<!-- RIGHT -->
<div class="right">
    <span class="rb1">⚡</span>
    <span class="rb2">⚡</span>

    <h1>Welcome Back!</h1>
    <p class="right-sub">Login to your Shajahan Tandoori account<br>and enjoy authentic Multan cuisine 🔥</p>

    @if($errors->any())
    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
    @endif
    @if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <!-- Demo hint -->
    <div class="demo-hint" id="demoHint">
        <i class="fas fa-info-circle" style="color:#C47D00;"></i>
        <span id="demoHintTxt">Credentials filled — click Login to continue</span>
    </div>

    <form method="POST" action="{{ route('login.post') }}" id="loginForm" novalidate>
        @csrf
        <div class="field">
            <i class="fas fa-user ico"></i>
            <input type="text" name="login" id="loginInput"
                placeholder="E-mail or Phone (03XXXXXXXXX)"
                value="{{ old('login') }}" autocomplete="username" required>
            @error('login')<p class="err-msg">{{ $message }}</p>@enderror
        </div>
        <div class="field">
            <i class="fas fa-lock ico"></i>
            <input type="password" name="password" id="passInp"
                placeholder="Password" autocomplete="current-password" required>
            <button type="button" class="eye" onclick="togglePass()">
                <i class="fas fa-eye" id="eyeIco"></i>
            </button>
            @error('password')<p class="err-msg">{{ $message }}</p>@enderror
        </div>
        <div class="forgot-row"><a href="#">Forgot password?</a></div>
        <button type="submit" class="btn-login" id="loginBtn">Login</button>
    </form>

    <div class="divider"><span>Or continue as</span></div>

    <div class="alts">
        <button type="button" class="btn-alt" onclick="fillAndLogin('user@shahjan.com','user123','👤 Demo User')">
            <i class="fas fa-user"></i> Demo User
        </button>
        <button type="button" class="btn-alt admin" onclick="fillAndLogin('admin@shahjan.com','admin123','🔧 Admin Login')">
            <i class="fas fa-screwdriver-wrench"></i> Admin Login
        </button>
    </div>

    <p class="switch">Don't have an account? <a href="{{ route('register') }}">Create one free →</a></p>
</div>

<script>
function togglePass() {
    const i = document.getElementById('passInp');
    const e = document.getElementById('eyeIco');
    i.type = i.type === 'password' ? 'text' : 'password';
    e.className = i.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
}

// Fill credentials AND auto-submit
function fillAndLogin(email, pass, label) {
    document.getElementById('loginInput').value = email;
    document.getElementById('passInp').value = pass;

    // Show hint
    const hint = document.getElementById('demoHint');
    document.getElementById('demoHintTxt').textContent = label + ' credentials filled — logging in...';
    hint.classList.add('show');

    // Auto submit after short delay
    setTimeout(() => {
        const btn = document.getElementById('loginBtn');
        btn.disabled = true;
        btn.textContent = 'Logging in...';
        document.getElementById('loginForm').submit();
    }, 600);
}

document.getElementById('loginForm').addEventListener('submit', function() {
    const b = document.getElementById('loginBtn');
    b.disabled = true;
    b.textContent = 'Logging in...';
});
</script>
</body>
</html>