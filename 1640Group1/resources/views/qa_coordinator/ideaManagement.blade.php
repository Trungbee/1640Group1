@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4"><i class="bi bi-folder2-open"></i> Submitted Ideas Management</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">No.</th>
                            <th>Staff Info</th>
                            <th>Idea Title & Category</th>
                            <th class="text-center">Reactions</th>
                            <th class="text-center">Status</th>
                            <th>Submitted Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ideas as $key => $idea)
                        <tr>
                            <td class="ps-4 text-muted">{{ $key + 1 }}</td>

                            <td>
                                <div class="fw-bold text-dark">{{ $idea->user->fullName ?? $idea->user->username ?? 'Unknown' }}</div>
                                <small class="text-muted"><i class="bi bi-person-badge"></i> {{ $idea->user->username ?? 'N/A' }}</small>
                            </td>

                            <td>
                                <div class="fw-bold text-primary mb-1 text-truncate" style="max-width: 200px;" title="{{ $idea->title }}">{{ $idea->title }}</div>
                                <span class="badge bg-info text-dark rounded-pill" style="font-size: 0.7rem;">{{ $idea->category->name ?? 'N/A' }}</span>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-light text-dark border me-1 px-2 py-1" title="Thumbs Up">
                                    <i class="bi bi-hand-thumbs-up-fill text-primary"></i> {{ $idea->upvotes }}
                                </span>
                                <span class="badge bg-light text-dark border px-2 py-1" title="Thumbs Down">
                                    <i class="bi bi-hand-thumbs-down-fill text-danger"></i> {{ $idea->downvotes }}
                                </span>
                            </td>

                            @php
                                $deadline = \Carbon\Carbon::parse($idea->created_at)->endOfWeek();
                                $isVoteClosed = now()->greaterThan($deadline);
                            @endphp
                            <td class="text-center">
                                @if($isVoteClosed)
                                    <span class="badge bg-danger rounded-pill"><i class="bi bi-lock-fill"></i> Closed</span>
                                @else
                                    <span class="badge bg-success rounded-pill"><i class="bi bi-unlock-fill"></i> Open</span>
                                @endif
                            </td>

                            <td class="small text-muted">
                                {{ $idea->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.download', $idea->ideaId) }}" class="btn btn-sm btn-outline-primary" title="Download File">
                                        <i class="bi bi-download"></i>
                                    </a>

                                    <form action="{{ route('admin.deleteIdea', $idea->ideaId) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn XÓA VĨNH VIỄN bài đăng này cùng các dữ liệu/file liên quan không?');">
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
@endsection
