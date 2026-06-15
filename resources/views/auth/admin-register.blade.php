<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Register — Shajahan Tandoori Grills</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    *,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:'DM Sans',sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#1A1208 0%,#2C1F0E 50%,#1A1208 100%);padding:20px;}

    .card{background:#fff;border-radius:24px;width:100%;max-width:480px;overflow:hidden;box-shadow:0 32px 80px rgba(0,0,0,0.4);}

    /* Top banner */
    .card-top{background:linear-gradient(135deg,#1A1208,#2C1F0E);padding:32px 36px 28px;text-align:center;position:relative;overflow:hidden;}
    .card-top::before{content:'';position:absolute;top:-40px;right:-40px;width:160px;height:160px;background:rgba(232,160,32,0.12);border-radius:50%;}
    .card-top::after{content:'';position:absolute;bottom:-30px;left:-30px;width:120px;height:120px;background:rgba(232,160,32,0.08);border-radius:50%;}
    .admin-ico{width:64px;height:64px;background:linear-gradient(135deg,#E8A020,#C47D00);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin:0 auto 14px;box-shadow:0 8px 24px rgba(232,160,32,0.35);position:relative;z-index:1;}
    .card-top h1{font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:900;color:#fff;margin-bottom:6px;position:relative;z-index:1;}
    .card-top p{color:rgba(255,255,255,0.55);font-size:.82rem;position:relative;z-index:1;}

    /* Warning badge */
    .warn-badge{display:flex;align-items:center;gap:10px;background:#FFF8E6;border:1.5px solid #F5D490;border-radius:12px;padding:12px 16px;margin:24px 36px 0;}
    .warn-badge i{color:#C47D00;font-size:1rem;flex-shrink:0;}
    .warn-badge span{color:#7A5200;font-size:.8rem;line-height:1.5;}

    /* Form */
    .card-body{padding:24px 36px 32px;}
    .field{margin-bottom:14px;position:relative;}
    .field label{display:block;font-size:.72rem;font-weight:700;color:#4A4440;margin-bottom:5px;text-transform:uppercase;letter-spacing:.05em;}
    .field input{width:100%;padding:13px 14px 13px 42px;background:#F5F4F1;border:1.5px solid #F5F4F1;border-radius:50px;font-size:.88rem;font-family:'DM Sans',sans-serif;color:#1C1C1C;outline:none;transition:all .2s;}
    .field input::placeholder{color:#B8BEC8;}
    .field input:focus{border-color:#E8A020;background:#fff;box-shadow:0 0 0 3px rgba(232,160,32,.12);}
    .field input.err{border-color:#EF4444;background:#FFF5F5;}
    .field input.admin-code-inp{letter-spacing:.08em;font-weight:700;}
    .fi{position:absolute;left:15px;bottom:13px;color:#C0B8AD;font-size:.85rem;pointer-events:none;}
    .eye-btn{position:absolute;right:14px;bottom:12px;color:#C0B8AD;cursor:pointer;background:none;border:none;font-size:.9rem;}
    .eye-btn:hover{color:#E8A020;}
    .err-msg{color:#EF4444;font-size:.75rem;margin-top:4px;padding-left:14px;}

    .form-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;}

    /* Strength */
    .str-bar{height:3px;border-radius:2px;background:#E8E4DC;margin-top:5px;overflow:hidden;}
    .str-fill{height:100%;border-radius:2px;transition:all .3s;width:0%;}
    .str-txt{font-size:.7rem;margin-top:2px;padding-left:14px;}

    /* Admin code special field */
    .code-wrap{position:relative;}
    .code-reveal{position:absolute;right:14px;bottom:12px;color:#C0B8AD;cursor:pointer;background:none;border:none;font-size:.9rem;}
    .code-hint{background:#F0F4FF;border:1px solid #C7D2FE;border-radius:8px;padding:8px 12px;font-size:.75rem;color:#3730A3;margin-top:6px;display:flex;align-items:center;gap:6px;}

    /* Submit */
    .btn-submit{width:100%;background:linear-gradient(135deg,#1A1208,#3D2A10);color:#fff;border:none;border-radius:50px;padding:15px;font-size:.95rem;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;transition:all .22s;display:flex;align-items:center;justify-content:center;gap:9px;margin-top:20px;box-shadow:0 6px 20px rgba(26,18,8,.3);}
    .btn-submit:hover{background:linear-gradient(135deg,#2C1F0E,#4A3218);transform:translateY(-2px);box-shadow:0 10px 28px rgba(26,18,8,.4);}
    .btn-submit:disabled{opacity:.65;cursor:not-allowed;transform:none;}

    .links{text-align:center;margin-top:20px;font-size:.82rem;color:#8A8277;display:flex;flex-direction:column;gap:6px;}
    .links a{color:#E8A020;font-weight:600;text-decoration:none;}
    .links a:hover{text-decoration:underline;}

    .alert{display:flex;align-items:flex-start;gap:10px;padding:11px 16px;border-radius:12px;font-size:.83rem;margin-bottom:16px;}
    .alert-error{background:#FFF5F5;color:#EF4444;border:1px solid #FECACA;}
    </style>
</head>
<body>

<div class="card">
    <!-- Top -->
    <div class="card-top">
        <div class="admin-ico">🔧</div>
        <h1>Admin Registration</h1>
        <p>Create a new admin account for Shajahan Tandoori</p>
    </div>

    <!-- Warning -->
    <div class="warn-badge">
        <i class="fas fa-shield-halved"></i>
        <span>Admin registration requires a <strong>secret access code</strong>. Contact the system owner if you don't have it.</span>
    </div>

    <!-- Form -->
    <div class="card-body">

        @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle" style="margin-top:2px;flex-shrink:0;"></i>
            <div>{{ $errors->first() }}</div>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.register.post') }}" id="adminForm" novalidate>
            @csrf

            <div class="field">
                <label>Full Name *</label>
                <i class="fas fa-user fi"></i>
                <input type="text" name="name" placeholder="Admin Name"
                    value="{{ old('name') }}" required
                    class="{{ $errors->has('name') ? 'err' : '' }}">
                @error('name')<p class="err-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-row">
                <div class="field">
                    <label>Email *</label>
                    <i class="fas fa-envelope fi"></i>
                    <input type="email" name="email" placeholder="admin@example.com"
                        value="{{ old('email') }}" required
                        class="{{ $errors->has('email') ? 'err' : '' }}">
                    @error('email')<p class="err-msg">{{ $message }}</p>@enderror
                </div>
                <div class="field">
                    <label>Phone *</label>
                    <i class="fas fa-phone fi"></i>
                    <input type="tel" name="phone" id="phoneInp" placeholder="03001234567"
                        value="{{ old('phone') }}" maxlength="13" required
                        class="{{ $errors->has('phone') ? 'err' : '' }}">
                    @error('phone')<p class="err-msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="form-row">
                <div class="field">
                    <label>Password *</label>
                    <i class="fas fa-lock fi"></i>
                    <input type="password" name="password" id="passInp"
                        placeholder="Min. 8 chars" required oninput="checkStr(this.value)"
                        class="{{ $errors->has('password') ? 'err' : '' }}">
                    <button type="button" class="eye-btn" onclick="tp('passInp','e1')">
                        <i class="fas fa-eye" id="e1"></i>
                    </button>
                    <div class="str-bar"><div class="str-fill" id="strFill"></div></div>
                    <p class="str-txt" id="strTxt"></p>
                    @error('password')<p class="err-msg">{{ $message }}</p>@enderror
                </div>
                <div class="field">
                    <label>Confirm Password *</label>
                    <i class="fas fa-lock fi"></i>
                    <input type="password" name="password_confirmation" id="confInp"
                        placeholder="Repeat password" required>
                    <button type="button" class="eye-btn" onclick="tp('confInp','e2')">
                        <i class="fas fa-eye" id="e2"></i>
                    </button>
                    <p class="err-msg" id="matchErr" style="display:none;">Passwords don't match</p>
                </div>
            </div>

            <div class="field">
                <label>🔐 Admin Secret Code *</label>
                <i class="fas fa-key fi"></i>
                <input type="password" name="admin_code" id="codeInp"
                    placeholder="Enter admin registration code"
                    class="admin-code-inp {{ $errors->has('admin_code') ? 'err' : '' }}"
                    required autocomplete="off">
                <button type="button" class="code-reveal" onclick="tp('codeInp','e3')">
                    <i class="fas fa-eye" id="e3"></i>
                </button>
                @error('admin_code')
                <p class="err-msg">{{ $message }}</p>
                @else
                <div class="code-hint">
                    <i class="fas fa-info-circle"></i>
                    Contact the restaurant owner for the admin access code
                </div>
                @enderror
            </div>

            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="fas fa-user-shield"></i> Create Admin Account
            </button>
        </form>

        <div class="links">
            <span>Already have an admin account? <a href="{{ route('login') }}">Login here →</a></span>
            <span><a href="{{ route('login') }}">← Back to Login</a></span>
        </div>
    </div>
</div>

<script>
function tp(id, ico) {
    const i = document.getElementById(id), e = document.getElementById(ico);
    i.type = i.type === 'password' ? 'text' : 'password';
    e.className = i.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
}
function checkStr(v) {
    const f = document.getElementById('strFill'), t = document.getElementById('strTxt');
    let s = 0;
    if(v.length>=8)s++; if(/[A-Z]/.test(v))s++; if(/[0-9]/.test(v))s++; if(/[^A-Za-z0-9]/.test(v))s++;
    const map = [[25,'#EF4444','Weak'],[50,'#F59E0B','Fair'],[75,'#3B82F6','Good'],[100,'#52B44B','Strong ✓']];
    const [w,c,m] = map[Math.max(0,s-1)];
    f.style.width = v.length > 0 ? w+'%' : '0%';
    f.style.background = c;
    t.textContent = v.length > 0 ? 'Strength: '+m : '';
    t.style.color = c;
}
document.getElementById('phoneInp').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g,'');
});
document.getElementById('confInp').addEventListener('input', function() {
    const ok = this.value === document.getElementById('passInp').value;
    document.getElementById('matchErr').style.display = this.value && !ok ? 'block' : 'none';
});
document.getElementById('adminForm').addEventListener('submit', function(e) {
    if(document.getElementById('passInp').value !== document.getElementById('confInp').value) {
        e.preventDefault(); document.getElementById('matchErr').style.display='block'; return;
    }
    const b = document.getElementById('submitBtn');
    b.disabled = true; b.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';
});
</script>
</body>
</html>