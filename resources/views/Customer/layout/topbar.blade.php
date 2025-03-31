<header class="header-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2">
                    <div class="logo">
                        <a href="{{route('index.gallery')}}">
                            <img src="{{ asset('storage/' . $setting->wlogo) }}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <nav class="nav-menu">
                        <ul>
                            <li class="active"><a href="{{route('index.gallery')}}">Home</a></li>
                            <li><a href="{{route('about')}}">About Us</a></li>
                            <li><a href="{{route('class')}}">Classes</a></li>
                            <li><a href="{{route('services')}}">Services</a></li>
                            <li><a href="{{route('team')}}">Our Team</a></li>
                            <li><a href="#">Pages</a>
                                <ul class="dropdown">
                                    <li><a href="{{route('about')}}">About us</a></li>
                                    <li><a href="{{route('timetable')}}">Classes timetable</a></li>
                                    <li><a href="./bmi-calculator.html">Bmi calculate</a></li>
                                    <li><a href=".{{route('team')}}">Our team</a></li>
                                    <li><a href="{{route('plan')}}">Plans</a></li>
                                    <li><a href="{{route('gallery')}}">Gallery</a></li>
                                    <li><a href="{{route('blog')}}">Our blog</a></li>
                                    <li><a href="./404.html">404</a></li>
                                </ul>
                            </li>
                            <li><a href="{{route('contact')}}">Contact</a></li>
                            <li><a href="{{route('appointment')}}">Appointment</a></li>
                            <li><a href="{{route('product')}}">Product</a></li>
                            @if(Auth::check()) 
                                <li>
                                    <a href="{{ route('clogout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('clogout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                                <li>
                                    <li><a href="{{route('profile')}}">Profile</a></li>
                                </li>
                                <li>
                                    <li><a href="{{route('feedback')}}">Feedback</a></li>
                                </li>
                                <li>
                                    <li><a href="{{route('health.form')}}">Diet Plan</a></li>
                                </li>
                            @else
                                <li><a href="{{ route('clogin') }}">Login</a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="top-option">
                        <div class="to-search search-switch">
                            <i class="fa fa-search"></i>
                        </div>
                        <div class="to-social">
                            <a href="{{$setting->facebook_link}}"target="_blank"><i class="fa fa-facebook"></i></a>
                            <a href="{{$setting->twitter_link}}"target="_blank"><i class="fa fa-twitter"></i></a>
                            <a href="{{$setting->youtube_link}}"target="_blank"><i class="fa fa-youtube-play"></i></a>
                            <a href="{{$setting->instagram_link}}"target="_blank"><i class="fa fa-instagram"></i></a>
                            <a href="{{route('cart.detail')}}">
                                <i class="fa fa-shopping-cart" style="color: white;" ></i>
                                @if ($totalQty > 0)
                                <sup id="cart_items_no" style="color:red;width: 18px;height: 18px;line-height: 17px;display: inline-block;background: #e82954;text-align: center;	    border-radius: 50%;position: relative;top: -12px;color: #fff;font-size: 12px;left: -7px;">
                                    <span class="cart-badge " style="color:white">{{ $totalQty }}</span>
                                @endif
                                </sup>
                            </a>                                              
                         </div>
                    </div>
                </div>
            </div>
            <div class="canvas-open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
        <hr style="background-color: red">
    </header>