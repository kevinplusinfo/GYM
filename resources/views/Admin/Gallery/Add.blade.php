@extends('admin.layout.main')
@section('title') Gallery @endsection

@section('styles')
<style>
    .error { color: red; font-weight: normal !important; }
    .cursor-pointer { cursor: pointer; }
    
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
                    <li class="breadcrumb-item"><a href="{{route('dashbord')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('gallery.gallery')}}">Gallery</a></li>
                    <li class="breadcrumb-item active">Add</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body">
                <form id="gallery-form" action="{{ route('gallery.uplode') }}/{{ isset($Gallery) ? $Gallery->id : '' }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ isset($Gallery) ? $Gallery->id : '' }}">
                    <input type="hidden" name="uploaded_image" id="uploadedImagePath" value="{{ isset($Gallery) ? $Gallery->img : '' }}">

                    <div class="mb-3">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
                    
                        <div class="mt-2 image-container">
                            @if (!empty($Gallery) && !empty($Gallery->img))
                                <img id="preview-image" src="{{ asset('storage/' . $Gallery->img) }}" width="300" alt="Current Image" class="img-fluid">
                            @endif
                        </div>
                    </div>
                    
                    
                    <div class="mb-3">
                        <label for="alt">Alt Text</label>
                        <input type="text" name="alt" class="form-control" id="alt" value="{{ isset($Gallery) ? $Gallery->alt : '' }}" placeholder="Enter alt text">
                    </div>

                    <div class="text-right mb-3 mt-3">
                        <button type="submit" id="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>            
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function () {
   
    $(document).ready(function(){
        $(".sidebar .nav-link").removeClass('active');
        $(".gallery-link").addClass('active');
    });
});
</script>
@endsection
