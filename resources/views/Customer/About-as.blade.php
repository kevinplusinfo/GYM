@extends('Customer.layout.main')
@section('title', 'About-as')
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
    {{-- <section class="choseus-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Why chose us?</span>
                        <h2>PUSH YOUR LIMITS FORWARD</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-034-stationary-bike"></span>
                        <h4>Modern equipment</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            dolore facilisis.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-033-juice"></span>
                        <h4>Healthy nutrition plan</h4>
                        <p>Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel
                            facilisis.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-002-dumbell"></span>
                        <h4>Proffesponal training plan</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            dolore facilisis.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-014-heart-beat"></span>
                        <h4>Unique to your needs</h4>
                        <p>Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel
                            facilisis.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ChoseUs Section End --> --}}

    <!-- About US Section Begin -->
   
    <section class="hero-section">
        <div class="gallery-section gallery-page">
            
            <section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb-bg.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <div class="breadcrumb-text">
                                <h2>About-as</h2>
                                <div class="bt-option">
                                    <a href="{{route('index.gallery')}}">Home</a>
                                    <span>About</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="aboutus-section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 p-0">
                            <div class="about-video set-bg" data-setbg="{{asset('/assets/img/about-us.jpg')}}">
                                <a href="{{$setting->video_link}}" class="play-btn video-popup"><i
                                    class="fa fa-caret-right"></i>
                                </a>
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
            </section>
            <section class="team-section spad">
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
                        <div class="ts-slider owl-carousel">
                            @foreach($trainers as $trainer)
                                <div class="col-lg-4">
                                    <div class="ts-item set-bg" data-setbg="{{ Storage::url($trainer->image) }}">
                                        <div class="ts_text">
                                            <h4>{{$trainer->name}}</h4>
                                            <span>Gym Trainer</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
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
            <section class="testimonial-section spad">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title">
                                <span>Testimonial</span>
                                <h2>Our Clients Say</h2>
                            </div>
                        </div>
                    </div>
                    <div class="ts_slider owl-carousel">
                        @foreach($feedbacks as $feedback)
                            <div class="ts_item">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <div class="ti_pic">
                                            @if($feedback->img)
                                                <img src="{{ asset('storage/' . $feedback->img) }}" alt="Feedback Image">
                                            @else
                                                <img src="{{ asset('img/testimonial/default.jpg') }}" alt="Default Image">
                                            @endif
                                        </div>
                                        <div class="ti_text">
                                            <p>{{ $feedback->description }}</p>
                                            <h5>{{ $feedback->user->name ?? 'Anonymous' }}</h5>
                                            <div class="tt-rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star{{ $i <= $feedback->rating ? '' : '-o' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            
        
            <!-- Get In Touch Section Begin -->
           <!-- Get In Touch Section Begin -->
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
