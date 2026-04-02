<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-[#64B5F6] flex items-center justify-center min-h-screen font-sans">

    <div class="w-full max-w-sm p-6 text-center">
        <div class="mb-6">
            <div class="bg-white w-24 h-24 rounded-full mx-auto flex items-center justify-center shadow-lg">
                <i class="fa-solid fa-user text-5xl text-[#64B5F6]"></i>
            </div>
        </div>

        <h2 class="text-white text-2xl font-light tracking-widest mb-8 uppercase">User Login</h2>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="relative mb-4">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 border-r border-gray-300 my-2">
                    <i class="fa-solid fa-user text-gray-500"></i>
                </span>
                <input type="text" name="username" placeholder="Username"
                    class="w-full py-3 pl-14 pr-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-sm" required>
            </div>

            <div class="relative mb-4">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 border-r border-gray-300 my-2">
                    <i class="fa-solid fa-lock text-gray-500"></i>
                </span>
                <input type="password" name="password" placeholder="Password"
                    class="w-full py-3 pl-14 pr-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-sm" required>
            </div>

            <div class="flex items-center justify-between text-white text-sm mb-8">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="hidden peer">
                    <div class="w-5 h-5 border-2 border-white rounded-full flex items-center justify-center mr-2 peer-checked:bg-gray-600 transition">
                        <i class="fa-solid fa-check text-[10px] text-white"></i>
                    </div>
                    Remember me
                </label>
                <a href="{{ route('password.request') }}" class="hover:underline">Forgot Password?</a>
            </div>

            <button type="submit"
                class="w-full bg-white text-gray-700 font-medium py-3 rounded-lg shadow-md hover:bg-gray-100 transition duration-200 uppercase tracking-widest">
                Login
            </button>
        </form>
    </div>

</body>
</html>
