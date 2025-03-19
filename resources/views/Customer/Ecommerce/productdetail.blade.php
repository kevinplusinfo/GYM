@extends('Customer.layout.main')
@section('title')Product @endsection
@section('styles')
<link href="{{asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.27/dist/fancybox.css" />

<style>
    * { box-sizing: border-box; }
    body { margin: 0; font-family: Arial; }
    .error { color: red; font-weight: normal !important; }
    #reportrange { cursor: pointer; }
    .daterangepicker .calendar th, .daterangepicker .calendar td { font-family: monospace !important; }
    .badge { font-size: 15px; cursor: pointer; }
    th, td { text-align: center; }

    .header { text-align: center; padding: 32px; }
    .row { display: flex; flex-wrap: wrap; padding: 0 4px; }
    .column { flex: 25%; max-width: 25%; padding: 0 4px; }
    .column img, .description img { width: 100%; height: auto; margin-bottom: 20px; vertical-align: middle; }

    @media (max-width: 800px) { .column { flex: 50%; max-width: 50%; } }
    @media (max-width: 600px) { .column { flex: 100%; max-width: 100%; } }

    .breadcrumb-section { width: 100%; height: 500px; display: flex; justify-content: center; align-items: center; }
    .breadcrumb-section img { width: 100%; height: 100%; object-fit: contain; }
    @media (max-width: 768px) { .breadcrumb-section { height: 350px; } }
    @media (max-width: 480px) { .breadcrumb-section { height: 250px; } }

    .custom-carousel-btn {
        background-color: rgba(0, 0, 0, 0.5); border-radius: 50%;
        width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;
        position: absolute; top: 50%; transform: translateY(-50%);
        transition: background-color 0.3s;
    }
    .custom-carousel-btn:hover { background-color: rgba(8, 8, 8, 0.267); }
    .carousel-control-prev { left: 10px; }
    .carousel-control-next { right: 10px; }
    .carousel-control-prev-icon, .carousel-control-next-icon { filter: invert(1); width: 20px; height: 20px; }

    .product-container { background: #f8f9fa; padding: 40px; border-radius: 10px; }
    .flavor-tab, .size-option {
        cursor: pointer; padding: 10px 15px; border-radius: 20px; border: 1px solid #ccc;
        display: inline-block; margin: 5px; background-color: #fff; font-weight: bold; transition: 0.3s;
    }
    .flavor-tab.active, .size-option.active { background: #007bff; color: white; border-color: #007bff; }
    .flavor-content { display: none; }
    .flavor-content.active { display: block; }

    .btn-cart, .btn-buy {
        width: 150px; font-weight: bold; padding: 12px; border-radius: 25px;
    }
    .btn-cart { background: #28a745; color: white; }
    .btn-cart:hover { background: #218838; }
    .btn-buy { background: #ffc107; color: white; }
    .btn-buy:hover { background: #e0a800; }

    * { box-sizing: border-box; }
    body { margin: 0; font-family: Arial; }
    .error { color: red; font-weight: normal !important; }
    .product-container { background: #f8f9fa; padding: 40px; border-radius: 10px; }
    .carousel-item img { width: 100%; height: 500px; object-fit: contain; }
    .custom-carousel-btn {
        background-color: rgba(0, 0, 0, 0.5); border-radius: 50%;
        width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;
        position: absolute; top: 50%; transform: translateY(-50%);
        transition: background-color 0.3s;
    }
    .custom-carousel-btn:hover { background-color: rgba(8, 8, 8, 0.267); }
    .carousel-control-prev { left: 10px; }
    .carousel-control-next { right: 10px; }
    .flavor-tab.active, .size-option.active { background: #007bff; color: white; border-color: #007bff; }
    .flavor-content { display: none; }
    .flavor-content.active { display: block; }
    .tab-content { background-color: black; color: white; padding: 20px; border-radius: 5px; }
</style>
@endsection
@section('content')
    <div class="gallery-section gallery-page">
        <section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb-bg.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="breadcrumb-text">
                            <h2>Product Detail</h2>
                            <div class="bt-option">
                                <a href="{{route('index.gallery')}}">Home</a>
                                <a href="{{route('product')}}">Product</a>
                                <span>Detail</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="container mt-5">
            <div class="row product-container shadow" style="background-color: #151515;">
                <div class="col-md-6">
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" id="carousel-images">
                            <div class="carousel-item active">
                                <img src="{{ Storage::url($product->main_image) }}" class="d-block w-100" alt="Main Product Image" data-fancybox="gallery" >
                            </div>
                            @foreach($product->images as $image)
                                <div class="carousel-item">
                                    <img src="{{ Storage::url($image->image) }}" class="d-block w-100" alt="Product Image" data-fancybox="gallery" >
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev custom-carousel-btn" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next custom-carousel-btn" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
                
                <div class="col-md-6" style="background-color: black">
                    <h2 style="color: white;" class="mb-3 mt-2">{{ $product->title }}</h2>
                    {{-- <p>{!! $product->description !!}</p> --}}
                    <h4 class="mb-2">
                        <span class="text-muted" style="text-decoration: line-through;">
                            MRP: ₹ <span id="product-mrp">{{ number_format($product->productFlavors->first()->sizes->first()->strike_price ?? 0) }}</span>
                        </span>
                    </h4>
                    
                    <h4 class="text-danger mb-2">
                        Price: ₹ <span id="product-price">{{ number_format($product->productFlavors->first()->sizes->first()->price ?? 0) }}</span>
                    </h4>

                    <h5  style="color: #ccc" class="mb-1">Select Flavor:</h5>
                    @foreach ($product->productFlavors as $index => $productFlavor)
                        <span class="flavor-tab {{ $index == 0 ? 'active' : '' }}" data-flavor="{{ $productFlavor->flavor->id }}">
                            {{ $productFlavor->flavor->name }}
                        </span>
                    @endforeach
    
                    @foreach ($product->productFlavors as $index => $productFlavor)
                        <div class="flavor-content {{ $index == 0 ? 'active' : '' }}" id="flavor-{{ $productFlavor->flavor->id }}">
                            <h5 style="color: #ccc" class="mb-1">Available Sizes:</h5>
                            <div class="size-options">
                                @foreach ($productFlavor->sizes as $size)
                                    <span class="size-option {{ $loop->first ? 'active' : '' }}" data-price="{{ $size->price }}" data-qty="{{ $size->qty }}" data-size="{{ $size->id }}">
                                        {{ $size->weight }}g 
                                    </span>
                                @endforeach
                            </div>
                            <p class="mt-2">Stock: <span id="stock-quantity">{{ $productFlavor->sizes->first()->qty ?? 'Out of stock' }}</span></p>
                        </div>
                    @endforeach
    
                    <div class="mt-3">
                        <label for="quantity" style="color: white">Quantity:</label>
                        <input type="number" id="quantity" class="form-control w-25 d-inline-block" value="1" min="1">
                    </div>
    
                    <div class="mt-4 d-flex align-items-center gap-3">
                        <button class="btn btn-cart flex-grow-1 btn-primary" id="addToCartBtn">Add to Cart</button>
                        <button class="btn btn-buy flex-grow-1 ml-2">Buy Now</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <ul class="nav nav-pills mb-3" id="productTabs">
                <li class="nav-item">
                    <a class="nav-link active" id="description-tab" data-bs-toggle="pill" href="#description">Description</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="specification-tab" data-bs-toggle="pill" href="#specification">Specification</a>
                </li>
            </ul>
            
            <div class="tab-content mb-3" id="productTabsContent">
                <div class="tab-pane fade show active" id="description" >
                    <p >{!! $product->description !!}</p>
                </div>
                <div class="tab-pane fade" id="specification">
                    <p>{{ $product->specification }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.27/dist/fancybox.umd.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            new bootstrap.Carousel(document.querySelector("#productCarousel"), {
                interval: 3000, 
                pause: "hover",
                wrap: true
            });
        });
        
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".flavor-tab").forEach(tab => {
                tab.addEventListener("click", function () {
                    document.querySelectorAll(".flavor-tab").forEach(t => t.classList.remove("active"));
                    document.querySelectorAll(".flavor-content").forEach(c => c.classList.remove("active"));

                    this.classList.add("active");
                    document.getElementById("flavor-" + this.dataset.flavor).classList.add("active");
                    let firstSize = document.querySelector("#flavor-" + this.dataset.flavor + " .size-option");
                    if (firstSize) {
                        firstSize.click();
                    }
                });
            });

            document.querySelectorAll(".size-option").forEach(size => {
                size.addEventListener("click", function () {
                    document.querySelectorAll(".size-option").forEach(s => s.classList.remove("active"));
                    this.classList.add("active");

                    document.getElementById("product-mrp").innerText = parseFloat(this.dataset.strike_price).toFixed(2);
                    document.getElementById("product-price").innerText = parseFloat(this.dataset.price).toFixed(2);
                    document.getElementById("stock-quantity").innerText = this.dataset.qty;
                });
            });

            document.getElementById("addToCartBtn").addEventListener("click", function () {
                let selectedFlavor = document.querySelector(".flavor-tab.active").dataset.flavor;
                let selectedSize = document.querySelector(".size-option.active").dataset.size;
                let quantity = document.getElementById("quantity").value;
            });
            
        });
        
        $(document).ready(function(){
            Fancybox.bind('[data-fancybox="gallery"]', {
                    infinite: true,
                    keyboard: true,
                    transitionEffect: "fade",
                    buttons: ["zoom", "close"]
                });
            });
            document.addEventListener("DOMContentLoaded", function () {
            var firstTab = new bootstrap.Tab(document.querySelector("#productTabs .nav-link.active"));
            firstTab.show();
        });

        $("#addToCartBtn").click(function () {
            let product_id = {{ $product->id }};
            let customer_id = {{ auth()->id() ? auth()->id() : 'null' }};
            let flavor_id = $(".flavor-tab.active").data("flavor");
            let size_id = $(".size-option.active").data("size");
            let qty = $("#quantity").val();

            if (customer_id === null) {
                alert("Please login first to add products to the cart.");
                window.location.href = "{{ route('clogin') }}"; 
                return;
            }

            $.ajax({
                url: "{{ route('cart.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: product_id,
                    customer_id: customer_id,
                    productflavor_id: flavor_id,
                    productflavorsize_id: size_id,
                    qty: qty
                },
                success: function(response) {
                    alert("Product added to cart successfully!");
                    // $(".cart-message").text("Product added to cart successfully!");

                },
                error: function(xhr) {
                    alert("Failed to add product to cart. Please try again.");
                }
            });
        });

    </script>
@endsection