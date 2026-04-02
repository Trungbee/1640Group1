@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="text-center fw-bold mb-4">Update User</h2>

    <form action="{{ route('updateUser',$user->userId) }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-2">
                <label>Username (Login ID)</label>
                <input type="text" name="username" class="form-control" value="{{ $user->username }}" readonly style="background-color: bisque">
            </div>
            <div class="col-md-6 mb-2">
                <label>Full Name</label>
                <input type="text" name="fullName" class="form-control" value="{{ $user->fullName }}" readonly style="background-color: bisque">
            </div>
        </div>

        <div class="mb-2">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" readonly style="background-color: bisque">
        </div>

        <div class="mb-2">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Leave empty if no change">
        </div>

        <div class="mb-2">
            <input type="checkbox" name="resetQuestion">
            <label>Reset Authentication Questions</label>
        </div>

        <div class="mb-2">
            <label>Assign Role</label>
            <select name="role" class="form-select {{ $errors->has('role') ? 'is-invalid' : '' }}" required>
                <option value="" disabled selected>Select a role</option>
                <option value="Staff" {{ $user->role == 'Staff' ? 'selected' : '' }}>Staff</option>
                <option value="QACoordinator" {{ $user->role == 'QACoordinator' ? 'selected' : '' }}>QA Coordinator</option>
                <option value="QAManager" {{ $user->role == 'QAManager' ? 'selected' : '' }}>QA Manager</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100 btn-create">Update Account</button>

        <div class="text-center mt-3">
            <a href="{{ route('admin.staffManagement') }}" class="text-decoration-none text-muted small">Cancel and go back</a>
        </div>

</div>
@endsection
