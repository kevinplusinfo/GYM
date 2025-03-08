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
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Plans</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Palne</li>
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
            <a href="{{route('plan.form')}}" class="btn btn-primary btn-sm">Add Plans ⚙️</a>
        </div><br>
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
                                <th>Status</th>    
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($plans as $plan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $plan->name }}</td>
                                <td>{{ $plan->description }}</td>
                                <td>{{ $plan->duration }}</td>
                                <td>{{ $plan->price }}</td>
                                <td>
                                    @if(isset($planFeatures[$plan->id]) && $planFeatures[$plan->id]->isNotEmpty())
                                        @foreach($planFeatures[$plan->id] as $feature)
                                            <span class="badge bg-info">{{ $feature->name }}</span>
                                        @endforeach
                                    @else
                                        <span>No Features</span>
                                    @endif
                                </td>
                                <td>{{ $plan->payment_type }}</td>
                                <td>{{ $plan->status }}</td>
                                <td>
                                    <a href="{{ route('plan.update', $plan->id) }}"><i class="far fa-edit text-success"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('plan.delete', $plan->id) }}" onclick="return confirm('Are you sure you want to delete this plan?')">
                                        <i class="fas fa-trash text-danger"></i>
                                    </a>
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
        $(".plan-link").addClass('active');
    </script>
@endsection
