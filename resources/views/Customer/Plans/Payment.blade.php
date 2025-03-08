@extends('Customer.layout.main')

@section('title', 'Payment')

@section('content')
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb-bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb-text">
                    <h2>Complete Paym</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "{{ $key }}",
        "amount": "{{ $amount }}", 
        "currency": "INR",
        "name": "Your Company Name",
        "description": "Purchase {{ $plan->name }} Plan",
        "image": "{{ asset('assets/img/logo.png') }}",
        "order_id": "{{ $order_id }}",
        "callback_url": "{{route('customer.payment.verify')}}",
        /*"handler": function (response){
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
        },*/
        "theme": {
            "color": "#3399cc"
        }
    };

    var rzp1 = new Razorpay(options);
   
        rzp1.open();
       
</script>

@endsection
