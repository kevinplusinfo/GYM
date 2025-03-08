@extends('admin.layout.main')
@section('title')Flavor @endsection
@section('styles')
    <link href="{{asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css')}}" rel="stylesheet">
    <style>
        .error{color: red;font-weight: normal!important;}
        #reportrange{cursor: pointer;}
        .daterangepicker .calendar th, .daterangepicker .calendar td{font-family: monospace!important;}
        /*#add_medicine{margin-left: 920px;}*/
        .badge{font-size: 15px;cursor: pointer}
        th,td{text-align: center;}
        
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
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item"><a href="">Ecom</a></li>
                        <li class="breadcrumb-item active"><a href="">Flavor</a></li>
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
                <a href="{{ route('flavors.form') }}" class="btn btn-primary btn-sm">Add Flavor</a>
            </div><br>
            {{-- @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif --}}

            <div class="card mt-3">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Flavor Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($flavors as $flavor)
                                <tr>
                                    <td>{{ $flavor->id }}</td>
                                    <td>{{ $flavor->name }}</td>
                                    <td>
                                        <a href="{{ route('flavors.form', $flavor->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('flavors.destroy', $flavor->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
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
     $("#precaution").val("{{@$_GET['precaution']}}");
     $(document).ready(function(){
        $(".sidebar .nav-link").removeClass('active');
        $(".ecom-link").addClass('active');
    });
</script>
@endsection