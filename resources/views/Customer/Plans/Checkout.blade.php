@extends('Customer.layout.main')

@section('title', 'Checkout')

@section('content')
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb-bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb-text">
                    <h2>Checkout</h2>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pricing-section spad">
    <div class="container checkout-container d-flex justify-content-center">
        <div class="row w-100">
            <div class="col-lg-6">
                <div class="leave-comment">
                    <div class="card-header text-center bg-grey">
                        <h4 class="text-black mb-0" style="color: white">Billing Information</h4>
                    </div>
                    <div class="card-body" style="border: 1px solid white">
                        <form id="paymentForm" action="{{ route('customer.payment.create') }}" method="post">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">

                            <div class="mb-3">
                                <label class="form-label" style="color: white">Name</label>
                                <input type="text"  placeholder="Name " name="name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color: white">Phone</label>
                                <input type="text" placeholder="Phone" name="phone" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color: white">Email</label>
                                <input type="email" placeholder="Email" name="email" required>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Proceed to Payment</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="leave-comment">
                    <div class="card-header text-center bg-grey" >
                        <h4 class="text-black mb-0" style="color: white">Plan Details</h4>
                    </div>
                    <div class="card-body" style="border: 1px solid white">
                        <h5 class="mb-3" style="color: white">{{ $plan->name }}</h5>
                        <p>Duration: <strong>{{ strtoupper($plan->duration) }} Month</strong></p>
                        <p>Price: <strong>₹{{ number_format($plan->price, 2) }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('scripts ')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
{{-- <script>
    var options = {
        "key": "{{ $key }}",
        "amount": "{{ $amount }}", 
        "currency": "INR",
        "name": "Your Company Name",
        "description": "Purchase {{ $plan->name }} Plan",
        "image": "{{ asset('assets/img/logo.png') }}",
        "order_id": "{{ $order_id }}",
        "handler": function (response){
            $.ajax({
                url: "{{ route('customer.payment.verify') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_order_id: response.razorpay_order_id,
                    razorpay_signature: response.razorpay_signature
                },
                success: function (data) {
                    alert("Payment successful!");
                    window.location.href = "{{ route('customer.plans.index') }}";
                },
                error: function (error) {
                    alert("Payment failed! Please try again.");
                }
            });
        },
        "theme": {
            "color": "#3399cc"
        }
    };

    var rzp1 = new Razorpay(options);
    document.getElementById('payment').onclick = function(e){
        rzp1.open();
        e.preventDefault();
    }
</script> --}}
@endsection
