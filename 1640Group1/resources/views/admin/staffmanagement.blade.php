@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="text-center fw-bold mb-4">Staff Management</h2>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <table class="table table-bordered text-center align-middle">

                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Question 1</th>
                        <th>Question 2</th>
                        <th>Question 3</th>
                        <th>Phone Number</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Data will be loaded from database -->
                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection
