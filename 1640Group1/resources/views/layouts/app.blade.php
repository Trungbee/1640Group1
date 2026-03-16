<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Academic Portal</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f7fe;
            margin: 0;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: white;
            padding: 20px;
            position: fixed;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .university-brand {
            padding: 20px 10px;
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 20px;
        }

        .nav-link {
            color: #6c757d;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 5px;
            transition: 0.3s;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .nav-link i {
            margin-right: 12px;
            font-size: 1.2rem;
        }

        .nav-link:hover,
        .nav-link.active {
            background: #e9f2ff;
            color: #2b99d6;
        }

        /* Main content */
        .main-content {
            margin-left: 280px;
            padding: 40px;
            width: calc(100% - 280px);
        }

        .top-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 30px;
            gap: 20px;
        }

        .profile-img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #2b99d6;
        }

        /* card */
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.05);
        }

        .chart-title {
            text-align: center;
            font-weight: 600;
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="university-brand">
            <h5 class="fw-bold mb-0 text-primary">
                <i class="bi bi-mortarboard-fill"></i> ACADEMIC
            </h5>
            <small class="text-muted">System Administration</small>
        </div>

        <nav class="nav flex-column flex-grow-1">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <a class="nav-link {{ request()->routeIs('admin.socialmedia') ? 'active' : '' }}" href="{{ route('admin.socialmedia') }}">
                <i class="bi bi-book"></i> Social Media Management
            </a>

            <a class="nav-link {{ request()->routeIs('admin.staffmanagement') ? 'active' : '' }}" href="{{ route('admin.staffmanagement') }}">
                <i class="bi bi-people"></i> Staff Management
            </a>

            <a class="nav-link {{ request()->routeIs('admin.ideas') ? 'active' : '' }}" href="{{ route('admin.ideas') ?? '#' }}">
                <i class="bi bi-lightbulb"></i> Submitted Ideas
            </a>
        </nav>

        <div class="mt-auto border-top pt-3">
            <a href="#" class="nav-link text-danger fw-bold" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-left"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <div class="main-content">

        <div class="top-bar">
            <div class="text-end me-2">
                <p class="mb-0 fw-bold small">{{ Auth::user()->fullName ?? 'System Admin' }}</p>
                <small class="text-muted">Role: {{ Auth::user()->role ?? 'Admin' }}</small>
            </div>
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->username ?? 'A' }}&background=2b99d6&color=fff" class="profile-img">
        </div>

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
