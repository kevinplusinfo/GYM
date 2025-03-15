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
        <form action="{{ route('product.save', ['id' => $product->id ?? null]) }}" method="POST" enctype="multipart/form-data" id="form">
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
                                @if(isset($product))
                                    @php $flavorIndex = 0; @endphp
                                    @foreach ($product->productFlavors as $key => $productFlavor)
                                        <div id="flavor-container-{{ $flavorIndex }}" class="flavor-item">
                                            <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                                                <div class="card-body">
                                                    <div class="row mt-2">
                                                        <div class="col-11 mt-3">
                                                            <label for="flavore">Flavor</label>
                                                            <div class="input-group col-9 mb-1">
                                                                <select class="flavore form-control flavor-select" name="flavore[{{ $flavorIndex }}]" required>
                                                                    <option value="">Select Flavor</option>
                                                                    @foreach ($flavors as $f)
                                                                        <option value="{{ $f->id }}" {{ $f->id == optional($productFlavor->flavor)->id ? 'selected' : '' }}>
                                                                            {{ $f->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <button type="button" class="btn btn-danger btn-sm remove-flavor" data-id="{{ $flavorIndex }}">Remove</button>
                                                             </div>
                                                        </div>
                                                    </div>
                                        
                                                    <div class="detail-container mt-3 float-right" id="detail-container-{{ $flavorIndex }}">
                                                        <button type="button" class="btn btn-primary btn-sm add-detail" data-id="{{ $flavorIndex }}" data-flewer-index="{{ $flavorIndex }}">Add Detail</button>
                                                        <div class="details-group" id="details-group-{{ $flavorIndex }}">
                                                            @if(!empty($productFlavor->sizes))
                                                                @php $detailIndex = 0; @endphp
                                                                @foreach ($productFlavor->sizes as $index => $size)
                                                                    <div class="row mt-2 detail-item" id="detail-{{ $flavorIndex }}-{{ $detailIndex }}">
                                                                        <div class="col-5">
                                                                            <label>Weight</label>
                                                                            <input type="text" name="weight[{{ $flavorIndex }}][]" class="form-control" value="{{ $size->weight }}" required>
                                                                        </div>
                                                                        
                                                                       
                                                                        <div class="col-7">
                                                                            <label>Prices</label>
                                                                            <div class="input-group mb-3">
                                                                                <input type="number" name="price[{{ $flavorIndex }}][]" class="form-control" value="{{ $size->price }}" required>
                                                                                <span class="input-group-text">(₹)</span>
                                                                                <input type="number" name="strike_price[{{ $flavorIndex }}][]" class="form-control" value="{{ $size->strike_price }}" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row ml-2">
                                                                            <div class="col-mb-5">
                                                                                <label>Qty</label>
                                                                                <input type="number" name="qty[{{ $flavorIndex }}][]" class="form-control" value="{{ $size->qty }}" required>
                                                                            </div>
                                                                            <div class="col">
                                                                                <button type="button" class="btn btn-danger btn-sm remove-detail ml-3" data-id="{{ $flavorIndex }}" data-detail="{{ $detailIndex }}" style="margin-top:35px;">Remove</button>
                                                                            </div>
                                                                        </div>
                                                                    </div> <hr>
                                                                    @php $detailIndex++; @endphp
                                                                @endforeach 
                                                            @else
                                                                <p>No sizes available.</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @php $flavorIndex++; @endphp
                                    @endforeach
                                @endif
                                <div id="size" class="element-container">
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
                                    <div id="mainImagePreview">
                                        @if(isset($product) && $product->main_image)
                                            <div class="image-container" style="position: relative; display: inline-block;">
                                                <img src="{{ asset('storage/'.$product->main_image) }}" class="img-fluid mt-2" style="max-width: 200px;">
                                                <span class="delete-icon" data-image-id="{{ $product->id }}" 
                                                      data-image-type="main" 
                                                      data-image-path="{{ $product->main_image }}" 
                                                      style="position: absolute; top: 0; right: 0; cursor: pointer; color: white;  padding: 5px; font-size: 20px;">×</span>
                                            </div>
                                            <input type="hidden" name="main_image_path" value="{{ $product->main_image }}">
                                        @endif
                                    </div>
                                </div>
                            
                                <div class="mb-3">
                                    <label>Additional Images</label>
                                    <input type="file" id="additionalImages" name="images[]" class="form-control" multiple>
                                    <div id="additionalImagePreview">
                                        @if(isset($product->images))
                                            @foreach ($product->images as $image)
                                                <div class="image-container" style="position: relative; display: inline-block;">
                                                    <img src="{{ asset('storage/'.$image->image) }}" class="img-fluid mt-2" style="max-width: 200px;">
                                                    <span class="delete-icon" data-image-id="{{ $image->id }}" 
                                                          data-image-type="additional" 
                                                          data-image-path="{{ $image->image }}" 
                                                          style="position: absolute; top: 0; right: 0; cursor: pointer; color: white;  padding: 5px; font-size: 20px;">×</span>
                                                    <input type="hidden" name="uploaded_images[]" value="{{ $image->image }}">
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="card-header" style="background-color: rgb(200, 200, 221)">
                            <h3 class="card-title">Specification</h3>
                        </div>
                        <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="title">Specification</label>
                                    <input type="text" name="specification" id="title" class="form-control"  placeholder="Enter Specification" required value="{{ $product->specification ?? '' }}">
                                </div>
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

    let flewer_index = {{ isset($product) ? count($product->productFlavors) : 0 }};
    let detailIndex = {{ isset($product) ? max(array_map(function($flavor) { return count($flavor['sizes']); }, $product->productFlavors->toArray())) : 0 }};

    $(document).on('click', '#addflavore', function() {
        let flavorHTML = `
            <div id="flavor-container-${flewer_index}" class="flavor-item">
                <div class="card" style="box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); border: 1px solid rgba(0, 0, 0, 0.1);">
                    <div class="card-body">
                        <label for="flavore">Flavor</label>
                        <div class="row mt-2">
                            <div class="input-group col-9 mb-1">
                                <select class="flavore form-control flavor-select" name="flavore[${flewer_index}]" required>
                                    <option value="">Select Flavor</option>
                                    @foreach ($flavors as $f)
                                        <option value="{{ $f->id }}">{{ $f->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-danger btn-sm remove-flavor" data-id="${flewer_index}">Remove</button>
                            </div>
                        </div>
                        <div class="detail-container mt-3 float-right" id="detail-container-${flewer_index}" style="display: none;">
                            <button type="button" class="btn btn-primary btn-sm add-detail" data-id="${flewer_index}" data-flewer-index="${flewer_index}">Add Detail</button>
                            <div class="details-group" id="details-group-${flewer_index}"></div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $(".element-container").append(flavorHTML);
        flewer_index++;
    });

    $(document).on("change", ".flavor-select", function () {
        let parentId = $(this).closest(".flavor-item").attr("id");
        $("#" + parentId + " .detail-container").show();
    });

    $(document).on("click", ".add-detail", function () {
        let id = $(this).data("id");
        let current_element_flewer_index = $(this).data('flewer-index');
        let detailHTML = `
            <div class="row mt-2 detail-item" id="detail-${id}-${detailIndex}">
                <div class="col-5">
                    <label>Weight</label>
                    <input type="text" name="weight[${current_element_flewer_index}][]" class="form-control" placeholder="Enter Weight" required>
                </div>
                <div class="col-7">
                    <label>Prices</label>
                    <div class="input-group mb-3">
                        <input type="number" name="price[${current_element_flewer_index}][]" class="form-control" placeholder="Enter Price" required>
                        <span class="input-group-text">(₹)</span>
                        <input type="number" name="strike_price[${current_element_flewer_index}][]" class="form-control" placeholder="Enter Strike Price" required>
                    </div>
                </div>
                <div class="row ml-2">
                    <div class="col-mb-5">
                        
                    <label>QTY</label>
                    <input type="number" name="qty[${current_element_flewer_index}][]" class="form-control" placeholder="Enter Qty" required>
                   </div>
                   <div class="col">
                    <button type="button" class="btn btn-danger btn-sm remove-detail ml-3" data-id="${id}" data-detail="${detailIndex}" style="margin-top:35px;">Remove</button>
                    </div>
                </div>
                <hr>
            </div>
        `;
        $("#details-group-" + id).append(detailHTML);
        detailIndex++;
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
        formData.append('is_main', type === 'main'); // Send flag to backend

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
                        $(previewDiv).append(`
                            <div class="image-container" style="position: relative; display: inline-block;">
                                <img src="/storage/${path}" class="img-fluid mt-2" style="max-width: 200px;">
                                <span class="delete-icon" data-image-id="0" data-image-type="${type}" data-image-path="${path}" 
                                    style="position: absolute; top: 0; right: 0; cursor: pointer; color: white;  padding: 5px; font-size: 20px;">×</span>
                            </div>
                        `);

                        $('<input>').attr({
                            type: 'hidden',
                            name: type === 'main' ? 'main_image_path' : 'uploaded_images[]',
                            value: path // Store only folder path in hidden input
                        }).appendTo('form');
                    });
                }
            },
            error: function (error) {
                console.log("Upload failed", error);
            }
        });
    }

    $(document).on('click', '.delete-icon', function () {
        let imageId = $(this).data('image-id');
        let imageType = $(this).data('image-type');
        let imagePath = $(this).data('image-path'); 
        let parentDiv = $(this).closest('.image-container');

        if (confirm('Are you sure you want to delete this image?')) {
            $.ajax({
                url: "{{ route('delete.image') }}",
                type: "GET",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    image_id: imageId,
                    image_type: imageType,
                    image_path: imagePath
                },
                success: function (response) {
                    if (response.success) {
                        parentDiv.remove();
                    } else {
                        alert('Failed to delete the image.');
                    }
                },
                error: function () {
                    alert('Error deleting the image.');
                }
            });
        }
    });

    $(".sidebar .nav-link").removeClass('active');
    $(".ecom-link").addClass('active');
    $(".category-menu").addClass('menu-open');

});
</script>
@endsection
