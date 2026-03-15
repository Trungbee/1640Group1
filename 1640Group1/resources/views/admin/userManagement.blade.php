<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Dashboard | Academic Portal</title>
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
            min-height: 580px;
        }

        /* Cột trái minh họa */
        .login-sidebar {
            background-color: #f0f7ff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            text-decoration: none;
            color: #333;
            font-size: 24px;
        }

        .illustration {
            max-width: 85%;
            height: auto;
        }

        /* Cột phải nội dung */
        .login-form-section {
            padding: 50px 60px;
        }

        .admin-badge {
            background-color: #eef6ff;
            color: #2b99d6;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* Menu Items */
        .manage-card {
            display: flex;
            align-items: center;
            padding: 18px;
            margin-bottom: 15px;
            border: 1px solid #f0f0f0;
            border-radius: 12px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
        }

        .manage-card:hover {
            border-color: #2b99d6;
            background-color: #f8fbff;
            transform: translateY(-3px);
            color: #2b99d6;
        }

        .icon-box {
            width: 45px;
            height: 45px;
            background: #f0f7ff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.3rem;
            color: #2b99d6;
        }

        .btn-home {
            color: #6c757d;
            text-decoration: none;
            font-size: 0.85rem;
            transition: 0.2s;
        }

        .btn-home:hover {
            color: #2b99d6;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="row g-0">
        <div class="col-md-6 login-sidebar d-none d-md-flex">
            <a href="{{ route('admin.home') }}" class="back-button">‹</a>
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/data-management-4346045-3614136.png" alt="Management Illustration" class="illustration">
        </div>

        <div class="col-md-6 login-form-section">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <span class="admin-badge">Admin Control</span>
                <a href="{{ route('admin.home') }}" class="btn-home"><i class="bi bi-house"></i> Home</a>
            </div>

            <div class="mb-5">
                <h3 class="fw-bold mb-1">Management</h3>
                <p class="text-muted small">Select a module to manage your portal system.</p>
            </div>

            <div class="manage-list">
                <a href="/user-list" class="manage-card">
                    <div class="icon-box">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>
                    <div>
                        <div class="fw-bold">User Directory</div>
                        <div class="small text-muted">View, edit or delete user accounts</div>
                    </div>
                </a>

                <a href="/role-permissions" class="manage-card">
                    <div class="icon-box">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Permissions</div>
                        <div class="small text-muted">Control user access levels</div>
                    </div>
                </a>

                <a href="/system-logs" class="manage-card">
                    <div class="icon-box">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <div>
                        <div class="fw-bold">System Logs</div>
                        <div class="small text-muted">Track all administrative activities</div>
                    </div>
                </a>
            </div>

            <div class="mt-5 pt-3 border-top text-center">
                <p class="text-muted extra-small" style="font-size: 0.7rem;">&copy; 2026 Academic Management System. All rights reserved.</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
