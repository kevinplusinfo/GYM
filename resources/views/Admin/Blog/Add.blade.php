@extends('admin.layout.main')
@section('title', 'Blogs')
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
                <h1>Blog</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Blog</li>
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
        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <form action="{{ route('blog.add') }}/{{ isset($Blog) ? $Blog->id : '' }}" method="POST" enctype="multipart/form-data" id="form">
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
                                            <input type="text" name="title" id="title" class="form-control" value="{{ isset($Blog) ? $Blog->title : '' }}" placeholder="Enter Blog Title" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12 mt-3">
                                <div class="card-header" style="background-color: rgb(203, 203, 221)">
                                    <h3 class="card-title">Description</h3>
                                </div>
                                <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea id="summernote" name="description" class="form-control">
                                                {{ isset($Blog) ? $Blog->description : '' }}
                                            </textarea>
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
                                            <label for="img">Image</label>
                                            <input type="file" name="img" id="img" class="form-control">
                                        </div>
                                        @if (isset($Blog) && $Blog->img)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $Blog->img) }}" alt="Current Image" class="img-fluid" style="max-width: 200px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="card-header" style="background-color: rgb(203, 203, 221)">
                                    <h3 class="card-title">Tages</h3>
                                </div>
                                <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="tags">Tags</label>
                                            <input type="text" name="tags[]" id="tags" class="form-control" placeholder="Add Tags" required
                                                value="{{ isset($Blog) && $Blog->tags ? implode(',', $Blog->tags->pluck('tags')->toArray()) : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-right mb-3" style="background-color: #e0e4e6">
                        <a href="{{ route('blog.blog') }}" class="btn btn-default btn-sm">Cancel</a>
                        <button type="submit" id="submit" name="draft" class="btn btn-warning btn-sm">Save As Draft</button>
                        <button type="submit" id="submit" name="publish" class="btn btn-primary btn-sm">Save As Publish</button>
                    </div>
                </form>
            </div>
        </div>
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
            height: 200, 
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        var input = document.querySelector('#tags');
        var tagify = new Tagify(input, {
            whitelist: [],
            delimiters: ",",
            enforceWhitelist: false,
            originalInputValueFormat: values => values.map(item => item.value).join(',')
        });

        if ($('#hidden-tags').val()) {
            var existingTags = $('#hidden-tags').val().split(',').map(tag => ({ value: tag.trim() }));
            tagify.addTags(existingTags);
        }

        $('#form').on('submit', function () {
            var tags = tagify.value.map(tag => tag.value); 
            $('#hidden-tags').val(tags.join(',')); 
        });

        $("#form").validate({
            rules: {
                title: { required: true },
                img: {
                    required: function () {
                        return @json(!isset($Blog)); 
                    }
                },
                description: { required: true },
                tags: { required: true }
            },
            messages: {
                title: { required: "Title is required" },
                img: { required: "Please upload an image" },
                description: { required: "Description is required" },
                tags: { required: "Please add at least one tag" }
            }
        });
        $(".sidebar .nav-link").removeClass('active');
        $(".blog-link").addClass('active');
    });


    </script>

@endsection



