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
                        <form id="paymentForm" action="{{ route('payment.create') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" style="color: white">Name</label>
                                <input type="text"  placeholder="Enter Name" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color: white">Email</label>
                                <input type="email" placeholder="Enter Email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color: white">Phone</label>
                                <input type="text" placeholder="Enter Phone" name="phone" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color: white">Addresh</label>
                                <textarea name="address" id="" cols="30" rows="10"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color: white">City</label>
                                <input type="text" placeholder="Enter City" name="city" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color: white">State</label>
                                <input type="text" placeholder="Enter State" name="state" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="color: white">Zipcode</label>
                                <input type="number" placeholder="Enter Zipcode" name="zipcode" required>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Proceed to Payment</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="leave-comment">
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-white text-center mb-4">Shopping Cart</h2>
                                <div class="card bg-dark text-white">
                                    <div class="card-body">
                                        @php $totalAmount = 0; @endphp
                                        
                                        <div class="row py-2 border-bottom text-center fw-bold">
                                            <div class="col-md-2">Product</div>
                                            <div class="col-md-2">Flavor</div>
                                            <div class="col-md-2">Weight</div>
                                            <div class="col-md-2">Price</div>
                                            <div class="col-md-2">Qty</div>
                                            <div class="col-md-2">Total</div>
                                        </div>
            
                                        @foreach($cartItems as $item)
                                            @php
                                                $price = $item->productFlavorSize->price ?? 0;
                                                $subtotal = $price * $item->qty;
                                                $totalAmount += $subtotal;
                                            @endphp
                                            <div class="row align-items-center py-3 border-bottom text-center">
                                                <div class="col-md-2">
                                                    <img src="{{ Storage::url($item->product->main_image) }}" 
                                                         class="img-fluid img-thumbnail" 
                                                         width="80">
                                                </div>
                                                <div class="col-md-2">
                                                    <h6>{{ $item->productFlavor->flavor->name ?? 'N/A' }}</h6>
                                                </div>
                                                <div class="col-md-2">
                                                    <h6>{{ $item->productFlavorSize->weight ?? 'N/A' }}</h6>
                                                </div>
                                                <div class="col-md-2">
                                                    <h6>₹{{ number_format($price) }}</h6>
                                                </div>
                                                <div class="col-md-2">
                                                    <h6>{{ $item->qty }}</h6>
                                                </div>
                                                <div class="col-md-2">
                                                    <h6>₹{{ number_format($subtotal) }}</h6>
                                                </div>
                                            </div>
                                        @endforeach
            
                                        <div class="row mt-4">
                                            <div class="col-md-10 text-end">
                                                <h4>Total:</h4>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <h6>₹{{ number_format($totalAmount, ) }}</h6>
                                            </div>
                                        </div>
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                    </div> 
                </div>
            </div>
            
        </div>
    </div>
</section>
@endsection


@section('scripts ')

@endsection
