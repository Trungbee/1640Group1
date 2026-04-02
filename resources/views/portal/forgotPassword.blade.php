<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrieve Password | Academic Portal</title>
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
            max-width: 80%;
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
            background: transparent;
        }

        .form-control:focus {
            border-bottom-color: #3498db;
        }

        .form-control.is-invalid {
            border-bottom-color: #dc3545;
        }

        .btn-verify {
            background-color: #2b99d6;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-weight: 600;
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-verify:hover {
            background-color: #217db3;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="row g-0">
        <div class="col-md-6 login-sidebar d-none d-md-flex">
            <a href="{{ route('loginPage') }}" class="back-button">‹</a>
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/forgot-password-mobile-4268413-3551733.png" alt="Forgot Password Illustration" class="illustration">
        </div>

        <div class="col-md-6 login-form-section">
            <div class="university-url">🌐 www.universityname.ac.in</div>

            <div class="mb-4">
                <h3 class="fw-bold mb-1">Retrieve password</h3>
                <p class="text-muted small">Enter your email and verify your identity to reset your password.</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger py-2 mb-3" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger py-2 mb-3" role="alert">
                    <ul class="mb-0" style="padding-left: 15px; font-size: 14px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('verifyQuestion') }}">
                @csrf

                <div class="mb-3">
                    <label class="text-muted small">Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        required>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">Security question</label>
                    <select name="security_question"
                        class="form-control @error('security_question') is-invalid @enderror"
                        style="background-color: white; border: none; border-bottom: 2px solid #eee; border-radius: 0; padding: 10px 0;">
                        <option value="favorite_animal" {{ old('security_question') == 'favorite_animal' ? 'selected' : '' }}>What is your favorite animal?</option>
                        <option value="favorite_color" {{ old('security_question') == 'favorite_color' ? 'selected' : '' }}>What is your favorite color?</option>
                        <option value="child_birth_year" {{ old('security_question') == 'child_birth_year' ? 'selected' : '' }}>What is your child's birth year?</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">Answer</label>
                    <input type="text" name="answer" value="{{ old('answer') }}"
                        class="form-control @error('answer') is-invalid @enderror"
                        required>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-verify text-uppercase">Verify & Continue</button>

                <div class="text-center mt-4">
                    <a href="{{ route('loginPage') }}" class="text-decoration-none text-muted small">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
