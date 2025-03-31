


@extends('admin.layout.main')
@section('title', 'Plans')
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

@endsection

@section('content')
<div class="card mt-3">
    <div class="card-header">
        <form method="GET" action="{{ route('purchaseplan.index') }}">
            <div class="row">
                <div class="col-md-2">
                    <label for="name">Name</label>
                    <input type="search" name="name" id="name" class="form-control" 
                           placeholder="Search For Plan Name" value="{{ request()->get('name') }}">
                </div>
                <div class="col-md-2">
                    <label for="name">Price</label>
                    <input type="search" name="price" id="name" class="form-control" 
                           placeholder="Search For Plan Name" value="{{ request()->get('price') }}">
                </div>
                <div class="col-md-2">
                    <label for="duration">Duration</label>
                    <input type="search" name="duration" id="duration" class="form-control" 
                           placeholder="Search For Plan Duration" value="{{ request()->get('duration') }}">
                </div>
                <div class="col-md-2">
                    <label for="action">Action</label><br>
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card mt-3">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Duration</th>
                                <th>Price</th>
                                <th>Features</th>
                                <th>Payment Type</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ($plans as $plan)
                            <tr>
                                <td>{{ $plan->id }}</td>
                                <td>{{ $plan->name }}</td>
                                <td>{{$plan->description}}</td>
                                <td>{{$plan->duration}}</td>
                                <td>{{$plan->price}}</td>


                                <td>
                                    @if($plan->feature->isNotEmpty())
                                        <ul>
                                            @foreach ($plan->feature as $addedFeature)
                                                <li>{{ $addedFeature->feature->name ?? 'N/A' }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        No Features Added
                                    @endif
                                </td>
                                <td>{{$plan->payment_type}}</td>
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
        $(".purchaseplan-link").addClass('active');
    </script>
@endsection

