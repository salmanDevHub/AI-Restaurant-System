<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Phone — Shajahan Tandoori Grills</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
    body {
        font-family: 'DM Sans', sans-serif;
        min-height: 100vh;
        display: flex;
        background: #fff;
        overflow: hidden;
    }

    /* LEFT — same as login */
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
    .food-col .fi:nth-child(1) { height:190px; width:90%; border-radius:22px 22px 22px 6px; }
    .food-col .fi:nth-child(2) { height:160px; width:80%; border-radius:6px 22px 22px 22px; align-self:flex-end; margin-right:18px; }
    .food-col .fi:nth-child(3) { height:145px; width:84%; border-radius:22px 6px 22px 22px; }
    .food-col .fi img { width:100%; height:100%; object-fit:cover; display:block; }
    .doodle { position:absolute; right:-10px; top:50%; transform:translateY(-50%); z-index:5; opacity:0.18; width:200px; height:200px; }
    .doodle svg { width:100%; height:100%; }

    /* RIGHT */
    .right { flex:1; background:#fff; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:56px 52px; position:relative; overflow-y:auto; }
    .right-bolt-tr { position:absolute; top:28px; right:32px; font-size:1.3rem; color:#1C1C1C; font-weight:900; opacity:0.15; user-select:none; }
    .right-bolt-bl { position:absolute; bottom:28px; left:28px; font-size:1.1rem; color:#F5A623; font-weight:900; opacity:0.4; user-select:none; }

    /* OTP card */
    .otp-card { width:100%; max-width:380px; text-align:center; }
    .otp-icon { font-size:3.2rem; margin-bottom:18px; display:block; }
    .otp-card h1 { font-family:'Playfair Display',serif; font-size:2rem; font-weight:900; color:#1C1C1C; margin-bottom:10px; }
    .otp-desc { color:#8A8277; font-size:0.92rem; line-height:1.65; margin-bottom:28px; }
    .otp-desc strong { color:#1C1C1C; font-size:1rem; display:block; margin-top:4px; }

    /* OTP boxes */
    .otp-row { display:flex; gap:10px; justify-content:center; margin-bottom:26px; }
    .otp-box {
        width:54px; height:62px;
        background:#F5F4F1;
        border:2px solid #E8E4DC;
        border-radius:16px;
        font-size:1.7rem; font-weight:800;
        text-align:center; color:#1C1C1C;
        font-family:'DM Sans',sans-serif;
        outline:none; transition:all 0.18s;
    }
    .otp-box:focus { border-color:#F5A623; background:#fff; box-shadow:0 0 0 4px rgba(245,166,35,0.14); }
    .otp-box.filled { border-color:#F5A623; background:#FFFAEF; }

    /* Verify button */
    .btn-verify {
        width:100%; background:#52B44B; color:#fff;
        border:none; border-radius:50px; padding:15px;
        font-size:1rem; font-weight:700; cursor:pointer;
        font-family:'DM Sans',sans-serif; transition:all 0.22s;
        display:flex; align-items:center; justify-content:center; gap:9px;
        margin-bottom:22px;
    }
    .btn-verify:hover { background:#3D9438; transform:translateY(-2px); box-shadow:0 8px 28px rgba(82,180,75,0.38); }
    .btn-verify:disabled { background:#C5E0C3; cursor:not-allowed; transform:none; box-shadow:none; }
    .btn-verify.ready { background:#52B44B; animation:pulse 0.4s ease; }
    @keyframes pulse { 0%{transform:scale(1)} 50%{transform:scale(1.02)} 100%{transform:scale(1)} }

    /* Resend */
    .resend-wrap { color:#8A8277; font-size:0.875rem; margin-bottom:16px; }
    .resend-btn { color:#F5A623; font-weight:700; cursor:pointer; background:none; border:none; font-family:'DM Sans',sans-serif; font-size:0.875rem; transition:opacity 0.2s; }
    .resend-btn:disabled { color:#C0B8AD; cursor:not-allowed; }
    .timer-txt { font-weight:700; color:#1C1C1C; }

    /* Progress ring */
    .timer-ring { display:inline-block; vertical-align:middle; }
    .timer-ring svg { transform:rotate(-90deg); }
    .ring-bg { fill:none; stroke:#E8E4DC; stroke-width:3; }
    .ring-fill { fill:none; stroke:#F5A623; stroke-width:3; stroke-linecap:round; transition:stroke-dashoffset 1s linear; }

    .back-link { display:inline-flex; align-items:center; gap:6px; color:#8A8277; text-decoration:none; font-size:0.85rem; margin-top:4px; transition:color 0.15s; }
    .back-link:hover { color:#F5A623; }

    .alert { display:flex; align-items:center; gap:10px; padding:12px 18px; border-radius:12px; font-size:0.875rem; margin-bottom:20px; text-align:left; }
    .alert-error  { background:#FFF5F5; color:#EF4444; border:1px solid #FECACA; }
    .alert-success { background:#F0FDF4; color:#16A34A; border:1px solid #BBF7D0; }

    @media(max-width:820px) { .left{display:none;} .right{padding:40px 24px;} }
    </style>
</head>
<body>

<!-- LEFT -->
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
        <div class="fi"><img src="https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=500" alt="Kabab" onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500'"></div>
        <div class="fi"><img src="https://images.unsplash.com/photo-1631515243349-e0cb75fb8d3a?w=500" alt="Biryani" onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500'"></div>
        <div class="fi"><img src="https://images.unsplash.com/photo-1574894709920-11b28e7367e3?w=500" alt="Naan" onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500'"></div>
    </div>
    <div class="doodle"><svg viewBox="0 0 200 200" fill="none"><circle cx="100" cy="100" r="80" stroke="#F5A623" stroke-width="2.5" stroke-dasharray="8 5"/><circle cx="100" cy="100" r="55" stroke="#F5A623" stroke-width="1.5" stroke-dasharray="5 4"/><path d="M100 20 Q130 60 100 100 Q70 140 100 180" stroke="#F5A623" stroke-width="2" fill="none"/><path d="M20 100 Q60 70 100 100 Q140 130 180 100" stroke="#F5A623" stroke-width="2" fill="none"/></svg></div>
</div>

<!-- RIGHT -->
<div class="right">
    <span class="right-bolt-tr">⚡</span>
    <span class="right-bolt-bl">⚡</span>

    <div class="otp-card">
        <span class="otp-icon">📱</span>
        <h1>Verify Your Phone</h1>
        <p class="otp-desc">
            We've sent a 6-digit OTP to
            <strong>{{ Auth::user()->phone ?? '+92 XXX XXXXXXX' }}</strong>
            <span style="font-size:0.78rem;color:#B0A898;">(Check logs in dev mode)</span>
        </p>

        @if($errors->any())
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
        @endif
        @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('user.verify.phone.post') }}" id="otpForm">
            @csrf
            <input type="hidden" name="otp" id="realOtp">

            <div class="otp-row">
                @for($i=1;$i<=6;$i++)
                <input type="text" class="otp-box" id="d{{$i}}"
                    maxlength="1" inputmode="numeric" pattern="[0-9]"
                    autocomplete="off"
                    onkeydown="handleKey(event,{{$i}})"
                    oninput="onDigit(this,{{$i}})"
                    {{ $i===1 ? 'onpaste="handlePaste(event)"' : '' }}>
                @endfor
            </div>

            <button type="submit" class="btn-verify" id="verifyBtn" disabled>
                <i class="fas fa-shield-check"></i> Verify Phone Number
            </button>
        </form>

        <div class="resend-wrap">
            Didn't receive the code?&nbsp;
            <form method="POST" action="{{ route('user.resend.otp') }}" style="display:inline;" id="resendForm">
                @csrf
                <button type="submit" class="resend-btn" id="resendBtn" disabled>
                    Resend OTP <span class="timer-txt" id="timerTxt">(60s)</span>
                </button>
            </form>
        </div>

        <a href="{{ route('login') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Login
        </a>
    </div>
</div>

<script>
// Countdown
let secs = 60;
const interval = setInterval(() => {
    secs--;
    document.getElementById('timerTxt').textContent = secs > 0 ? `(${secs}s)` : '';
    if(secs <= 0) {
        clearInterval(interval);
        document.getElementById('resendBtn').disabled = false;
    }
}, 1000);

function handleKey(e, pos) {
    const cur = document.getElementById(`d${pos}`);
    if(e.key === 'Backspace') {
        if(!cur.value && pos > 1) { document.getElementById(`d${pos-1}`).focus(); }
        cur.value = '';
        cur.classList.remove('filled');
        updateOtp();
        e.preventDefault();
    } else if(e.key === 'ArrowLeft' && pos > 1) {
        document.getElementById(`d${pos-1}`).focus();
    } else if(e.key === 'ArrowRight' && pos < 6) {
        document.getElementById(`d${pos+1}`).focus();
    }
}

function onDigit(inp, pos) {
    inp.value = inp.value.replace(/\D/g,'').slice(-1);
    if(inp.value) {
        inp.classList.add('filled');
        if(pos < 6) document.getElementById(`d${pos+1}`).focus();
    } else {
        inp.classList.remove('filled');
    }
    updateOtp();
}

function handlePaste(e) {
    e.preventDefault();
    const paste = (e.clipboardData||window.clipboardData).getData('text').replace(/\D/g,'').slice(0,6);
    paste.split('').forEach((ch,i) => {
        const el = document.getElementById(`d${i+1}`);
        if(el) { el.value=ch; el.classList.add('filled'); }
    });
    const last = Math.min(paste.length, 6);
    if(last > 0) document.getElementById(`d${last}`).focus();
    updateOtp();
}

function updateOtp() {
    let otp = '';
    for(let i=1;i<=6;i++) otp += document.getElementById(`d${i}`).value;
    document.getElementById('realOtp').value = otp;
    const btn = document.getElementById('verifyBtn');
    const full = otp.length === 6;
    btn.disabled = !full;
    if(full) btn.classList.add('ready');
}

document.getElementById('otpForm').addEventListener('submit', function() {
    const b = document.getElementById('verifyBtn');
    b.disabled=true; b.innerHTML='<i class="fas fa-spinner fa-spin"></i> Verifying...';
});
</script>
</body>
</html>