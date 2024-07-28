<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <title>@yield('title', setting('site.title'))</title>
    <meta name="keywords"
        content="apparel, catalog, clean, ecommerce, ecommerce HTML, electronics, fashion, html eCommerce, html store, minimal, multipurpose, multipurpose ecommerce, online store, responsive ecommerce template, shops" />
    <meta name="description" content="Best ecommerce html template for single and multi vendor store.">
    <meta name="author" content="ashishmaraviya">

    <!-- site Favicon -->
    <link rel="icon" href="{{ Voyager::image(setting('site.icon')) }}" sizes="32x32" />
    <link rel="apple-touch-icon" href="{{ Voyager::image(setting('site.icon')) }}" />
    <meta name="msapplication-TileImage" content="{{ Voyager::image(setting('site.icon')) }}" />

    <!-- css Icon Font -->
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/vendor/ecicons.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    {{-- google font --}}


    <!-- css All Plugins Files -->


    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/jquery-ui.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/countdownTimer.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/nouislider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/slick.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/star-rating.css') }}">
    <link rel="stylesheet" href="cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <link rel="stylesheet" href="{{ asset('assets/custom.css') }}">



    <style>
        .category-drop::after {
            top: 7px !important;
        }
    </style>



    <!-- Main Style -->

    @yield('css')
    <style>
        .ec-footer {
            background: #fff !important;
        }

        .ec-footer .footer-top .ec-footer-widget .ec-footer-links .ec-footer-link:not(:last-child) {
            /* margin-bottom: 0 !important; */

        }

        .ec-footer .footer-top .ec-footer-widget .ec-footer-heading {
            color: #212529 !important;

        }

        .ec-footer .footer-top .ec-footer-widget .ec-footer-heading::before {
            border-bottom: 1px solid #000000 !important;
        }

        .footer-bottom .ec-copy .site-name:hover {
            color: #000 !important;
            ;
        }

        #scrollUp {
            background-color: #000000 !important;
        }

        .is-invalid {
            border: 1px solid red !important;
        }
    </style>

</head>

