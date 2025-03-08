@extends('admin.layout.main')
@section('title', 'class')
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
                <h1>Class</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Class</li>
                    <li class="breadcrumb-item active">Add</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        {{-- <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
            <div class="card-body"> --}}
                <form action="{{ route('class.add') }}/{{ isset($class) ? $class->id : '' }}" method="POST" enctype="multipart/form-data" id="form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12 mt-3">
                                <div class="card-header" style="background-color: rgb(200, 200, 221)">
                                    <h3 class="card-title">Title</h3>
                                </div>
                                <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input type="text" name="title" id="title" class="form-control" value="{{ isset($class) ? $class->title : '' }}" placeholder="Enter Class Title" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12 mt-3">
                                <div class="card-header" style="background-color: rgb(200, 200, 221)">
                                    <h3 class="card-title">Media</h3>
                                </div>
                                <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="img">Image</label>
                                            <input type="file" name="img" id="img" class="form-control">
                                        </div>
                                        @if (isset($class) && $class->img)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $class->img) }}" alt="Current Image" class="img-fluid" style="max-width: 200px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="card-header" style="background-color: rgb(200, 200, 221)">
                                    <h3 class="card-title">Status</h3>
                                </div>
                                <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                                    <div class="card-body">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" name="active" id="active" {{ isset($class) && $class->status == 'Active' ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="active"> Status</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12 mt-3">
                                <div class="card-header" style="background-color: rgb(205, 205, 219)">
                                    <h3 class="card-title">Social Media</h3>
                                </div>
                                <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea id="summernote" name="description" class="form-control">
                                                {{ isset($class) ? $class->description : '' }}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-right mb-3" style="background-color: #e0e4e6">
                        <a href="{{ route('class.class') }}" class="btn btn-default btn-sm">Cancel</a>
                        <button type="submit" id="submit" name="publish" class="btn btn-primary btn-sm">Save</button>
                    </div>
                </form>
            {{-- </div>
        </div> --}}
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/daterange-picker/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/daterange-picker/js/daterangepicker.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.16.4/tagify.min.js"></script>

    <script>
        $(document).ready(function () {

            $('#summernote').summernote({
                placeholder: 'Write your blog content here...',
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            $("#form").validate({
                rules: {
                    title: { required: true },
                    img: { 
                        required: function () {
                            return {{ isset($Blog) ? 'false' : 'true' }};
                        }
                    },
                    description: { required: true },
                },
                messages: {
                    title: { required: "This field is required" },
                    img: { required: "Please upload an image" },
                    description: { required: "This field is required" },
                },
                errorPlacement: function (error, element) {
                    element.closest('.form-control').after(error);
                }
            });

            $(".sidebar .nav-link").removeClass('active');
            $(".class-link").addClass('active');
        });
    </script>
@endsection
