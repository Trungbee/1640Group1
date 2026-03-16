<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User | Academic Portal</title>
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

        /* Sidebar trái */
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

        /* Section Form */
        .login-form-section {
            padding: 40px 60px;
        }

        .university-url {
            text-align: right;
            font-size: 0.8rem;
            color: #888;
            margin-bottom: 20px;
        }

        .form-control {
            border: none;
            border-bottom: 2px solid #eee;
            border-radius: 0;
            padding: 8px 0;
            box-shadow: none !important;
            background: transparent;
        }

        .form-control:focus {
            border-bottom-color: #3498db;
        }

        .btn-create {
            background-color: #2b99d6;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-weight: 600;
            margin-top: 25px;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-create:hover {
            background-color: #217db3;
            transform: translateY(-2px);
        }

        label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #6c757d;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="row g-0">
        <div class="col-md-6 login-sidebar d-none d-md-flex">
            <a href="{{ Route('admin.home') }}" class="back-button" title="Back to Dashboard">‹</a>
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/adding-user-illustration-download-in-svg-png-gif-formats--new-registration-add-man-person-avatar-business-pack-illustrations-5063116.png" alt="Add User Illustration" class="illustration">
        </div>

        <div class="col-md-6 login-form-section">
            <div class="university-url">🌐 Admin Panel</div>

            <div class="mb-4">
                <h3 class="fw-bold mb-1">Add new account</h3>
                <p class="text-muted small">Create a new student or staff profile in the system.</p>
            </div>

            <form action="{{ route('createNewUser') }}" method="POST">
                @csrf

                <div class="mb-2">
                    <label>Full name</label>
                    <input type="text" name="name" class="form-control" placeholder="" required>
                </div>

                <div class="mb-2">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="example@university.edu" required>
                </div>

                <div class="mb-2">
                    <label>Initial Password</label>
                    <input type="password" name="password" class="form-control" placeholder="" required>
                </div>

                <div class="mb-2">
                    <label>Choose role</label>
                    <select name="role" class="{{ $errors->has('role') ? 'input-error' : '' }}">
                        <option value="Staff" {{ old('role') == 'Staff' ? 'selected' : '' }}>Staff</option>
                        <option value="QACoordinator" {{ old('role') == 'QACoordinator' ? 'selected' : '' }}>QA Coordinator</option>
                        <option value="QAManagement" {{ old('role') == 'QAManagement' ? 'selected' : '' }}>QA Management</option>
                    </select>
                    @error('role')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-create">Create Account</button>

                <div class="text-center mt-3">
                    <a href="/home" class="text-decoration-none text-muted small">Cancel and go back</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
