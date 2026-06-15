<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Shajahan Tandoori Grills') - Pakistan\'s Finest Restaurant</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #FF4500;
            --primary-dark: #CC3700;
            --primary-light: #FF6B35;
            --secondary: #FFC107;
            --dark: #1A1A2E;
            --dark2: #16213E;
            --gray: #6B7280;
            --light: #F9FAFB;
            --white: #FFFFFF;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --border: #E5E7EB;
            --shadow: 0 4px 24px rgba(0,0,0,0.08);
            --shadow-lg: 0 20px 60px rgba(0,0,0,0.15);
            --radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'DM Sans', sans-serif; background: var(--light); color: var(--dark); overflow-x: hidden; }

        /* NAVBAR */
        .navbar {
            position: sticky; top: 0; z-index: 1000;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0 5%;
            display: flex; align-items: center; gap: 2rem;
            height: 70px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
        }
        .nav-brand {
            display: flex; align-items: center; gap: 10px;
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem; font-weight: 900;
            color: var(--primary); text-decoration: none;
        }
        .nav-brand span { color: var(--dark); }
        .nav-links { display: flex; align-items: center; gap: 0.5rem; margin-left: auto; }
        .nav-links a {
            padding: 8px 16px; border-radius: 8px;
            color: var(--dark); text-decoration: none;
            font-weight: 500; font-size: 0.9rem;
            transition: var(--transition);
        }
        .nav-links a:hover { background: #FFF0EB; color: var(--primary); }
        .nav-links a.active { color: var(--primary); font-weight: 600; }
        .btn-primary {
            background: var(--primary);
            color: white; border: none;
            padding: 10px 22px; border-radius: 10px;
            font-weight: 600; cursor: pointer;
            text-decoration: none; display: inline-flex;
            align-items: center; gap: 8px;
            transition: var(--transition);
            font-size: 0.9rem;
        }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 8px 20px rgba(255,69,0,0.3); }
        .cart-btn { position: relative; }
        .cart-badge {
            position: absolute; top: -8px; right: -8px;
            background: var(--primary); color: white;
            border-radius: 50%; width: 20px; height: 20px;
            font-size: 11px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }
        .user-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            object-fit: cover; border: 2px solid var(--primary);
        }
        .dropdown { position: relative; }
        .dropdown-menu {
            position: absolute; top: calc(100% + 10px); right: 0;
            background: white; border-radius: var(--radius);
            box-shadow: var(--shadow-lg); min-width: 200px;
            padding: 8px; display: none; z-index: 100;
            border: 1px solid var(--border);
        }
        .dropdown:hover .dropdown-menu { display: block; }
        .dropdown-menu a {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 14px; border-radius: 8px;
            color: var(--dark); text-decoration: none;
            font-size: 0.9rem; transition: var(--transition);
        }
        .dropdown-menu a:hover { background: var(--light); color: var(--primary); }

        /* TOAST */
        #toast-container {
            position: fixed; top: 80px; right: 20px;
            z-index: 9999; display: flex; flex-direction: column; gap: 10px;
        }
        .toast {
            background: var(--dark); color: white;
            padding: 14px 20px; border-radius: 12px;
            font-size: 0.9rem; font-weight: 500;
            box-shadow: var(--shadow-lg);
            animation: slideIn 0.3s ease; max-width: 320px;
            display: flex; align-items: center; gap: 10px;
        }
        .toast.success { background: var(--success); }
        .toast.error { background: var(--danger); }
        .toast.warning { background: var(--warning); color: var(--dark); }
        @keyframes slideIn { from { transform: translateX(100px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        /* AI CHATBOT */
        .ai-chat-fab {
            position: fixed; bottom: 30px; right: 30px;
            width: 60px; height: 60px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white; font-size: 1.5rem;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; z-index: 9990;
            box-shadow: 0 8px 30px rgba(255,69,0,0.4);
            animation: pulse-fab 2s infinite;
            border: none; transition: var(--transition);
        }
        @keyframes pulse-fab {
            0%, 100% { box-shadow: 0 8px 30px rgba(255,69,0,0.4); }
            50% { box-shadow: 0 8px 40px rgba(255,69,0,0.7); }
        }
        .ai-chat-fab:hover { transform: scale(1.1); }

        .ai-chat-window {
            position: fixed; bottom: 100px; right: 30px;
            width: 380px; height: 560px;
            background: white; border-radius: 24px;
            box-shadow: var(--shadow-lg); z-index: 9989;
            display: none; flex-direction: column;
            overflow: hidden; border: 1px solid var(--border);
        }
        .ai-chat-window.open { display: flex; animation: chatOpen 0.3s ease; }
        @keyframes chatOpen { from { transform: scale(0.8) translateY(20px); opacity: 0; } to { transform: scale(1) translateY(0); opacity: 1; } }

        .ai-chat-header {
            background: linear-gradient(135deg, var(--primary), #FF8C42);
            padding: 18px 20px; color: white;
            display: flex; align-items: center; gap: 12px;
        }
        .ai-avatar {
            width: 44px; height: 44px; border-radius: 50%;
            background: rgba(255,255,255,0.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }
        .ai-chat-messages {
            flex: 1; overflow-y: auto; padding: 16px;
            display: flex; flex-direction: column; gap: 12px;
        }
        .chat-msg {
            display: flex; gap: 8px; align-items: flex-end;
        }
        .chat-msg.user { flex-direction: row-reverse; }
        .chat-bubble {
            max-width: 80%; padding: 12px 16px;
            border-radius: 18px; font-size: 0.9rem; line-height: 1.5;
        }
        .chat-msg.bot .chat-bubble { background: var(--light); color: var(--dark); border-bottom-left-radius: 4px; }
        .chat-msg.user .chat-bubble { background: var(--primary); color: white; border-bottom-right-radius: 4px; }
        .mood-emojis {
            display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px;
        }
        .mood-btn {
            background: white; border: 2px solid var(--border);
            border-radius: 50px; padding: 6px 14px; cursor: pointer;
            font-size: 1rem; transition: var(--transition);
        }
        .mood-btn:hover { border-color: var(--primary); background: #FFF0EB; transform: scale(1.05); }
        .food-suggestion-card {
            display: flex; gap: 10px; padding: 10px;
            background: white; border-radius: 12px; border: 1px solid var(--border);
            margin-top: 6px; cursor: pointer;
            transition: var(--transition);
        }
        .food-suggestion-card:hover { border-color: var(--primary); box-shadow: 0 4px 12px rgba(255,69,0,0.1); }
        .food-suggestion-card img { width: 50px; height: 50px; border-radius: 8px; object-fit: cover; }
        .ai-input-row {
            padding: 12px 16px; border-top: 1px solid var(--border);
            display: flex; gap: 10px; align-items: center;
        }
        .ai-input {
            flex: 1; border: 1.5px solid var(--border); border-radius: 50px;
            padding: 10px 16px; font-size: 0.9rem; outline: none;
            transition: var(--transition); font-family: inherit;
        }
        .ai-input:focus { border-color: var(--primary); }
        .ai-send-btn {
            width: 40px; height: 40px; border-radius: 50%;
            background: var(--primary); color: white; border: none;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: var(--transition);
        }
        .ai-send-btn:hover { background: var(--primary-dark); }
        .typing-indicator { display: flex; gap: 4px; padding: 8px; }
        .typing-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--gray); animation: typing 1.2s infinite;
        }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }
        @keyframes typing { 0%, 60%, 100% { transform: translateY(0); } 30% { transform: translateY(-8px); } }

        /* FOOTER */
        footer {
            background: var(--dark); color: #9CA3AF;
            padding: 60px 5% 30px;
        }
        .footer-grid {
            display: grid; grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px; margin-bottom: 40px;
        }
        .footer-brand { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: white; margin-bottom: 12px; }
        .footer-links { list-style: none; display: flex; flex-direction: column; gap: 8px; }
        .footer-links a { color: #9CA3AF; text-decoration: none; font-size: 0.9rem; transition: var(--transition); }
        .footer-links a:hover { color: var(--primary); }
        .footer-bottom { border-top: 1px solid #374151; padding-top: 24px; display: flex; justify-content: space-between; align-items: center; }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .nav-links .hide-mobile { display: none; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .ai-chat-window { width: calc(100vw - 20px); right: 10px; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="{{ route('user.home') }}" class="nav-brand">
            🔥 Shajahan<span> Tandoori</span>
        </a>
        <div class="nav-links">
            <a href="{{ route('user.home') }}" class="{{ request()->routeIs('user.home') ? 'active' : '' }} hide-mobile">Home</a>
            <a href="{{ route('user.menu') }}" class="{{ request()->routeIs('user.menu*') ? 'active' : '' }} hide-mobile">Menu</a>
            <a href="{{ route('user.orders') }}" class="{{ request()->routeIs('user.orders*') ? 'active' : '' }} hide-mobile">My Orders</a>

            @auth
                <a href="{{ route('user.cart') }}" class="btn-primary cart-btn" style="background: var(--dark);">
                    🛒 Cart
                    <span class="cart-badge" id="cartCount">0</span>
                </a>
                <div class="dropdown">
                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="user-avatar" style="cursor:pointer;">
                    <div class="dropdown-menu">
                        <a href="{{ route('user.profile') }}"><i class="fas fa-user"></i> Profile</a>
                        <a href="{{ route('user.notifications') }}"><i class="fas fa-bell"></i> Notifications</a>
                        <a href="{{ route('user.orders') }}"><i class="fas fa-receipt"></i> My Orders</a>
                        @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Admin Panel</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:10px;padding:10px 14px;border-radius:8px;font-size:0.9rem;color:#EF4444;font-family:inherit;">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="hide-mobile" style="color:var(--gray);">Login</a>
                <a href="{{ route('register') }}" class="btn-primary">Sign Up</a>
            @endauth
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <script>document.addEventListener('DOMContentLoaded',()=>showToast('{{ session("success") }}','success'))</script>
    @endif
    @if(session('error'))
        <script>document.addEventListener('DOMContentLoaded',()=>showToast('{{ session("error") }}','error'))</script>
    @endif

    <div id="toast-container"></div>

    <!-- Main Content -->
    @yield('content')

    <!-- AI Chatbot -->
    @auth
    <button class="ai-chat-fab" onclick="toggleChat()" title="Ask Zara AI AI">🤖</button>

    <div class="ai-chat-window" id="aiChatWindow">
        <div class="ai-chat-header">
            <div class="ai-avatar">🤖</div>
            <div>
                <div style="font-weight:700;font-size:1rem;">Zara AI AI</div>
                <div style="font-size:0.8rem;opacity:0.9;">🟢 Online • Your food guide</div>
            </div>
            <button onclick="toggleChat()" style="margin-left:auto;background:rgba(255,255,255,0.2);border:none;color:white;width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:1.1rem;">✕</button>
        </div>
        <div class="ai-chat-messages" id="chatMessages"></div>
        <div class="ai-input-row">
            <input type="text" class="ai-input" id="chatInput" placeholder="Tell me your mood or ask for food..." onkeypress="if(event.key==='Enter')sendChat()">
            <button class="ai-send-btn" onclick="sendChat()"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>
    @endauth

    <!-- Footer -->
    <footer>
        <div class="footer-grid">
            <div>
                <div class="footer-brand">🔥 Shajahan Tandoori Grills</div>
                <p style="font-size:0.9rem;line-height:1.7;max-width:280px;">Pakistan's finest all-in-one restaurant. From biryani to pizza, we've got your cravings covered. Order now and get it delivered in 45 mins!</p>
                <div style="display:flex;gap:12px;margin-top:20px;">
                    <a href="#" style="color:#9CA3AF;font-size:1.2rem;"><i class="fab fa-facebook"></i></a>
                    <a href="#" style="color:#9CA3AF;font-size:1.2rem;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="color:#9CA3AF;font-size:1.2rem;"><i class="fab fa-twitter"></i></a>
                    <a href="#" style="color:#9CA3AF;font-size:1.2rem;"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div>
                <h4 style="color:white;margin-bottom:16px;">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li><a href="{{ route('user.menu') }}">Our Menu</a></li>
                    <li><a href="{{ route('user.orders') }}">Track Order</a></li>
                    <li><a href="#">About Us</a></li>
                </ul>
            </div>
            <div>
                <h4 style="color:white;margin-bottom:16px;">Cuisines</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('user.menu', ['category'=>'pakistani']) }}">🇵🇰 Pakistani</a></li>
                    <li><a href="{{ route('user.menu', ['category'=>'chinese']) }}">🥢 Chinese</a></li>
                    <li><a href="{{ route('user.menu', ['category'=>'italian']) }}">🍕 Italian</a></li>
                    <li><a href="{{ route('user.menu', ['category'=>'burgers']) }}">🍔 Burgers</a></li>
                    <li><a href="{{ route('user.menu', ['category'=>'bbq']) }}">🥩 BBQ</a></li>
                </ul>
            </div>
            <div>
                <h4 style="color:white;margin-bottom:16px;">Contact</h4>
                <ul class="footer-links">
                    <li>📞 0300-FOODIEHUB</li>
                    <li>✉️ hello@foodiehub.pk</li>
                    <li>📍 Lahore, Pakistan</li>
                    <li>🕐 Open 10AM - 2AM</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© 2024 Shajahan Tandoori Grills. All rights reserved.</span>
            <span>Made with ❤️ in Pakistan 🇵🇰</span>
        </div>
    </footer>

    <script>
    // Toast System
    function showToast(msg, type='success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        const icons = {success:'✅',error:'❌',warning:'⚠️'};
        toast.innerHTML = `<span>${icons[type]||'ℹ️'}</span><span>${msg}</span>`;
        container.appendChild(toast);
        setTimeout(() => toast.style.opacity='0', 3000);
        setTimeout(() => toast.remove(), 3500);
    }

    // CSRF for AJAX
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    // Cart count update
    function updateCartCount() {
        fetch('/api/cart/count').then(r=>r.json()).then(d=>{ document.getElementById('cartCount').textContent = d.count || 0; }).catch(()=>{});
    }

    // Add to cart
    function addToCart(foodId, btn) {
        if (btn) { btn.disabled = true; btn.textContent = '⏳'; }
        fetch('/cart/add', {
            method: 'POST',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken},
            body: JSON.stringify({food_id: foodId, quantity: 1})
        }).then(r=>r.json()).then(d=>{
            if (d.success) {
                showToast(d.message, 'success');
                document.getElementById('cartCount').textContent = d.count;
            } else showToast(d.message || 'Error adding to cart', 'error');
            if (btn) { btn.disabled = false; btn.textContent = '🛒 Add to Cart'; }
        }).catch(()=>{ if(btn){btn.disabled=false;btn.textContent='🛒 Add to Cart';} });
    }

    // AI Chat
    let chatHistory = [];
    let chatOpen = false;
    const sessionId = 'session_{{ Auth::id() ?? "guest" }}_' + Date.now();

    function toggleChat() {
        chatOpen = !chatOpen;
        const win = document.getElementById('aiChatWindow');
        win.classList.toggle('open', chatOpen);
        if (chatOpen && chatHistory.length === 0) initChat();
    }

    function initChat() {
        const msgs = document.getElementById('chatMessages');
        const hour = new Date().getHours();
        let greeting = hour < 12 ? "Good morning! 🌅" : hour < 17 ? "Good afternoon! ☀️" : "Good evening! 🌙";
        addBotMsg(`${greeting} I'm Zara AI, your personal food guide! 🍽️\n\nHow are you feeling right now? Pick an emoji or tell me!\n`, true);
    }

    function addBotMsg(text, showMoods=false) {
        const msgs = document.getElementById('chatMessages');
        const div = document.createElement('div');
        div.className = 'chat-msg bot';
        let moodHtml = '';
        if (showMoods) {
            const moods = ['😊 Happy','😢 Sad','😡 Angry','😴 Tired','🥳 Celebrate','💪 After Gym','🤒 Sick','❤️ Romantic','☕ Breakfast','🍕 Craving'];
            moodHtml = `<div class="mood-emojis">${moods.map(m=>`<button class="mood-btn" onclick="sendMood('${m}')">${m}</button>`).join('')}</div>`;
        }
        div.innerHTML = `<div style="font-size:1.4rem">🤖</div><div><div class="chat-bubble">${text.replace(/\n/g,'<br>')}${moodHtml}</div></div>`;
        msgs.appendChild(div);
        msgs.scrollTop = msgs.scrollHeight;
    }

    function addUserMsg(text) {
        const msgs = document.getElementById('chatMessages');
        const div = document.createElement('div');
        div.className = 'chat-msg user';
        div.innerHTML = `<div class="chat-bubble">${text}</div>`;
        msgs.appendChild(div);
        msgs.scrollTop = msgs.scrollHeight;
    }

    function addTyping() {
        const msgs = document.getElementById('chatMessages');
        const div = document.createElement('div');
        div.className = 'chat-msg bot'; div.id = 'typingMsg';
        div.innerHTML = `<div style="font-size:1.4rem">🤖</div><div class="chat-bubble"><div class="typing-indicator"><div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div></div></div>`;
        msgs.appendChild(div);
        msgs.scrollTop = msgs.scrollHeight;
    }

    function removeTyping() { document.getElementById('typingMsg')?.remove(); }

    function sendMood(mood) { document.getElementById('chatInput').value = mood; sendChat(); }

    async function sendChat() {
        const input = document.getElementById('chatInput');
        const msg = input.value.trim();
        if (!msg) return;
        input.value = '';
        addUserMsg(msg);
        chatHistory.push({role: 'user', content: msg});
        addTyping();

        try {
            const res = await fetch('/api/ai/chat', {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken},
                body: JSON.stringify({message: msg, history: chatHistory.slice(-10), session_id: sessionId})
            });
            const data = await res.json();
            removeTyping();
            if (data.success) {
                chatHistory.push({role: 'assistant', content: data.message});
                const msgs = document.getElementById('chatMessages');
                const div = document.createElement('div');
                div.className = 'chat-msg bot';
                let foodHtml = '';
                if (data.suggested_foods?.length > 0) {
                    foodHtml = '<div style="margin-top:10px;display:flex;flex-direction:column;gap:8px;">';
                    data.suggested_foods.forEach(f => {
                        foodHtml += `<div class="food-suggestion-card" onclick="window.location='/menu/${f.slug || f.id}'">
                            <img src="${f.image}" alt="${f.name}" onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=100'">
                            <div><div style="font-weight:600;font-size:0.85rem">${f.name}</div>
                            <div style="color:var(--primary);font-weight:700;font-size:0.9rem">Rs.${f.effective_price || f.price}</div>
                            <div style="font-size:0.75rem;color:var(--gray)">${f.spicy_icon || ''} ${f.cuisine || ''} ⭐${f.rating || ''}</div></div>
                        </div>`;
                    });
                    foodHtml += '</div>';
                }
                div.innerHTML = `<div style="font-size:1.4rem">🤖</div><div><div class="chat-bubble">${data.display_message || data.message}${foodHtml}</div></div>`;
                msgs.appendChild(div);
                msgs.scrollTop = msgs.scrollHeight;
            } else addBotMsg("Oops! " + (data.message || "Something went wrong. Please try again!"));
        } catch(e) { removeTyping(); addBotMsg("Connection error. Please try again! 🔄"); }
    }

    document.addEventListener('DOMContentLoaded', updateCartCount);
    </script>
    @stack('scripts')
</body>
</html>
