<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; background-color: #f4f6f9; }
        .signup-container { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        .signup-container h2 { margin-bottom: 25px; font-size: 28px; color: #333; }
        .form-group { text-align: left; margin-bottom: 15px; }
        .form-group label { display: block; font-size: 13px; margin-bottom: 5px; color: #555; }
        .form-group input, .form-group select { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn-register { background-color: #2b98d6; color: white; border: none; padding: 12px 30px; border-radius: 4px; cursor: pointer; font-weight: bold; margin-top: 15px; width: 100%; }
        .btn-register:hover { background-color: #2382b8; }

        /* CSS MỚI: Định dạng cho dòng thông báo lỗi và viền đỏ */
        .error-message { color: #d9534f; font-size: 12px; margin-top: 5px; display: block; font-style: italic; }
        .input-error { border-color: #d9534f !important; background-color: #fff8f8; }
    </style>
</head>
<body>

    <div class="signup-container">
        <h2>Sign Up</h2>
        <form action="/register" method="POST">
            @csrf

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username') }}" class="{{ $errors->has('username') ? 'input-error' : '' }}" required>
                @error('username')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

                        <div class="form-group">
                <label>Phone No</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="{{ $errors->has('phone') ? 'input-error' : '' }}" required>
                @error('phone')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="{{ $errors->has('email') ? 'input-error' : '' }}" required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="{{ $errors->has('password') ? 'input-error' : '' }}" required>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <div class="form-group">
                <label>Choose role</label>
                <select name="role" class="{{ $errors->has('role') ? 'input-error' : '' }}">
                    <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="qa_coordinator" {{ old('role') == 'qa_coordinator' ? 'selected' : '' }}>QA Coordinator</option>
                    <option value="qa_management" {{ old('role') == 'qa_management' ? 'selected' : '' }}>QA Management</option>
                </select>
                @error('role')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-register">REGISTER</button>
        </form>
    </div>

</body>
</html>