<body>
    <!-- <div id="ec-overlay">
        <div class="ec-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div> -->
    <!-- Header start  -->
    @yield('content')

    <!-- Footer Start -->
    <footer class="ec-footer border-0" id="footer">
        <div class="footer-container">
            <div class="footer-offer">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-md-3 d-flex align-items-center" style="height:140px">
                            <div class="align-self-center">
                                <div class="header-logo">
                                    <a href="{{ route('homepage') }}">
                                        <img src="{{ Voyager::image(setting('site.newslletter_logo')) }}"
                                            alt="{{ setting('site.title') }}">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 mb-3 d-flex justify-content-end align-items-center p-0">
                            <div><span class="text-white" style="font-size: 13px">Join our weekly email list! </span>
                            </div>
                            <form style="width: 70%" name="ec-newsletter-form" method="post"
                                action="{{ route('subscribe') }}">
                                @csrf
                                <div class="ec-subscribe-form ms-3 ">
                                    <div id="ec_news_signup" class="ec-form footer-email">
                                        <input class="ec-email pt-2" type="email" required=""
                                            placeholder="Enter your email here..." name="email" value="" />
                                        <button id="ec-news-btn" class="btn btn-dark ms-3 rounded-pill mx-1 shadow-sm"
                                            type="submit" name="subscribe" value="">Subscribe</button>
                                    </div>

                                </div>
                            </form>


                        </div>

                    </div>
                </div>
            </div>
            <div class="footer-top section-space-footer-p border-0" id="#footer">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-sm-12 col-lg-3 ec-footer-contact d-flex justify-content-center">
                            <div class="ec-footer-widget">
                                <!-- <div class="ec-footer-logo"><a href="#"><img src="assets/images/logo/footer-logo.png" alt=""><img class="dark-footer-logo" src="assets/images/logo/dark-logo.png" alt="Site Logo" style="display: none;" /></a></div>
                                <h4 class="ec-footer-heading">Contact us</h4> -->
                                <ul class="mb-2" style="width: 280px">
                                    <li class="list-inline-item"><a class="hdr-facebook" href="#"><i
                                                class="ecicon eci-facebook e rounded-circle p-3  d-flex justify-content-center"
                                                style="font-size:15px; height:47px; width:45px;"></i></a>
                                    </li>
                                    <li class="list-inline-item"><a class="hdr-linkedin" href="#"><i
                                                class="ecicon eci-linkedin  rounded-circle p-3 "
                                                style="font-size:15px"></i></a>
                                    </li>
                                    <li class="list-inline-item"><a class="hdr-instagram" href="#"><i
                                                class="ecicon eci-instagram rounded-circle p-3  border"
                                                style="font-size:15px; "></i></a>
                                    </li>
                                    <li class="list-inline-item"><a class="hdr-twitter" href="#"><i
                                                class="ecicon eci-twitter  rounded-circle p-3  border"
                                                style="font-size:15px"></i></a>
                                    </li>


                                    <p class="py-4" style="font-size: 13px">Follow our social media for Ahromart
                                        news and updates. </p>
                                </ul>
                                <div class="ec-footer-links">

                                    <ul class="align-items-center">

                                        <li class=" text-dark " style="font-size:13px"><span><i
                                                    class="fa-solid fa-phone me-1"></i><strong>Call
                                                    Us:</strong></span>1233-777</li>
                                        <li class=" text-dark " style="font-size:13px"><span><i
                                                    class="fa-solid fa-envelope me-1"></i><strong>Email:</strong></span>ahamart@contact.com
                                        </li>


                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-3 ec-footer-account d-flex justify-content-center">
                            <div class="ec-footer-widget ">
                                <h4 class="ec-footer-heading" class="text-dark "
                                    style="border: none;padding-bottom: 0px;color: #0B1D42 !important;">Account
                                </h4>
                                <div class="div" style="width: 15%;border-bottom: 3px solid #3BB77E;">

                                </div>
                                <div class="ec-footer-links  col-sm-12  ">
                                    <ul class="align-items-center">
                                        <li class="ec-footer-link"><a href="{{ route('login') }}"
                                                class="text-dark mt-3">Sign in</a></li>
                                        <li class="ec-footer-link"><a href="{{ route('vendor.create') }}"
                                                class="text-dark">Become a Seller</a></li>

                                        <li class="ec-footer-link"><a href="{{ route('user.ordersIndex') }}"
                                                class="text-dark">Orders</a></li>
                                        <li class="ec-footer-link"><a href="{{ route('vendor.dashboard') }}"
                                                class="text-dark">Seller Board</a></li>

                                        <li class="ec-footer-link"><a href="{{ route('shops', ['featured']) }}"
                                                class="text-dark">Hot deals</a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-3 ec-footer-account d-flex justify-content-center">
                            <div class="ec-footer-widget ">
                                <h4 class="ec-footer-heading" class="text-dark "
                                    style="border: none;padding-bottom: 0px;color: #0B1D42 !important;">Useful links
                                </h4>
                                <div class="div" style="width: 15%;border-bottom: 3px solid #3BB77E;">

                                </div>
                                <div class="ec-footer-links  col-sm-12  ">
                                    {!! menu('leftside', 'menus.bootstrap') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-3 ec-footer-service d-flex justify-content-center">
                            <div class="ec-footer-widget">
                                <h4 class="ec-footer-heading" class="text-dark "
                                    style="border: none;padding-bottom: 0px;color: #0B1D42 !important;">Useful links
                                </h4>
                                <div class="div" style="width: 15%;border-bottom: 3px solid #3BB77E;">

                                </div>
                                <div class="ec-footer-links">


                                    {!! menu('main', 'menus.bootstrap') !!}


                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="footer-bottom border-top">
                <div class="container">
                    <div class="row align-items-center">

                        <!-- Footer Copyright Start -->
                        <div class="col text-center footer-copy">
                            <div class="footer-bottom-copy d-flex justify-content-start ">
                                <div class="ec-copy text-dark text-left" style="color:#000000 !important;opacity:1;">
                                    Copyright © 2023 <a class="site-name text-upper"
                                        href="#">Ahromart<span>.</span></a>. All Rights Reserved</div>
                                <div class="img">
                                </div>
                            </div>
                        </div>
                        <!-- Footer Copyright End -->
                        <!-- Footer payment -->
                        <div class="col footer-bottom-right">
                            <div class="footer-bottom-payment d-flex justify-content-end">
                                <div class="payment-link">
                                    <img src="{{ asset('assets/img/cards.png') }}" alt="">
                                </div>

                            </div>
                        </div>
                        <!-- Footer payment -->
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Area End -->


    <div class="modal fade" id="ec_quickview_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="btn-close qty_close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-body" id="quick_view">

                </div>
            </div>
        </div>
    </div>
    <!-- Newsletter Modal Start -->
    <div id="ec-popnews-bg"></div>
    <div id="ec-popnews-box">
        <div id="ec-popnews-close"><i class="ecicon eci-close"></i></div>
        <div class="row">
            <div class="col-md-6 disp-no-767">
                <img src="{{ Voyager::image(setting('site.newslletter_logo')) }}" alt="newsletter">
            </div>
            <div class="col-md-6">
                <div id="ec-popnews-box-content">
                    <h2>Subscribe Newsletter</h2>
                    <p>Subscribe the ekka ecommerce to get in touch and get the future update. </p>
                    <form id="ec-popnews-form" action="{{ route('subscribe') }}" method="post">
                        @csrf
                        <input type="email" name="email" placeholder="Email Address" required />
                        <button type="submit" class="btn btn-primary" name="subscribe">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Newsletter Modal end -->


    <!-- Footer navigation panel for responsive display -->
    <div class="ec-nav-toolbar">
        <div class="container">
            <div class="ec-nav-panel">
                <div class="ec-nav-panel-icons">
                    <a href="#ec-mobile-menu" class="navbar-toggler-btn ec-header-btn ec-side-toggle"><i
                            class="fi-rr-menu-burger"></i></a>
                </div>
                <div class="ec-nav-panel-icons">
                    <a href="#ec-side-cart" class="toggle-cart ec-header-btn ec-side-toggle"><i
                            class="fi-rr-shopping-bag"></i><span
                            class="ec-cart-noti ec-header-count cart-count-lable">3</span></a>
                </div>
                <div class="ec-nav-panel-icons">
                    <a href="{{ route('homepage') }}" class="ec-header-btn"><i class="fi-rr-home"></i></a>
                </div>
                <div class="ec-nav-panel-icons">
                    <a href="wishlist.html" class="ec-header-btn"><i class="fi-rr-heart"></i><span
                            class="ec-cart-noti">4</span></a>
                </div>
                <div class="ec-nav-panel-icons">
                    <a href="login.html" class="ec-header-btn"><i class="fi-rr-user"></i></a>
                </div>

            </div>
        </div>
    </div>

    <x-alert :exclude="[route('user.update_profile')]" />

    <!-- Vendor JS -->
    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/vendor/modernizr-3.11.2.min.js') }}"></script>

    <!--Plugins JS-->

    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/countdownTimer.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/nouislider.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/slick.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/infiniteslidev2.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/click-to-call.js') }}"></script>

    <!-- Main Js -->
    <!-- <script src="{{ asset('assets/js/filter.js') }}"></script> -->
    <script src="{{ asset('assets/frontend-assets/js/vendor/index.js') }}"></script>
    <script src="{{ asset('assets/js/star-rating.js') }}"></script>
    <script src="cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"></script>
    <script>
        function cartQnty() {
            $.ajax({
                type: 'get',
                url: '/cart-qty',
                success: function(response) {
                    console.log(response);

                    $('#cartQty').text(response);
                    if (response == 0) {
                        $('#cartQty').hide();
                    } else {
                        $('#cartQty').show();
                    }
                },
                error: function(xhr) {
                    // Handle the error response
                    console.log(xhr.responseText);
                }
            });
        }

        cartQnty();
        console.log(cartQnty())
        $(document).ready(function() {
            $('.cart-store').click(function() {
                var addToCartBtn = $(this);
                var productId = $(this).data('product-id');
                var quantity = $('.addToCartForm_' + productId).find('.qty').val();
                var oldQty = "{{ Cart::getTotalQuantity() }}";
                var parentDiv = $(this).closest('.ec-product-inner');

                $.ajax({
                    type: 'POST',
                    url: '/add-cart',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                        // Handle the success response
                        console.log(response);
                        cartQnty();
                        addToCartBtn.attr('disabled', true);
                        parentDiv.find('.fi-rr-shopping-basket').addClass('text-success').attr(
                            'disabled', true);
                        parentDiv.find('#addToCartBtn').text('added').attr('disabled', true);

                    },
                    error: function(xhr) {
                        // Handle the error response
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>

    <script>
        function quickView(id) {

            $.ajax({
                url: '/quickview',
                method: 'GET',
                data: {
                    product_id: id
                },
                success: function(response) {
                    $('#ec_quickview_modal').modal('show')
                    $('#quick_view').html(response)
                },

            });
        }
    </script>


    <script>
        function wishlist(id) {

            $.ajax({
                url: '/wishlist/add',
                method: 'GET',
                data: {
                    productId: id
                },
                success: function() {
                    var element = $('.add-wish-new_' + id);
                    if (element.hasClass('fa-solid')) {
                        element.addClass('fa-regular').removeClass('fa-solid text-success');
                    } else {
                        element.addClass('fa-solid text-success').removeClass('fa-regular ');
                    }


                }

            });
        }
    </script>

    <script>
        var shopUrl = "{{ route('shops') }}";

        function updateSearchParams(searchParam, searchValue, route) {
            var url;

            if (window.location.pathname !== "/shops" || (new URL(route)).pathname == '/vendors') {
                url = new URL(route);
            } else {
                url = new URL(window.location.href);
            }

            url.searchParams.set(searchParam, searchValue);

            // Get the existing parameters from the current URL
            var existingParams = new URLSearchParams(window.location.search);

            // Remove the existing parameter that matches the searchParam
            existingParams.delete(searchParam);

            // Append the new parameters to the existing parameters
            existingParams.forEach((value, key) => {
                url.searchParams.set(key, value);
            });

            const newUrl = url.href;
            window.location = newUrl;
        }
    </script>


    <script>
        $(document).ready(function() {
            $('#ratingForm input[type="checkbox"]').on('change', function() {
                updateSearchParams("ratings", $(this).val(), shopUrl);
            });
        });
    </script>



    <script>
        $("#product_rating").rating({
            showCaption: true
        });
        $(".published_rating").rating({
            showCaption: false,
            readonly: true,
        });
    </script>

    @yield('js')
    <script>
        $(document).ready(function() {
            $('.toast').toast('show');
        })
        $('.toast_close').click(function() {
            $('.toast').toast('hide');
        })
    </script>
    @if (session()->has('subscribeEmail'))
        <script>
            var dataValue = true;
            ecCreateCookie('ecPopNewsLetter', dataValue, 1);
        </script>
    @endif

</body>

</html>
