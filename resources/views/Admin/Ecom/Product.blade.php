@extends('admin.layout.main')

@section('title', 'Products')

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
   
</style>
@endsection

@section('content-header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Products</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Products</li>
                    <li class="breadcrumb-item active">List</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="float-right">
            <a href="{{ route('ecom.product.form') }}" class="btn btn-primary btn-sm">Add Product</a>
        </div><br>
        <div class="card mt-3">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $key => $product)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if($product->images->isNotEmpty())
                                        <img src="{{ Storage::url($product->main_image) }}" alt="Product Image" width="50">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>{{ $product->title }}</td>
                                
                                <td>
                                    <a href="{{ route('product.update', $product->id) }}" class=""><i class="far fa-edit text-success"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('product.delete', $product->id) }}" onclick="return confirm('Are You Sure  Delete This Medicine?')"><i class="fas fa-trash text-danger"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>                        
                    </table>
                </div>
            </div> 
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(".sidebar .nav-link").removeClass('active');
    $(".ecom-link").addClass('active');
</script>
@endsection
