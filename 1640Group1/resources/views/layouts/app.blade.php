<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Academic Portal')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7fe; display: flex; min-height: 100vh; margin: 0; }
        .sidebar { width: 260px; background: white; box-shadow: 2px 0 10px rgba(0,0,0,0.05); padding: 20px; position: fixed; height: 100vh; }
        .main-content { margin-left: 260px; width: calc(100% - 260px); padding: 30px; }
        .nav-link { color: #6c757d; padding: 10px 15px; border-radius: 8px; margin-bottom: 5px; text-decoration: none; display: block; }
        .nav-link:hover, .nav-link.active { background: #e9f2ff; color: #2b99d6; }
        .header-box { background: linear-gradient(135deg, #2b99d6, #1a7bb3); color: white; padding: 30px; border-radius: 15px; margin-bottom: 25px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="mb-4 px-2">
            <h5 class="fw-bold text-primary">PORTAL</h5>
        </div>
        <nav>
            <a href="{{ route('home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
                <i class="bi bi-house-door me-2"></i> Home
            </a>
            <div class="mt-3 small text-muted px-3 text-uppercase fw-bold">Accounts</div>
            <a href="/user-management" class="nav-link">
                <i class="bi bi-people me-2"></i> Manage User
            </a>
            <a href="/new-user" class="nav-link">
                <i class="bi bi-person-plus me-2"></i> Create New User
            </a>
        </nav>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>