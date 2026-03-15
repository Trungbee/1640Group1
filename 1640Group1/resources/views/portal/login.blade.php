<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Student Portal</title>
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
            min-height: 600px;
        }

        /* Phần bên trái: Hình ảnh/Minh họa */
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
            max-width: 100%;
            height: auto;
        }

        /* Phần bên phải: Form */
        .login-form-section {
            padding: 60px;
        }

        .university-logo {
            width: 80px;
            margin-bottom: 20px;
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

        .btn-signin {
            background-color: #2b99d6;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-weight: 600;
            margin-top: 30px;
        }

        .btn-signin:hover {
            background-color: #217db3;
        }

        .footer-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            margin-top: 20px;
        }

        .university-url {
            text-align: right;
            font-size: 0.8rem;
            color: #888;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="row g-0">
        <div class="col-md-6 login-sidebar d-none d-md-flex">
            <a href="#" class="back-button">‹</a>
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/online-education-2112443-1778939.png" alt="Illustration" class="illustration">
        </div>

        <div class="col-md-6 login-form-section">
            <div class="university-url">🌐 www.universityname.ac.in</div>

            <div class="text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/3449/3449692.png" alt="Logo" class="university-logo">
                <h4 class="fw-bold mb-1">UNIVERSITY NAME</h4>
                <p class="text-primary small fw-bold mb-4">STUDENT PANEL</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success text-center py-2" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger py-2" role="alert">
                    <ul class="mb-0" style="padding-left: 15px; font-size: 14px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="text-muted small">Email Address</label>
                    <input type="text" name="email" class="form-control" placeholder="Enter Email Address" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3 position-relative">
                    <label class="text-muted small">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <div class="footer-links">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label text-muted" for="remember">Remember me</label>
                    </div>
                    <a href="forgotPassword" class="text-decoration-none text-muted">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-signin">Sign in</button>
            </form>

            <div class="text-center mt-3">
                <span class="text-muted small">Don't have an account? </span>
                <a href="/sign-up" class="text-decoration-none small fw-bold" style="color: #2b99d6;">Sign up here</a>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
