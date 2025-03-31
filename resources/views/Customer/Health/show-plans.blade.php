@extends('Customer.layout.main')

@section('title', 'Health Plan')

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

<section class="pricing-section spad bg-dark text-white">
    <div class="container">
        <h2 class="text-center mb-4">Your Weekly Health Plan</h2>

        @if(!empty($plans) && is_array($plans))
            @foreach($plans as $planNo => $planDetails)
                <div class="card bg-secondary text-white border-light shadow-lg mb-4">
                    <div class="card-header text-center">
                        <h3 class="text-warning">Plan {{ $planNo }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('select.health.plan') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            <input type="hidden" name="plan_no" value="{{ $planNo }}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-white">
                                            <thead>
                                                <tr class="bg-dark text-center">
                                                    <th width="20%">Day</th>
                                                    <th width="40%">Exercise</th>
                                                    <th width="40%">Diet</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($planDetails['exercise'] as $day => $exercise)
                                                    <tr>
                                                        <td class="text-center"><strong>{{ ucfirst($day) }}</strong></td>
                                                        <td>
                                                            <ul class="mb-0">
                                                                @foreach((array) $exercise as $workout)
                                                                    <li>{{ $workout }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            <ul class="mb-0">
                                                                @foreach($planDetails['diet'][$day] ?? [] as $mealType => $meal)
                                                                    <li>
                                                                        <strong>{{ ucfirst($mealType) }}:</strong> 
                                                                        {{ is_array($meal) ? implode(', ', $meal) : $meal }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <label class="mr-2">
                                    <input type="checkbox" name="ischeck" class="form-controler"> Push Notification
                                </label>
                                <button type="submit" class="btn btn-warning ml-5">Select Plan {{ $planNo }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-center text-danger">No plans available.</p>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('index.gallery') }}" class="btn btn-outline-light">Back to Dashboard</a>
        </div>
    </div>
</section>

@endsection
