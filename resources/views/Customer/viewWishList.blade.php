@extends('Customer.head')
@section('content')

<div class="page-wrapper">

    @include('Customer.header')

    <main class="main">
        <div class="page-header text-center"
            style="background-image: url('/customer/assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Wishlist<span>Shop</span></h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                </ol>
            </div><!-- End .container -->
        </nav><!-- End .breadcrumb-nav -->

        <div class="page-content">
            <div class="cart">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9">
                            <table class="table table-cart table-mobile">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($wishlistItemDetails as $data)

                                    @php
                                    $photosCart = json_decode($data->photo, true);
                                    @endphp

                                    <tr>
                                        <td class="product-col">
                                            <div class="product">
                                                <figure class="product-media">
                                                    <a href="#">
                                                        <img src="{{ asset('uploads/' . $photosCart[0]) }}"
                                                            alt="Product image">
                                                    </a>
                                                </figure>

                                                <h3 class="product-title">
                                                    <a href="#">{{$data->name}}</a>
                                                </h3><!-- End .product-title -->
                                            </div><!-- End .product -->
                                        </td>

                                        <td class="price-col">{{$data->price}}.00</td>
                                        
                                       
                                        <td class="remove-col"><a href="/removeWishlistItems/{{$data->item_ID}}"><button
                                                    class="btn-remove"><i class="icon-close"></a></i></button></td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table><!-- End .table table-wishlist -->

                            <div class="cart-bottom">
                                <!-- <div class="cart-discount">
			            				<form action="#">
			            					<div class="input-group">
				        						<input type="text" class="form-control" required placeholder="coupon code">
				        						<div class="input-group-append">
													<button class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></button>
												</div>
			        						</div>
			            				</form>
			            			</div> -->

                                <!-- <a href="/viewCart" class="btn btn-outline-dark-2"><span>UPDATE CART</span><i class="icon-refresh"></i></a> -->
                            </div><!-- End .cart-bottom -->
                        </div><!-- End .col-lg-9 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .cart -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->
@endsection