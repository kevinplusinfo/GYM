@extends('admin.layout.main')
@section('title', 'Feedback')

@section('styles')
<style>
    .error { color: red; font-weight: normal!important; }
    .feedback-card { border-radius: 10px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); }
    .feedback-header { background: #007bff; color: white; padding: 10px; border-top-left-radius: 10px; border-top-right-radius: 10px; }
    .feedback-body { padding: 15px; }
    .feedback-img { width: 80px; height: 80px; border-radius: 8px; object-fit: cover; }
    .feedback-rating { font-size: 16px; font-weight: bold; color: #ff9800; }
    .feedback-date { font-size: 14px; color: #777; }
</style>
@endsection

@section('content-header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Feedback</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashbord') }}">Home</a></li>
                    <li class="breadcrumb-item active">Feedback</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container">
    <div class="row">
        @forelse($feedbacks as $feedback)
            <div class="col-md-6">
                <div class="card feedback-card mb-4">
                    <div class="feedback-header">
                        <h5 class="mb-0">{{ $feedback->user->name ?? 'N/A' }} ({{ $feedback->user->mno ?? 'N/A' }})</h5>
                    </div>
                    <div class="feedback-body">
                        <p><strong>Feedback:</strong> {{ $feedback->description }}</p>
                        <p><strong>Suggestion:</strong> {{ $feedback->suggestion }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="feedback-rating">⭐ {{ $feedback->rating }}</span>
                            </div>
                            <div>
                                @if($feedback->img)
                                    <a href="{{ asset('storage/' . $feedback->img) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $feedback->img) }}" class="feedback-img">
                                    </a>
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </div>
                        </div>
                        <p class="feedback-date text-right mt-2">{{ $feedback->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12 text-center">
                <p class="text-muted">No feedback available.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $(".sidebar .nav-link").removeClass('active');
        $(".feedback-link").addClass('active');
    });
</script>
@endsection