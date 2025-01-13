@extends('Customer.head')
@section('content')

<div class="page-wrapper">

    @include('Customer.header')

    <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact us</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
            <div class="container">
                <div class="page-header page-header-big text-center"
                    style="background-image: url('/customer/assets/images/contact-header-bg.jpg')">
                    <h1 class="page-title text-white">Contact us<span class="text-white">keep in touch with us</span>
                    </h1>
                </div><!-- End .page-header -->
            </div><!-- End .container -->

            <div class="page-content pb-0">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 mb-2 mb-lg-0">
                            <h2 class="title mb-1">Contact Information</h2><!-- End .title mb-2 -->
                            <p class="mb-3">Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu
                                pulvinar nunc sapien ornare nisl. Phasellus pede arcu, dapibus eu, fermentum et, dapibus
                                sed, urna.</p>
                            <div class="row">
                                <div class="col-sm-7">
                                    <div class="contact-info">
                                        <h3>The Office</h3>
                                        <ul class="contact-list">
                                            <li>
                                                <i class="icon-map-marker"></i>
                                                70 Washington Square South New York, NY 10012, United States
                                            </li>
                                            <li>
                                                <i class="icon-phone"></i>
                                                <a href="tel:#">+92 423 567</a>
                                            </li>
                                            <li>
                                                <i class="icon-envelope"></i>
                                                <a href="mailto:#">info@Molla.com</a>
                                            </li>
                                        </ul><!-- End .contact-list -->
                                    </div><!-- End .contact-info -->
                                </div><!-- End .col-sm-7 -->
            
                                <div class="col-sm-5">
                                    <div class="contact-info">
                                        <h3>The Office</h3>
                                        <ul class="contact-list">
                                            <li>
                                                <i class="icon-clock-o"></i>
                                                <span class="text-dark">Monday-Saturday</span> <br>11am-7pm ET
                                            </li>
                                            <li>
                                                <i class="icon-calendar"></i>
                                                <span class="text-dark">Sunday</span> <br>11am-6pm ET
                                            </li>
                                        </ul><!-- End .contact-list -->
                                    </div><!-- End .contact-info -->
                                </div><!-- End .col-sm-5 -->
                            </div><!-- End .row -->
                        </div><!-- End .col-lg-6 -->
                    </div><!-- End .row -->
            
                    <hr class="mt-4 mb-5">
            
                </div><!-- End .container -->
            </div><!-- End .page-content -->
            
        </main><!-- End .main -->
    @endsection