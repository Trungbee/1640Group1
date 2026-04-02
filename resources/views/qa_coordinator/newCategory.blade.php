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
            padding: 40px 60px;
        }

        .university-url {
            text-align: right;
            font-size: 0.8rem;
            color: #888;
            margin-bottom: 20px;
        }

        .form-control, .form-select {
            border: none;
            border-bottom: 2px solid #eee;
            border-radius: 0;
            padding: 8px 0;
            box-shadow: none !important;
            background: transparent;
        }

        .form-control:focus, .form-select:focus {
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
            <a href="{{ route('admin.dashboard') }}" class="back-button" title="Back to Dashboard">‹</a>
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/forgot-password-4268397-3551717.png" alt="Edit Security Questions" class="illustration">
        </div>

        <div class="col-md-6 login-form-section">
            <div class="university-url">🌐 QA Coordinator Panel</div>

            <div class="mb-4">
                <h3 class="fw-bold mb-1">Add new category</h3>
                <p class="text-muted small">Create a new category in the system.</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success py-2">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger py-2">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('createNewCategory') }}" method="POST">
                @csrf
                <div class="mb-2">
                    <label>Category Name</label>
                    <input type="text" name="name" class="form-control" placeholder="" value="{{ old('name') }}" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-create">Create Category</button>

                <div class="text-center mt-3">
                    <a href="{{ route('qa_coordinator.categoryManagement') }}" class="text-decoration-none text-muted small">Cancel and go back</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
