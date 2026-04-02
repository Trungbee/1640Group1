@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="text-center fw-bold mb-4">Staff Management</h2>

    <a href="{{ route('admin.newUser') }}">Create new User   </a>
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <table class="table table-bordered text-center align-middle">

                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Accept terms</th>
                        <th>Question 1</th>
                        <th>Question 2</th>
                        <th>Question 3</th>
                        <th>Options</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Data will be loaded from database -->
                    @foreach($users as $user)
                        @if ($user->role!='Admin')
                        <tr>
                            <th>{{ $user->userId }}</th>
                            <th>{{ $user->fullName }}</th>
                            <th>{{ $user->role }}</th>
                            <th>{{ $user->email }}</th>
                            <th>{{ $user->acceptTerms }}</th>
                            <th>{{ $user->favorite_animal }}</th>
                            <th>{{ $user->favorite_color }}</th>
                            <th>{{ $user->child_birth_year }}</th>
                            <th>
                                {{-- Update Button --}}
                                <a href="{{ route('qa_manager.updateUser',$user->userId) }}" class="btn btn-success">
                                Update Account
                                </a>

                                {{-- Delete Button --}}
                                <a href="{{ route('qa_manager.deleteUser',$user->userId) }}" class="btn btn-danger"
                                onclick="return confirm('Delete this account will delete all associated ideas and votes. Continue?');">
                                Delete Account
                                </a>
                            </th>
                        </tr>
                        @endif
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection
