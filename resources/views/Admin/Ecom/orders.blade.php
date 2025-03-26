@extends('admin.layout.main')

@section('title', 'orders')

@section('styles')
<link href="{{ asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.min.css" rel="stylesheet">

<style>
    .error {
        color: red;
        font-weight: normal !important;
    }
    #reportrange {
        cursor: pointer;
    }
    .daterangepicker .calendar th, .daterangepicker .calendar td {
        font-family: monospace !important;
    }
    .cursor-pointer {
        cursor: pointer;
    }
</style>
@endsection

@section('content-header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Product & Customer Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Products</li>
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
                <h3 class="card-title">Product & Customer Information</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Product Image</th>
                            <th>Total Amount</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($orders) && count($orders) > 0)
                            @foreach($orders as $key => $order)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->name ?? 'Guest' }}</td>
                                        <td>{{ $order->email ?? 'N/A' }}</td>
                                        <td>{{ $order->phone ?? 'N/A' }}</td>
                                        <td>
                                            @if($order->orderItems->isNotEmpty())
                                            <img src="{{ Storage::url($order->orderItems->first()->product->main_image ?? 'default.jpg') }}" width="50">

                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        
                                        <td>
                                            ₹{{ number_format($order->orderItems->sum('total_price')) }}
                                        </td>
                                    <td>
                                        {{ number_format($order->orderItems->sum('qty')) }}
                                    </td>
                                    <td>
                                        <i class="fa-solid fa-eye text-primary cursor-pointer" data-toggle="modal" data-target="#orderModal" data-id="{{ $order->id }}"></i>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" class="text-center">No Orders Found</td>
                            </tr>
                        @endif
                    </tbody>
                    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="orderModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-center" id="orderModalTitle"><b>ORDER DETAILS</b></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="orderDetails">
                                    <!-- Order details will be dynamically inserted here -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                                            
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(".sidebar .nav-link").removeClass('active');
    $(".ecom-link").addClass('active');
    $(".order-link").addClass('active');
    $(".products-menu").addClass('menu-open');

    $(document).ready(function () {
    $('i[data-toggle="modal"]').on('click', function () {
        let orderId = $(this).data('id');
        $.ajax({
            url: "{{ route('ecom.getOrderDetails') }}",
            type: "GET",
            data: { id: orderId },
            success: function (response) {
                $('#orderDetails').html(response.html);
                $('#orderModal').modal('show');
            },
        });
    });
});



</script>
@endsection
