@extends('layouts.app')

@section('content')
<style>
    .idea-card {
        max-width: 500px;
        margin: auto;
        border-radius: 20px;
        transition: transform 0.2s;
    }
    .idea-card:hover {
        transform: translateY(-2px);
    }
    .idea-card .card-body {
        min-height: 300px;
    }
    /* Highlight comment */
    .newest-comment {
        border-left: 4px solid #007bff !important;
        background-color: #f8f9fa;
    }
    .comments-list {
        max-height: 300px;
        overflow-y: auto;
        scrollbar-width: thin;
    }
</style>

<div class="container-fluid">
    <!-- MENU -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h3 class="fw-bold mb-0"><i class="bi bi-globe2 text-primary"></i> Social Media List</h3>

        <div class="btn-group shadow-sm bg-white rounded" role="group" aria-label="Sort Ideas">
            <a href="{{ route('staff.socialMedia', ['sort' => 'latest']) }}"
               class="btn {{ (!isset($sort) || $sort == 'latest') ? 'btn-primary fw-bold' : 'btn-outline-primary' }}">
               <i class="bi bi-clock-history me-1"></i> Latest Ideas
            </a>

            <a href="{{ route('staff.socialMedia', ['sort' => 'popular']) }}"
               class="btn {{ (isset($sort) && $sort == 'popular') ? 'btn-primary fw-bold' : 'btn-outline-primary' }}">
               <i class="bi bi-fire me-1"></i> Most Popular
            </a>

            <a href="{{ route('staff.socialMedia', ['sort' => 'viewed']) }}"
               class="btn {{ (isset($sort) && $sort == 'viewed') ? 'btn-primary fw-bold' : 'btn-outline-primary' }}">
               <i class="bi bi-eye me-1"></i> Most Viewed
            </a>

            <a href="{{ route('staff.socialMedia', ['sort' => 'comments']) }}"
               class="btn {{ (isset($sort) && $sort == 'comments') ? 'btn-primary fw-bold' : 'btn-outline-primary' }}">
               <i class="bi bi-chat-dots me-1"></i> Latest Comments
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            @forelse($ideas as $idea)
                <div class="card border-0 shadow-sm mb-4 rounded-4 idea-card" data-idea-id="{{ $idea->ideaId }}">
                    <div class="card-body p-4 text-center">


                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center text-start">
                                @if($idea->is_anonymous)
                                    <img src="https://ui-avatars.com/api/?name=A&background=333&color=fff" class="rounded-circle me-3 shadow-sm" width="50" height="50">
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-incognito text-secondary"></i> Anonymous User</h6>
                                        <small class="text-muted d-block">{{ $idea->created_at->diffForHumans() }}</small>
                                    </div>
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ $idea->user->fullName ?? 'U' }}&background=random" class="rounded-circle me-3 border shadow-sm" width="50" height="50">
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">{{ $idea->user->fullName ?? 'Unknown Staff' }}</h6>
                                        <small class="text-muted d-block">{{ $idea->created_at->diffForHumans() }}</small>
                                    </div>
                                @endif
                            </div>

                            <a href="{{ route('staff.downloadIdea', $idea->ideaId) }}" class="btn btn-outline-primary rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>

                        <div class="mb-3 text-start">
                            <h5 class="fw-bold text-primary">{{ $idea->title }}</h5>
                            <p class="text-secondary mb-0" style="white-space: pre-wrap; font-size: 0.95rem;">{{ Str::limit($idea->description, 300) }}</p>
                        </div>

                        @php
                            $myVote = $myReactions[$idea->ideaId] ?? null;
                            $deadline = \Carbon\Carbon::parse($idea->created_at)->endOfWeek();
                            $isVoteClosed = now()->greaterThan($deadline);
                        @endphp

                        <div class="mb-3">
                            @if($isVoteClosed)
                                <span class="badge bg-danger mb-1 px-3 py-2 rounded-pill shadow-sm"><i class="bi bi-lock-fill"></i> Voting Closed</span>
                            @else
                                <span class="badge bg-success mb-1 px-3 py-2 rounded-pill shadow-sm"><i class="bi bi-unlock-fill"></i> Voting Open</span>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between mt-3 gap-2">
                            <button onclick="toggleReaction({{ $idea->ideaId }}, 'upvote', this)" class="btn {{ $myVote === true ? 'btn-primary' : 'btn-outline-secondary' }} w-50 rounded-pill btn-reaction" data-type="upvote" {{ $isVoteClosed ? 'disabled' : '' }}>
                                <i class="bi {{ $myVote === true ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-up' }} me-1"></i>
                                <span class="vote-count">{{ $idea->upvotes }}</span>
                            </button>

                            <button onclick="toggleReaction({{ $idea->ideaId }}, 'downvote', this)" class="btn {{ $myVote === false ? 'btn-danger' : 'btn-outline-secondary' }} w-50 rounded-pill btn-reaction" data-type="downvote" {{ $isVoteClosed ? 'disabled' : '' }}>
                                <i class="bi {{ $myVote === false ? 'bi-hand-thumbs-down-fill' : 'bi-hand-thumbs-down' }} me-1"></i>
                                <span class="vote-count">{{ $idea->downvotes }}</span>
                            </button>
                        </div>

                        <hr class="text-muted opacity-25 my-3">

                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-sm btn-link text-decoration-none fw-bold text-secondary p-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComments{{ $idea->ideaId }}">
                                <i class="bi bi-chat-dots"></i> View Comments ({{ $idea->comments->count() }})
                            </button>

                            <span class="text-muted small fw-bold">
                                <i class="bi bi-eye-fill me-1"></i> <span id="view-count-{{ $idea->ideaId }}">{{ $idea->views ?? 0 }}</span> Views
                            </span>
                        </div>

                        <div class="collapse mt-3 text-start" id="collapseComments{{ $idea->ideaId }}">
                            <div class="comments-list mb-3 px-1">
                                <!-- Display new comment to the top -->
                                @forelse($idea->comments->sortByDesc('created_at') as $comment)
                                    <div class="d-flex mb-3 p-2 rounded {{ $loop->first ? 'newest-comment shadow-sm' : 'bg-light' }}">
                                        <img src="https://ui-avatars.com/api/?name={{ $comment->is_anonymous ? 'A' : ($comment->user->fullName ?? 'U') }}&background={{ $comment->is_anonymous ? '333' : 'random' }}" class="rounded-circle me-2 border shadow-sm" width="35" height="35">
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0 fw-bold fs-6" style="font-size: 0.85rem !important;">
                                                    {{ $comment->is_anonymous ? 'Anonymous' : ($comment->user->fullName ?? 'Unknown') }}
                                                </h6>
                                                <small class="text-muted" style="font-size: 0.7rem;">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-0 small text-dark mt-1">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-muted small py-2">No comments yet. Be the first to comment!</p>
                                @endforelse
                            </div>

                            @if(!$isVoteClosed)
                                <form action="{{ route('staff.storeComment', $idea->ideaId) }}" method="POST">
                                    @csrf
                                    <div class="input-group mb-2 shadow-sm rounded-pill overflow-hidden border">
                                        <input type="text" name="content" class="form-control border-0 bg-light px-4" placeholder="Write a comment..." required>
                                        <button class="btn btn-primary px-3" type="submit"><i class="bi bi-send-fill"></i></button>
                                    </div>
                                    <div class="form-check ms-2">
                                        <input class="form-check-input" type="checkbox" name="is_anonymous" id="anonComment{{ $idea->ideaId }}" value="1">
                                        <label class="form-check-label small text-muted" for="anonComment{{ $idea->ideaId }}">Comment anonymously</label>
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-secondary py-2 text-center small mb-0 rounded-pill">
                                    <i class="bi bi-lock-fill"></i> Comments are disabled.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox display-1"></i>
                    <p class="mt-3 fs-5">No ideas found.</p>
                </div>
            @endforelse

            <div class="d-flex justify-content-center mt-4 mb-5">
                {{ $ideas->links('pagination::bootstrap-5') }}
            </div>
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
                alert("🚫 " + (errData.message || "An error occurred!"));
                throw new Error("API Error");
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
                btnUp.classList.toggle('btn-primary', btnUp.classList.contains('btn-outline-secondary'));
                btnUp.classList.toggle('btn-outline-secondary', !btnUp.classList.contains('btn-primary'));
                btnDown.classList.add('btn-outline-secondary');
                btnDown.classList.remove('btn-danger');
            } else {
                btnDown.classList.toggle('btn-danger', btnDown.classList.contains('btn-outline-secondary'));
                btnDown.classList.toggle('btn-outline-secondary', !btnDown.classList.contains('btn-danger'));
                btnUp.classList.add('btn-outline-secondary');
                btnUp.classList.remove('btn-primary');
            }
            buttonElement.disabled = false;
        })
        .catch(error => { buttonElement.disabled = false; });
    }

    document.addEventListener('DOMContentLoaded', function() {
        let options = { root: null, rootMargin: '0px', threshold: 0.5 };
        let observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    let ideaId = entry.target.getAttribute('data-idea-id');
                    if (ideaId) {
                        fetch(`/staff/idea/${ideaId}/view`, {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                let viewSpan = document.getElementById('view-count-' + ideaId);
                                if(viewSpan) viewSpan.innerText = parseInt(viewSpan.innerText) + 1;
                            }
                        });
                    }
                    observer.unobserve(entry.target);
                }
            });
        }, options);
        document.querySelectorAll('.idea-card').forEach(card => observer.observe(card));
    });
</script>
@endsection
