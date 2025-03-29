@extends('Customer.layout.main')
@section('title', 'Health')

@section('content')

<!-- Breadcrumb Section -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb-bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb-text">
                    <h2>Health</h2>
                    <div class="bt-option">
                        <a href="{{ route('index.gallery') }}">Home</a>
                        <span>Health Plans</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Health Plans Section -->
<section class="pricing-section spad bg-black text-white">
    <div class="container">
        <h2 class="text-center mb-4">Generated Health Plans</h2>

        <div class="row">
            @if(is_array($plan->plans) && count($plan->plans) > 0)
                @foreach($plan->plans as $plan_name => $details)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card bg-dark text-white border-light shadow-lg">
                            <div class="card-header text-center bg-secondary">
                                <h4 class="mb-0 text-white">{{ ucfirst(str_replace('_', ' ', $plan_name)) }}</h4>
                            </div>
                            <div class="card-body">
                                
                                <!-- Workout Plan -->
                                @if(isset($details['exercise']) && is_array($details['exercise']))
                                    <h5 class="text-success">Workout Plan</h5>
                                    <ul class="list-group list-group-flush">
                                        @foreach($details['exercise'] as $day => $workout)
                                            <li class="list-group-item bg-dark text-white border-light">
                                                <strong>{{ ucfirst($day) }}:</strong> 
                                                <p class="mb-0">{{ is_string($workout) ? $workout : 'N/A' }}</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                                <!-- Diet Plan -->
                                @if(isset($details['diet']) && is_array($details['diet']))
                                    <h5 class="text-danger mt-3">Diet Plan</h5>
                                    <ul class="list-group list-group-flush">
                                        @foreach($details['diet'] as $meal_time => $meal)
                                            <li class="list-group-item bg-dark text-white border-light">
                                                <strong>{{ ucfirst($meal_time) }}:</strong>
                                                <p class="mb-0">{{ is_string($meal) ? $meal : 'N/A' }}</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                                <!-- Add Plan Button -->
                                <div class="text-center mt-3">
                                    <button class="btn btn-primary w-100">Add Plan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center">
                    <p class="text-danger">No health plans found.</p>
                </div>
            @endif
        </div>

        <!-- Back to Dashboard Button -->
        <div class="text-center mt-4">
            <a href="{{ route('index.gallery') }}" class="btn btn-outline-light">Back to Dashboard</a>
        </div>
    </div>
</section>

@endsection
