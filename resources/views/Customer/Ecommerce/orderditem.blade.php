@extends('Customer.layout.main')

@section('content')
<div class="container">
    <h2 class="mb-4">Your Orders</h2>

    @foreach ($orders as $order)
        <div class="card mb-3">
            <div class="card-header">
                <strong>Order ID:</strong> {{ $order->id }} | 
                <strong>Total Price:</strong> ${{ number_format($order->total_price, 2) }}
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Flavor</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->name ?? 'N/A' }}</td>
                                <td>{{ $item->productFlavor->flavor->name ?? 'N/A' }}</td>
                                <td>{{ $item->productFlavorSize->weight ?? 'N/A' }} g - ${{ number_format($item->productFlavorSize->price ?? 0, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>
                                    @if ($item->product->main_image)
                                        <img src="{{ asset('storage/' . $item->product->main_image) }}" alt="Product Image" width="50">
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
@endsection
