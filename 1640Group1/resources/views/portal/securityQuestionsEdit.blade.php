<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Security Questions | Academic Portal</title>
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
            background: transparent;
        }

        .form-control:focus {
            border-bottom-color: #3498db;
        }

        .form-control.is-invalid {
            border-bottom-color: #dc3545;
        }

        .btn-save {
            background-color: #2b99d6;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-weight: 600;
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-save:hover {
            background-color: #217db3;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="row g-0">
        <div class="col-md-6 login-sidebar d-none d-md-flex">
            @php
                if ($isFirstSetup) {
                    $role = Auth::user()->role;

                    $cancelUrl = match($role) {
                        'Admin'         => route('admin.dashboard'),
                        'Staff'         => route('staff.home'),
                        'QACoordinator' => route('qa_coordinator.home'),
                        'QAManager'     => route('qa_manager.home'),
                        default         => route('login'), // Fallback if role is unknown
                    };
                } else {
                    $cancelUrl = route('securityQuestions');
                }
            @endphp
            <a href="{{ $cancelUrl }}" class="back-button" title="Back">‹</a>
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/forgot-password-4268397-3551717.png" alt="Edit Security Questions" class="illustration">
        </div>

        <div class="col-md-6 login-form-section">
            <div class="university-url">🌐 www.universityname.ac.in</div>

            <div class="mb-4">
                <h3 class="fw-bold mb-1">{{ $isFirstSetup ? 'Set Up Security Question' : 'Update Security Question' }}</h3>
                <p class="text-muted small">Logged in as <strong>{{ Auth::user()->email }}</strong></p>
                <p class="text-muted small">{{ $isFirstSetup ? 'Choose a security question and set your answer.' : 'Choose which question to update and enter the new answer.' }}</p>
            </div>

            @if(session('info'))
                <div class="alert alert-info py-2 mb-3" role="alert">
                    {{ session('info') }}
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

            <form action="{{ route('updateSecurityQuestions') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="text-muted small">Select question</label>
                    <select name="security_question"
                        class="form-control @error('security_question') is-invalid @enderror"
                        style="background-color: white; border: none; border-bottom: 2px solid #eee; border-radius: 0; padding: 10px 0;">
                        <option value="favorite_animal" {{ old('security_question') == 'favorite_animal' ? 'selected' : '' }}>What is your favorite animal?</option>
                        <option value="favorite_color" {{ old('security_question') == 'favorite_color' ? 'selected' : '' }}>What is your favorite color?</option>
                        <option value="child_birth_year" {{ old('security_question') == 'child_birth_year' ? 'selected' : '' }}>What is your child's birth year?</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="text-muted small">New answer</label>
                    <input type="text" name="new_answer" value="{{ old('new_answer') }}"
                        class="form-control @error('new_answer') is-invalid @enderror"
                        required>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-save text-uppercase">{{ $isFirstSetup ? 'Save Security Question' : 'Save Changes' }}</button>

                <div class="text-center mt-4">
                    <a href="{{ $cancelUrl }}" class="text-decoration-none text-muted small">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
