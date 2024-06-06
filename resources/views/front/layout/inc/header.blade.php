<!-- HEADER -->
<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">
						<li><a href="#"><i class="fa fa-phone"></i> +94-123-456-7989</a></li>
						<li><a href="#"><i class="fa fa-envelope-o"></i> navindunimnal@gmail.com</a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i> 12 Union Place Colombo</a></li>
					</ul>
					<ul class="header-links pull-right">
						<li><a href="#"><i class="fa fa-dollar"></i> Rs</a></li>
						<li><a href="#"><i class="fa fa-user-o"></i> My Account</a></li>
					</ul>
				</div>
			</div>
			<!-- /TOP HEADER -->

			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="#" class="logo">
									<img src="{{ asset('template/landwind-main/images/Black Pink Bold Elegant Monogram Personal Brand Logo(2).svg')}} " alt="" height="125" width="125">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

						<!-- SEARCH BAR -->
						<div class="col-md-6">
							<div class="header-search">
								<form>
									<select class="input-select">
										<option value="0">All Categories</option>
										<option value="1">Category 01</option>
										<option value="1">Category 02</option>
									</select>
									<input class="input" placeholder="Search here">
									<button class="search-btn">Search</button>
								</form>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">
								<!-- Wishlist -->
								<div>
									<a href="#">
										<i class="fa fa-heart-o"></i>
										<span>Your Wishlist</span>
										<div class="qty">2</div>
									</a>
								</div>
								<!-- /Wishlist -->

								<!-- Cart -->
								<div class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
										<i class="fa fa-shopping-cart"></i>
										<span>Your Cart</span>
										<div class="qty">3</div>
									</a>
									<div class="cart-dropdown">
										<div class="cart-list">
											<div class="product-widget">
												<div class="product-img">
													<img src="/front/img/product01.png" alt="">
												</div>
												<div class="product-body">
													<h3 class="product-name"><a href="#">product name goes here</a></h3>
													<h4 class="product-price"><span class="qty">1x</span>$980.00</h4>
												</div>
												<button class="delete"><i class="fa fa-close"></i></button>
											</div>

											<div class="product-widget">
												<div class="product-img">
													<img src="/front/img/product02.png" alt="">
												</div>
												<div class="product-body">
													<h3 class="product-name"><a href="#">product name goes here</a></h3>
													<h4 class="product-price"><span class="qty">3x</span>$980.00</h4>
												</div>
												<button class="delete"><i class="fa fa-close"></i></button>
											</div>
										</div>
										<div class="cart-summary">
											<small>3 Item(s) selected</small>
											<h5>SUBTOTAL: $2940.00</h5>
										</div>
										<div class="cart-btns">
											<a href="#">View Cart</a>
											<a href="#">Checkout  <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>
								</div>
								<!-- /Cart -->

								<!-- Menu Toogle -->
								<div class="menu-toggle">
									<a href="#">
										<i class="fa fa-bars"></i>
										<span>Menu</span>
									</a>
								</div>
								<!-- /Menu Toogle -->
							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->
		</header>
		<!-- /HEADER -->

		<!-- NAVIGATION -->
		<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">

					<!-- NAV -->

<!-- <div class="container-fluid-lg">
	<div class="row">
		<div class="col-12">
			<div class="header-nav">
				<div class="header-nav-left">
					<button class="dropdown-category">
						<i class="ijaboIcon icon-copy bi bi-list-nested"></i>
						<span>&nbsp;Browse Categories</span>
					</button>
					<div class="category-dropdown">
						<div class="category-title">
							<h5>Categories</h5>
							<button type="button" class="btn p-0 close-button text-content">
								<i class="fa fa-xmark"></i>
							</button>
						</div>

					@if( count(get_categories()) > 0 )

					@foreach(get_categories() as $category)

					
					<ul class="category-list">
						<li class="onhover-category-list">
							<a href="javascript:void(0)" class="category-name">
								<h6>{{ $category->category_name }}</h6>

								@if( count($category->subcategories) > 0 )
								<i class="fa fa-angle-right"></i>
								@endif
							</a>

							@if( count($category->subcategories) > 0)
							<div class="onhover-category-box">
								@foreach ($category->subcategories as $subcategory)
								@if($subcategory->is_child_of == 0)

								<div class="list">
									<div class="category-title-box">
										<a href="javascript:void(0)">
											<h5>{{$subcategory->subcategory_name}}</h5>
										</a>
									</div>

									@if( count($subcategory->children) > 0 )
									<ul>
										@foreach($subcategory->children as $child_subcategory)
										<li>
											<a href="javascript:void(0)">
												{{$child_subcategory->subcategory_name}}
											</a>
										</li>
										@endforeach
									</ul>
									@endif
								</div>
								@endif
								@endforeach
								
                            </div>
							@endif
						</li>
					</ul>

					@endforeach
					@endif
					 /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			</div>
			</div>
			</div>
			</div>
			</div>
			</div>
			<!-- /container -->
		</nav>
		<!-- /NAVIGATION -->