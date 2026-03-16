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
            z-index: 1000;
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
            text-decoration: none;
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
            border: 2px solid #2b99d6;
        }

        .top-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 30px;
            gap: 20px;
        }

        .btn-logout-sidebar {
            color: #dc3545;
            font-weight: 600;
            padding: 12px 15px;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: 0.3s;
        }
        .btn-logout-sidebar:hover {
            background-color: #fff5f5;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="university-brand">
            <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-mortarboard-fill"></i> ACADEMIC</h5>
            <small class="text-muted">Staff Portal</small>
        </div>

        <nav class="nav flex-column flex-grow-1">
            <a class="nav-link active" href="{{ route('staff.home') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a class="nav-link" href="#"><i class="bi bi-book"></i> My Submissions</a>
            <a class="nav-link" href="{{ route('staff.authSetup') }}"><i class="bi bi-shield-lock"></i> Security Setup</a>
            <a class="nav-link" href="#"><i class="bi bi-person"></i> My Profile</a>
        </nav>

        <div class="mt-auto border-top pt-3">
            <a href="#" class="btn-logout-sidebar" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-left me-2"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div class="text-end me-2">
                <p class="mb-0 fw-bold small">{{ Auth::user()->username ?? 'Staff User' }}</p>
                <small class="text-muted">Role: {{ Auth::user()->role ?? 'Staff' }}</small>
            </div>
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->username ?? 'S' }}&background=2b99d6&color=fff" alt="Profile" class="profile-img">
        </div>

        <div class="header-welcome">
            <h2 class="fw-bold">Welcome back, {{ Auth::user()->username ?? 'Staff' }}! 👋</h2>
            <p class="mb-0 opacity-75">Ready to share your brilliant ideas with the community?</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show fw-bold shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show fw-bold shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="text-muted small fw-bold text-uppercase">Your Total Ideas</div>
                    <h3 class="fw-bold mt-2">12</h3>
                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="text-muted small fw-bold text-uppercase">Global Engagement</div>
                    <h3 class="fw-bold mt-2">85%</h3>
                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: 85%"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="text-muted small fw-bold text-uppercase">System Status</div>
                    <h3 class="fw-bold mt-2 text-success">Active</h3>
                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-warning" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-8">
                <h5 class="fw-bold mb-4"><i class="bi bi-plus-circle-fill text-primary"></i> Submit New Idea</h5>
                <div class="bg-white p-4 rounded-4 shadow-sm border">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('idea.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold">Idea Title</label>
                            <input type="text" name="title" class="form-control border-2" placeholder="Enter a brief title" value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control border-2" rows="3" placeholder="Explain your idea..." required>{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Select Category</label>
                            <select name="category_id" class="form-select border-2" required>
                                <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>-- Choose a category --</option>

                                @if(isset($categories) && count($categories) > 0)
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->categoryId ?? $cat->id }}" {{ old('category_id') == ($cat->categoryId ?? $cat->id) ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="1" {{ old('category_id') == 1 ? 'selected' : '' }}>Information Technology</option>
                                    <option value="2" {{ old('category_id') == 2 ? 'selected' : '' }}>Business</option>
                                    <option value="3" {{ old('category_id') == 3 ? 'selected' : '' }}>Design</option>
                                @endif

                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Document Attachment</label>
                            <input class="form-control border-2" type="file" name="document" accept=".doc,.docx,.pdf" required>
                            <div class="form-text mt-2 text-muted">
                                <i class="bi bi-info-circle"></i> Allowed: Word, PDF. Max size: 10MB.
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                                <i class="bi bi-cloud-upload me-2"></i> Upload Idea Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <h5 class="fw-bold mb-4">Quick Tips</h5>
                <div class="bg-white p-4 rounded-4 shadow-sm border mb-3">
                    <h6 class="fw-bold text-primary"><i class="bi bi-lightbulb"></i> Effective Submission</h6>
                    <p class="small text-muted">Make sure your file is formatted correctly and doesn't exceed 10MB to ensure smooth processing.</p>
                </div>
                <div class="bg-light p-4 rounded-4 border border-dashed text-center">
                    <i class="bi bi-shield-check text-success display-6"></i>
                    <h6 class="fw-bold mt-2">Secure Portal</h6>
                    <p class="small text-muted mb-0">Your documents are encrypted and safely stored.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
