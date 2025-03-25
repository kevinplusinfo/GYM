@extends('Customer.layout.main')

@section('content')
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb-bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb-text">
                    <h2>Order Detail</h2>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pricing-section spad" style="background-color: #000; padding: 60px 0; color: #fff;">
    <div class="container checkout-container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h2 class="mb-4 text-center font-weight-bold text-white">Your Orders</h2>
                @foreach ($orders as $order)
                    <div class="card mb-4 shadow-lg" style="border-radius: 12px; background-color: #111; color: #fff; border: 1px solid #444;">
                        <div class="card-header bg-gradient text-white text-center" style="background: linear-gradient(135deg, #ff8c00, #ff4500);">
                            <h5 class="mb-0"><strong>Order ID:</strong> {{ $order->order_no }} | <strong>Total Price:</strong> ₹{{ number_format($order->orderItems->sum('total_price')) }} </h5>
                        </div>
                        <div class="card-body" style="background-color: #222;">
                            <div class="table-responsive">
                                <table class="table table-bordered table-dark text-center">
                                    <thead class=" text-white">
                                        <tr>
                                            <th style="width: 100px;">Image</th>
                                            <th>Product</th>
                                            <th>Flavor</th>
                                            <th>Size</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderItems as $item)
                                            <tr>
                                                <td>
                                                    @if ($item->product->main_image)
                                                        <img src="{{ asset('storage/' . $item->product->main_image) }}" alt="Product Image" width="80" class="rounded border border-light">
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>{{ $item->product->title ?? 'N/A' }}</td>
                                                <td>{{ $item->productFlavor->flavor->name ?? 'N/A' }}</td>
                                                <td>{{ $item->productFlavorSize->weight ?? 'N/A' }}g</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>₹{{ number_format($item->productFlavorSize->price) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="container">
                                    <div class="row align-items-start">
                                        <div class="col-md-4">
                                            <h2 class="mb-2">Your Details</h2>
                                            <p><strong>Name:</strong> {{ $order->name }}</p>
                                            <p><strong>Email:</strong> {{ $order->email }}</p>
                                            <p><strong>Phone:</strong> {{ $order->phone }}</p>
                                        </div>
                                        <div class="col-md-8">
                                            <h3 class="mb-2">Address</h3>
                                            <p>✔ <strong>Address:</strong> {{ $order->address }}</p>
                                            <p>✔ <strong>City:</strong> {{ $order->city }}</p>
                                            <p>✔ <strong>State:</strong> {{ $order->state }}</p>
                                            <p>✔ <strong>Zipcode:</strong> {{ $order->zipcode }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <a href="{{ route('product') }}" class="btn btn-outline-warning btn-lg px-5 py-2">Back to Products</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
