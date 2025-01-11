@extends('Customer.head')
@section('content')

    <div class="page-wrapper">

     @include('Customer.header')
    
     <main class="main">
        	<div class="page-header text-center" style="background-image: url('/customer/assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Order List<span>Shop</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Order List</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="container">
					<table id="table_filter" class="table table-wishlist table-mobile">
						<thead>
							<tr>
                                <th>No</th>
								<th>Product</th>
                                <th>Quantity</th>
								<th>Price</th>
                                <th>Delevery Type</th>
								<th></th>
								<th></th>
							</tr>
						</thead>

						<tbody>
                            @foreach($orderData as $key =>$orderItem)

                                    @php
                                        $orderItemCart = json_decode($orderItem->photo, true);
                                    @endphp
                                <tr>
                                <td class="price-col">{{++$key}}</td>
                                    <td class="product-col">
                                        <div class="product">
                                            <figure class="product-media">
                                                <a href="#">
                                                    <img src="{{ asset('uploads/' . $orderItemCart[0]) }}" alt="Product image">
                                                </a>
                                            </figure>

                                            <h3 class="product-title">
                                                <a href="#">{{$orderItem->name}}</a>
                                            </h3><!-- End .product-title -->
                                        </div><!-- End .product -->
                                    </td>
                                    <td class="price-col">{{$orderItem->orderQuantity}}</td>
                                    <td class="price-col">{{$orderItem->orderQuantity  * $orderItem->price }}</td>
                                    @if($orderItem->order_status == 1)
                                      <td class="stock-col"><span class="in-stock">Free Shipping</span></td>
                                    @else
                                      <td class="stock-col"><span class="out-of-stock">Take Away</span></td>
                                    @endif

                                    <td class="action-col">
                                        <div class="dropdown">
                                        <button class="btn btn-block btn-outline-primary-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="icon-list-alt"></i>Select Options
                                        </button>

                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Give Feedback</a>
                                            <a class="dropdown-item" href="#">Check Order</a>
                                            <!-- <a class="dropdown-item" href="#">Order Recived </a> -->
                                        </div>
                                        </div>
                                    </td>
                                    <td class="remove-col"><button class="btn-remove"><i class="icon-close"></i></button></td>
                                </tr>

                            @endforeach











							<!-- <tr>
								<td class="product-col">
									<div class="product">
										<figure class="product-media">
											<a href="#">
												<img src="/customer/assets/images/products/table/product-2.jpg" alt="Product image">
											</a>
										</figure>

										<h3 class="product-title">
											<a href="#">Blue utility pinafore denim dress</a>
										</h3>
									</div>
								</td>
								<td class="price-col">$76.00</td>
								<td class="stock-col"><span class="in-stock">In stock</span></td>
								<td class="action-col">
									<button class="btn btn-block btn-outline-primary-2"><i class="icon-cart-plus"></i>Add to Cart</button>
								</td>
								<td class="remove-col"><button class="btn-remove"><i class="icon-close"></i></button></td>
							</tr>
							<tr>
								<td class="product-col">
									<div class="product">
										<figure class="product-media">
											<a href="#">
												<img src="/customer/assets/images/products/table/product-3.jpg" alt="Product image">
											</a>
										</figure>

										<h3 class="product-title">
											<a href="#">Orange saddle lock front chain cross body bag</a>
										</h3>
									</div>
								</td>
								<td class="price-col">$52.00</td>
								<td class="stock-col"><span class="out-of-stock">Out of stock</span></td>
								<td class="action-col">
									<button class="btn btn-block btn-outline-primary-2 disabled">Out of Stock</button>
								</td>
								<td class="remove-col"><button class="btn-remove"><i class="icon-close"></i></button></td>
							</tr> -->

						</tbody>
					</table><!-- End .table table-wishlist -->
	            	<div class="wishlist-share">
	            		<div class="social-icons social-icons-sm mb-2">
	            			<label class="social-label">Share on:</label>
	    					<a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
	    					<a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
	    					<a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
	    					<a href="#" class="social-icon" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
	    					<a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
	    				</div><!-- End .soial-icons -->
	            	</div><!-- End .wishlist-share -->
            	</div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->


 @endsection