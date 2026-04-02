<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Setup | Academic Portal</title>
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

        .btn-submit {
            background-color: #2b99d6;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-weight: 600;
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background-color: #217db3;
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
            <div class="university-url">🌐 www.universityname.ac.in</div>

            <div class="mb-4">
                <h3 class="fw-bold mb-1">Set up your security question</h3>
                <p class="text-muted small">This will be used to verify your identity when you forget your password.</p>
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

            <form action="{{ route('createAuthAnswer') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="text-muted small">Choose a security question</label>
                    <select name="security_question"
                        class="form-control @error('security_question') is-invalid @enderror"
                        style="background-color: white; border: none; border-bottom: 2px solid #eee; border-radius: 0; padding: 10px 0;">
                        <option value="favorite_animal" {{ old('security_question') == 'favorite_animal' ? 'selected' : '' }}>What is your favorite animal?</option>
                        <option value="favorite_color" {{ old('security_question') == 'favorite_color' ? 'selected' : '' }}>What is your favorite color?</option>
                        <option value="child_birth_year" {{ old('security_question') == 'child_birth_year' ? 'selected' : '' }}>What is your child's birth year?</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">Your answer</label>
                    <input type="text" name="answer" value="{{ old('answer') }}"
                        class="form-control @error('answer') is-invalid @enderror"
                        required>
                </div>

                <div class="mb-3">
                    <input type="checkbox" name="term" id="term" required>
                    <label for="term" class="text-muted small ms-1">I accept the terms &amp; service</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-submit">Finish Setup</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
