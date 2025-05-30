<aside class="main-sidebar sidebar-dark-primary elevation-4" >
	<a href="{{route('dashbord')}}" class="brand-link">
		<img src="{{ asset('storage/' . $setting->wlogo) }}" alt="KVN GYM" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">KVN GYM</span>
	</a>
	<div class="sidebar">
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="{{ asset('storage/' . (Auth::user()->profile_image ?? 'default-avatar.jpg')) }}" class="img-circle elevation-3" alt="User Image" style="">
			</div>
			<div class="info text-center">
				<a href="javascript:void(0);" class="d-block text-center">
					{{ Auth::user()->name }}
				</a>
            </div>
        </div>
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                    	<i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
            <div class="sidebar-search-results"><div class="list-group"><a href="#" class="list-group-item"><div class="search-title"><strong class="text-light"></strong>N<strong class="text-light"></strong>o<strong class="text-light"></strong> <strong class="text-light"></strong>e<strong class="text-light"></strong>l<strong class="text-light"></strong>e<strong class="text-light"></strong>m<strong class="text-light"></strong>e<strong class="text-light"></strong>n<strong class="text-light"></strong>t<strong class="text-light"></strong> <strong class="text-light"></strong>f<strong class="text-light"></strong>o<strong class="text-light"></strong>u<strong class="text-light"></strong>n<strong class="text-light"></strong>d<strong class="text-light"></strong>!<strong class="text-light"></strong></div><div class="search-path"></div></a></div></div>
        </div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				{{--
				<li class="nav-item menu-open">
					<a href="#" class="nav-link active">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashboard
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="./index.html" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Dashboard v1</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="./index2.html" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Dashboard v2</p>
							</a>
						</li>
					</ul>
				</li>
				
				--}}
				<li class="nav-item">
					<a href="{{route('dashbord')}}" class="nav-link  dashbord-link">
						<i class="nav-icon nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashbord
						</p>
					</a>
				</li>
				<li class="nav-item menu-is-opening category-menu  ">
					<a href="#" class="nav-link ecom-link">
						<i class=" nav-icon fa-brands fa-intercom"></i>
						<p>
							Ecommerce
							<i class="right fas fa-angle-left"></i>
					  </p>
					</a>
					<ul class="nav nav-treeview" style="display: none;">
					  <li class="nav-item">
						<a href="{{route('ecom.product')}}" class="nav-link  product-link ">
							<i class="fa-brands fa-product-hunt nav-icon"></i> 
						  <p>Product</p>
						</a>
					  </li>
					  <li class="nav-item">
						<a href="{{route('ecom.orders')}}" class="nav-link order-link">
							<i class="fa-solid fa-bag-shopping nav-icon"></i>
						  <p>Order</p>
						</a>
					  </li>
					  <li class="nav-item">
						<a href="{{route('ecom.cart')}}" class="nav-link cart-link">
							<i class="fa-solid fa-cart-shopping nav-icon"></i>
						  <p>Cart</p>
						</a>
					  </li>
					  <li class="nav-item">
						<a href="{{route('flavors.index')}}" class="nav-link flavor-link">
							<i class="fa-solid fa-sitemap nav-icon"></i>
						  <p>Flavore</p>
						</a>
					  </li>
					</ul>
				  </li>
				  <li class="nav-item">
					<a href="{{route('purchaseplan.index')}}" class="nav-link  purchaseplan-link">
						<i class="fa-solid fa-credit-card nav-icon"></i>
						<p>
							Purchase Plan
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{route('admin.user')}}" class="nav-link  user-link">
						<i class="fa-solid fa-users nav-icon"></i>
						<p>
							Users
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{route('gallery.gallery')}}" class="nav-link  gallery-link">
						<i class="nav-icon far fa-image"></i>
						<p>
							Gallery
						</p>
					</a>
				</li>

				<li class="nav-item">
					<a href="{{route('blog.blog')}}" class="nav-link  blog-link">
						<i class="fa-solid nav-icon far fa-book"></i>						
						<p>
							Blog
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{route('plan.plan')}}" class="nav-link  plan-link">
						<i class="fa-regular nav-icon fa-money-bill-1"></i>
						<p>
							Plans
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{route('Feature.plan')}}" class="nav-link  feature-link">
						<i class="fa-solid nav-icon fa-rocket"></i>						<p>
							Plans Feature
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{route('class.class')}}" class="nav-link  class-link">
						<i class="fa-solid nav-icon fa-layer-group"></i>
						<p>
							Classes
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{route('trainer.index')}}" class="nav-link  team-link">
						<i class="fa-solid nav-icon fa-people-group"></i>
						<p>
							Trainer
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{route('appointment.index')}}" class="nav-link  appointment-link">
						<i class="fa-solid fa-handshake-simple nav-icon"></i>
						<p>
							Appointment
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{route('userfeedback')}}" class="nav-link  feedback-link">
						<i class="fa-solid fa-star nav-icon"></i>
						<p>
							Feedback
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{route('admin.contact')}}" class="nav-link  contact-link">
						<i class="nav-icon fas fa-envelope"></i>
						<p>
							Contact Us
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="{{route('setting')}}" class="nav-link  setting-link">
						<i class="fa-solid fa-gear nav-icon "></i> 
						<p>
							Settings
						</p>
					</a>
				</li>
			</ul>
		</nav>
    </div>
</aside>