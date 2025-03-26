@extends('admin.layout.main')
@section('title', 'Flavor')
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
                    <h1>Flavor</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashbord')}}">Home</a></li>
                        <li class="breadcrumb-item active">Ecom</li>
                        <li class="breadcrumb-item active">Flavor</li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('flavors.save', $flavor->id ?? null) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Flavor Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $flavor->name ?? '') }}" required>
                        </div>
                        <div class="float-right">
                            <a href="{{ route('flavors.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $(".sidebar .nav-link").removeClass('active');
            $(".ecom-link").addClass('active');
            $(".flavor-link").addClass('active');
        });
    </script>
@endsection



