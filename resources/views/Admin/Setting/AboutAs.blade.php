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
@endsection

@section('content')
<div class="content">
    <div class="container-fluid">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>About Us</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('dashbord')}}">Home</a></li>
                            <li class="breadcrumb-item active">Settings</li>
                            <li class="breadcrumb-item active">About Us</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <div class="row">
            <div class="col-md-2">
                <div class="list-group">
                    <a href="{{route('setting')}}" class="list-group-item list-group-item-action index">Index</a>
                    <a href="{{route('setting.weblogo')}}" class="list-group-item list-group-item-action wblogo">Website Logo</a>
                    <a href="{{route('setting.contact')}}" class="list-group-item list-group-item-action contact">Contact Details</a>
                    <a href="{{route('setting.favicon')}}" class="list-group-item list-group-item-action favicon">Fav - Icon</a>
                    <a href="{{route('setting.sociallink')}}" class="list-group-item list-group-item-action social">Social Links</a>
                    <a href="{{route('setting.aboutas')}}" class="list-group-item list-group-item-action about">About Us</a>
                </div>  
            </div>

            <div class="col-md-8">
                <div class="card-body">
                    <form action="{{ route('setting.storeaboutas') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header bg-light">
                            <h3 class="card-title">About Us</h3>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label>Title</label>
                                    <input type="text" name="about_title" class="form-control" 
                                           value="{{ old('about_title', $setting->about_title ?? '') }}" 
                                           placeholder="Enter About Us Title">
                                </div>

                                <div class="mb-3">
                                    <label>YouTube Video URL</label>
                                    <input type="text" name="video_link" id="video_link" class="form-control"
                                           value="{{ old('video_link', $setting->video_link ?? '') }}"
                                           placeholder="Enter YouTube Video URL">
                                    <div class="mt-2" id="video_preview">
                                        @if(!empty($setting->video_link))
                                            @php
                                                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $setting->video_link, $matches);
                                                $videoId = $matches[1] ?? null;
                                            @endphp
                                            @if($videoId)
                                                <iframe width="100%" height="200" id="video_iframe"
                                                    src="https://www.youtube.com/embed/{{ $videoId }}"
                                                    frameborder="0" allowfullscreen>
                                                </iframe>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label>Description</label>
                                    <textarea name="about_description" class="form-control" 
                                              placeholder="Enter About Us Description">{{ old('about_desciption', $setting->about_desciption ?? '') }}</textarea>
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
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".sidebar .nav-link").removeClass('active');
        $(".setting-link").addClass('active');

        $(".list-group-item").removeClass('active');
        $(".about").addClass('active');

        $('#video_link').on('blur', function() {
            let videoUrl = $(this).val();
            let videoId = extractYouTubeId(videoUrl);

            if (videoId) {
                $('#video_preview').html(`
                    <iframe width="100%" height="200" 
                        src="https://www.youtube.com/embed/${videoId}" 
                        frameborder="0" allowfullscreen>
                    </iframe>
                `);
            } else {
                $('#video_preview').html('<p class="text-danger">Invalid YouTube URL</p>');
            }
        });

        function extractYouTubeId(url) {
            let match = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
            return match ? match[1] : null;
        }
    });
</script>
@endsection
