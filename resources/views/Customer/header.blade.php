<header class="header header-7">
            <div class="header-top">
                <div class="container">
                    <div class="header-left">
                        <div class="header-dropdown">
                            <a href="#">Lkr</a>
                        </div><!-- End .header-dropdown -->

                    </div><!-- End .header-left -->

                    <div class="header-right">
                        <ul class="top-menu">
                            <li>
                                <a href="#">Links</a>
                                <ul>
                                @if(Auth::guard('customer')->check())  
                                    @if(Auth::guard('customer')->user()->type == 1)
                                      <li><a href="/seller/registration"><i class="icon-phone"></i>Become a Seller</a></li>                                                
                                    @else
                                      <li><a href="/seller/dashboard"  target="_blank"><i class="icon-phone"></i>Seller Dashboard</a></li> 
                                    @endif
                                @endif
                                
                                    <li><a href="tel:#"><i class="icon-phone"></i>Call: +0123 456 789</a></li>
                                    
                                @if(Auth::guard('customer')->check())  
                                    <li><a href="/wishList"><i class="icon-heart-o"></i>My Wishlist  @if(isset($wishlistCount) && $wishlistCount > 0)
                                        <span>({{ $wishlistCount }})</span>
                                    @endif</a></li>
                                    @else
                                    <li><a href="#" onclick="needLogin()"><i class="icon-heart-o"></i>My Wishlist  @if(isset($wishlistCount) && $wishlistCount > 0)
                                        <span>({{ $wishlistCount }})</span>
                                    @endif</a></li>
                                @endif
                                
                                    <li><a href="/about">About Us</a></li>
                                    <li><a href="/contact">Contact Us</a></li>

                                    @if(Auth::guard('customer')->check())  
                                    <li><a href="/userDashboard" ><i class="icon-user"></i>{{Auth::guard('customer')->user()->name}}</a></li>
                                    <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-toggle="modal"><i class="icon-arrow-right"></i>Logout</a></li>

                                    
                                    <form id="logout-form" action="/logout/customer" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                          
                                    @else
                                    <li><a href="#signin-modal" data-toggle="modal"><i class="icon-user"></i>Login</a></li>
                                    @endif
                                </ul>
                            </li>
                        </ul><!-- End .top-menu -->
                    </div><!-- End .header-right -->
                </div><!-- End .container-fluid -->
            </div><!-- End .header-top -->

            @if (\Session::has('success'))
                    <script>
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: {!! json_encode(\Session::get('success')) !!},
                            showConfirmButton: false,
                            timer: 1500
                        });
                    </script>
            @endif
            @if (\Session::has('delete'))
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: {!! json_encode(\Session::get('delete')) !!},
                            footer: ''
                        });
                    </script>
            @endif
            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    <script>
                        Swal.fire({
                        icon: "error",
                        position: "top-end",
                        title: "",
                        text: {!! json_encode($error) !!},
                        footer: '',
                        timer: 4500,
                        showConfirmButton: false,
                        });
                    </script>
                @endforeach
            @endif
            
            <div class="header-middle sticky-header">
                <div class="container">
                    <div class="header-left">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Toggle mobile menu</span>
                            <i class="icon-bars"></i>
                        </button>
                        
                        <a href="index.html" class="logo">
                            <img src="/customer/assets/images/demos/demo-7/logo.png" alt="Molla Logo" width="105" height="25">
                        </a>

                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                                <li class="megamenu-container active">
                                    <a href="/" class="">Home</a>
                                </li>
                                <li>
                                    <a href="category.html" class="sf-with-ul">Shop</a>

                                    <div class="megamenu megamenu-md">
                                        <div class="row no-gutters">
                                            <div class="col-md-8">
                                                <div class="menu-col">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="menu-title">Women's</div><!-- End .menu-title -->
                                                            <ul> 
                                                                @foreach($categories as $item)
                                                                   @if($item->type == "Womens")
                                                                    <li><a href="category-list.html">{{$item->name}}</a></li>
                                                                   @endif
                                                                @endforeach                       
                                                            </ul>

                                                            <div class="menu-title">Men's</div><!-- End .menu-title -->
                                                            <ul>
                                                               @foreach($categories as $item)
                                                                   @if($item->type == "Mens")
                                                                    <li><a href="category-list.html">{{$item->name}}</a></li>
                                                                   @endif
                                                                @endforeach         
                                                            </ul>
                                                        </div><!-- End .col-md-6 -->

                                                        <div class="col-md-6">
                                                            <div class="menu-title">Wearing Items</div><!-- End .menu-title -->
                                                            <ul>
                                                                @foreach($categories as $item)
                                                                    @if($item->type == "WearingItems")
                                                                        <li><a href="category-list.html">{{$item->name}}</a></li>
                                                                    @endif
                                                                @endforeach    
                                                            </ul>
                                                            <div class="menu-title">Shop Pages</div><!-- End .menu-title -->
                                                            <ul>
                                                                <li><a href="cart.html">Cart</a></li>
                                                                <li><a href="checkout.html">Checkout</a></li>
                                                                <li><a href="/wishList">Wishlist</a></li>
                                                                <li><a href="/userDashboard">My Account</a></li>
                                                                <li><a href="#">Lookbook</a></li>
                                                            </ul>
                                                        </div><!-- End .col-md-6 -->
                                                    </div><!-- End .row -->
                                                </div><!-- End .menu-col -->
                                            </div><!-- End .col-md-8 -->

                                            <div class="col-md-4">
                                                <div class="banner banner-overlay">
                                                    <a href="category.html" class="banner banner-menu">
                                                        <img src="/customer/assets/images/menu/banner-1.jpg" alt="Banner">

                                                        <div class="banner-content banner-content-top">
                                                            <div class="banner-title text-white">Last <br>Chance<br><span><strong>Sale</strong></span></div><!-- End .banner-title -->
                                                        </div><!-- End .banner-content -->
                                                    </a>
                                                </div><!-- End .banner banner-overlay -->
                                            </div><!-- End .col-md-4 -->
                                        </div><!-- End .row -->
                                    </div><!-- End .megamenu megamenu-md -->
                                </li>
                               
                            </ul><!-- End .menu -->
                        </nav><!-- End .main-nav -->
                    </div><!-- End .header-left -->

                    <div class="header-right">
                        <div class="header-search header-search-extended header-search-visible">
                            <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                            <form action="#" method="get">
                                <div class="header-search-wrapper search-wrapper-wide">
                                    <label for="q" class="sr-only">Search</label>
                                    <input type="search" class="form-control" name="q" id="q" placeholder="Search product ..." required>
                                    <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->
                        
                        <div class="dropdown cart-dropdown">

                        @if(Auth::guard('customer')->check())  

                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <i class="icon-shopping-cart"></i>
                                <span class="cart-count">{{count($cartData)}}</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-cart-products">


                                @foreach($cartData as $data)

                                    @php
                                        $photosCart = json_decode($data->photo, true);
                                    @endphp

                                    <div class="product">
                                        <div class="product-cart-details">
                                            <h4 class="product-title">
                                                <a href="product.html">{{$data->name}}</a>
                                            </h4>

                                            <span class="cart-product-info">
                                                <span class="cart-product-qty">1</span>
                                                x Rs {{$data->price}}.00
                                            </span>
                                        </div><!-- End .product-cart-details -->

                                        <figure class="product-image-container">
                                            <a href="/viewCart" class="product-image">
                                                <img src="{{ asset('uploads/' . $photosCart[0]) }}" alt="product">
                                            </a>
                                        </figure>
                                        <!-- <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a> -->
                                    </div><!-- End .product -->
                                @endforeach
                                
                                </div><!-- End .cart-product -->

                                <!-- <div class="dropdown-cart-total">
                                    <span>Total</span>

                                    <span class="cart-total-price">$160.00</span>
                                </div> -->

                                <div class="dropdown-cart-action">
                                    <a href="/viewCart" class="btn btn-primary">View Cart</a>
                                    <!-- <a href="checkout.html" class="btn btn-outline-primary-2"><span>Checkout</span><i class="icon-long-arrow-right"></i></a> -->
                                </div><!-- End .dropdown-cart-total -->
                            </div><!-- End .dropdown-menu -->

                        @else

                            <a href="#"  onclick="needLogin()" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <i class="icon-shopping-cart"></i>
                            </a>

                        @endif

                          
                        </div><!-- End .cart-dropdown -->


                    </div><!-- End .header-right -->
                </div><!-- End .container-fluid -->
            </div><!-- End .header-middle -->
        </header><!-- End .header -->

<script>
        function needLogin()
    {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Login required!",
            footer: ''
            });
    }
</script>