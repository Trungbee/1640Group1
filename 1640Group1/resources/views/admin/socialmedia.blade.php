@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="text-center fw-bold mb-4">Social media management</h2>

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

                    <tr>
                        <td>1</td>
                        <td>Math Study Tips</td>
                        <td>John</td>
                        <td>15</td>
                        <td>2</td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>History Timeline</td>
                        <td>Anna</td>
                        <td>10</td>
                        <td>1</td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>English Grammar</td>
                        <td>Mike</td>
                        <td>18</td>
                        <td>3</td>
                    </tr>

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection