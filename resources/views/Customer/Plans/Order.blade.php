@extends('Customer.layout.main')

@section('title', 'Your Order')

@section('styles')
<link href="{{ asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css') }}" rel="stylesheet">
<style>
    body {
        background-color: #121212; /* Dark background */
        color: #f1f1f1; /* Light text for contrast */
    }

    

    .order-card {
        background: #1e1e1e; /* Dark card */
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(255, 255, 255, 0.1);
        padding: 25px;
        margin-top: 30px;
        color: #fff;
    }

    .order-card h2 {
        font-size: 22px;
        font-weight: 600;
        color: #f8b400;
        margin-bottom: 15px;
        border-bottom: 2px solid #f8b400;
        display: inline-block;
        padding-bottom: 5px;
    }

    .order-card p {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .badge-status {
        font-size: 14px;
        padding: 5px 10px;
        border-radius: 5px;
        color: #fff;
    }

    .badge-paid { background: #28a745; }
    .badge-pending { background: #ffc107; color: #121212; }
    .badge-failed { background: #dc3545; }

    .plan-card {
        background: #2a2a2a;
        padding: 20px;
        border-radius: 8px;
        margin-top: 20px;
        border-left: 5px solid #f8b400;
    }

    .plan-features {
        list-style-type: none;
        padding-left: 0;
    }

    .plan-features li {
        font-size: 14px;
        background: #383838;
        padding: 8px 12px;
        margin-bottom: 5px;
        border-radius: 5px;
        color: #fff;
    }

    @media (max-width: 768px) {
        .order-card {
            padding: 20px;
        }
    }
</style>
@endsection

@section('content')
<section class="hero-section">
    <div class="gallery-section gallery-page">
        <section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb-bg.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="breadcrumb-text" >
                            <h1 style="color: white">YOUR ORDER</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="container mb-5">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="order-card">
                    <h2>Order Details</h2>
                    <p><strong>Order ID:</strong> {{ $order->id }}</p>
                    <p><strong>Payment Status:</strong> 
                        <span class="badge 
                            @if($order->status == 'Paid') badge-paid 
                            @elseif($order->status == 'Pending') badge-pending 
                            @else badge-failed 
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <p><strong>Amount Paid:</strong> ₹{{ number_format($order->amount, 2) }}</p>

                    @if($order->plan)
                        <div class="plan-card">
                            <h2>Plan Details</h2>
                            <p><strong>Plan Name:</strong> {{ $order->plan->name }}</p>
                            <p><strong>Plan Price:</strong> ₹{{ number_format($order->plan->price, 2) }}</p>
                            <p><strong>Description:</strong> {{ $order->plan->description }}</p>

                            <h3>Plan Features</h3>
                            <ul class="plan-features">
                                @foreach($order->plan->feature as $feature)
                                    <li>✔ {{ $feature->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <p>No plan details available.</p>
                    @endif
                    <div class="text-right mb-3 mt-3">
                        <a href="{{route('plan')}}">
                            <button type="submit" id="submit" class="btn btn-warning btn-sm">Back</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
