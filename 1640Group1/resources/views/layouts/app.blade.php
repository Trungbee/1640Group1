<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Portal</title>

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

        /* Profile dropdown */
        .profile-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            user-select: none;
        }

        .profile-img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #2b99d6;
            transition: box-shadow 0.2s;
        }

        .profile-wrapper:hover .profile-img {
            box-shadow: 0 0 0 4px rgba(43,153,214,0.18);
        }

        .profile-chevron {
            font-size: 12px;
            color: #adb5bd;
            transition: transform 0.2s;
        }

        .profile-wrapper.open .profile-chevron {
            transform: rotate(180deg);
        }

        .profile-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 10px);
            background: white;
            border-radius: 12px;
            border: 0.5px solid #e5e7eb;
            box-shadow: 0 8px 24px rgba(0,0,0,0.10);
            min-width: 210px;
            z-index: 9999;
            overflow: hidden;
            animation: dropdownFade 0.15s ease;
        }

        @keyframes dropdownFade {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .profile-dropdown.show { display: block; }

        .dropdown-header-info {
            padding: 14px 16px 10px;
            border-bottom: 0.5px solid #f0f0f0;
        }

        .dropdown-header-info p {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .dropdown-header-info small {
            color: #6c757d;
            font-size: 12px;
        }

        .dropdown-item-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 16px;
            font-size: 14px;
            color: #374151;
            text-decoration: none;
            transition: background 0.15s;
        }

        .dropdown-item-custom:hover { background: #f4f7fe; color: #2b99d6; }
        .dropdown-item-custom i { font-size: 16px; width: 18px; text-align: center; }
        .dropdown-item-custom.danger { color: #dc3545; }
        .dropdown-item-custom.danger:hover { background: #fff5f5; color: #dc3545; }

        .dropdown-divider-custom {
            height: 0.5px;
            background: #f0f0f0;
            margin: 4px 0;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="university-brand">
            <h5 class="fw-bold mb-0 text-primary">
                <i class="bi bi-mortarboard-fill"></i> ACADEMIC
            </h5>
            <small class="text-muted">
                {{ Auth::user() && Auth::user()->role === 'Admin' ? 'System Administration' : 'Staff Portal' }}
            </small>
        </div>

        <nav class="nav flex-column flex-grow-1">
            @if(Auth::user() && Auth::user()->role === 'Admin')
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('admin.staffmanagement') ? 'active' : '' }}" href="{{ route('admin.staffManagement') }}">
                    <i class="bi bi-people"></i> Staff Management
                </a>
                <a class="nav-link {{ request()->routeIs('admin.ideas') ? 'active' : '' }}" href="{{ route('admin.ideas') }}">
                    <i class="bi bi-globe2"></i> Social Media Management
                </a>

            @elseif(Auth::user() && Auth::user()->role === 'Staff')
                <a class="nav-link {{ request()->routeIs('staff.home') ? 'active' : '' }}" href="{{ route('staff.home') }}">
                    <i class="bi bi-speedometer2"></i> Home
                </a>
                <a class="nav-link {{ request()->routeIs('staff.socialMedia') ? 'active' : '' }}" href="{{ route('staff.socialMedia') }}">
                    <i class="bi bi-globe2"></i> Social Media
                </a>
                <a class="nav-link {{ request()->routeIs('staff.mySubmissions') ? 'active' : '' }}" href="{{ route('staff.mySubmissions') }}">
                    <i class="bi bi-cloud-arrow-up"></i> My Submissions
                </a>

            @elseif(Auth::user() && Auth::user()->role === 'QACoordinator')
                <a class="nav-link {{ request()->routeIs('qa_coordinator.home') ? 'active' : '' }}" href="{{ route('qa_coordinator.home') }}">
                    <i class="bi bi-speedometer2"></i> Home
                </a>
                <a class="nav-link {{ request()->routeIs('staff.socialMedia') ? 'active' : '' }}" href="{{ route('staff.socialMedia') }}">
                    <i class="bi bi-globe2"></i> Social Media
                </a>
                <a class="nav-link {{ request()->routeIs('qa_coordinator.categoryManagement') ? 'active' : '' }}" href="{{ route('qa_coordinator.categoryManagement') }}">
                    <i class="bi bi-globe2"></i> Category Management
                </a>
                <a class="nav-link {{ request()->routeIs('qa_coordinator.ideaManagement') ? 'active' : '' }}" href="{{ route('qa_coordinator.ideaManagement') }}">
                    <i class="bi bi-globe2"></i> Idea Management
                </a>

            @else
                <a class="nav-link {{ request()->routeIs('staff.home') ? 'active' : '' }}" href="{{ route('staff.home') }}">
                    <i class="bi bi-speedometer2"></i> Home
                </a>
                <a class="nav-link {{ request()->routeIs('staff.socialMedia') ? 'active' : '' }}" href="{{ route('staff.socialMedia') }}">
                    <i class="bi bi-globe2"></i> Social Media
                </a>
                <a class="nav-link {{ request()->routeIs('admin.staffmanagement') ? 'active' : '' }}" href="{{ route('admin.staffManagement') }}">
                    <i class="bi bi-people"></i> Staff Management
                </a>
            @endif
        </nav>
    </div>

    <div class="main-content">

        <div class="top-bar">
            <div class="profile-wrapper" id="profileWrapper">
                <div class="text-end me-1">
                    <p class="mb-0 fw-bold small">{{ Auth::user()->fullName ?? Auth::user()->username ?? 'System Admin' }}</p>
                    <small class="text-muted">Role: {{ Auth::user()->role ?? 'User' }}</small>
                </div>
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->fullName ?? Auth::user()->username ?? 'A' }}&background=2b99d6&color=fff"
                     class="profile-img">
                <span class="profile-chevron">&#8964;</span>

                <div class="profile-dropdown" id="profileDropdown">
                    <div class="dropdown-header-info">
                        <p>{{ Auth::user()->fullName ?? Auth::user()->username ?? 'System Admin' }}</p>
                        <small>{{ Auth::user()->email ?? '' }}</small>
                    </div>
                    <a href="{{ route('securityQuestions') }}" class="dropdown-item-custom">
                        <i class="bi bi-shield-lock"></i> Security Questions
                    </a>
                    <a href="{{ route('changePassword') }}" class="dropdown-item-custom" style="color: #2b99d6;">
                        <i class="bi bi-key"></i> Change Password
                    </a>
                    <div class="dropdown-divider-custom"></div>
                    <a href="#" class="dropdown-item-custom danger"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-left"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const profileWrapper = document.getElementById('profileWrapper');
        const profileDropdown = document.getElementById('profileDropdown');

        profileWrapper.addEventListener('click', function (e) {
            e.stopPropagation();
            profileWrapper.classList.toggle('open');
            profileDropdown.classList.toggle('show');
        });

        document.addEventListener('click', function () {
            profileWrapper.classList.remove('open');
            profileDropdown.classList.remove('show');
        });
    </script>

</body>
</html>