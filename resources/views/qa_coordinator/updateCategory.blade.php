@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="text-center fw-bold mb-4">Update Category</h2>

    @if(session('success'))
        <div class="alert alert-success py-2">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger py-2">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('updateCategory',$category->categoryId) }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-2">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
            </div>

        <button type="submit" class="btn btn-primary w-100 btn-create">Update Category</button>

        <div class="text-center mt-3">
            <a href="{{ route('qa_coordinator.categoryManagement') }}" class="text-decoration-none text-muted small">Cancel and go back</a>
        </div>

</div>
@endsection
