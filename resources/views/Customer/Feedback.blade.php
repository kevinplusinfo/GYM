@extends('Customer.layout.main')
@section('title', 'Feedback')

@section('styles')
<link href="{{ asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/themes/fontawesome-stars.css">
<style>
    .error { color: red; font-weight: normal !important; }
    .cursor-pointer { cursor: pointer; }
</style>
@endsection

@section('content')
<section class="hero-section">
    <div class="gallery-section gallery-page">
        <section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb-bg.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="breadcrumb-text">
                            <h2>Feedback</h2>
                            <div class="bt-option">
                                <a href="{{route('index.gallery')}}">Home</a>
                                <span>Feedback</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <section class="contact-section spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="section-title contact-title">
                            <span>Feedback</span>
                            <h2>Give Us Your Opinion</h2>
                        </div>
                        <p>Your feedback helps us improve our services. Please share your experience with us.</p>
                    </div>
                    <div class="col-lg-6">
                        <div class="leave-comment">
                            <form id="feedbackForm" action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                                <div class="form-group">
                                    <label for="description" style="color: white">Feedback <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="suggestion" style="color: white">Suggestion</label>
                                    <textarea name="suggestion" class="form-control"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="rating" style="color: white">Rating <span class="text-danger">*</span></label>
                                    <select id="rating" name="rating" required>
                                        <option value="">Select Rating</option>
                                        <option value="1">1 Star</option>
                                        <option value="2">2 Stars</option>
                                        <option value="3">3 Stars</option>
                                        <option value="4">4 Stars</option>
                                        <option value="5">5 Stars</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="img" style="color: white">Upload Image (Optional)</label>
                                    <input type="file" name="img" class="form-control-file" accept="image/*">
                                </div>

                                <button type="submit" class="btn btn-primary">Submit Feedback</button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- <div class="map">
                    <iframe src="https://www.google.com/maps/embed?..." height="550" style="border:0;" allowfullscreen=""></iframe>
                </div> --}}
            </div>
        </section>

        <div class="gettouch-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="gt-text">
                            <i class="fa fa-map-marker"></i>
                            <p>{{$setting->addresh}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="gt-text">
                            <i class="fa fa-mobile"></i>
                            <ul>
                                <li>{{$setting->mno1}}</li>
                                <li>{{$setting->mno2}}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="gt-text email">
                            <i class="fa fa-envelope"></i>
                            <p>{{$setting->email}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</section>
@endsection

@section('scripts')
<script src="{{ asset('assets/plugins/daterange-picker/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterange-picker/js/daterangepicker.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-bar-rating/1.2.2/jquery.barrating.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
        $('#rating').barrating({
            theme: 'fontawesome-stars'
        });

        $("#feedbackForm").validate({
            rules: {
                description: { required: true, maxlength: 191 },
                rating: { required: true },
                img: { accept: "image/*" }
            },
            messages: {
                description: { required: "Feedback is required", maxlength: "Max 191 characters" },
                rating: { required: "Please select a rating" },
                img: { accept: "Only image files are allowed" }
            }
        });
    });
</script>
@endsection
