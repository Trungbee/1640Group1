@extends('layouts.app')
@section('title', 'Login')

@section('content')
    <h1 class="auth-title">Login</h1>

    <form action="#" method="POST">
        @csrf
        <div class="mb-4">
            <label class="form-label-custom">Email</label>
            <input type="email" name="email" class="input-grey" placeholder="Enter your username" required>
        </div>

        <div class="mb-2">
            <label class="form-label-custom">Password</label>
            <input type="password" name="password" class="input-grey" required>
        </div>

        <div class="text-end mb-4">
            <a href="/forgotPassword" class="link-custom">Forgot Password?</a>
        </div>

        <div class="text-center">
            <button type="submit" class="btn-outline-dark-custom">Login</button>
        </div>
    </form>
@endsection