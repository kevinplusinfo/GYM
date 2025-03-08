@extends('Customer.layout.main')
@section('title', 'Plans')
@section('styles')
<link href="{{asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css')}}" rel="stylesheet">
<style>
    .error { color: red; font-weight: normal!important; }
    #reportrange { cursor: pointer; }
    .daterangepicker .calendar th, .daterangepicker .calendar td { font-family: monospace!important; }
    .badge { font-size: 15px; cursor: pointer; }
    th, td { text-align: center; }
</style>
@endsection

@section('content')
    <section class="hero-section">
        <div class="gallery-section gallery-page">
            <section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb-bg.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <div class="breadcrumb-text">
                                <h2>Active Plans</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="pricing-section spad">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title">
                                <span>Our Plan</span>
                                <h2>Choose your pricing plan</h2>
                            </div>
                        </div>
                    </div>
                </div>
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
                <div class="row justify-content-center mt-4">
                    @foreach($plans as $plan)
                        <div class="col-lg-4 col-md-8 mb-4">
                            <div class="ps-item">
                                <h3>{{ $plan->name }}</h3>
                                <div class="pi-price">
                                    <h2>₹ {{ number_format($plan->price, 2) }}</h2>
                                    <span>{{ strtoupper($plan->duration) }} Month</span>
                                </div>
                                <ul>
                                    @if(isset($planFeatures[$plan->id]) && $planFeatures[$plan->id]->isNotEmpty())
                                        @foreach($planFeatures[$plan->id] as $feature)
                                            <li>{{ $feature->name }}</li>
                                        @endforeach
                                    @endif
                                </ul>
                                <div class="pi-price">
                                    <span>Payment Type : {{ $plan->payment_type }} </span>
                                </div>
                                <a href="{{ route('customer.checkout', ['id' => $plan->id]) }}" class="btn btn-primary">Enrole Now</a>
                                <a href="#" class="thumb-icon"><i class="fa fa-picture-o"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </section>
@endsection
@section('scripts')

@endsection
