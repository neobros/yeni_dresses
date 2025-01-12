@extends('Customer.head')
@section('content')

    <div class="page-wrapper">

     @include('Customer.header')
    
	 <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container d-flex align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Products</a></li>
                        <!-- <li class="breadcrumb-item active" aria-current="page">Default</li> -->
                    </ol>
<!-- 
                    <nav class="product-pager ml-auto" aria-label="Product">
                        <a class="product-pager-link product-pager-prev" href="#" aria-label="Previous" tabindex="-1">
                            <i class="icon-angle-left"></i>
                            <span>Prev</span>
                        </a>

                        <a class="product-pager-link product-pager-next" href="#" aria-label="Next" tabindex="-1">
                            <span>Next</span>
                            <i class="icon-angle-right"></i>
                        </a>
                    </nav> -->
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
                    <div class="product-details-top">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-gallery product-gallery-vertical">
                                    <div class="row">

                                            @php
                                                $imageData = json_decode($itemDetails->photo, true);
                                            @endphp  
                                            
                                        <figure class="product-main-image">
                                            <img style="width: 82%;" id="product-zoom" src="{{ asset('uploads/' . $imageData[0]) }}" data-zoom-image="{{ asset('uploads/' . $imageData[0]) }}" alt="product image">

                                            <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                                <i class="icon-arrows"></i>
                                            </a>
                                        </figure><!-- End .product-main-image -->

                                        <div id="product-zoom-gallery" class="product-image-gallery">
                                           
                                            @foreach($imageData as $data)

                                            <a class="product-gallery-item active" href="#" data-image="{{ asset('uploads/' . $data) }}" data-zoom-image="{{ asset('uploads/' . $data) }}">
                                                <img src="{{ asset('uploads/' . $data) }}" alt="product side">
                                            </a>
                                              @endforeach


                                           <!--  <a class="product-gallery-item active" href="#" data-image="/customer/assets/images/products/single/1.jpg" data-zoom-image="/customer/assets/images/products/single/1-big.jpg">
                                                <img src="/customer/assets/images/products/single/1-small.jpg" alt="product side">
                                            </a>

                                            <a class="product-gallery-item" href="#" data-image="/customer/assets/images/products/single/2.jpg" data-zoom-image="/customer/assets/images/products/single/2-big.jpg">
                                                <img src="/customer/assets/images/products/single/2-small.jpg" alt="product cross">
                                            </a>

                                            <a class="product-gallery-item" href="#" data-image="/customer/assets/images/products/single/3.jpg" data-zoom-image="/customer/assets/images/products/single/3-big.jpg">
                                                <img src="/customer/assets/images/products/single/3-small.jpg" alt="product with model">
                                            </a>

                                            <a class="product-gallery-item" href="#" data-image="/customer/assets/images/products/single/4.jpg" data-zoom-image="/customer/assets/images/products/single/4-big.jpg">
                                                <img src="/customer/assets/images/products/single/4-small.jpg" alt="product back">
                                            </a> -->
                                        </div><!-- End .product-image-gallery -->
                                    </div><!-- End .row -->
                                </div><!-- End .product-gallery -->
                            </div><!-- End .col-md-6 -->

                            <div class="col-md-6">
                                <div class="product-details">
                                    <h1 class="product-title">{{$itemDetails->name}}</h1><!-- End .product-title -->

                                    <div class="ratings-container">
                                        <div class="ratings">
                                            <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                                        </div><!-- End .ratings -->
                                        <a class="ratings-text" href="#product-review-link" id="review-link">({{ $reviews->count() }} Reviews)</a>
                                    </div><!-- End .rating-container -->

                                    <div class="product-price">
                                        Rs {{$itemDetails->price}}
                                    </div><!-- End .product-price -->

                                    <!-- <div class="product-content">
                                        <p>Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing. Sed lectus. </p>
                                    </div> -->

                                    <!-- <div class="details-filter-row details-row-size">
                                        <label>Color:</label>

                                        <div class="product-nav product-nav-thumbs">
                                            <a href="#" class="active">
                                                <img src="/customer/assets/images/products/single/1-thumb.jpg" alt="product desc">
                                            </a>
                                            <a href="#">
                                                <img src="/customer/assets/images/products/single/2-thumb.jpg" alt="product desc">
                                            </a>
                                        </div>
                                    </div> -->
                                    <div class="details-filter-row details-row-size">
                                        <label for="size">Size:</label>
                                        <div class="select-custom">
                                            @if($itemDetails->category_type !== 'WearingItems') {{-- Check if the category type is not "Wearing Items" --}}
                                                <select name="size" id="size" class="form-control">
                                                    <option value="" selected="selected">Select a size</option>
                                                    @php
                                                        $sizeMapping = [
                                                            'S' => 'Small',
                                                            'M' => 'Medium',
                                                            'L' => 'Large',
                                                            'XL' => 'Extra Large',
                                                            '2XL' => '2X Large',
                                                            '3XL' => '3X Large',
                                                            '4XL' => '4X Large',
                                                            '5XL' => '5X Large',
                                                        ];
                                    
                                                        $sizeData = json_decode($itemDetails->size, true);
                                                    @endphp
                                    
                                                    @foreach($sizeData as $data)
                                                        @if(array_key_exists($data, $sizeMapping))
                                                            <option value="{{ $data }}">{{ $sizeMapping[$data] }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            @else
                                                <span>Size selection is not applicable for Wearing Items.</span>
                                            @endif
                                        </div><!-- End .select-custom -->
                                        
                                        @if($itemDetails->category_type !== 'WearingItems')
                                            <a href="#" class="size-guide"><i class="icon-th-list"></i>size guide</a>
                                        @endif
                                    </div><!-- End .details-filter-row -->
                                    
                                    <div class="details-filter-row details-row-size">
                                        <label for="qty">Qty:</label>
                                        <div class="product-details-quantity">  
                                            <input type="number" id="quantity" class="form-control" value="1" min="1" max="{{ $itemDetails->quantity }}" step="1" data-decimals="0" required>
                                        </div><!-- End .product-details-quantity -->
                                    </div><!-- End .details-filter-row -->

                                    <div class="product-details-action">
                                    @if(Auth::guard('customer')->check())  
                                       @if(Auth::guard('customer')->user()->id == $itemDetails->seller_ID)
                                            <a   href="javascript:void(0);"  class="btn-product btn-cart"><span>It's Your Product</span></a>
                                       @else
                                           <!-- If the item is already in the cart -->
                                            @if(count($cartDetails) > 0)
                                                <a href="javascript:void(0);" class="btn-product btn-cart"><span>Item Added Already</span></a>
                                            @else
                                                <!-- Add to Cart Button -->
                                                <a href="javascript:void(0);" onclick="addToCart({{ $itemDetails->item_ID }} , this)" class="btn-product btn-cart"><span>Add to Cart</span></a>
                                            @endif
                                            
                                            <!-- Wishlist Button -->
                                            <div class="details-action-wrapper">
                                                <a href="javascript:void(0);" onclick="addToWishlist({{ $itemDetails->item_ID }} , this)" class="btn-product btn-wishlist" title="Wishlist">
                                                    <span>Add to Wishlist</span>
                                                </a>
                                            </div><!-- End .details-action-wrapper -->
                                           
                                        @endif
                                      
                                    @else
                                        <a   href="javascript:void(0);"   onclick="needLogin()" class="btn-product btn-cart"><span>add to cart</span></a>
                                    @endif

                                    </div><!-- End .product-details-action -->

                                    <div class="product-details-footer">
                                        <div class="product-cat">
                                            <span>Category:</span>

                                            @foreach ($categories as $category) 
                                                @if ($category->category_ID == $itemDetails->category_ID) 
                                                
                                                    <a href="#">{{$category->type}}</a>,
                                                    <a href="#">{{$category->name}}</a>

                                                @endif
                                            @endforeach
                                        </div><!-- End .product-cat -->

                                        <div class="social-icons social-icons-sm">
                                            <span class="social-label">Share:</span>
                                            <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                            <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                                            <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                                            <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                                        </div>
                                    </div><!-- End .product-details-footer -->

                                    <!-- Virtual Fit Button -->
                                        <a href="javascript:void(0);" onclick="startVirtualFit({{ $itemDetails->item_ID }} , this)" class="btn btn-outline-dark-3 btn-more" style=" margin-left: 10px">
                                            <span>Virtual Fit</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </a>

                                </div><!-- End .product-details -->
                            </div><!-- End .col-md-6 -->
                        </div><!-- End .row -->
                    </div><!-- End .product-details-top -->

                    <div class="product-details-tab">
                        <ul class="nav nav-pills justify-content-center" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Additional information</a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping & Returns</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews ({{ $reviews->count() }})</a>
                            </li>
                            <!-- Added Inquiry button -->
                            @if (!Auth::guard('customer')->check() || Auth::guard('customer')->user()->type === 1)
                                <li class="nav-item">
                                    <a class="nav-link" id="product-inquiry-link" data-toggle="tab" href="#product-inquiry-tab" role="tab" aria-controls="product-inquiry-tab" aria-selected="false">Inquiry</a>
                                </li>
                            @endif
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                                <div class="product-desc-content">
                                    {!! $itemDetails->description !!}
                                </div><!-- End .product-desc-content -->
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                                <div class="product-desc-content">
                                    <h3>Information</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna viverra non, semper suscipit, posuere a, pede. Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. </p>

                                    <h3>Fabric & care</h3>
                                    <ul>
                                        <li>Faux suede fabric</li>
                                        <li>Gold tone metal hoop handles.</li>
                                        <li>RI branding</li>
                                        <li>Snake print trim interior </li>
                                        <li>Adjustable cross body strap</li>
                                        <li> Height: 31cm; Width: 32cm; Depth: 12cm; Handle Drop: 61cm</li>
                                    </ul>

                                    <h3>Size</h3>
                                    <p>one size</p>
                                </div><!-- End .product-desc-content -->
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
                                <div class="product-desc-content">
                                    <h3>Delivery & returns</h3>
                                    <p>We deliver to over 100 countries around the world. For full details of the delivery options we offer, please view our <a href="#">Delivery information</a><br>
                                    We hope you’ll love every purchase, but if you ever need to return an item you can do so within a month of receipt. For full details of how to make a return, please view our <a href="#">Returns information</a></p>
                                </div><!-- End .product-desc-content -->
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
                                <div class="reviews">
                                    @foreach ($reviews as $review)
                                    <div class="review">
                                        <div class="row no-gutters">
                                            <div class="col-auto">
                                                <h4><a href="#">{{ $review->user_name }}</a></h4>
                                                <div class="ratings-container">
                                                    <div class="ratings">
                                                        <div class="ratings-val" style="width: {{ $review->rating * 20 }}%;"></div>
                                                    </div>
                                                </div>
                                                <span class="review-date">{{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</span>
                                            </div>
                                            <div class="col">
                                                <div class="review-content">
                                                    <p>{{ $review->content }}</p>
                                                </div>
                                                <div class="review-action">
                                                    <a href="#"><i class="icon-thumbs-up"></i>Helpful ({{ $review->helpful_count }})</a>
                                                    <a href="#"><i class="icon-thumbs-down"></i>Unhelpful ({{ $review->unhelpful_count }})</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @if (!Auth::guard('customer')->check() || Auth::guard('customer')->user()->type === 1)
                                    <!-- Review Submission Form -->
                                    <div class="review-form-container mt-4">
                                        <h4>Submit a review</h4>
                                    
                                        <form id="review-form" action="{{ route('product.review.store', [$itemDetails->item_ID, $itemDetails->seller_ID]) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label>Rating *</label>
                                                <div class="rating-stars">
                                                    <input type="hidden" name="rating" id="rating" required>
                                                    <span class="star" data-value="1">&#9733;</span>
                                                    <span class="star" data-value="2">&#9733;</span>
                                                    <span class="star" data-value="3">&#9733;</span>
                                                    <span class="star" data-value="4">&#9733;</span>
                                                    <span class="star" data-value="5">&#9733;</span>
                                                </div>
                                            </div>
                                            <div class="textarea-container">
                                                <textarea class="form-control" name="review" cols="30" rows="4" id="review" required placeholder="Review *"></textarea>
                                                <button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm submit-btn">
                                                    <span>SUBMIT</span>
                                                    <i class="icon-long-arrow-right"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>

                            <!-- New Inquiry tab content -->
                            <div class="tab-pane fade" id="product-inquiry-tab" role="tabpanel" aria-labelledby="product-inquiry-link">
                            <div class="product-inquiry-content">
                                <h3>Inquiry</h3>
                               
                                <p>If you have any inquiries about this product, please contact us or fill in the inquiry form below.</p>
                                <div class="inquiry-form-container">
                                    <form id="inquiry-form" action="{{ route('product.inquiry.store', $itemDetails->item_ID) }}" method="POST">
                                        @csrf
                                        <!-- Inquiry form fields -->
                                        <div class="textarea-container">
                                            <textarea class="form-control" name="message" cols="30" rows="4" id="inquiry" required placeholder="Message *"></textarea>
                                            <button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm submit-btn">
                                                <span>SUBMIT</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="inquiry-history">
                                    @if ($inquiryDetails && $inquiryDetails->isNotEmpty())
                                        <h3 class="mb-3">Your Inquiries</h3>
                                        <ul class="list-group" id="inquiry-list">
                                            @foreach ($inquiryDetails as $inquiry)
                                                <li class="list-group-item" id="inquiry-{{ $inquiry->id }}">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <strong>Inquiry:</strong>
                                                            <p class="mb-0">{{ $inquiry->message }}</p>
                                                            <small class="text-muted">Submitted on: {{ $inquiry->created_at ? \Carbon\Carbon::parse($inquiry->created_at)->format('F j, Y, g:i a') : 'N/A' }}</small>
                                                        </div>
                                                    </div>
                                                    @if ($inquiry->reply)
                                                        <div class="mt-3 bg-light p-3 rounded">
                                                            <strong>Seller Reply:</strong>
                                                            <p class="mb-0">{{ $inquiry->reply }}</p>
                                                            <small class="text-muted">Replied on: {{ $inquiry->replied_at ? \Carbon\Carbon::parse($inquiry->replied_at)->format('F j, Y, g:i a') : 'N/A' }}</small>
                                                        </div>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>No inquiries submitted for this product yet.</p>
                                    @endif
                                </div>
                            </div><!-- End .product-inquiry-content -->
                        </div><!-- .End .tab-pane -->
                        </div><!-- End .tab-content -->
                    </div><!-- End .product-details-tab -->

                    <h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->

                    <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                        data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "480": {
                                    "items":2
                                },
                                "768": {
                                    "items":3
                                },
                                "992": {
                                    "items":4
                                },
                                "1200": {
                                    "items":4,
                                    "nav": true,
                                    "dots": false
                                }
                            }
                        }'>
                        @foreach($highRateProducts as $item)
                            @php
                                $photos = json_decode($item->photo, true); // Assuming the 'photo' column contains JSON data
                            @endphp
                            <div class="product product-7 text-center">
                                <figure class="product-media">
                                <span class="product-label label-new">New</span>
                                    <a href="/product/{{$item->item_ID}}">
                                        <img src="{{ asset('uploads/' . $photos[0]) }}" alt="Product image" class="product-image">
                                    </a>

                                    <div class="product-action-vertical">
                                        <a href="javascript:void(0);"   onclick="addToWishlist({{ $item->item_ID }} , this)" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                    </div><!-- End .product-action-vertical -->

                                    <div class="product-action">
                                        <a href="/addToCart/{{$item->item_ID}}" class="btn-product btn-cart"><span>add to cart</span></a>
                                    </div><!-- End .product-action -->
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <h3 class="product-title"><a href="/product/{{$item->item_ID}}">{{$item->name}}</a></h3><!-- End .product-title -->
                                    <div class="product-price">
                                        ${{$item->price}}.00
                                    </div><!-- End .product-price -->
                                    <div class="ratings-container">
                                        <div class="ratings">
                                        <div class="ratings-val" style="width: {{ $item->rating_percentage * 20 }}%;"></div>
                                        </div><!-- End .ratings -->
                                        <span class="ratings-text">({{ $item->reviews_count }} Reviews)</span>
                                    </div><!-- End .rating-container -->
                                    <div class="product-nav product-nav-thumbs">
                                        
                                    <a href="#">
                                        @if(isset($photos[1]))
                                            <img src="{{ asset('uploads/' . $photos[1]) }}" alt="product desc">
                                        @endif
                                    </a>
                                    <a href="#">
                                        @if(isset($photos[2]))
                                            <img src="{{ asset('uploads/' . $photos[2]) }}" alt="product desc">
                                        @endif
                                    </a>

                                    <a href="#">
                                        @if(isset($photos[3]))
                                            <img src="{{ asset('uploads/' . $photos[3]) }}" alt="product desc">
                                        @endif
                                    </a>
                                </div><!-- End .product-nav -->
                                </div><!-- End .product-body -->
                            </div><!-- End .product -->
                        @endforeach
                    </div><!-- End .owl-carousel -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->
        <style>
        .inquiry-form-container {
            position: relative;
        }

        .textarea-container {
            position: relative;
            width: 100%;
        }

        .textarea-container textarea {
            width: 100%;
            padding-bottom: 40px; /* Add space at the bottom for the button */
        }

        .submit-btn {
            position: absolute;
            bottom: 10px; /* Position at the bottom */
            right: 10px; /* Position at the right */
            padding: 8px 16px; /* Optional: adjust button size */
        }
    </style>

<script>
    function addToCart(itemID, button) {


        var quantity = document.getElementById("quantity").value;
        
        var size = document.getElementById("size").value;
        

        if (!size) {

            Swal.fire({
                    icon: "error",
                    title: "",
                    text: "Please select a size",
                    footer: ''
                });
            return;  
        }

        $.ajax({
            url: '/addToCart',  
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',  
                item_ID: itemID,   
                quantity: quantity,           
                size: size                   
            },
            success: function(response) {



             if(response.success == 1)
             {
         
                Swal.fire({
                    icon: "success",
                    position: "center",
                    text: response.message,
                    footer: ''
                });

                $(button).html('<span>Item Added Already</span>');

                $(button).attr('onclick', ''); // Remove the onclick attribute to disable future clicks
                
                // Disable the button to prevent further interaction
                $(button).prop('disabled', true);
                
                // Optionally, add a CSS class to change button appearance
                $(button).addClass('disabled');
                
            
             }
             else
             {
     
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: {!! json_encode(\Session::get('delete')) !!},
                    footer: ''
                });
        
             }

            },
            error: function(xhr) {

              
            }
        });
    }


