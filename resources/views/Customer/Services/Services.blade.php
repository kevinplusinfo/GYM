@extends('Customer.layout.main')
@section('title', 'Services')
@section('styles')
<link href="{{asset('assets/plugins/daterange-picker/css/daterangepicker-bs3.css')}}" rel="stylesheet">
<style>
    .error { color: red; font-weight: normal!important; }
    #reportrange { cursor: pointer; }
    .daterangepicker .calendar th, .daterangepicker .calendar td { font-family: monospace!important; }
    .badge { font-size: 15px; cursor: pointer; }
    th, td { text-align: center; }
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
                                <h2>Services</h2>
                                <div class="bt-option">
                                    <a href="{{route('index.gallery')}}">Home</a>
                                    <span>Services</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="services-section spad">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title">
                                <span>What we do?</span>
                                <h2>PUSH YOUR LIMITS FORWARD</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($classes as $class )
                            <div class="col-lg-3 order-lg-1 col-md-6 p-0">
                                <div class="ss-pic">
                                    <img src="{{ Storage::url($class->img) }}" alt="">
                                </div>
                            </div>
                            <div class="col-lg-3 order-lg-2 col-md-6 p-0">
                                <div class="ss-text">
                                    <h4>{{$class->title}}</h4>
                                    <p>{!! Str::limit(strip_tags($class->description), 110, '...') !!}</p>
                                    <a href="{{ route('class.detail', $class->id) }}">Explore</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            {{-- <section class="aboutus-section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 p-0">
                            <div class="about-video set-bg" data-setbg="{{asset('/assets/img/about-us.jpg')}}">
                                <a href="{{$setting->video_link}}" class="play-btn video-popup"><i
                                        class="fa fa-caret-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-6 p-0">
                            <div class="about-text">
                                <div class="section-title">
                                    <span>About Us</span>
                                    <h2 style="color: white;">{{$setting->about_title}}</h2>
                                </div>
                                <div class="at-desc" style="color: white;">
                                    <p>{{$setting->about_desciption}}</p>
                                </div>
                                <div class="about-bar">
                                    <div class="ab-item">
                                        <p>Body building</p>
                                        <div id="bar1" class="barfiller">
                                            <span class="fill" data-percentage="80"></span>
                                            <div class="tipWrap">
                                                <span class="tip"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ab-item">
                                        <p>Training</p>
                                        <div id="bar2" class="barfiller">
                                            <span class="fill" data-percentage="85"></span>
                                            <div class="tipWrap">
                                                <span class="tip"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ab-item">
                                        <p>Fitness</p>
                                        <div id="bar3" class="barfiller">
                                            <span class="fill" data-percentage="75"></span>
                                            <div class="tipWrap">
                                                <span class="tip"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> --}}
            
            <section class="banner-section set-bg" data-setbg="{{asset('/assets/img/banner-bg.jpg')}}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <div class="bs-text">
                                <h2>registration now to get more deals</h2>
                                <div class="bt-tips">Where health, beauty and fitness meet.</div>
                                <a href="{{route('appointment')}}" class="primary-btn  btn-normal">Appointment</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="pricing-section spad">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title">
                                <span>Our Plan</span>
                                <h2>Choose your pricing plan</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-4">
                        @foreach($plans as $plan)
                            <div class="col-lg-4 col-md-8 mb-4">
                                <div class="ps-item">
                                    <h3>{{ $plan->name }}</h3>
                                    <div class="pi-price">
                                        <h2>₹ {{ number_format($plan->price, 2) }}</h2>
                                        <span>{{ strtoupper($plan->duration) }} Month</span>
                                    </div>
                                    <ul>
                                        @if(isset($planFeatures[$plan->id]) && $planFeatures[$plan->id]->isNotEmpty())
                                            @foreach($planFeatures[$plan->id] as $feature)
                                                <li>{{ $feature->name }}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    <div class="pi-price">
                                        <span>Payment Type : {{ $plan->payment_type }} </span>
                                    </div>
                                    <a href="#" class="primary-btn pricing-btn">Enroll now</a>
                                    <a href="#" class="thumb-icon"><i class="fa fa-picture-o"></i></a>
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
        </div>
    </section>
@endsection
