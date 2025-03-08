@extends('admin.layout.main')

@section('title', 'Setting')

@section('styles')
<style>
    .error { color: red; font-weight: normal !important; }
    .container { max-width: 1000px; margin: 0 auto; padding: 30px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
    h1 { text-align: center; color: #333; margin-bottom: 30px; }
    .form-group { margin-bottom: 20px; }
    label { font-weight: bold; display: block; margin-bottom: 8px; }
    input[type="text"], input[type="number"], input[type="email"], textarea, select {
        width: 100%; padding: 10px; margin: 5px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;
    }
    .submit-btn { width: 100%; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
    .submit-btn:hover { background-color: #0056b3; }
    .image-preview { max-width: 100px; max-height: 100px; margin-top: 10px; border-radius: 4px; border: 1px solid #ccc; padding: 5px; }
    
</style>
<link rel="stylesheet" 
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
@endsection

@section('content-header')
@section('content')
<div class="content">
    <div class="container-fluid">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Website Logo</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('dashbord')}}">Home</a></li>
                            <li class="breadcrumb-item active">Settings</li>
                            <li class="breadcrumb-item active">Contact</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <div class="row">
            <div class="col-md-2">
                <div class="list-group">
                    <a href="{{route('setting')}}" class="list-group-item list-group-item-action index ">
                        Index
                    </a>
                    <a href="{{route('setting.weblogo')}}" class="list-group-item list-group-item-action payment-gateways-settings wblogo">
                        Website Logo
                    </a>
                    <a href="{{route('setting.contact')}}" class="list-group-item list-group-item-action exam-checkout-settings contact">
                        Contect Detail
                    </a>
                    <a href="{{route('setting.favicon')}}" class="list-group-item list-group-item-action chatgpt-settings favicon">
                        Fav - Icon
                    </a>
                    <a href="{{route('setting.sociallink')}}" class="list-group-item list-group-item-action coupon-settings social">
                        Social Link
                    </a>
                    <a href="{{route('setting.aboutas')}}" class="list-group-item list-group-item-action exam-tips-settings about">
                        About As
                    </a>
                </div> 
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <form action="{{ route('setting.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header " style="background-color: #cdd1d3">
                            <h3 class="card-title">Website Logo</h3>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label>Logo</label>
                                    <input type="file" name="wlogo" class="form-control">
                                    @if(isset($setting->wlogo))
                                        <img src="{{ asset('storage/' . $setting->wlogo) }}" class="image-preview">
                                    @endif
                                </div>
                                <div class="card-header text-right" style="background-color: #e0e4e6">
                                    <a href="{{ route('setting') }}" class="btn btn-default btn-sm">Cancel</a>
                                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('setting.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-header" style="background-color: #cdd1d3">
                                <h3 class="card-title">Index Banner</h3>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label>Banner 1</label>
                                        <input type="file" name="img1" class="form-control">
                                        @if($setting->img1 ?? false)
                                            <img src="{{ asset('storage/' . $setting->img1) }}" class="image-preview">
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label>Banner 2</label>
                                        <input type="file" name="img2" class="form-control">
                                        @if($setting->img2 ?? false)
                                            <img src="{{ asset('storage/' . $setting->img2) }}" class="image-preview">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-header" style="background-color: #cdd1d3">
                                <h3 class="card-title">Contact Details</h3>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label>Address</label>
                                        <input type="text" name="addresh" class="form-control" value="{{ $setting->addresh ?? '' }}" placeholder="Enter Address">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Mobile No 1</label>
                                            <input type="number" name="mno1" class="form-control" value="{{ $setting->mno1 ?? '' }}" placeholder="Enter Mobile No 1">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Mobile No 2</label>
                                            <input type="number" name="mno2" class="form-control" value="{{ $setting->mno2 ?? '' }}" placeholder="Enter Mobile No 2">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ $setting->email ?? '' }}" placeholder="Enter Email">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-header " style="background-color: #cdd1d3">
                                <h3 class="card-title">Fav-Icon</h3>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label>Fav-Icon</label>
                                        <input type="file" name="favicon" class="form-control">
                                        @if(isset($setting->favicon))
                                            <img src="{{ asset('storage/' . $setting->favicon) }}" class="image-preview">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-header" style="background-color: #cdd1d3">
                                <h3 class="card-title">Social Link</h3>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label>Facebook</label>
                                        <input type="text" name="facebook" class="form-control" value="{{ $setting->facebook_link ?? '' }}" placeholder="Enter Facebook URL">
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>Twitter</label>
                                            <input type="text" name="twitter" class="form-control" value="{{ $setting->twitter_link ?? '' }}" placeholder="Enter Twitter URL">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Youtube</label>
                                            <input type="text" name="youtube" class="form-control" value="{{ $setting->youtube_link ?? '' }}" placeholder="Enter Youtube URL">
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" name="instagram" class="form-control" value="{{ $setting->instagram_link ?? '' }}" placeholder="Enter Instagram URL"  >
                                    </div>
                                    <div class="mb-3">
                                        <label>Gmail</label>
                                        <input type="text" name="gmail" class="form-control" value="{{ $setting->gmail_link ?? '' }}" placeholder="Enter Gmail URL">
                                    </div>
                                    <div class="mb-3">
                                        <label>Footer Description</label>
                                        <textarea name="footerdescription" class="form-control" placeholder="Footer Description">{{ old('footerdescription', $setting->footerdescription ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-header " style="background-color: #cdd1d3">
                                <h3 class="card-title">Website Logo</h3>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label>Logo</label>
                                        <input type="file" name="wlogo" class="form-control">
                                        @if(isset($setting->wlogo))
                                            <img src="{{ asset('storage/' . $setting->wlogo) }}" class="image-preview">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-header" style="background-color: #cdd1d3">
                                <h3 class="card-title">About Us</h3>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label>Title</label>
                                        <input type="text" name="about_title" class="form-control" value="{{ old('about_title', $setting->about_title ?? '') }}" placeholder="Enter About Us Title">
                                    </div>
                                    <div class="mb-3">
                                        <label>YouTube Video URL</label>
                                        <input type="text" name="video_link" class="form-control" value="{{ old('video_link', $setting->video_link ?? '') }}" placeholder="Enter YouTube Video URL">
                                        
                                        @if(!empty($setting->video_link))
                                            @php
                                                // Extract YouTube Video ID directly in Blade
                                                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $setting->video_link, $matches);
                                                $videoId = $matches[1] ?? null;
                                            @endphp

                                            @if($videoId)
                                                <div class="mt-2">
                                                    <iframe width="100%" height="200" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label>Description</label>
                                        <textarea name="about_description" class="form-control" placeholder="Enter About Us Description">{{ old('about_desciption', $setting->about_desciption ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-header text-right" style="background-color: #e0e4e6">
                        <a href="{{ route('setting') }}" class="btn btn-default btn-sm">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $(".sidebar .nav-link").removeClass('active');
        $(".setting-link").addClass('active');
        
        $(".list-group-item .list-group-item-action").removeClass('active');
        $(".wblogo").addClass('active');
    });
</script>
@endsection
