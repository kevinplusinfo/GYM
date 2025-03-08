@extends('Customer.layout.main')
@section('title')Gallery @endsection
@section('styles')
<link href="{{ asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css') }}" rel="stylesheet">
<style>
    .error { color: red; font-weight: normal!important; }
    #reportrange { cursor: pointer; }
    .daterangepicker .calendar th, .daterangepicker .calendar td { font-family: monospace!important; }
    .badge { font-size: 15px; cursor: pointer; }
    th, td { text-align: center; }
</style>
@endsection
@section('content')
<div class="gallery-section gallery-page">
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Blog's</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="blog-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 p-0">
                    @foreach($Blog as $blog)
                    <div class="blog-item">
                        <div class="bi-pic">
                            <img src="{{ Storage::url($blog->img) }}" class="img-fluid img-thumbnail" width="200" alt="Uploaded Image">
                        </div>
                        <div class="bi-text">
                            <h5><a href="./blog-details.html">{{ $blog->title }}</a></h5>
                            <ul>
                                <li>by Admin</li>
                                <li>{{ $blog->created_at }}</li>
                            </ul>
                            <p>                                 
                                   {!! nl2br(e(Str::limit(strip_tags($blog->description), 350))) !!}
                            </p>
                        </div>
                    </div>
                    @endforeach
                    <div class="d-flex justify-content-center">
                        {{ $Blog->links('pagination::bootstrap-4') }} 
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 p-0">
                    <div class="sidebar-option">
                        <div class="so-tags">
                            <h5 class="title">Popular tags</h5>
                            <a href="#">Gyming</a>
                            <a href="#">Body building</a>
                            <a href="#">Yoga</a>
                            <a href="#">Weightloss</a>
                            <a href="#">Professional</a>
                            <a href="#">Stretching</a>
                            <a href="#">Cardio</a>
                            <a href="#">Karate</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
