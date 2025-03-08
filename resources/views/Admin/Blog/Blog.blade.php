@extends('admin.layout.main')
@section('title')Blog @endsection
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
                <h1>Blog</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active"><a href="">Blog</a></li>
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
            <a href="{{route('blog.form')}}" class="btn btn-primary btn-sm">Add Blog</a>
        </div><br>
        <div class="card mt-3">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Tags</th>
                            <th>Stutus</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        <tbody>
                            @php $i = 1;@endphp
                            @foreach($blog as $blog)
                            <tr>
                                <td>
                                    {{ $i++ }}
                                </td>
                                <td>
                                    {{$blog->title}}

                                </td>
                                <td>
                                    <img src="{{ Storage::url($blog->img) }} " class="img-fluid img-thumbnail" width="250" alt="Uploaded Image">
                                </td>
                                
                                <td>
                                    @foreach (json_decode($blog->tags) as $tag)
                                        {{ $tag->tags }} @if (!$loop->last), @endif
                                    @endforeach
                                </td>
                                <td>
                                    {{ $blog->status == 1 ? 'Publish' : 'Draft' }}
                                </td>
                                <td>
                                    <a href="{{ route('blog.update', $blog->id) }}"><i class="far fa-edit text-success"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('blog.delete', $blog->id) }}" onclick="return confirm('Are You Sure  Delete This Medicine?')"><i class="fas fa-trash text-danger"></i></a>
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
        $(".blog-link").addClass('active');
    });
</script>
@endsection