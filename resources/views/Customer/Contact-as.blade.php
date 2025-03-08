@extends('Customer.layout.main')
@section('title', 'Contact-as')
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
                                <h2>Contact-as</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="contact-section spad">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="section-title contact-title">
                                <span>Contact Us</span>
                                <h2>GET IN TOUCH</h2>
                            </div>
                            <div class="contact-widget">
                                <div class="cw-text">
                                    <i class="fa fa-map-marker"></i>
                                    <p>{{$setting->addresh}}</p>
                                </div>
                                <div class="cw-text">
                                    <i class="fa fa-mobile"></i>
                                    <ul>
                                        <li>{{$setting->mno1}}</li>
                                        <li>{{$setting->mno2}}</li>
                                    </ul>
                                </div>
                                <div class="cw-text email">
                                    <i class="fa fa-envelope"></i>
                                    <p>{{$setting->email}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="leave-comment">
                                <form action="{{route('add.contact')}}">
                                    @csrf
                                    <input type="text" name="name" placeholder="Name" required>
                                    <input type="text" name="email" placeholder="Email" required>
                                    <input type="text" name="website" placeholder="Website">
                                    <textarea placeholder="Comment" name="comment"></textarea>
                                    <button type="submit">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="map">
                        <iframe
                            src="https://www.google.com/maps/dir//Shop+No+-+1+to+5,+Purshottam+villa,+Ramkatha+Rd,+near+Swaminarayan+Gurukul,+Katargam,+Surat,+Gujarat+395004/@21.2443716,72.7534008,12z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3be04f59c0a62175:0xea7eec5cd1c3a485!2m2!1d72.8234412!2d21.2443861?entry=ttu"
                            height="550" style="border:0;" allowfullscreen="">
                        </iframe>
                    </div>
                </div>
            </section>
            <!-- Contact Section End -->
        
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
