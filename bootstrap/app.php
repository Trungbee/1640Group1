<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth; // Thêm dòng này

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Cấu hình chuyển hướng khi đã đăng nhập (Thay thế cho RedirectIfAuthenticated)
        $middleware->redirectGuestsTo(fn () => route('loginPage'));

        $middleware->redirectUsersTo(function () {
            $user = Auth::user();
            if ($user && strtolower($user->role) === 'admin') {
                return route('admin.dashboard');
            }
            return route('staff.home');
        });

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
