@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="text-center fw-bold mb-4">Topic Management</h2>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <table class="table table-bordered text-center align-middle">

                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Topic</th>
                        <th>Author</th>
                        <th>Thumbup</th>
                        <th>Thumbdown</th>
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
