@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h2 class="text-center fw-bold mb-4">Category Management</h2>

    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <a href="{{ route('qa_coordinator.newCategory') }}">Create new Category   </a>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">No.</th>
                            <th>Category name</th>
                            <th>Idea count</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $key => $category)
                        <tr>
                            <td class="ps-4 text-muted">{{ $key + 1 }}</td>

                            <td>
                                <span class="badge bg-info text-dark rounded-pill" style="font-size: 0.7rem;">{{ $category->name ?? 'N/A' }}</span>
                            </td>

                                <@php
                                    $ideaCount = App\Models\Idea::where('categoryId', $category->categoryId)->count();
                                @endphp

                            <td class="ps-4 text-muted">
                                {{ $ideaCount }}
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    <form action="{{ route('qa_coordinator.deleteCategory', $category->categoryId) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Idea">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox display-4 d-block mb-3 opacity-50"></i>
                                No ideas submitted yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>

@endsection
