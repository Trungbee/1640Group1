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

                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>Admin</td>
                        <td>john@example.com</td>
                        <td>******</td>
                        <td>Pet name?</td>
                        <td>Mother name?</td>
                        <td>Birth city?</td>
                        <td>0123456789</td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Anna Smith</td>
                        <td>Staff</td>
                        <td>anna@example.com</td>
                        <td>******</td>
                        <td>First school?</td>
                        <td>Best friend?</td>
                        <td>Favorite teacher?</td>
                        <td>0987654321</td>
                    </tr>

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection