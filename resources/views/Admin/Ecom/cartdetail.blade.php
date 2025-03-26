@extends('admin.layout.main')

@section('title', 'Cart Details')

@section('styles')
<style>
    .error { color: red; font-weight: normal !important; }
    .cursor-pointer { cursor: pointer; }
    .table th, .table td { vertical-align: middle; }
</style>
@endsection

@section('content-header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cart Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Cart</li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Customer Cart Information</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Total Quantity</th>
                            <th>Total Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($cartItems) && count($cartItems) > 0)
                            @php
                                $overallTotalQty = 0;
                                $overallTotalPrice = 0;
                            @endphp

                            @foreach($cartItems->groupBy('customer_id') as $key => $customerCart)
                                @php
                                    $totalQty = $customerCart->sum('qty');
                                    $totalPrice = $customerCart->sum(function($cart) {
                                        return $cart->qty * $cart->productFlavorSize->price;
                                    });

                                    $overallTotalQty += $totalQty;
                                    $overallTotalPrice += $totalPrice;
                                    $i = 1;
                                @endphp
                                
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $customerCart->first()->customer->name ?? 'Guest' }}</td>
                                    <td>{{ $customerCart->first()->customer->email ?? 'N/A' }}</td>
                                    <td>{{ $customerCart->first()->customer->mno ?? 'N/A' }}</td>
                                    <td>{{ $totalQty }}</td>
                                    <td>₹{{ number_format($totalPrice, 2) }}</td>
                                    <td>
                                        <i class="fa-solid fa-eye text-primary cursor-pointer" 
                                           data-toggle="modal" 
                                           data-target="#cartModal" 
                                           data-customer="{{ $customerCart->first()->customer_id }}">
                                        </i>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">No Cart Items Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="cartModalTitle"><b>Cart Details</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="cartDetails">
                <!-- Cart details will be dynamically inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('i[data-toggle="modal"]').on('click', function () {
            let customerId = $(this).data('customer');
            $.ajax({
                url: "{{ route('admin.cart.details') }}",
                type: "GET",
                data: { customer_id: customerId },
                success: function (response) {
                    $('#cartDetails').html(response.html);
                    $('#cartModal').modal('show');
                },
            });
        });
    });
    $(".sidebar .nav-link").removeClass('active');
    $(".ecom-link").addClass('active');
    $(".cart-link").addClass('active');
    $(".category-menu").addClass('menu-open');
</script>
@endsection
