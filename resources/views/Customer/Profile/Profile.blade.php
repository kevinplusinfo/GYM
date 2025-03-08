@extends('Customer.layout.main') 
@section('title') Profile @endsection 

@section('styles')
<link href="{{ asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css') }}" rel="stylesheet">
<style>
    .error { color: red; font-weight: normal!important; }
    .badge { font-size: 15px; cursor: pointer; }
    th, td { text-align: center; }
    .form-control { background-color: #151515; color: white; border: 1px solid #444; padding: 10px; border-radius: 8px; }
    .profile-card { background-color: #222; color: white; padding: 20px; border-radius: 10px; text-align: center; }
    label { font-weight: bold; color: #fff; margin-bottom: 5px; }
</style>
@endsection

@section('content') 
<section class="classes-section spad">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                <div class="profile-card">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            @if(Auth::user()->profile_image)
                                <img src="{{ Storage::url(Auth::user()->profile_image) }}" 
                                    alt="Profile Image" class="img-fluid rounded-circle border border-3 border-white" 
                                    style="width: 250px; height: 250px; object-fit: cover;">
                            @else
                                <img src="{{ asset('assets/default-profile.png') }}" 
                                    alt="Default Profile Image" class="img-thumbnail rounded-circle" 
                                    width="250" height="250" style="object-fit: cover;">
                            @endif
                        </div>
        
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4 mt-4">
                                    <strong>Name:</strong> 
                                    <h2 class="mt-3 text-white">{{ Auth::user()->name }}</h2>
                                </div>
                                <div class="col-md-4 mt-4">
                                    <strong>Mobile No:</strong> 
                                    <h3 class="mt-4 text-white">{{ Auth::user()->mno }}</h3>
                                </div>
                                <div class="col-md-4 mt-4">
                                    <strong>Email:</strong>
                                    <h4 class="mt-4 text-white">{{ Auth::user()->email }}</h4>
                                </div>
                            </div>
        
                            @if(!is_null($order))
                                <div class="mt-3 text-center">
                                    <a href="{{ route('customer.purchase.plan', ['order_id' => $order->id] ) }}" class="btn btn-warning">
                                        Courent Purchase Plan
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- ✅ Bootstrap Tabs for Profile Update -->
        <div class="leave-comment mt-5">
            <h2 class="mb-3 text-center text-white">Update Profile</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
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

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                        General
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">
                        Security
                    </button>
                </li>
            </ul>

            <!-- Single Form for Both Tabs -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf    

                <div class="tab-content mt-3" id="profileTabsContent">
                    <!-- ✅ General Information Tab -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                                </div>
                            </div>
                    
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="mno">Mobile No</label>
                            <input type="number" name="mno" class="form-control" value="{{ Auth::user()->mno }}" required>
                        </div>
                    
                        <div class="mb-3">
                            <label for="image">Profile Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>

                    <!-- ✅ Security (Password Update) Tab -->
                    <div class="tab-pane fade" id="security" role="tabpanel">
                        <div class="mb-3">
                            <label for="current_password">Current Password</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>
                    
                        <div class="mb-3">
                            <label for="newpassword">New Password</label>
                            <input type="password" name="newpassword" class="form-control">
                        </div>
                           
                        <div class="mb-3">
                            <label for="newpassword_confirmation">Confirm New Password</label>
                            <input type="password" name="newpassword_confirmation" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>

        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
