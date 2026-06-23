<!DOCTYPE html>
<html lang="en" data-bs-theme="light" id="htmlRoot">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ST Voucher Solution - Admin</title>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --st-red: #dc3545;
            --st-red-hover: #bb2d3b;
            --st-black: #0f0f0f;
            --st-bg-light: #f8f9fa;
            --st-sidebar-width: 260px;
            --st-sidebar-collapsed-width: 70px;
            --st-navbar-height: 70px;
            --st-radius: 16px;
            --st-shadow: 0 4px 20px rgba(0,0,0,0.05);
            --st-shadow-hover: 0 10px 30px rgba(0,0,0,0.08);
            --st-transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        [data-bs-theme="dark"] {
            --st-bg-light: #121212;
            --bs-body-bg: #121212;
            --bs-body-color: #e0e0e0;
            --st-shadow: 0 4px 20px rgba(0,0,0,0.2);
            --st-shadow-hover: 0 10px 30px rgba(0,0,0,0.3);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--st-bg-light);
            color: var(--st-black);
            overflow-x: hidden;
        }

        [data-bs-theme="dark"] body {
            color: #e0e0e0;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: var(--st-radius);
            box-shadow: var(--st-shadow);
            transition: var(--st-transition);
            margin-bottom: 1.5rem;
        }

        [data-bs-theme="dark"] .card {
            background-color: #1e1e1e;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: var(--st-shadow-hover);
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--st-red);
            border-color: var(--st-red);
            border-radius: 8px;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: var(--st-red-hover);
            border-color: var(--st-red-hover);
        }

        /* Layout */
        #wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        /* Sidebar */
        #sidebar {
            width: var(--st-sidebar-width);
            background: #fff;
            box-shadow: 2px 0 10px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            transition: var(--st-transition);
            z-index: 1000;
        }

        [data-bs-theme="dark"] #sidebar {
            background: #1e1e1e;
            box-shadow: 2px 0 10px rgba(0,0,0,0.2);
        }

        #sidebar.collapsed {
            width: var(--st-sidebar-collapsed-width);
        }

        .sidebar-brand {
            height: var(--st-navbar-height);
            display: flex;
            align-items: center;
            padding: 0 1.25rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--st-black);
            text-decoration: none;
            white-space: nowrap;
        }

        [data-bs-theme="dark"] .sidebar-brand {
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-brand .logo-icon {
            background: rgba(220, 53, 69, 0.1);
            color: var(--st-red);
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 1.2rem;
        }

        #sidebar.collapsed .sidebar-brand .brand-text {
            display: none;
        }

        .sidebar-nav {
            flex-grow: 1;
            overflow-y: auto;
            padding: 1rem 0;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .nav-section {
            font-size: 0.7rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #adb5bd;
            padding: 0.5rem 1.5rem;
            margin-top: 0.5rem;
        }

        #sidebar.collapsed .nav-section {
            display: none;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.65rem 1.5rem;
            color: #495057;
            text-decoration: none;
            font-weight: 500;
            transition: var(--st-transition);
            white-space: nowrap;
        }

        [data-bs-theme="dark"] .sidebar-link {
            color: #adb5bd;
        }

        .sidebar-link i {
            font-size: 1.1rem;
            margin-right: 12px;
            color: #adb5bd;
            transition: var(--st-transition);
        }

        #sidebar.collapsed .sidebar-link {
            justify-content: center;
            padding: 0.8rem 0;
        }
        #sidebar.collapsed .sidebar-link i {
            margin-right: 0;
            font-size: 1.3rem;
        }
        #sidebar.collapsed .sidebar-link span {
            display: none;
        }

        .sidebar-link:hover, .sidebar-link.active {
            color: var(--st-red);
            background-color: rgba(220, 53, 69, 0.05);
            border-right: 3px solid var(--st-red);
        }

        .sidebar-link:hover i, .sidebar-link.active i {
            color: var(--st-red);
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        [data-bs-theme="dark"] .sidebar-footer {
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        /* Content Area */
        #content-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            transition: var(--st-transition);
        }

        /* Top Navbar */
        .top-navbar {
            height: var(--st-navbar-height);
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            z-index: 999;
        }

        [data-bs-theme="dark"] .top-navbar {
            background: #1e1e1e;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .navbar-left {
            display: flex;
            align-items: center;
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #6c757d;
            cursor: pointer;
            margin-right: 1rem;
        }

        .search-bar {
            position: relative;
            width: 300px;
        }

        .search-bar i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
        }

        .search-bar input {
            width: 100%;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border-radius: 20px;
            border: 1px solid #e9ecef;
            background-color: #f8f9fa;
            font-size: 0.9rem;
            transition: var(--st-transition);
        }

        [data-bs-theme="dark"] .search-bar input {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
            color: #fff;
        }

        .search-bar input:focus {
            outline: none;
            border-color: var(--st-red);
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
            background-color: #fff;
        }

        [data-bs-theme="dark"] .search-bar input:focus {
            background-color: #1e1e1e;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-icon-btn {
            background: rgba(0,0,0,0.03);
            border: none;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #495057;
            cursor: pointer;
            transition: var(--st-transition);
            position: relative;
        }

        [data-bs-theme="dark"] .nav-icon-btn {
            background: rgba(255,255,255,0.05);
            color: #e0e0e0;
        }

        .nav-icon-btn:hover {
            background: rgba(220, 53, 69, 0.1);
            color: var(--st-red);
        }

        .nav-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: var(--st-red);
            color: white;
            font-size: 0.6rem;
            padding: 0.2em 0.4em;
            border-radius: 10px;
            border: 2px solid #fff;
        }

        [data-bs-theme="dark"] .nav-badge {
            border-color: #1e1e1e;
        }

        .server-status {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #198754;
            box-shadow: 0 0 0 2px rgba(25, 135, 84, 0.2);
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0% { box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.4); }
            70% { box-shadow: 0 0 0 6px rgba(25, 135, 84, 0); }
            100% { box-shadow: 0 0 0 0 rgba(25, 135, 84, 0); }
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--st-red), #ff6b6b);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }
        
        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--st-black);
            line-height: 1.2;
        }

        [data-bs-theme="dark"] .user-name {
            color: #fff;
        }

        .user-role {
            font-size: 0.75rem;
            color: #6c757d;
        }

        /* Main Page Content */
        .page-content {
            padding: 1.5rem 2rem;
            flex-grow: 1;
            overflow-y: auto;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            color: var(--st-black);
        }

        [data-bs-theme="dark"] .page-title {
            color: #fff;
        }

        /* Tables */
        .table {
            vertical-align: middle;
        }
        .table thead th {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: #6c757d;
            font-weight: 600;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            background-color: #f8f9fa;
        }

        [data-bs-theme="dark"] .table {
            color: #e0e0e0;
            border-color: #3d3d3d;
        }
        
        [data-bs-theme="dark"] .table thead th {
            background-color: #2d2d2d;
            color: #adb5bd;
            border-bottom-color: #3d3d3d;
        }
        
        [data-bs-theme="dark"] .table-hover>tbody>tr:hover>* {
            background-color: rgba(255,255,255,0.05);
            color: #fff;
        }

        [data-bs-theme="dark"] .table tbody td {
            color: #e0e0e0;
            border-color: #3d3d3d;
        }

        [data-bs-theme="dark"] .text-dark {
            color: #f0f0f0 !important;
        }

        [data-bs-theme="dark"] .bg-white {
            background-color: #1e1e1e !important;
        }

        [data-bs-theme="dark"] .bg-light {
            background-color: #2d2d2d !important;
        }

        [data-bs-theme="dark"] .border {
            border-color: #3d3d3d !important;
        }

        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
            color: #f0f0f0;
        }

        [data-bs-theme="dark"] .form-control:focus,
        [data-bs-theme="dark"] .form-select:focus {
            background-color: #1e1e1e;
            border-color: #dc3545;
            color: #f0f0f0;
        }

        [data-bs-theme="dark"] .form-label {
            color: #adb5bd;
        }

        [data-bs-theme="dark"] .btn-light {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
            color: #f0f0f0;
        }

        [data-bs-theme="dark"] .btn-light:hover {
            background-color: #3d3d3d;
            border-color: #4d4d4d;
            color: #f0f0f0;
        }

        [data-bs-theme="dark"] .dropdown-menu {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
        }

        [data-bs-theme="dark"] .dropdown-item {
            color: #f0f0f0;
        }

        [data-bs-theme="dark"] .dropdown-item:hover {
            background-color: #3d3d3d;
            color: #f0f0f0;
        }

        [data-bs-theme="dark"] .text-muted {
            color: #adb5bd !important;
        }

        [data-bs-theme="dark"] .badge.bg-light {
            background-color: #2d2d2d !important;
            color: #f0f0f0 !important;
            border-color: #3d3d3d !important;
        }

        [data-bs-theme="dark"] .alert {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
            color: #f0f0f0;
        }

        [data-bs-theme="dark"] .modal-content {
            background-color: #1e1e1e;
            border-color: #3d3d3d;
        }

        [data-bs-theme="dark"] .modal-header,
        [data-bs-theme="dark"] .modal-footer {
            border-color: #3d3d3d;
        }

        [data-bs-theme="dark"] .nav-tabs {
            border-color: #3d3d3d;
        }

        [data-bs-theme="dark"] .nav-tabs .nav-link {
            color: #adb5bd;
        }

        [data-bs-theme="dark"] .nav-tabs .nav-link.active {
            background-color: #1e1e1e;
            border-color: #3d3d3d #3d3d3d #1e1e1e;
            color: #f0f0f0;
        }

        [data-bs-theme="dark"] .nav-tabs .nav-link:hover {
            border-color: #4d4d4d;
        }

        [data-bs-theme="dark"] .page-link {
            background-color: #2d2d2d;
            border-color: #3d3d3d;
            color: #f0f0f0;
        }

        [data-bs-theme="dark"] .page-link:hover {
            background-color: #3d3d3d;
            border-color: #4d4d4d;
            color: #f0f0f0;
        }

        [data-bs-theme="dark"] .page-item.active .page-link {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        [data-bs-theme="dark"] .page-item.disabled .page-link {
            background-color: #1e1e1e;
            border-color: #3d3d3d;
            color: #6c757d;
        }

        /* Fade-in Animation */
        .fade-in {
            animation: fadeIn 0.4s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Mobile Responsiveness Improvements */
        @media (max-width: 991.98px) {
            #sidebar {
                position: fixed;
                height: 100vh;
                transform: translateX(-100%);
                box-shadow: 2px 0 20px rgba(0,0,0,0.15);
            }
            #sidebar.show {
                transform: translateX(0);
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 999;
                backdrop-filter: blur(2px);
            }
            .sidebar-overlay.show {
                display: block;
            }
            .search-bar {
                display: none;
            }
            .user-info {
                display: none;
            }
            .page-content {
                padding: 1rem;
            }
            .top-navbar {
                padding: 0 1rem;
            }
            .navbar-right {
                gap: 0.5rem;
            }
            .server-status {
                display: none !important;
            }
        }

        @media (max-width: 575.98px) {
            .page-content {
                padding: 0.75rem;
            }
            .page-title {
                font-size: 1.25rem;
            }
            .card {
                margin-bottom: 1rem;
            }
            .top-navbar {
                height: 60px;
            }
            .toggle-btn {
                margin-right: 0.5rem;
                font-size: 1.25rem;
            }
            .user-avatar {
                width: 35px;
                height: 35px;
                font-size: 1rem;
            }
        }

        /* Touch-friendly improvements */
        @media (hover: none) and (pointer: coarse) {
            .sidebar-link {
                padding: 0.85rem 1.5rem;
            }
            .btn {
                min-height: 44px;
            }
            .form-control, .form-select {
                min-height: 44px;
            }
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar Overlay for mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar -->
        <aside id="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <div class="logo-icon"><i class="bi bi-wifi"></i></div>
                <span class="brand-text">ST Voucher</span>
            </a>
            
            <div class="sidebar-nav">
                <div class="nav-section">Dashboard</div>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i> <span>Overview</span>
                </a>
                
                <div class="nav-section">Infrastructure</div>
                <a href="{{ route('admin.sites.index') }}" class="sidebar-link {{ request()->routeIs('admin.sites.*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i> <span>Sites</span>
                </a>
                <a href="{{ route('admin.nas.index') }}" class="sidebar-link {{ request()->routeIs('admin.nas.*') ? 'active' : '' }}">
                    <i class="bi bi-hdd-network"></i> <span>NAS & Clients</span>
                </a>

                <div class="nav-section">Voucher Engine</div>
                <a href="{{ route('admin.profiles.index') }}" class="sidebar-link {{ request()->routeIs('admin.profiles.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i> <span>Profiles</span>
                </a>
                <a href="{{ route('admin.vouchers.index') }}" class="sidebar-link {{ request()->routeIs('admin.vouchers.*') ? 'active' : '' }}">
                    <i class="bi bi-ticket-perforated"></i> <span>Vouchers</span>
                </a>

                <div class="nav-section">Monitoring & Logs</div>
                <a href="{{ route('admin.sessions.index') }}" class="sidebar-link {{ request()->routeIs('admin.sessions.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> <span>Active Users</span>
                </a>
                <a href="{{ route('admin.logs.accounting') }}" class="sidebar-link {{ request()->routeIs('admin.logs.accounting') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i> <span>Accounting</span>
                </a>
                <a href="{{ route('admin.logs.auth') }}" class="sidebar-link {{ request()->routeIs('admin.logs.auth') ? 'active' : '' }}">
                    <i class="bi bi-shield-lock"></i> <span>Authentication</span>
                </a>

                <div class="nav-section">System</div>
                <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart"></i> <span>Reports</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i> <span>Settings</span>
                </a>
            </div>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="sidebar-link w-100 border-0 bg-transparent text-start text-danger">
                        <i class="bi bi-box-arrow-left text-danger"></i> <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div id="content-wrapper">
            <!-- Top Navbar -->
            <header class="top-navbar">
                <div class="navbar-left">
                    <button class="toggle-btn" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="search-bar">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Search vouchers, users, sites...">
                    </div>
                </div>

                <div class="navbar-right">
                    <div class="server-status bg-success bg-opacity-10 text-success d-none d-md-flex">
                        <div class="status-dot"></div>
                        RADIUS Online
                    </div>
                    
                    <button class="nav-icon-btn" id="themeToggle" title="Toggle Dark Mode">
                        <i class="bi bi-moon"></i>
                    </button>
                    
                    <button class="nav-icon-btn position-relative">
                        <i class="bi bi-bell"></i>
                        <span class="nav-badge">3</span>
                    </button>

                    <div class="dropdown">
                        <div class="user-profile" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-info text-end">
                                <span class="user-name">{{ auth()->user()->name ?? 'Administrator' }}</span>
                                <span class="user-role">{{ auth()->user()->role ?? 'Admin' }}</span>
                            </div>
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3">
                            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                            <li><a class="dropdown-item py-2" href="#"><i class="bi bi-gear me-2"></i> Preferences</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger"><i class="bi bi-box-arrow-right me-2"></i> Sign out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="page-content fade-in">
                <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <h2 class="page-title">@yield('header', 'Dashboard')</h2>
                    <div class="page-actions">
                        @yield('actions')
                    </div>
                </div>
                
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-center alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        function toggleSidebar() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
                sidebarOverlay.classList.toggle('show');
            } else {
                sidebar.classList.toggle('collapsed');
            }
        }

        document.getElementById('sidebarToggle').addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);

        // Dark Mode Toggle
        const themeToggle = document.getElementById('themeToggle');
        const htmlElement = document.documentElement;
        const icon = themeToggle.querySelector('i');

        // Function to apply theme
        function applyTheme(theme) {
            if (theme === 'dark') {
                htmlElement.setAttribute('data-bs-theme', 'dark');
                icon.classList.remove('bi-moon');
                icon.classList.add('bi-sun');
                localStorage.setItem('theme', 'dark');
            } else {
                htmlElement.setAttribute('data-bs-theme', 'light');
                icon.classList.remove('bi-sun');
                icon.classList.add('bi-moon');
                localStorage.setItem('theme', 'light');
            }
            
            // Re-render charts if they exist
            if (typeof updateChartsTheme === 'function') {
                updateChartsTheme(theme);
            }
        }

        // Check local storage on page load
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            applyTheme('dark');
        } else {
            applyTheme('light');
        }

        themeToggle.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            applyTheme(newTheme);
        });

        // Initialize DataTables globally
        $(document).ready(function() {
            $('.datatable').DataTable({
                "language": {
                    "search": "<i class='bi bi-search text-muted'></i>",
                    "searchPlaceholder": "Search records..."
                },
                "dom": '<"row align-items-center mb-3"<"col-md-6"l><"col-md-6"f>>rt<"row align-items-center mt-3"<"col-md-6"i><"col-md-6"p>>',
                "drawCallback": function() {
                    $('.dataTables_filter input').addClass('form-control form-control-sm rounded-pill px-3');
                    $('.dataTables_length select').addClass('form-select form-select-sm rounded-pill px-3');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>