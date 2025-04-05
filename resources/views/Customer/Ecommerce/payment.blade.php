@extends('Customer.layout.main')

@section('title', 'Payment')

@section('content')
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb-bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb-text">
                    <h2>Complete Payment</h2>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var options = {
                "key": "{{config('services.razorpay.key')}}",
                "amount": "{{ $amount }}", 
                "currency": "INR",
                "name": "KVN'S GYM",
                "description": "Purchase @isset($plan) {{ $plan->name }} Plan @else Order Payment @endisset",
                "image": "{{ asset('assets/img/logo.png') }}",
                "order_id": "{{ $order_id }}",
                "callback_url": "{{ route('payment.verifay') }}",
                "theme": {
                    "color": "#3399cc"
                }
            };

            var rzp1 = new Razorpay(options);

            rzp1.open();
        });
    </script>

@endsection
