@extends('Customer.layout.main')

@section('title', 'Health Plans')
@section('styles')
    <style>
        .custom-tab-btn {
            background-color: #222; 
            color: #fff !important;
            border: 2px solid #ff4d00; 
            border-radius: 50px; 
            padding: 12px 20px;
            margin: 5px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.4s ease-in-out;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(255, 77, 0, 0.5);
        }

        .custom-tab-btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 77, 0, 0.5), transparent);
            transition: all 0.4s ease-in-out;
        }

        .custom-tab-btn:hover::before {
            left: 100%;
        }

        .custom-tab-btn:hover {
            background: #ff4d00 !important;
            color: black !important;
            border-color: black !important;
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(255, 77, 0, 0.7);
        }

        .custom-tab-btn.active {
            background: #ff4d00 !important;
            color: black !important;
            border-color: black !important;
            box-shadow: 0 0 15px rgba(255, 77, 0, 1);
        }
    </style>
@endsection
@section('content')
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb-text">
                        <h2>Health Plan</h2>
                        <div class="bt-option">
                            <a href="{{ route('index.gallery') }}">Home</a>
                            <span>Health Plans</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pricing-section spad  text-white">
        <div class="container">
            <h2 class="text-center mb-1">Your Selected Plans</h2>
            @if(!empty($selectedPlans))
                @foreach($selectedPlans as $plan)
                    <div class="card pricing-section spad  text-white  shadow-lg">
                        <div class="card-body">
                            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab-{{ $plan['plan_no'] }}" role="tablist">
                                @foreach($plan['exercise'] as $day => $routine)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link custom-tab-btn {{ $loop->first ? 'active' : '' }}" 
                                            id="pills-{{ $plan['plan_no'] }}-{{ $day }}-tab" 
                                            data-bs-toggle="pill" 
                                            data-bs-target="#pills-{{ $plan['plan_no'] }}-{{ $day }}" 
                                            type="button" 
                                            role="tab">
                                            {{ ucfirst($day) }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content" id="pills-tabContent-{{ $plan['plan_no'] }}">
                                @foreach($plan['exercise'] as $day => $routine)
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="pills-{{ $plan['plan_no'] }}-{{ $day }}" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card bg-dark text-white p-3 mb-3">
                                                    <h5 class="text-center"><i class="fas fa-dumbbell"></i> Exercise Routine - {{ ucfirst($day) }}</h5>
                                                    <ul class="list-group">
                                                        <li class="list-group-item bg-dark text-white">🔸 <strong>Warm-Up:</strong> {{ $routine['warm_up'] ?? 'N/A' }}</li>
                                                        <li class="list-group-item bg-dark text-white">🏋️ <strong>Primary:</strong> {{ $routine['primary'] ?? 'N/A' }}</li>
                                                        <li class="list-group-item bg-dark text-white">🧘 <strong>Cool-Down:</strong> {{ $routine['cool_down'] ?? 'N/A' }}</li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card bg-dark text-white p-3 mb-3">
                                                    <h5 class="text-center"><i class="fas fa-utensils"></i> Diet Plan - {{ ucfirst($day) }}</h5>
                                                    <ul class="list-group">
                                                        <li class="list-group-item bg-dark text-white">🍳 <strong>Breakfast:</strong> {{ $plan['diet'][$day]['breakfast'] ?? 'N/A' }}</li>
                                                        <li class="list-group-item bg-dark text-white">🥗 <strong>Lunch:</strong> {{ $plan['diet'][$day]['lunch'] ?? 'N/A' }}</li>
                                                        <li class="list-group-item bg-dark text-white">🍲 <strong>Dinner:</strong> {{ $plan['diet'][$day]['dinner'] ?? 'N/A' }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center">No plans available.</p>
            @endif

            <div class="text-center mt-4">
                <a href="{{ route('index.gallery') }}" class="btn btn-outline-light">Back to Dashboard</a>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
