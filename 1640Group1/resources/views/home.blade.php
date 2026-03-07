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
            background-color: #f4f7fe;
            margin: 0;
            display: flex;
        }

        /* Sidebar Style */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: white;
            padding: 20px;
            position: fixed;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
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
        }

        .nav-link i {
            margin-right: 12px;
            font-size: 1.2rem;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #e9f2ff;
            color: #2b99d6;
        }

        /* Main Content Style */
        .main-content {
            margin-left: 280px;
            padding: 40px;
            width: calc(100% - 280px);
        }

        .header-welcome {
            background: linear-gradient(135deg, #2b99d6, #1a7bb3);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(43, 153, 214, 0.2);
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.05);
        }

        .profile-img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }

        .top-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 30px;
            gap: 20px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="university-brand">
            <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-mortarboard-fill"></i> ACADEMIC</h5>
            <small class="text-muted">Student Management</small>
        </div>
        
        <nav class="nav flex-column flex-grow-1">
            <a class="nav-link active" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a class="nav-link" href="#"><i class="bi bi-book"></i> Courses</a>
            <a class="nav-link" href="#"><i class="bi bi-calendar-event"></i> Schedule</a>
            <a class="nav-link" href="#"><i class="bi bi-file-earmark-text"></i> Exam Result</a>
            <a class="nav-link" href="#"><i class="bi bi-person"></i> Profile</a>
        </nav>

        <div class="mt-auto">
            <a class="nav-link text-danger" href="/logout"><i class="bi bi-box-arrow-left"></i> Logout</a>
        </div>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div class="text-end me-2">
                <p class="mb-0 fw-bold small">John Doe</p>
                <small class="text-muted">Student ID: 2024001</small>
            </div>
            <img src="https://i.pravatar.cc/150?u=john" alt="Profile" class="profile-img">
        </div>

        <div class="header-welcome">
            <h2 class="fw-bold">Welcome back, John! 👋</h2>
            <p class="mb-0 opacity-75">You have 2 classes today and 1 upcoming assignment.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="text-muted small fw-bold text-uppercase">GPA Score</div>
                    <h3 class="fw-bold mt-2">3.85 / 4.0</h3>
                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 85%"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="text-muted small fw-bold text-uppercase">Attendance</div>
                    <h3 class="fw-bold mt-2">92%</h3>
                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: 92%"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="text-muted small fw-bold text-uppercase">Credits Earned</div>
                    <h3 class="fw-bold mt-2">102 / 120</h3>
                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-warning" style="width: 75%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-8">
                <h5 class="fw-bold mb-4">Upcoming Classes</h5>
                <div class="card border-0 shadow-sm p-3 mb-3">
                    <div class="d-flex justify-content-between align-items: center">
                        <div>
                            <h6 class="fw-bold mb-1">Advanced Web Development</h6>
                            <small class="text-muted"><i class="bi bi-clock"></i> 08:30 AM - 10:30 AM | Room 402</small>
                        </div>
                        <span class="badge bg-light text-primary align-self-center">In 20 mins</span>
                    </div>
                </div>
                </div>
            <div class="col-md-4">
                <h5 class="fw-bold mb-4">University News</h5>
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <p class="small text-muted mb-2">March 08, 2026</p>
                    <h6 class="fw-bold">Mid-semester break announcement</h6>
                    <a href="#" class="btn btn-sm btn-link p-0 text-decoration-none">Read more</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>