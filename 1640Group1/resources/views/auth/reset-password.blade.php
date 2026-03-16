@extends('layouts.app')

@section('title', 'Login via Phone')

@section('content')
    <h1 class="auth-title">Login</h1>

    <form action="#" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label-custom">Phone number</label>
            <div class="d-flex gap-2">
                <input type="text" name="phone" class="form-control form-control-custom w-100">
                <button type="button" class="btn btn-outline-dark" style="border-radius: 0; padding: 5px 10px; font-size: 0.9rem; white-space: nowrap;">Send code</button>
            </div>
        </div>

        <div class="mb-3">
            <input type="text" name="otp" class="form-control form-control-custom" placeholder="">
        </div>

        <p class="text-danger-custom">Your phone number or code is incorrect</p>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-outline-dark-custom">Confirm</button>
        </div>
    </form>
@endsection
