<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Academic Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #e9f2ff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 1000px;
            width: 95%;
            min-height: 550px;
        }

        .login-sidebar {
            background-color: #f0f7ff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .illustration {
            max-width: 90%;
            height: auto;
        }

        .login-form-section {
            padding: 50px 60px;
        }

        .university-url {
            text-align: right;
            font-size: 0.8rem;
            color: #888;
            margin-bottom: 30px;
        }

        /* Style cho các nút điều hướng chính */
        .home-menu-item {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            margin-bottom: 15px;
            border: 1px solid #eee;
            border-radius: 10px;
            text-decoration: none;
            color: #444;
            transition: 0.3s;
        }

        .home-menu-item:hover {
            background-color: #f8fbff;
            border-color: #2b99d6;
            color: #2b99d6;
            transform: translateX(5px);
        }

        .home-menu-item i {
            font-size: 1.5rem;
            margin-right: 15px;
            color: #2b99d6;
        }

        .btn-logout {
            margin-top: 20px;
            color: #dc3545;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="row g-0">
        <div class="col-md-6 login-sidebar d-none d-md-flex">
            <img src="https://tse4.mm.bing.net/th/id/OIP.Vz3Ijf4o6TBKRvx2gZiqDwHaB2?rs=1&pid=ImgDetMain&o=7&rm=3" alt="Welcome Illustration" class="illustration">
        </div>

        <div class="col-md-6 login-form-section">
            <div class="university-url">🌐 Dashboard v1.0</div>

            <div class="mb-5">
                <h3 class="fw-bold mb-1">Welcome back!</h3>
                <p class="text-muted">Academic Portal Homepage</p>
            </div>

            <div class="menu-list">
                <a href="{{ route('admin.userManagement') }}" class="home-menu-item">
                    <i class="bi bi-people"></i>
                    <div>
                        <div class="fw-bold">Manage Accounts</div>
                        <div class="small text-muted">View and edit user permissions</div>
                    </div>
                </a>

                <a href="{{ route('admin.newUser') }}" class="home-menu-item">
                    <i class="bi bi-person-plus"></i>
                    <div>
                        <div class="fw-bold">Create New User</div>
                        <div class="small text-muted">Add a new student or staff member</div>
                    </div>
                </a>

                <a href="{{ route('admin.dashboard') }}" class="home-menu-item">
                    <i class="bi bi-gear"></i>
                    <div>
                        <div class="fw-bold">Dashboard</div>
                        <div class="small text-muted">Configure portal parameters</div>
                    </div>
                </a>
            </div>

            <div class="text-center">
                <a href="{{ route('logout') }}" class="btn-logout d-inline-block"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-left"></i> Logout System
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
