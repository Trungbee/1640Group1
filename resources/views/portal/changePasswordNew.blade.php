<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password | Academic Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
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
            position: relative;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            text-decoration: none;
            color: #333;
            font-size: 24px;
            font-weight: bold;
        }

        .illustration {
            max-width: 85%;
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

        .form-control {
            border: none;
            border-bottom: 2px solid #eee;
            border-radius: 0;
            padding: 10px 0;
            box-shadow: none !important;
        }

        .form-control:focus {
            border-bottom-color: #3498db;
        }

        .form-control.is-invalid {
            border-bottom-color: #dc3545;
        }

        .btn-change {
            background-color: #2b99d6;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-weight: 600;
            margin-top: 30px;
            transition: 0.3s;
        }

        .btn-change:hover {
            background-color: #217db3;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="row g-0">
        <div class="col-md-6 login-sidebar d-none d-md-flex">
            <a href="{{ route('changePassword') }}" class="back-button" title="Back">‹</a>
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/forgot-password-4268397-3551717.png" alt="Set New Password Illustration" class="illustration">
        </div>

        <div class="col-md-6 login-form-section">
            <div class="university-url">🌐 www.universityname.ac.in</div>

            <div class="mb-4">
                <h3 class="fw-bold mb-2">Set new password</h3>
                <p class="text-muted small">Logged in as <strong>{{ Auth::user()->email }}</strong></p>
                <p class="text-muted small">Your new password must be at least 5 characters.</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger py-2 mb-3" role="alert">
                    <ul class="mb-0" style="padding-left: 15px; font-size: 14px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('updatePassword') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="text-muted small fw-bold">New password</label>
                    <input type="password" name="newPassword"
                        class="form-control @error('newPassword') is-invalid @enderror"
                        placeholder="Enter new password" required>
                </div>

                <div class="mb-4">
                    <label class="text-muted small fw-bold">Confirm new password</label>
                    <input type="password" name="verifyPassword"
                        class="form-control @error('verifyPassword') is-invalid @enderror"
                        placeholder="Re-enter new password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-change text-uppercase">Save New Password</button>

                <div class="text-center mt-4">
                    @php $dashboardUrl = Auth::user()->role === 'Admin' ? route('admin.home') : route('staff.home'); @endphp
                    <a href="{{ $dashboardUrl }}" class="text-decoration-none text-muted small">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