</script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#inquiry-form').on('submit', function (e) {
            e.preventDefault();  

            var form = $(this);
            var formData = form.serialize();  
            
            $.ajax({
                url: form.attr('action'),  
                type: 'POST',
                data: formData,
                success: function (response) {
                    var inquiryList = $('#inquiry-list');

                    if (inquiryList.length === 0) {
                        $('.inquiry-history').html(`
                            <h3 class="mb-3">Your Inquiries</h3>
                            <ul class="list-group" id="inquiry-list"></ul>
                        `);
                        inquiryList = $('#inquiry-list');
                    }

                    inquiryList.prepend(`
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>Inquiry:</strong>
                                    <p class="mb-0">${response.message}</p>
                                    <small class="text-muted">Submitted on: ${response.created_at}</small>
                                </div>
                            </div>
                        </li>
                    `);

                    $('#inquiry').val('');

                    Swal.fire({
                        title: 'Success!',
                        text: 'Your inquiry has been submitted.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                },
                error: function (error) {
                    if (error.responseJSON && error.responseJSON.error && error.responseJSON.error === 'You must be logged in to submit an inquiry.') {
                        Swal.fire({
                            title: 'Login Required',
                            text: 'Please log in first to submit an inquiry.',
                            icon: 'warning',
                            confirmButtonText: 'Log In'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#signin-modal').modal('show');
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an error submitting your inquiry.',
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    }
                }
            });
        });
    });
</script>

<!-- Start of styles and scripts for reviews -->
<style>
    .rating-stars {
        display: flex;
        gap: 5px;
        cursor: pointer;
    }

    .star {
        font-size: 2rem;
        color: #ccc;
        transition: color 0.3s ease;
    }

    /* Highlight stars on hover */
    .rating-stars .star:hover,
    .rating-stars .star:hover ~ .star {
        color: #ffc107;
    }

    /* Highlight selected stars */
    .star.selected {
        color: #ffc107;
    }
</style>
<script>
    document.querySelectorAll('.rating-stars .star').forEach(star => {
        star.addEventListener('click', function () {
            const ratingValue = this.getAttribute('data-value');
            document.getElementById('rating').value = ratingValue;
            
            // Reset all stars
            document.querySelectorAll('.rating-stars .star').forEach(s => s.classList.remove('selected'));

            // Highlight the selected stars
            this.classList.add('selected');
            let previousStar = this.previousElementSibling;
            while (previousStar) {
                previousStar.classList.add('selected');
                previousStar = previousStar.previousElementSibling;
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#review-form').on('submit', function (e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize(); // Serialize the form for AJAX submission

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                success: function (response) {
                    var reviewList = $('#review-list');

                    if (reviewList.length === 0) {
                        $('.review-history').html(`
                            <h3 class="mb-3">Your Reviews</h3>
                            <ul class="list-group" id="review-list"></ul>
                        `);
                        reviewList = $('#review-list');
                    }

                    reviewList.prepend(`
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>Review:</strong>
                                    <p class="mb-0">${response.message}</p>
                                    <small class="text-muted">Submitted on: ${response.created_at}</small>
                                </div>
                            </div>
                        </li>
                    `);

                    $('#review').val(''); // Clear the review input field

                    Swal.fire({
                        title: 'Success!',
                        text: 'Your review has been submitted successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                },
                error: function (error) {
                    if (error.responseJSON && error.responseJSON.error === 'You must be logged in to submit a review.') {
                        Swal.fire({
                            title: 'Login Required',
                            text: 'Please log in first to submit a review.',
                            icon: 'warning',
                            confirmButtonText: 'Log In'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#signin-modal').modal('show'); 
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an error submitting your review.',
                            icon: 'error',
                            confirmButtonText: 'Try Again'
                        });
                    }
                }
            });
        });
    });
</script>

 <!-- End of styles and scripts for reviews -->


 <!-- Wishlist and virtual fit functions -->
 <script>
    function addToWishlist(itemID, button) {
        $.ajax({
            url: '/addToWishlist',  
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',  
                item_ID: itemID                 
            },
            success: function(response) {
                if (response.success == 1) {
                    Swal.fire({
                        icon: "success",
                        position: "center",
                        text: response.message,
                        footer: ''
                    });

                    // Update the button state and appearance
                    $(button).html('<i class="heart-icon heart-filled"></i> <span>Item Added Already</span>');  // Change heart icon to filled
                    $(button).attr('onclick', ''); // Remove the onclick attribute
                    $(button).prop('disabled', true); // Disable the button
                    $(button).addClass('disabled'); // Optionally add a class to disable the button

                } else if (response.success == 0) {
                    Swal.fire({
                        icon: "info",
                        position: "center",
                        text: response.message, // Show the message from the response
                        footer: ''
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong! Please try again later.",
                    footer: ''
                });
            }
        });
    }

    function startVirtualFit(itemID, element) {
    console.log(`Starting Virtual Fit for item ID: ${itemID}`);
}

</script>

 @endsection