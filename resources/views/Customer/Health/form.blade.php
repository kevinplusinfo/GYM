@extends('Customer.layout.main')
@section('title', 'Health')
@section('content')

<section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb-bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb-text">
                    <h2>Class</h2>
                    <div class="bt-option">
                        <a href="{{ route('index.gallery') }}">Home</a>
                        <span>Health</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pricing-section spad">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Oops!</strong> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="container checkout-container d-flex justify-content-center">
        
        <div class="row w-100">
            <div class="col-lg-12">
                <div class="leave-comment">
                    <div class="card-header text-center bg-grey">
                        <h4 class="text-black mb-0" style="color: white">Enter Your Details</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('generate.health.plan') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-white">Goal</label>
                                <input type="text" class="form-control" placeholder="Enter your goal" name="goal" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-white">Current Weight (kg)</label>
                                <input type="number" class="form-control" placeholder="Enter your weight" name="current_weight" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-white">Height (cm)</label>
                                <input type="number" step="0.01" class="form-control" placeholder="Enter your height" name="height" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-white">Age</label>
                                <input type="number" class="form-control" placeholder="Enter your age" name="age" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-white">Activity Level</label>
                                <select class="form-control" name="activity_level" required>
                                    <option value="Sedentary">Sedentary</option>
                                    <option value="Moderate">Moderate</option>
                                    <option value="Active">Active</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-white">Work</label>
                                <input type="text" class="form-control" placeholder="Enter your work" name="work" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-white">Daily Routine</label>
                                <textarea class="form-control" placeholder="Describe your daily routine" name="dailyroutin" ></textarea>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Get Diet Plan & Exercise</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
