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
                          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3719.6288378626466!2d72.8212518751951!3d21.244382981654036!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04f59c0a62175%3A0xea7eec5cd1c3a485!2sShop%20No%20-%201%20to%205%2C%20Purshottam%20villa%2C%20Ramkatha%20Rd%2C%20near%20Swaminarayan%20Gurukul%2C%20Katargam%2C%20Surat%2C%20Gujarat%20395004!5e0!3m2!1sen!2sin!4v1712579700000!5m2!1sen!2sin"
                          width="100%"
                          height="550"
                          style="border:0;"
                          allowfullscreen=""
                          loading="lazy"
                          referrerpolicy="no-referrer-when-downgrade">
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
