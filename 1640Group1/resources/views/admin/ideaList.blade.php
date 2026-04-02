@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4"><i class="bi bi-folder2-open"></i> Submitted Ideas Management</h3>

    <!--@if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif-->

    <div class="card border-0 shadow-sm mb-5">
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
                        @php
                            // Calculate the voting lockout period.
                            $deadline = \Carbon\Carbon::parse($idea->created_at)->endOfWeek();
                            $isClosed = now()->greaterThan($deadline);
                        @endphp
                        <tr>
                            <td class="ps-4 text-muted">{{ $key + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $idea->user->fullName ?? 'Unknown' }}</div>
                                <div class="small text-muted"><i class="bi bi-person-badge"></i> {{ $idea->user->username ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-primary text-truncate" style="max-width: 250px;">{{ $idea->title }}</div>
                                <span class="badge bg-info text-dark rounded-pill">{{ $idea->category->name ?? 'N/A' }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border me-1"><i class="bi bi-hand-thumbs-up-fill text-primary"></i> {{ $idea->upvotes }}</span>
                                <span class="badge bg-light text-dark border"><i class="bi bi-hand-thumbs-down-fill text-danger"></i> {{ $idea->downvotes }}</span>
                            </td>
                            <td class="text-center">
                                @if($isClosed)
                                    <span class="badge bg-danger rounded-pill"><i class="bi bi-lock-fill"></i> Closed</span>
                                @else
                                    <span class="badge bg-success rounded-pill"><i class="bi bi-unlock-fill"></i> Open</span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $idea->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ url('/admin/downloadIdea/' . $idea->ideaId) }}" class="btn btn-sm btn-outline-primary" title="Download File">
                                        <i class="bi bi-download"></i>
                                    </a>

                                    <a href="{{ url('/admin/deleteIdea/' . $idea->ideaId) }}" class="btn btn-sm btn-outline-danger btn-delete-idea" title="Delete Idea">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox display-4 d-block mb-3 opacity-50"></i>
                                No ideas have been submitted yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-delete-idea');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            // Get the actual URL from the button click.
            const targetUrl = this.getAttribute('href') || this.closest('form')?.getAttribute('action');
            const formElement = this.closest('form');

            // Box Alert
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to permanently delete this idea and all its related files? This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-trash"></i> Yes, delete it!',
                cancelButtonText: 'Cancel',
                backdrop: `rgba(0,0,0,0.5)`,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {

                    if (formElement) {
                        formElement.submit();
                    } else if (targetUrl) {
                        window.location.href = targetUrl;
                    }
                }
            });
        });
    });
});
</script>
@endsection
