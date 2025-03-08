@extends('Customer.layout.main') <!-- Extend from the layout file -->
@section('title') Profile @endsection <!-- Page Title -->

@section('styles')
<link href="{{ asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css') }}" rel="stylesheet">
<style>
    .error { color: red; font-weight: normal!important; }
    .badge { font-size: 15px; cursor: pointer }
    th, td { text-align: center; }
    .form-control { background-color: #151515; color: white; }
</style>
@endsection

@section('content') <!-- Content Section -->
<section class="classes-section spad">
    <div class="col-lg-5 text-center" style="margin-left:29%; margin-top: 5%">
        <div class="leave-comment">
            <h2 class="mb-1" style="color: white;">Profile</h2>
            <div class="container">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger"> 
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')

                    {{-- Profile Image Preview --}}
                    <div class="mb-3 text-center">
                        @if(Auth::user()->profile_image)
                            <img src="{{ Storage::url(Auth::user()->profile_image) }}" 
                                 alt="Profile Image" 
                                 class="img-thumbnail rounded-circle" width="220" height="120" style="object-fit: cover;">
                        @else
                            <img src="{{ asset('assets/default-profile.png') }}" 
                                 alt="Default Profile Image" 
                                 class="img-thumbnail rounded-circle" width="120" height="120" style="object-fit: cover;">
                        @endif
                        <input type="file" name="image" class="form-control mt-2">
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label" style="color: white;">Name</label>
                        <input type="text" name="name" class="form-control" value="{{Auth::user()->name}}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label" style="color: white;">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                    </div>

                    {{-- Current Password (Only Required if User Enters a New Password) --}}
                    <div class="mb-3">
                        <label for="current_password" class="form-label" style="color: white;">Current Password</label>
                        <input type="password" name="current_password" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label" style="color: white;">New Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label" style="color: white;">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
@endsection
