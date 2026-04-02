@extends('layouts.app')

@section('content')
<style>
.idea-card {
    max-width: 500px;
    margin: auto;
    border-radius: 20px;
}

.idea-card .card-body {
    min-height: 300px;
}
</style>
<div class="container-fluid">
    <h3 class="fw-bold mb-4"><i class="bi bi-globe2"></i> Topic List</h3>

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            @forelse($ideas as $idea)
                <div class="card border-0 shadow-sm mb-4 rounded-4 idea-card">
                    <div class="card-body p-4 text-center">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ $idea->user->fullName ?? 'U' }}&background=random" class="rounded-circle me-3" width="50" height="50">
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $idea->user->fullName ?? $idea->user->username ?? 'Unknown Staff' }}</h6>
                                    <small class="text-muted">{{ $idea->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <a href="{{ route('staff.downloadIdea', $idea->ideaId) }}" class="btn btn-primary rounded-circle shadow-sm" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;" title="Download File">
                                <i class="bi bi-cloud-arrow-down-fill fs-5"></i>
                            </a>
                        </div>

                        <div class="mb-3">
                            <h5 class="fw-bold text-primary">{{ $idea->title }}</h5>
                            <p class="text-secondary mb-0" style="white-space: pre-wrap;">{{ $idea->description }}</p>
                        </div>

                        @php
                            $myVote = $myReactions[$idea->ideaId] ?? null;
                            $deadline = \Carbon\Carbon::parse($idea->created_at)->endOfWeek();
                            $isVoteClosed = now()->greaterThan($deadline);
                        @endphp

                        <div class="mb-3">
                            @if($isVoteClosed)
                                <span class="badge bg-danger mb-1 px-3 py-2 rounded-pill shadow-sm"><i class="bi bi-lock-fill"></i> Voting Closed</span>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Ended at {{ $deadline->format('H:i - d/m/Y') }}</small>
                            @else
                                <span class="badge bg-success mb-1 px-3 py-2 rounded-pill shadow-sm"><i class="bi bi-unlock-fill"></i> Voting Open</span>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Closed on Sunday ({{ $deadline->format('d/m/Y') }})</small>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button onclick="toggleReaction({{ $idea->ideaId }}, 'upvote', this)" class="btn {{ $myVote === true ? 'btn-primary' : 'btn-outline-secondary' }} w-50 me-2 rounded-pill btn-reaction" data-type="upvote" {{ $isVoteClosed ? 'disabled' : '' }}>
                                <i class="bi {{ $myVote === true ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-up' }} me-1"></i>
                                <span class="vote-count">{{ $idea->upvotes }}</span>
                            </button>

                            <button onclick="toggleReaction({{ $idea->ideaId }}, 'downvote', this)" class="btn {{ $myVote === false ? 'btn-danger' : 'btn-outline-secondary' }} w-50 ms-2 rounded-pill btn-reaction" data-type="downvote" {{ $isVoteClosed ? 'disabled' : '' }}>
                                <i class="bi {{ $myVote === false ? 'bi-hand-thumbs-down-fill' : 'bi-hand-thumbs-down' }} me-1"></i>
                                <span class="vote-count">{{ $idea->downvotes }}</span>
                            </button>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox display-1"></i>
                    <p class="mt-3">No ideas have been submitted yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    function toggleReaction(ideaId, action, buttonElement) {
        buttonElement.disabled = true;

        fetch(`/staff/react-idea/${ideaId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ action: action })
        })
        .then(async response => {
            if (!response.ok) {
                let errData = await response.json();
                // Báo lỗi bằng hộp thoại nếu cố tình can thiệp mã nguồn khi đã hết hạn
                alert("🚫 " + (errData.message || "A system error has occurred!"));
                throw new Error("Lỗi API");
            }
            return response.json();
        })
        .then(data => {
            let container = buttonElement.parentElement;
            let btnUp = container.querySelector('[data-type="upvote"]');
            let btnDown = container.querySelector('[data-type="downvote"]');

            btnUp.querySelector('.vote-count').innerText = data.upvotes;
            btnDown.querySelector('.vote-count').innerText = data.downvotes;

            if (action === 'upvote') {
                if (btnUp.classList.contains('btn-primary')) {
                    btnUp.classList.replace('btn-primary', 'btn-outline-secondary');
                    btnUp.querySelector('i').classList.replace('bi-hand-thumbs-up-fill', 'bi-hand-thumbs-up');
                } else {
                    btnUp.classList.replace('btn-outline-secondary', 'btn-primary');
                    btnUp.querySelector('i').classList.replace('bi-hand-thumbs-up', 'bi-hand-thumbs-up-fill');
                    btnDown.classList.replace('btn-danger', 'btn-outline-secondary');
                    btnDown.querySelector('i').classList.replace('bi-hand-thumbs-down-fill', 'bi-hand-thumbs-down');
                }
            } else {
                if (btnDown.classList.contains('btn-danger')) {
                    btnDown.classList.replace('btn-danger', 'btn-outline-secondary');
                    btnDown.querySelector('i').classList.replace('bi-hand-thumbs-down-fill', 'bi-hand-thumbs-down');
                } else {
                    btnDown.classList.replace('btn-outline-secondary', 'btn-danger');
                    btnDown.querySelector('i').classList.replace('bi-hand-thumbs-down', 'bi-hand-thumbs-down-fill');
                    btnUp.classList.replace('btn-primary', 'btn-outline-secondary');
                    btnUp.querySelector('i').classList.replace('bi-hand-thumbs-up-fill', 'bi-hand-thumbs-up');
                }
            }
            buttonElement.disabled = false;
        })
        .catch(error => {
            // Không mở lại nút nếu bài đã bị khóa
        });
    }
</script>
@endsection
