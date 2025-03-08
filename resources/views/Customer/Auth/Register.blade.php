@extends('Customer.layout.main')
@section('title') Register @endsection

@section('styles')
<link href="{{ asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css') }}" rel="stylesheet">
<style>
    .error { color: red; font-weight: normal !important; }
    #reportrange { cursor: pointer; }
    .daterangepicker .calendar th, .daterangepicker .calendar td { font-family: monospace !important; }
    .badge { font-size: 15px; cursor: pointer; }
    th, td { text-align: center; }
    .form-control {
        background-color: #151515;
        color: white;
        border: 1px solid #444;
    }
    .form-control::placeholder {
        color: #bbb;
    }
    label {
        color: white;
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }
    button {
        background-color: #ff4d00;
        color: white;
        border: none;
        padding: 10px 15px;
        margin-top: 10px;
        cursor: pointer;
        width: 100%;
    }
    button:hover {
        background-color: #e64000;
    }
    .error-messages {
        color: red;
        list-style-type: none;
        padding: 0;
    }
    .form-group {
        margin-bottom: 15px;
        text-align: left;
    }
</style>
@endsection

@section('content')
<section class="classes-section spad">
    <div class="col-lg-7 mx-auto">
        <div class="leave-comment">
            <h2 class="mt-5 text-white text-center">Register</h2>
            <p class="mt-2 text-center">Fill in the details below to register for our gym.</p>
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Full Name" value="{{ old('name') }}">
                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" value="{{ old('email') }}">
                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="mno">Mobile No</label>
                    <input type="number" name="mno" id="mno" class="form-control" placeholder="Mobile No" value="{{ old('mno') }}">
                    @error('mno') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password">
                    @error('password_confirmation') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <button type="submit">Register</button>

                <a href="{{ route('clogin') }}" class="d-block mt-2 text-white text-center">
                    Already Have an Account? Login Here
                </a>
            </form>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
        $("#registerForm").validate({
            rules: {
                name: { required: true, minlength: 3 },
                email: { required: true, email: true },
                mno: { required: true, digits: true, minlength: 10, maxlength: 10 },
                password: { required: true, minlength: 6 },
                password_confirmation: { required: true, equalTo: "#password" }
            },
            messages: {
                name: { required: "Please enter your name", minlength: "Name must be at least 3 characters" },
                email: { required: "Email is required", email: "Enter a valid email" },
                mno: { required: "Mobile number is required", digits: "Enter a valid 10-digit mobile number", minlength: "Mobile number must be 10 digits", maxlength: "Mobile number must be 10 digits" },
                password: { required: "Enter a password", minlength: "Password must be at least 6 characters" },
                password_confirmation: { required: "Confirm your password", equalTo: "Passwords do not match" }
            },
            errorElement: "div",
            errorPlacement: function (error, element) {
                error.addClass("text-danger");
                error.insertAfter(element);
            }
        });
    });
</script>
@endsection
