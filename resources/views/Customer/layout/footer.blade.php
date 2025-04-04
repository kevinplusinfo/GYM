<section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="fs-about">
                        <div class="fa-logo">
                            <a href="#"><img src="{{ asset('storage/' . $setting->wlogo) }}" alt=""></a>
                        </div>
                        <p>{{$setting->footerdescription}}</p>

                        <div class="fa-social">
                            <a href="{{$setting->facebook_link}}" target="_blank"><i class="fa fa-facebook"></i></a>
                            <a href="{{$setting->twitter_link}}"target="_blank"><i class="fa fa-twitter"></i></a>
                            <a href="{{$setting->youtube_link}}"target="_blank"><i class="fa fa-youtube-play"></i></a>
                            <a href="{{$setting->instagram_link}}"target="_blank"><i class="fa fa-instagram"></i></a>
                            <a href="{{$setting->gmail_link}}"target="_blank"><i class="fa  fa-envelope-o"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="fs-widget">
                        <h4>Useful links</h4>
                        <ul>
                            <li><a href="{{route('about')}}">About</a></li>
                            <li><a href="{{route('blog')}}">Blog</a></li>
                            <li><a href="{{route('class')}}">Classes</a></li>
                            <li><a href="{{route('contact')}}">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <div class="fs-widget">
                        <h4>Support</h4>
                        <ul>
                            <li><a href="{{route('clogin')}}">Login</a></li>
                            <li><a href="{{route('profile')}}">My account</a></li>
                            <li><a href="{{route('plan')}}">Subscribe</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="fs-widget">
                        <h4>Tips & Guides</h4>
                        <div class="fw-recent">
                            <h6><a href="#">Physical fitness may help prevent depression, anxiety</a></h6>
                            <ul>
                                <li>3 min read</li>
                                <li>20 Comment</li>
                            </ul>
                        </div>
                        <div class="fw-recent">
                            <h6><a href="#">Fitness: The best exercise to lose belly fat and tone up...</a></h6>
                            <ul>
                                <li>3 min read</li>
                                <li>20 Comment</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="copyright-text">
                        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Kvn Gondaliya</a> 🏋️🍽️  🔥🚀 🎯
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                    </div>
                </div>
            </div>
        </div>
    </section>