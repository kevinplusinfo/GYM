@extends('Customer.layout.main')

@section('title') Login @endsection

@section('styles')
<link href="{{ asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css') }}" rel="stylesheet">
<style>
    .error { color: red; font-weight: normal !important; }
    .form-control {
        background-color: #151515;
        color: white;
        border: 1px solid #444;
        padding: 10px;
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
    .form-group {
        margin-bottom: 15px;
        text-align: left;
    }
    button {
        background-color: #ff4d00;
        color: white;
        border: none;
        padding: 10px;
        margin-top: 10px;
        cursor: pointer;
        width: 100%;
        border-radius: 5px;
        font-size: 16px;
    }
    button:hover {
        background-color: #e64000;
    }
    .error-messages {
        color: red;
        list-style-type: none;
        padding: 0;
    }
</style>
@endsection

@section('content')
<section class="classes-section spad">
    <div class="col-lg-5 mx-auto">
        <div class="leave-comment">
            <h2 class="mt-5 text-white text-center">Login</h2>
            <p class="mt-2 text-center">Login and Visit Our Gym.</p>
            <form method="POST" action="{{ route('slogin') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required autofocus class="form-control" placeholder="Enter your email" value="{{ old('email') }}">
                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required class="form-control" placeholder="Enter your password">
                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group ">
                    <div class="col-mb-4">
                        <label for="remember">Remember Me</label>
                        <input type="checkbox" name="remember" id="remember" style="margin-top: 5px;">
                    </div>
                </div>

                <button type="submit" class="mb-2">Login</button>

                <a href="{{ route('register') }}" class="d-block mt-2 text-white text-center">
                    Don't Have an Account? Register Here
                </a>
            </form>

            @if ($errors->any())
                <ul class="error-messages mt-3 text-start">
                    @foreach ($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
