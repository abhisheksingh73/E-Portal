<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>@yield('title') - Textile Ministry E-Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #1a2a6c;
            --primary-light: #4a5d9a;
            --accent: #fdbb2d;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg-main: #f3f4f6;
            --bg-card: #ffffff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --sidebar-width: 280px;
            --glass: rgba(255, 255, 255, 0.7);
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1a2a6c 0%, #111827 100%);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            transition: var(--transition);
            z-index: 1000;
            box-shadow: 10px 0 30px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 32px 24px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-box {
            width: 40px;
            height: 40px;
            background: linear-gradient(45deg, var(--accent), #f97316);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a1a1a;
            font-weight: 800;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(253, 187, 45, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 4px 12px rgba(253, 187, 45, 0.3); }
            50% { transform: scale(1.05); box-shadow: 0 4px 20px rgba(253, 187, 45, 0.5); }
            100% { transform: scale(1); box-shadow: 0 4px 12px rgba(253, 187, 45, 0.3); }
        }

        .sidebar-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
        }

        .nav-links {
            padding: 20px 16px;
            flex: 1;
            overflow-y: auto;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            border-radius: 14px;
            margin-bottom: 8px;
            transition: var(--transition);
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-item i {
            width: 28px;
            font-size: 1.2rem;
            margin-right: 12px;
            transition: var(--transition);
        }

        .nav-item:hover {
            color: white;
            background: rgba(255,255,255,0.05);
            transform: translateX(5px);
        }

        .nav-item.active {
            background: var(--accent);
            color: #1a1a1a;
            font-weight: 700;
            box-shadow: 0 10px 20px rgba(253, 187, 45, 0.2);
        }

        .nav-item.active i {
            color: #1a1a1a;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        header {
            height: 80px;
            background: var(--glass);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.3);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            position: sticky;
            top: 0;
            z-index: 900;
            transition: var(--transition);
        }

        .search-bar {
            background: rgba(255,255,255,0.5);
            padding: 12px 20px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            width: 350px;
            border: 1px solid transparent;
            transition: var(--transition);
        }

        .search-bar:focus-within {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            width: 400px;
        }

        .search-bar input {
            background: transparent;
            border: none;
            outline: none;
            width: 100%;
            font-size: 0.95rem;
            color: var(--text-dark);
            font-weight: 500;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 8px 16px;
            border-radius: 16px;
            transition: var(--transition);
            cursor: pointer;
        }

        .user-profile:hover {
            background: rgba(255,255,255,0.5);
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-dark);
            display: block;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--primary);
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 1px;
            background: rgba(26, 42, 108, 0.1);
            padding: 2px 8px;
            border-radius: 4px;
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(26, 42, 108, 0.2);
            position: relative;
        }

        .avatar::after {
            content: '';
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 12px;
            height: 12px;
            background: var(--success);
            border: 2px solid white;
            border-radius: 50%;
        }

        .content-area {
            padding: 40px;
            animation: slideInUp 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Cards & Stats */
        .stat-card {
            background: white;
            padding: 28px;
            border-radius: 24px;
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            gap: 24px;
            transition: var(--transition);
            border: 1px solid rgba(255,255,255,0.5);
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .card {
            background: white;
            border-radius: 28px;
            box-shadow: var(--shadow-md);
            padding: 32px;
            margin-bottom: 32px;
            border: 1px solid rgba(255,255,255,0.5);
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
        }

        /* Table Styling */
        table tr {
            transition: var(--transition);
        }
        
        table tr:hover {
            background: #f8fafc;
        }

        /* Buttons */
        .logout-link {
            display: flex;
            align-items: center;
            color: #ef4444;
            text-decoration: none;
            gap: 12px;
            font-weight: 700;
            padding: 16px 24px;
            border-radius: 16px;
            transition: var(--transition);
            background: rgba(239, 68, 68, 0.05);
        }

        .logout-link:hover {
            background: #ef4444;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        @media (max-width: 1024px) {
            :root { --sidebar-width: 80px; }
            .sidebar-title, .nav-item span, .user-info, .search-bar { display: none; }
            .sidebar-header { justify-content: center; padding: 24px 0; }
            .logo-box { margin: 0; }
            .nav-item { justify-content: center; padding: 14px; margin: 0 10px 8px; }
            .nav-item i { margin-right: 0; }
            .main-content { margin-left: 80px; }
        }
        /* Admin Utilities */
        .glass-panel {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 32px;
        }

        .stagger-item {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInSlide 0.6s ease-out forwards;
        }

        @keyframes fadeInSlide {
            to { opacity: 1; transform: translateY(0); }
        }

        .action-btn {
            background: white;
            color: var(--primary);
            border: 1px solid #e2e8f0;
            padding: 10px 18px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            cursor: pointer;
            text-decoration: none;
        }

        .action-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(26, 42, 108, 0.1);
        }
    </style>
    @yield('extra_css')
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-box">T</div>
            <span class="sidebar-title">Textile E-Portal</span>
        </div>

        <nav class="nav-links">
            @yield('sidebar_links')
        </nav>

        <div class="btn-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" class="logout-link" onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </form>
        </div>
    </aside>

    <main class="main-content">
        <header>
            <div class="search-bar">
                <i class="fas fa-search" style="color: #94a3b8;"></i>
                <input type="text" placeholder="Search anything...">
            </div>

            <div class="user-profile">
                <div class="user-info">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <span class="user-role">{{ auth()->user()->role }}</span>
                </div>
                <div class="avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <div class="content-area">
            @yield('content')
        </div>
    </main>

    @yield('extra_js')

    <script type="text/javascript">
        // Prevent going back from dashboard
        function preventBack() {
            window.history.forward();
        }
        setTimeout("preventBack()", 0);
        window.onunload = function () { null };

        // Modern history manipulation to "trap" the user in the current URL
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };

        // Extra layer: Disable backspace as a 'back' command
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace') {
                const target = e.target;
                if (target.tagName !== 'INPUT' && target.tagName !== 'TEXTAREA' && !target.isContentEditable) {
                    e.preventDefault();
                }
            }
        });
    </script>
</body>
</html>
