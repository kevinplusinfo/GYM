@extends('Customer.layout.main')

@section('content')
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb-bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb-text">
                    <h2>Shopping Cart</h2>
                    <div class="bt-option">
                        <a href="{{route('index.gallery')}}">Home</a>
                        <a href="{{route('product')}}">Product</a>
                        <span>Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container mt-5">
    <h2 class="text-center mb-3">Your Shopping Cart</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($cartItems->isEmpty())
        <p class="text-center">Your cart is empty.</p>
        <a href="{{route('product')}}">
            <p class="text-center">Keep Shoping</p>
        </a >
    @else
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Image</th>
                        <th>Flavor</th>
                        <th>Weight</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr>
                        <td>
                            <img src="{{ Storage::url($item->product->main_image) }}" class="img-fluid img-thumbnail" width="250">
                        </td>
                        <td>{{ $item->productFlavor->flavor->name ?? 'N/A' }}</td>
                        <td>{{ $item->productFlavorSize->weight ?? 'N/A' }}</td>
                        <td>
                            {{ $item->productFlavorSize->price ?? 'N/A' }}
                        </td>
                        <td>
                            <input type="number" class="form-control update-qty" data-id="{{ $item->id }}" value="{{ $item->qty }}" min="1" style="width:80px;">
                        </td>
                        <td>
                            {{ ($item->productFlavorSize->price ?? 0) * $item->qty }}
                        </td>
                        <td>
                        <button class="btn btn-danger btn-sm remove-item"
                            data-product-id="{{ $item->product_id }}"
                            data-flavor-id="{{ $item->productflavor_id }}"
                            data-size-id="{{ $item->productflavorsize_id }}">
                            Remove
                        </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="float-right mb-2">
                <a href="{{route('cart.checkout')}}">
                    <button class="btn btn-warning ">Checkout</button>
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $(".update-qty").on("change", function() {
            let item_id = $(this).data("id");
            let new_qty = $(this).val();
            let product_id = $(this).closest("tr").find(".remove-item").data("product-id");
            let flavor_id = $(this).closest("tr").find(".remove-item").data("flavor-id");
            let size_id = $(this).closest("tr").find(".remove-item").data("size-id");
            $.ajax({
                url: "{{ route('cart.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    qty: new_qty,
                    customer_id: "{{ auth()->id() }}",
                    product_id: product_id,
                    productflavor_id: flavor_id,
                    productflavorsize_id: size_id,
                },
                success: function(response) {

                },
                error: function(xhr) {
                    alert("Failed to update quantity. Try again.");
                }
            });
        });

    
        $(".remove-item").click(function() {
            let product_id = $(this).data("product-id");
            let flavor_id = $(this).data("flavor-id");
            let size_id = $(this).data("size-id");

            $.ajax({
                url: "{{ route('cart.remove') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: product_id,
                    productflavor_id: flavor_id,
                    productflavorsize_id: size_id
                },
                success: function(response) {
                    alert(response.message);
                    location.reload(); // Refresh the page after successful removal
                },
                error: function(xhr) {
                    alert("Failed to remove item. Try again.");
                }
            });
        });
    });
    
</script>
@endsection
