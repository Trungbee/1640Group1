@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4"><i class="bi bi-folder2-open"></i> Submitted Ideas List</h2>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">No.</th>
                            <th>Staff Name</th>
                            <th>Category</th>
                            <th>Idea Title</th>
                            <th style="max-width: 250px;">Description</th>
                            <th>File Name</th>
                            <th>Submitted Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ideas as $key => $idea)
                        <tr>
                            <td class="ps-4">{{ $key + 1 }}</td>

                            <td class="fw-bold text-primary">
                                <i class="bi bi-person-circle me-1"></i> {{ $idea->user->username ?? 'Unknown' }}
                            </td>

                            <td>
                                <span class="badge bg-info text-dark rounded-pill px-3 py-2">
                                    {{ $idea->category->name ?? 'N/A' }}
                                </span>
                            </td>

                            <td class="fw-bold text-dark">
                                {{ $idea->title }}
                            </td>

                            <td class="text-muted small" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $idea->description }}">
                                {{ \Illuminate\Support\Str::limit($idea->description, 60, '...') }}
                            </td>

                            <td class="text-secondary small">
                                <i class="bi bi-file-earmark-text me-1 text-primary"></i>
                                {{ basename($idea->filePath) }}
                            </td>

                            <td class="small">
                                {{ $idea->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td class="text-center">
                                <a href="{{ route('admin.download', $idea->ideaId) }}" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
                                    <i class="bi bi-cloud-arrow-down-fill me-1"></i> Download
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
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
