@extends('Customer.layout.main') 
@section('title') Trainer @endsection 

@section('styles')
<link href="{{ asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css') }}" rel="stylesheet">
<style>
    .error { color: red; font-weight: normal!important; }
    .badge { font-size: 15px; cursor: pointer; }
    th, td { text-align: center; }
    .form-control { background-color: #151515; color: white; }
    .profile-card { background-color: #222; color: white; padding: 20px; border-radius: 10px; text-align: center; }
</style>
@endsection

@section('content') 
<section class="breadcrumb-section set-bg" data-setbg="{{asset('assets/img/breadcrumb-bg.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb-text">
                    <h2>Our Team</h2>
                    <div class="bt-option">
                        <a href="{{route('index.gallery')}}">Home</a>
                        <span>Our team</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Team Section Begin -->
<section class="team-section team-page spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="team-title">
                    <div class="section-title">
                        <span>Our Team</span>
                        <h2>TRAIN WITH EXPERTS</h2>
                    </div>
                    <a href="{{route('appointment')}}" class="primary-btn btn-normal appoinment-btn">appointment</a>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($trainers as $trainer)

                <div class="col-lg-4 col-sm-6">
                    <div class="ts-item set-bg" data-setbg="{{ Storage::url($trainer->image) }}">
                        <div class="ts_text">
                            <h4>{{$trainer->name}}</h4>
                            <span>Gym Trainer</span>
                            <div class="tt_social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-youtube-play"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa  fa-envelope-o"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
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
@endsection

@section('scripts')
@endsection
