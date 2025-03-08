@extends('admin.layout.main')
@section('title', 'Product')
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
                <h1>Product</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Ecom</li>
                    <li class="breadcrumb-item active">Product</li>
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
        <form action="{{ route('product.save', $product->id ?? null) }}" method="POST" enctype="multipart/form-data" id="form">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12 mt-3">
                        <div class="card-header" style="background-color: rgb(200, 200, 221)">
                            <h3 class="card-title">Info</h3>
                        </div>
                        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control"  placeholder="Enter Class Title" required value="{{  $product->title ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea id="summernote" name="description" class="form-control">
                                        {{  $product->description ?? ''}}
                                    </textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="title">Specification</label>
                                    <input type="text" name="specification" id="title" class="form-control"  placeholder="Enter Specification" required value="{{ $product->specification ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12 mt-3">
                        <div class="card-header" style="background-color: rgb(200, 200, 221)">
                            <h3 class="card-title">Media</h3>
                        </div>
                        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label>Main Image</label>
                                    <input type="file" id="mainImage" name="mainimg" class="form-control">
                                    <div id="mainImagePreview"></div>
                                    @if(isset($product) && $product->main_image)
                                        <img src="{{ Storage::url($product->main_image) }}"  class="img-fluid mt-2" style="max-width: 200px;">
                                    @endif
                                
                                    <label class="mt-4"> Images</label>
                                    <input type="file" id="additionalImages" name="images[]" class="form-control" multiple>
                                    <div id="additionalImagePreview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="card-header" style="background-color: rgb(200, 200, 221)">
                            <h3 class="card-title">Pricing & Stock & Flavore</h3>
                        </div>
                        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                            <div class="card-body">
                                <div class="card-header text-right mb-3" style="background-color: #e0e4e6">
                                    <button type="button" id="addflavore" name="addflavore" class="btn btn-primary btn-sm">Add Flavor</button>
                                </div>
                                <div id="size" class="element-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header text-right mb-3" style="background-color: #e0e4e6">
                <a href="{{ route('ecom.product') }}" class="btn btn-default btn-sm">Cancel</a>
                <button type="submit" id="submit" name="publish" class="btn btn-primary btn-sm">Save</button>
            </div>
        </form>
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

        $("#form").validate({
            rules: {
                title: { required: true },
                mainimg: { required: true },
                description: { required: true },
            },
            messages: {
                title: { required: "This field is required" },
                mainimg: { required: "Please upload an image" },
                description: { required: "This field is required" }
            },
            errorPlacement: function (error, element) {
                element.closest('.form-control').after(error);
            }
        });

        let i = 1; 
        let j = 1; 
        var flavors = "";
        let flever_index = 0;

        $(document).on('click', '#addflavore', function() {     
            let flavorHTML = `
                <div id="flavor-container-${i}" class="flavor-item">
                    <div class="row mt-2">
                        <div class="col-8 mt-3">
                            <label for="flavore">Flavor</label>
                            <select class="flavore form-control flavor-select" name="flavore[`+flever_index+`]" required>
                                <option value="">Select Flavor</option>
                                <?php foreach ($flavors as $f): ?>
                                    <option value="<?= $f->id ?>"><?= $f->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-2 mt-4">
                            <button type="button" class="btn btn-danger btn-sm remove-flavor" data-id="${i}">Remove</button>
                        </div>
                    </div>
                    <div class="detail-container mt-3 float-right" id="detail-container-${i}" style="display: none;">
                        <button type="button" class="btn btn-primary btn-sm add-detail" data-current-flewer-index="`+flever_index+`" data-id="${i}">Add Detail</button>
                        <div class="details-group" id="details-group-${i}"></div>
                    </div>
                </div>
            `;
            $(".element-container").append(flavorHTML);
            i++;
            flever_index++;     
        });

        $(document).on("change", ".flavor-select", function () {
            let parentId = $(this).closest(".flavor-item").attr("id");
            $("#" + parentId + " .detail-container").show();
        });

        let flewer_element_index = 0;
        $(document).on("click", ".add-detail", function () {
            let id = $(this).data("id");
            let current_flever_index = $(this).data('current-flewer-index');
            let detailHTML = `
                <div class="row mt-2 detail-item" id="detail-${id}-${j}">
                    <div class="col-3">
                        <label>Wieght</label>
                        <input type="text" name="weight[${current_flever_index}][`+flewer_element_index+`]" class="form-control" placeholder="Weight" required>
                    </div>
                    <div class="col-3">
                        <label>Price</label>
                        <input type="number" name="price[${current_flever_index}][`+flewer_element_index+`]" class="form-control" placeholder="Price" required>
                    </div>
                    <div class="col-3">
                        <label>QTY</label>
                        <input type="number" name="qty[${current_flever_index}][`+flewer_element_index+`]" class="form-control" placeholder="Qty" required>
                    </div>
                    <div class="col-3">
                    <label>Drop Price</label>
                        <input type="number" name="strike_price[${current_flever_index}][`+flewer_element_index+`]" class="form-control" placeholder="Qty" required>
                    </div>
                    <div class="col-3 mt-2">
                        <button type="button" class="btn btn-danger btn-sm remove-detail" data-id="${id}" data-detail="${j}">Remove</button>
                    </div>
                    <hr>
                </div>
            `;
            $("#details-group-" + id).append(detailHTML);
            j++;
            flewer_element_index++;
        });

        $(document).on("click", ".remove-flavor", function () {
            let id = $(this).data("id");
            $("#flavor-container-" + id).remove();
        });

        $(document).on("click", ".remove-detail", function () {
            let id = $(this).data("id");
            let detailId = $(this).data("detail");
            $("#detail-" + id + "-" + detailId).remove();
        });

        $('#mainImage').change(function () {
        uploadImages($(this)[0].files, 'main');
    });

    $('#additionalImages').change(function () {
        uploadImages($(this)[0].files, 'additional');
    });

    function uploadImages(files, type) {
        let formData = new FormData();
        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }
        formData.append('is_main', type === 'main');

        $.ajax({
            url: "{{ route('product.upload.images') }}",
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    let previewDiv = type === 'main' ? '#mainImagePreview' : '#additionalImagePreview';
                    $(previewDiv).empty();
                    response.paths.forEach(function (path) {
                        $(previewDiv).append(`<img src="${path}" class="img-fluid mt-2" style="max-width: 200px;">`);
                    });

                    response.paths.forEach(function (path) {
                        $('<input>').attr({
                            type: 'hidden',
                            name: type === 'main' ? 'main_image_path' : 'uploaded_images[]',
                            value: path
                        }).appendTo('form');
                    });
                }
            },
            error: function (error) {
                console.log("Upload failed", error);
            }
        });
    }

        $(".sidebar .nav-link").removeClass('active');
        $(".ecom-link").addClass('active');
    });
</script>
@endsection
