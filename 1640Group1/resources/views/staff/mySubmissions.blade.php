@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4"><i class="bi bi-cloud-arrow-up"></i> My Submissions</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4 mb-5">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white pt-3 pb-2 border-bottom-0">
                    <h5 class="fw-bold text-primary mb-0"><i class="bi bi-plus-circle me-2"></i>Submit New Idea</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('idea.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Idea Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter a brief title" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Description</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Explain your idea..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Select Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="" disabled selected>-- Choose a category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->categoryId }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Document Attachment</label>
                            <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx" required>
                        </div>

                        <button type="submit" class="btn btn-primary px-4 py-2 w-100 fw-bold">
                            <i class="bi bi-cloud-upload"></i> Upload Idea Now
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <h5 class="fw-bold mb-3">Quick Tips</h5>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="text-primary fw-bold"><i class="bi bi-lightbulb"></i> Effective Submission</h6>
                    <p class="text-muted small mb-0">Make sure your file is formatted correctly and doesn't exceed 10MB to ensure smooth processing.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm text-center py-4">
                <div class="card-body">
                    <i class="bi bi-shield-check text-success display-4 mb-2"></i>
                    <h6 class="fw-bold">Secure Portal</h6>
                    <p class="text-muted small mb-0">Your documents are encrypted and safely stored.</p>
                </div>
            </div>
        </div>
    </div>

    <h4 class="fw-bold mb-3"><i class="bi bi-clock-history"></i> My Submission History</h4>
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">No.</th>
                            <th>Idea Title</th>
                            <th>Category</th>
                            <th class="text-center">Status</th>
                            <th>Submitted Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($myIdeas as $key => $idea)
                        @php
                            // CHECK DEADLINE ĐỂ KHÓA NÚT SỬA
                            $deadline = \Carbon\Carbon::parse($idea->created_at)->endOfWeek();
                            $isClosed = now()->greaterThan($deadline);
                        @endphp
                        <tr>
                            <td class="ps-4 text-muted">{{ $key + 1 }}</td>
                            <td class="fw-bold text-dark text-truncate" style="max-width: 250px;">{{ $idea->title }}</td>
                            <td>
                                <span class="badge bg-info text-dark rounded-pill">{{ $idea->category->name ?? 'N/A' }}</span>
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
                                    <a href="{{ route('staff.downloadIdea', $idea->ideaId) }}" class="btn btn-sm btn-outline-primary" title="Download File">
                                        <i class="bi bi-download"></i>
                                    </a>

                                    @if($isClosed)
                                        <button class="btn btn-sm btn-outline-secondary" title="Đã khóa chỉnh sửa" disabled>
                                            <i class="bi bi-lock-fill"></i>
                                        </button>
                                    @else
                                        <a href="{{ route('staff.editIdea', $idea->ideaId) }}" class="btn btn-sm btn-outline-warning" title="Edit Idea">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-folder-x display-4 d-block mb-3 opacity-50"></i>
                                You haven't submitted any ideas yet.
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
