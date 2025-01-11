@extends('Customer.head')
@section('content')

<div class="page-wrapper">

    @include('Customer.header')

    <main class="main">
        <div class="page-header text-center"
            style="background-image: url('/customer/assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Shopping Cart<span>Shop</span></h1>
            </div><!-- End .container -->
        </div><!-- End .page-header -->
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
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
                                        <th>Size</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($cartData as $data)

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
                                        <td class="price-col">
                                            <div class="cart-product-quantity">
                                                <select name="size" id="size" class="form-control"
                                                    onchange="updateSize(this.value, {{ $data->cart_ID }})">
                                                    @php
                                                    $sizeData = json_decode($data->size, true);
                                                    @endphp
                                                    @foreach($sizeData as $sizes)
                                                    @if($sizes == "S")
                                                    @if($data->cartSize == "S")
                                                    <option selected value="S">S</option>
                                                    @else
                                                    <option value="S">S</option>
                                                    @endif
                                                    @endif

                                                    @if($sizes == "M")
                                                    @if($data->cartSize == "M")
                                                    <option selected value="M">M</option>
                                                    @else
                                                    <option value="M">M</option>
                                                    @endif
                                                    @endif

                                                    @if($sizes == "L")
                                                    @if($data->cartSize == "L")
                                                    <option selected value="L">L</option>
                                                    @else
                                                    <option value="L">L</option>
                                                    @endif
                                                    @endif

                                                    @if($sizes == "XL")
                                                    @if($data->cartSize == "XL")
                                                    <option selected value="XL">XL</option>
                                                    @else
                                                    <option value="XL">XL</option>
                                                    @endif
                                                    @endif

                                                    @endforeach
                                            </div>
                                            </select>
                                        </td>

                                        <td class="price-col">{{$data->price}}.00</td>
                                        <td class="quantity-col">
                                            <div class="cart-product-quantity">
                                                <input value="{{ $data->cartQuantity ?? 1 }}" type="number"
                                                    class="form-control" value="1" min="1" max="{{ $data->itemQuantity }}" step="1"
                                                    data-decimals="0" required
                                                    onchange="updateQuantity( this.value, {{ $data->cart_ID }} , {{ $data->price }})">
                                            </div><!-- End .cart-product-quantity -->
                                        </td>
                                        <td id="{{ $data->cart_ID }}" class="total-col">{{$data->price *
                                            $data->cartQuantity }}</td>
                                        <td class="remove-col"><a href="/deleteCartItems/{{$data->cart_ID}}"><button
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
                        <aside class="col-lg-3">


                            <form method="POST" action="/checkout">
                                @csrf
                                <div class="summary summary-cart">
                                    <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                                    <table class="table table-summary">
                                        <tbody>
                                            <!-- <tr class="summary-subtotal">
	                							<td>Subtotal:</td>
	                							<td>$160.00</td>
	                						</tr> -->
                                            <tr class="summary-shipping">
                                                <td>Name:</td>
                                                <td>&nbsp; {{Auth::guard('customer')->user()->name}}</td>
                                            </tr>

                                            <tr class="summary-shipping">
                                                <td>Shipping:</td>
                                                <td>&nbsp; {{Auth::guard('customer')->user()->address}}</td>
                                            </tr>

                                            <tr class="summary-shipping">
                                                <td>Phone Number:</td>
                                                <td>&nbsp; {{Auth::guard('customer')->user()->phone}}</td>
                                            </tr>

                                            <tr class="summary-shipping-row">
                                                <td>
                                                    <div class="custom-control custom-radio">
                                                        <input checked type="radio" id="free-shipping" value="1"
                                                            name="shipping" class="custom-control-input">
                                                        <label class="custom-control-label" for="free-shipping">Free
                                                            Shipping</label>
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>

                                            <tr class="summary-shipping-row">
                                                <td>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="standart-shipping" value="0"
                                                            name="shipping" class="custom-control-input">
                                                        <label class="custom-control-label" for="standart-shipping">Take
                                                            Away</label>
                                                    </div>
                                                </td>
                                                <td></td>
                                            </tr>



                                            <!-- <tr class="summary-shipping-estimate">
	                							<td>Estimate for Your Country<br> <a href="dashboard.html">Change address</a></td>
	                							<td>&nbsp;</td>
	                						</tr> -->

                                            <tr class="summary-total">
                                                <td>Total:</td>
                                                <td id="totalPrice">{{$totalPrice}}.00</td>
                                            </tr><!-- End .summary-total -->
                                        </tbody>
                                    </table><!-- End .table table-summary -->

                                    <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED
                                        TO CHECKOUT</button>
                                </div><!-- End .summary -->

                            </form>

                            <!-- <a href="category.html" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a> -->

                        </aside><!-- End .col-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .cart -->
        </div><!-- End .page-content -->
    </main><!-- End .main -->

    <script>
        function updateSize(selectedSize, cart_ID) {
            $.ajax({
                url: '/updateCartSize',
                type: 'POST',  // Using GET method
                data: {
                    _token: '{{ csrf_token() }}',
                    selectedSize: selectedSize,
                    cart_ID: cart_ID
                },
                success: function (response) {
                    document.getElementById("totalPrice").textContent = response.data + ".00";
                },
                error: function (xhr) {


                }
            });
        }


        function updateQuantity(quantity, cartID, price) {

            // var quantity = document.getElementById("quantity").value;

            var total = price * quantity;


            document.getElementById(cartID).textContent = total; // Format to two decimal places

            // Send the updated quantity to the backend using AJAX
            $.ajax({
                url: '/updateQuantity',  // Replace with your Laravel route URL
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',  // Laravel CSRF token for security
                    cart_ID: cartID,               // The cart ID
                    quantity: quantity             // The new quantity
                },
                success: function (response) {
                    console.log(response.data);

                    document.getElementById("totalPrice").textContent = response.data + ".00";
                },
                error: function (xhr) {

                }
            });
        }

    </script>

    @endsection