
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Stockify') - Inventory System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #080d18;
            --sidebar: #0c1424;
            --panel: #111c30;
            --panel-light: #16233a;
            --border: #24334d;
            --blue: #3984ff;
            --blue-light: #65a3ff;
            --text: #edf3ff;
            --muted: #8b9bb5;
            --green: #22c58b;
            --red: #ff647c;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
        }

        a {
            text-decoration: none;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 258px;
            height: 100vh;
            background: var(--sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: .3s;
        }

        .brand {
            padding: 27px 24px;
            border-bottom: 1px solid var(--border);
        }

        .brand-icon {
            width: 43px;
            height: 43px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #3984ff, #1755c5);
            border-radius: 13px;
            margin-right: 10px;
            color: white;
        }

        .brand-name {
            color: white;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .brand small {
            display: block;
            margin-left: 55px;
            margin-top: -8px;
            color: var(--muted);
            font-size: 9px;
            letter-spacing: 2px;
        }

        .menu-label {
            padding: 25px 25px 10px;
            color: #647590;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding: 0 13px;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 15px;
            margin-bottom: 5px;
            border-radius: 10px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 600;
            transition: .2s;
        }

        .nav-link-custom i {
            width: 19px;
            font-size: 15px;
            text-align: center;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            background: rgba(57,132,255,.13);
            color: var(--blue-light);
        }

        .nav-link-custom.active {
            border-left: 3px solid var(--blue);
        }

        .sidebar-logout {
            padding: 18px;
            border-top: 1px solid var(--border);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 13px 16px;
            border: 1px solid rgba(255,100,124,.2);
            border-radius: 11px;
            background: rgba(255,100,124,.08);
            color: var(--red);
            font-size: 13px;
            font-weight: 700;
            text-align: left;
            cursor: pointer;
            transition: .25s;
        }

        .logout-btn:hover {
            background: rgba(255,100,124,.18);
            border-color: var(--red);
        }

        .main-content {
            margin-left: 258px;
            min-height: 100vh;
        }

        .topbar {
            height: 75px;
            background: rgba(12,20,36,.92);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
        }

        .topbar-title {
            font-size: 13px;
            color: var(--muted);
        }

        .topbar-title strong {
            color: var(--text);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg,#3984ff,#174db0);
            border-radius: 12px;
            color: white;
            font-weight: 800;
        }

        .user-name {
            font-size: 12px;
            font-weight: 700;
            color: var(--text);
        }

        .user-role {
            font-size: 10px;
            color: var(--muted);
        }

        .content-area {
            padding: 30px;
        }

        .panel, .card {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 15px;
            color: var(--text);
        }

        .form-control, .form-select {
            background-color: var(--panel-light);
            border: 1px solid var(--border);
            color: var(--text);
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--panel-light);
            color: white;
            border-color: var(--blue);
            box-shadow: 0 0 0 .2rem rgba(57,132,255,.15);
        }

        .form-control::placeholder {
            color: var(--muted);
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-color: var(--text);
            --bs-table-border-color: var(--border);
        }

        .text-muted {
            color: var(--muted) !important;
        }

        .btn-primary {
            background: var(--blue);
            border-color: var(--blue);
        }

        .btn-primary:hover {
            background: #2169df;
        }

        .alert {
            border-radius: 12px;
        }

        @media(max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .content-area {
                padding: 18px;
            }

            .topbar {
                padding: 0 18px;
            }
        }

        @media print {
            .sidebar, .topbar, .no-print {
                display: none !important;
            }

            .main-content {
                margin: 0;
            }

            body {
                background: white;
                color: black;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<aside class="sidebar" id="sidebar">

    <div class="brand">
        <div>
            <span class="brand-icon">
                <i class="fas fa-cubes"></i>
            </span>
            <span class="brand-name">STOCKIFY</span>
        </div>
        <small>INVENTORY SYSTEM</small>
    </div>

    <div class="menu-label">MAIN MENU</div>

    <nav class="sidebar-menu">

        <a href="{{ route('dashboard') }}"
           class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i>
            Dashboard
        </a>

        <a href="{{ route('barang.index') }}"
           class="nav-link-custom {{ request()->routeIs('barang.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i>
            Data Barang
        </a>

        <a href="{{ route('kategori.index') }}"
           class="nav-link-custom {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
            <i class="fas fa-layer-group"></i>
            Kategori
        </a>

        <a href="{{ route('supplier.index') }}"
           class="nav-link-custom {{ request()->routeIs('supplier.*') ? 'active' : '' }}">
            <i class="fas fa-truck"></i>
            Supplier
        </a>

        <a href="{{ route('barang-masuk.index') }}"
           class="nav-link-custom {{ request()->routeIs('barang-masuk.*') ? 'active' : '' }}">
            <i class="fas fa-dolly"></i>
            Barang Masuk
        </a>

        <div class="menu-label">REPORTS & ACTIVITY</div>

        <a href="{{ route('laporan.index') }}"
           class="nav-link-custom {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
            <i class="fas fa-file-invoice"></i>
            Laporan Inventaris
        </a>

        <a href="{{ route('aktivitas.index') }}"
           class="nav-link-custom {{ request()->routeIs('aktivitas.*') ? 'active' : '' }}">
            <i class="fas fa-clock-rotate-left"></i>
            Riwayat Aktivitas
        </a>

    </nav>

    <div class="sidebar-logout">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-right-from-bracket"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>

</aside>

<div class="main-content">

    <header class="topbar">

        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-primary d-md-none"
                    onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="fas fa-bars"></i>
            </button>

            <div class="topbar-title">
                STOCKIFY / <strong>@yield('title', 'Dashboard')</strong>
            </div>
        </div>

        <div class="user-profile">
            <div class="text-end">
                <div class="user-name">
                    {{ auth()->user()->name ?? 'Administrator' }}
                </div>
                <div class="user-role">System Administrator</div>
            </div>

            <div class="avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
        </div>

    </header>

    <main class="content-area">

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
