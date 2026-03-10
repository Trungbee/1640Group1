@extends('layouts.app')

@section('title', 'Sign Up')

@section('content')
    <h1 class="auth-title">Sign Up</h1>

    <form action="#" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label-custom">Username</label>
            <input type="text" name="username" class="form-control form-control-custom" style="background-color: white; border: 1px solid #ccc;">
        </div>

        <div class="mb-3">
            <label class="form-label-custom">Phone No</label>
            <input type="text" name="phone" class="form-control form-control-custom" style="background-color: white; border: 1px solid #ccc;">
        </div>

        <div class="mb-3">
            <label class="form-label-custom">Email</label>
            <input type="email" name="email" class="form-control form-control-custom" style="background-color: white; border: 1px solid #ccc;">
        </div>

        <div class="mb-3">
            <label class="form-label-custom">Password</label>
            <input type="password" name="password" class="form-control form-control-custom" style="background-color: white; border: 1px solid #ccc;">
        </div>

        <div class="mb-3">
            <label class="form-label-custom">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control form-control-custom" style="background-color: white; border: 1px solid #ccc;">
        </div>

        <div class="mb-4">
            <label class="form-label-custom">Choose role</label>
            <select name="role" class="form-control form-control-custom" style="background-color: white; border: 1px solid #ccc;">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary px-4" style="border-radius: 4px;">REGISTER</button>
        </div>
    </form>
@endsection