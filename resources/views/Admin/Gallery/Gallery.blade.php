@extends('admin.layout.main')
@section('title')Gallery @endsection
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
                <h1>Gallery</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active"><a href="#">Gallery</a></li>
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
            <a href="{{route('gallery.form')}}" class="btn btn-primary btn-sm">Add Image</a>
        </div><br>
        <div class="card mt-3">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Alt</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1;@endphp
                            @foreach($images as $image)
                            <tr>
                                <td>
                                    {{ $i++ }}
                                </td>
                                <td>
                                    <img src="{{ Storage::url($image->img) }} " class="img-fluid img-thumbnail" width="200" alt="Uploaded Image">
                                </td>
                                <td>
                                    {{$image->alt}}
                                </td>
                                <td>
                                    <a href="{{ route('gallery.update', $image->id) }}"><i class="far fa-edit text-success"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('gallery.delete', $image->id) }}" onclick="return confirm('Are You Sure  Delete This Medicine?')"><i class="fas fa-trash text-danger"></i></a>
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
        $(".gallery-link").addClass('active');
    });
</script>
@endsection