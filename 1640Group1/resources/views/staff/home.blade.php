@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="bg-primary text-white p-4 rounded-3 mb-4 shadow-sm" style="background: linear-gradient(45deg, #2b99d6, #5ab7e6) !important;">
        <h3 class="fw-bold">Welcome back, {{ Auth::user()->fullName ?? Auth::user()->username ?? 'Staff' }}! 👋</h3>
        <p class="mb-0">Ready to share your brilliant ideas with the community?</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted fw-bold mb-2"><i class="bi bi-lightbulb text-warning me-1"></i> YOUR TOTAL IDEAS</h6>
                    <h2 class="fw-bold text-dark mb-3">{{ $totalIdeas }}</h2>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: {{ min(100, $totalIdeas * 10) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted fw-bold mb-2"><i class="bi bi-activity text-primary me-1"></i> GLOBAL ENGAGEMENT</h6>
                    <h2 class="fw-bold text-dark mb-3">{{ $engagementPercentage }}%</h2>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: {{ $engagementPercentage }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted fw-bold mb-2"><i class="bi bi-hand-thumbs-up text-danger me-1"></i> YOUR TOTAL VOTES</h6>
                    <h2 class="fw-bold text-success mb-3">{{ $totalMyVotes }}</h2>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-warning" style="width: {{ min(100, $totalMyVotes * 5) }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-4 text-center py-5">
        <div class="card-body">
            <i class="bi bi-inbox display-4 text-muted opacity-50 mb-3 d-block"></i>
            <h5 class="fw-bold text-dark">Have a new concept?</h5>
            <p class="text-muted mb-4">Head over to the submissions page to upload your documents.</p>
            <a href="{{ route('staff.mySubmissions') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                <i class="bi bi-arrow-right-circle me-2"></i> Go to My Submissions
            </a>
        </div>
    </div>

</div>
@endsection
