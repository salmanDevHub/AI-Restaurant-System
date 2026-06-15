<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Dashboard') — FoodieHub Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root{
            --primary:#FF4500;--primary-dark:#CC3700;--secondary:#FFC107;
            --dark:#1A1A2E;--dark2:#16213E;--sidebar-w:260px;
            --gray:#6B7280;--light:#F3F4F6;--white:#fff;
            --border:#E5E7EB;--success:#10B981;--warning:#F59E0B;
            --danger:#EF4444;--info:#3B82F6;
            --shadow:0 1px 8px rgba(0,0,0,0.08);
        }
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'DM Sans',sans-serif;background:var(--light);color:var(--dark);display:flex;min-height:100vh;}

        /* SIDEBAR */
        .sidebar{
            width:var(--sidebar-w);background:var(--dark);
            display:flex;flex-direction:column;
            position:fixed;top:0;left:0;height:100vh;
            overflow-y:auto;z-index:200;transition:transform 0.3s;
        }
        .sidebar-brand{
            padding:22px 24px;border-bottom:1px solid rgba(255,255,255,0.08);
            display:flex;align-items:center;gap:10px;
            font-size:1.3rem;font-weight:800;color:white;text-decoration:none;
        }
        .sidebar-brand span{color:var(--primary);}
        .admin-badge{
            background:var(--primary);color:white;
            font-size:0.65rem;font-weight:700;padding:2px 8px;
            border-radius:50px;margin-left:auto;
        }
        .sidebar-section{padding:16px 12px 6px;font-size:0.7rem;font-weight:700;color:#6B7280;text-transform:uppercase;letter-spacing:1px;}
        .nav-item{
            display:flex;align-items:center;gap:12px;
            padding:11px 16px;border-radius:10px;margin:2px 10px;
            color:#9CA3AF;text-decoration:none;font-size:0.875rem;font-weight:500;
            transition:all 0.15s;position:relative;
        }
        .nav-item:hover{background:rgba(255,255,255,0.06);color:white;}
        .nav-item.active{background:var(--primary);color:white;}
        .nav-item .nav-icon{width:20px;text-align:center;font-size:1rem;flex-shrink:0;}
        .nav-badge{
            margin-left:auto;background:var(--danger);color:white;
            font-size:0.7rem;font-weight:700;min-width:20px;height:20px;
            border-radius:50px;display:flex;align-items:center;justify-content:center;
            padding:0 5px;
        }
        .sidebar-footer{margin-top:auto;padding:16px 10px;border-top:1px solid rgba(255,255,255,0.08);}

        /* MAIN */
        .main-wrap{margin-left:var(--sidebar-w);flex:1;display:flex;flex-direction:column;min-height:100vh;}

        /* TOPBAR */
        .topbar{
            background:white;border-bottom:1px solid var(--border);
            padding:0 28px;height:65px;display:flex;align-items:center;
            gap:16px;position:sticky;top:0;z-index:100;
            box-shadow:var(--shadow);
        }
        .topbar-title{font-weight:700;font-size:1.1rem;color:var(--dark);}
        .topbar-right{margin-left:auto;display:flex;align-items:center;gap:14px;}
        .topbar-icon-btn{
            width:38px;height:38px;border-radius:10px;background:var(--light);
            border:1px solid var(--border);display:flex;align-items:center;justify-content:center;
            cursor:pointer;color:var(--gray);font-size:1rem;position:relative;
            text-decoration:none;transition:all 0.15s;
        }
        .topbar-icon-btn:hover{background:var(--primary);color:white;border-color:var(--primary);}
        .notif-dot{
            position:absolute;top:6px;right:6px;
            width:8px;height:8px;border-radius:50%;
            background:var(--danger);border:2px solid white;
        }
        .admin-info{display:flex;align-items:center;gap:10px;cursor:pointer;}
        .admin-av{width:36px;height:36px;border-radius:10px;object-fit:cover;border:2px solid var(--primary);}
        .admin-name{font-weight:700;font-size:0.875rem;color:var(--dark);}

        /* PAGE CONTENT */
        .page-content{padding:28px;flex:1;}
        .page-header{margin-bottom:24px;}
        .page-header h1{font-size:1.5rem;font-weight:800;color:var(--dark);margin-bottom:4px;}
        .page-header p{color:var(--gray);font-size:0.875rem;}
        .breadcrumb{display:flex;align-items:center;gap:6px;font-size:0.8rem;color:var(--gray);margin-bottom:8px;}
        .breadcrumb a{color:var(--gray);text-decoration:none;}
        .breadcrumb a:hover{color:var(--primary);}
        .breadcrumb .sep{color:var(--border);}

        /* CARDS */
        .card{background:white;border-radius:16px;border:1px solid var(--border);box-shadow:var(--shadow);}
        .card-header{padding:18px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
        .card-header h3{font-weight:700;font-size:1rem;color:var(--dark);}
        .card-body{padding:22px;}

        /* STATS GRID */
        .stats-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:20px;margin-bottom:28px;}
        .stat-card{
            background:white;border-radius:16px;padding:22px;
            border:1px solid var(--border);display:flex;align-items:center;gap:16px;
            box-shadow:var(--shadow);transition:all 0.2s;
        }
        .stat-card:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,0.1);}
        .stat-icon{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;}
        .stat-icon.orange{background:#FFF0EB;}
        .stat-icon.blue{background:#EFF6FF;}
        .stat-icon.green{background:#F0FDF4;}
        .stat-icon.yellow{background:#FFFBEB;}
        .stat-icon.purple{background:#F5F3FF;}
        .stat-val{font-size:1.6rem;font-weight:900;color:var(--dark);line-height:1.1;}
        .stat-lbl{font-size:0.8rem;color:var(--gray);margin-top:2px;}
        .stat-change{font-size:0.78rem;margin-top:4px;}
        .stat-change.up{color:var(--success);}
        .stat-change.down{color:var(--danger);}

        /* TABLE */
        .table-wrap{overflow-x:auto;}
        table{width:100%;border-collapse:collapse;}
        thead tr{background:var(--light);}
        th{padding:11px 16px;text-align:left;font-size:0.78rem;font-weight:700;color:var(--gray);text-transform:uppercase;letter-spacing:0.4px;white-space:nowrap;}
        td{padding:13px 16px;font-size:0.875rem;color:var(--dark);border-bottom:1px solid var(--border);vertical-align:middle;}
        tr:last-child td{border-bottom:none;}
        tr:hover td{background:#FAFAFA;}

        /* BADGES */
        .badge{padding:4px 12px;border-radius:50px;font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;gap:4px;}
        .badge-success{background:#DCFCE7;color:#166534;}
        .badge-warning{background:#FEF9C3;color:#854D0E;}
        .badge-danger{background:#FEE2E2;color:#991B1B;}
        .badge-info{background:#DBEAFE;color:#1E40AF;}
        .badge-purple{background:#F3E8FF;color:#6B21A8;}
        .badge-gray{background:#F3F4F6;color:#374151;}
        .badge-orange{background:#FFF0EB;color:var(--primary);}

        /* BUTTONS */
        .btn{display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:10px;font-weight:600;font-size:0.875rem;cursor:pointer;text-decoration:none;border:none;font-family:'DM Sans',sans-serif;transition:all 0.15s;}
        .btn-primary{background:var(--primary);color:white;}
        .btn-primary:hover{background:var(--primary-dark);transform:translateY(-1px);}
        .btn-secondary{background:var(--light);color:var(--dark);border:1px solid var(--border);}
        .btn-secondary:hover{border-color:var(--primary);color:var(--primary);}
        .btn-danger{background:#FEE2E2;color:var(--danger);}
        .btn-danger:hover{background:var(--danger);color:white;}
        .btn-success{background:#DCFCE7;color:#166534;}
        .btn-success:hover{background:var(--success);color:white;}
        .btn-sm{padding:6px 12px;font-size:0.8rem;border-radius:8px;}
        .btn-icon{width:34px;height:34px;padding:0;justify-content:center;border-radius:8px;}

        /* FORMS */
        .form-group{margin-bottom:18px;}
        .form-label{display:block;font-size:0.82rem;font-weight:600;color:var(--dark);margin-bottom:7px;}
        .form-control{width:100%;padding:11px 14px;border:1.5px solid var(--border);border-radius:11px;font-size:0.9rem;font-family:'DM Sans',sans-serif;outline:none;color:var(--dark);background:var(--light);transition:all 0.2s;}
        .form-control:focus{border-color:var(--primary);background:white;box-shadow:0 0 0 3px rgba(255,69,0,0.07);}
        select.form-control{cursor:pointer;}
        textarea.form-control{resize:vertical;min-height:90px;}
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px;}
        .form-grid .full{grid-column:1/-1;}
        .form-hint{font-size:0.78rem;color:var(--gray);margin-top:5px;}
        .toggle-switch{display:flex;align-items:center;gap:10px;}
        .toggle-switch input[type=checkbox]{width:44px;height:24px;accent-color:var(--primary);cursor:pointer;}

        /* ALERTS */
        .alert{padding:12px 16px;border-radius:10px;font-size:0.875rem;margin-bottom:18px;display:flex;align-items:center;gap:10px;}
        .alert-success{background:#F0FDF4;color:#166534;border:1px solid #BBF7D0;}
        .alert-error{background:#FFF5F5;color:var(--danger);border:1px solid #FECACA;}
        .alert-warning{background:#FFFBEB;color:#854D0E;border:1px solid #FDE68A;}
        .alert-info{background:#EFF6FF;color:#1D4ED8;border:1px solid #BFDBFE;}

        /* PAGINATION */
        .pagination{display:flex;gap:6px;flex-wrap:wrap;align-items:center;}
        .pagination a,.pagination span{width:36px;height:36px;display:flex;align-items:center;justify-content:center;border-radius:8px;font-size:0.875rem;font-weight:600;text-decoration:none;border:1px solid var(--border);color:var(--dark);transition:all 0.15s;}
        .pagination a:hover{border-color:var(--primary);color:var(--primary);}
        .pagination .active{background:var(--primary);border-color:var(--primary);color:white;}

        /* TOAST */
        #toast-wrap{position:fixed;top:76px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:8px;}
        .toast-msg{background:var(--dark);color:white;padding:12px 18px;border-radius:12px;font-size:0.875rem;box-shadow:0 8px 24px rgba(0,0,0,0.2);animation:tSlide 0.3s ease;display:flex;align-items:center;gap:8px;min-width:260px;max-width:340px;}
        .toast-msg.success{background:var(--success);}
        .toast-msg.error{background:var(--danger);}
        .toast-msg.warning{background:var(--warning);color:var(--dark);}
        @keyframes tSlide{from{transform:translateX(60px);opacity:0}to{transform:translateX(0);opacity:1}}

        /* MOBILE */
        .mob-toggle{display:none;background:none;border:none;font-size:1.4rem;cursor:pointer;color:var(--dark);}
        @media(max-width:1024px){
            .sidebar{transform:translateX(-100%);}
            .sidebar.open{transform:translateX(0);}
            .main-wrap{margin-left:0;}
            .mob-toggle{display:flex;}
        }
        @media(max-width:600px){
            .stats-grid{grid-template-columns:1fr 1fr;}
            .form-grid{grid-template-columns:1fr;}
            .page-content{padding:16px;}
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            🍽️ Foodie<span>Hub</span>
            <span class="admin-badge">ADMIN</span>
        </a>

        <div class="sidebar-section">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Dashboard
            @if(isset($pendingCount) && $pendingCount > 0)
            <span class="nav-badge">{{ $pendingCount }}</span>
            @endif
        </a>

        <div class="sidebar-section">Orders</div>
        <a href="{{ route('admin.orders.index') }}" class="nav-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
            <span class="nav-icon">📋</span> All Orders
        </a>
        <a href="{{ route('admin.orders.index', ['status'=>'pending']) }}" class="nav-item">
            <span class="nav-icon">⏳</span> Pending Orders
        </a>
        <a href="{{ route('admin.orders.index', ['status'=>'preparing']) }}" class="nav-item">
            <span class="nav-icon">👨‍🍳</span> In Kitchen
        </a>

        <div class="sidebar-section">Menu</div>
        <a href="{{ route('admin.foods.index') }}" class="nav-item {{ request()->routeIs('admin.foods*') ? 'active' : '' }}">
            <span class="nav-icon">🍔</span> Food Items
        </a>
        <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
            <span class="nav-icon">📂</span> Categories
        </a>

        <div class="sidebar-section">Customers</div>
        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <span class="nav-icon">👥</span> Users
        </a>

        <div class="sidebar-section">Account</div>
        <a href="{{ route('user.home') }}" class="nav-item" target="_blank">
            <span class="nav-icon">🌐</span> View Website
        </a>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item" style="width:100%;background:rgba(239,68,68,0.1);color:#FCA5A5;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;">
                    <span class="nav-icon">🚪</span> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main-wrap">
        <header class="topbar">
            <button class="mob-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">☰</button>
            <div class="topbar-title">@yield('page-title','Dashboard')</div>
            <div class="topbar-right">
                <a href="{{ route('admin.orders.index', ['status'=>'pending']) }}" class="topbar-icon-btn" title="Pending Orders">
                    🔔 <span class="notif-dot"></span>
                </a>
                <div class="admin-info">
                    <img src="{{ Auth::user()->avatar_url }}" alt="Admin" class="admin-av">
                    <div>
                        <div class="admin-name">{{ Auth::user()->name }}</div>
                        <div style="font-size:0.72rem;color:var(--gray);">Administrator</div>
                    </div>
                </div>
            </div>
        </header>

        <main class="page-content">
            @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="alert alert-error">❌ {{ session('error') }}</div>
            @endif
            @if($errors->any())
            <div class="alert alert-error">❌ {{ $errors->first() }}</div>
            @endif

            @yield('content')
        </main>
    </div>

    <div id="toast-wrap"></div>

    <script>
    function showToast(msg, type='success'){
        const w=document.getElementById('toast-wrap');
        const d=document.createElement('div');
        d.className=`toast-msg ${type}`;
        const icons={success:'✅',error:'❌',warning:'⚠️',info:'ℹ️'};
        d.innerHTML=`<span>${icons[type]||'ℹ️'}</span><span>${msg}</span>`;
        w.appendChild(d);
        setTimeout(()=>d.style.opacity='0',3500);
        setTimeout(()=>d.remove(),4000);
    }
    const csrf = document.querySelector('meta[name=csrf-token]')?.content;
    // Close sidebar on outside click (mobile)
    document.addEventListener('click', e=>{
        const sb = document.getElementById('sidebar');
        if(window.innerWidth<=1024 && sb.classList.contains('open') && !sb.contains(e.target) && !e.target.classList.contains('mob-toggle'))
            sb.classList.remove('open');
    });
    </script>
    @stack('scripts')
</body>
</html>
