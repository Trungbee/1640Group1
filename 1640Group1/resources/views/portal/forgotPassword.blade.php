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
            max-width: 80%;
            height: auto;
        }

        /* Section Form */
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

        /* Nút Send Code nhỏ gọn */
        .btn-send-code {
            font-size: 0.75rem;
            padding: 5px 12px;
            border-radius: 20px;
            white-space: nowrap;
            height: fit-content;
            align-self: flex-end;
            margin-bottom: 5px;
        }

        .btn-verify {
            background-color: #2b99d6;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-weight: 600;
            margin-top: 30px;
            transition: 0.3s;
        }

        .btn-verify:hover {
            background-color: #217db3;
        }

        .instruction-text {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="row g-0">
        <div class="col-md-6 login-sidebar d-none d-md-flex">
            <a href="login" class="back-button">‹</a>
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/forgot-password-mobile-4268413-3551733.png" alt="Forgot Password Illustration" class="illustration">
        </div>

        <div class="col-md-6 login-form-section">
            <div class="university-url">🌐 www.universityname.ac.in</div>
            
            <div class="mb-4">
                <h3 class="fw-bold mb-2">Retrieve password</h3>
                <p class="instruction-text">Enter your email to receive a 6-digit verification code.</p>
            </div>

            <form action="newPassword" method="GET">
                <div class="mb-4">
                    <label class="text-muted small fw-bold">Email address</label>
                    <div class="d-flex gap-2">
                        <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                        <button type="button" class="btn btn-outline-primary btn-send-code">Send code</button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text-muted small fw-bold">Verification Code</label>
                    <input type="text" name="code" class="form-control" placeholder="Enter Code" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-verify text-uppercase">Verify & Continue</button>
                
                <div class="text-center mt-4">
                    <a href="login" class="text-decoration-none text-muted small">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>