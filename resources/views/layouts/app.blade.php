<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>@yield('title', setting('site.title'))</title>
    <meta name="description" content="@yield('meta_description', setting('site.description'))">
    <meta name="keywords" content="@yield('keywords', setting('site.keywords'))">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title', setting('site.title'))" />
    <meta property="og:description" content="@yield('description', setting('site.description'))" />
    <meta property="og:image" content="{{ Voyager::image(setting('site.facebook_image')) }}" />
    @yield('head')


    <link rel="shortcut icon" href="{{ asset('assets/frontend-assets/img/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-old-assets/css/vendor/ecicons.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/style.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css"
    crossorigin="anonymous" />

    <style>
        div#ec_news_signup {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            border: 1px solid #9f8061 !important;
            padding: 5px;
            border-radius: 5px;
        }

        
        .iti__selected-dial-code{
            font-size: 16px;
        }
        .ec-subscribe-form .ec-email {
            display: inline-block;
            vertical-align: top;
            line-height: 35px;
            height: 35px;
            color: #fff !important;
            font-size: 16px;
            width: calc(100% - 35px);
            border: 0;
            background: transparent;
            border-radius: 0;
            -webkit-border-radius: 0;
            text-align: left;
            padding-left: 10px;
            padding-right: 10px;
            letter-spacing: 0.5px;
        }
        
        .invalid-feedback {
            font-size: 12px;
        }

        #country {
            height: 45px !important;
            color: #656060 !important;
        }

        
    </style>

    <style>
        .custom-button{
            text-align: center;
        }
   
    </style>
    @yield('css')

    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PXMPPQHC');</script>
    <!-- End Google Tag Manager -->
</head>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PXMPPQHC"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!-- Preloader -->
    <div class="preloader-bg"></div>
    <div id="preloader">
        <div id="preloader-status">
            <div class="preloader-position loader"> <span></span> </div>
        </div>
    </div>

    <div class="progress-wrap cursor-pointer">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- Navbar -->
    @include('layouts.nav')
    @yield('content')


    <!-- Modal -->
    <div class="modal fade" id="ageVerifyModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content pop-up p-3">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="img-pop-up">
                                <img class="img-pop text-center" src="/assets/logo-black.png" alt="">
                            </div>
                            <h4 class="pop-header-text">
                                {!! __('words.popup_header_title_1') !!}.
                                <br>
                                <strong>{!! __('words.popup_header_title_2') !!}</strong>
                            </h4>
                            <div class="btn-pop">
                                <form action="{{ route('verify.age') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="verify" value="1">
                                    <button type="submit" data-bs-dismiss="modal"
                                        class="btn btn-yes">{!! __('words.yes') !!}</button>
                                </form>
                                <form action="{{ route('verify.age') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="verify" value="0">
                                    <button type="submit" class="btn btn-no">{!! __('words.no') !!}</button>
                                </form>
                            </div>
                            <h6 class="pop-footer-text">
                                {!! __('words.popup_footer_title_1') !!}
                                <br>
                                <br>
                                {!! __('words.popup_footer_title_2') !!}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (
        !in_array(url()->current(), [
            route('zone.enter'),
            route('zone.scanner'),
            route('extraszone.enter'),
            route('extraszone.scanner'),
        ]))
        <footer class="footer">
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="footer-column footer-about">
                                {{-- <h3 class="footer-title">{{ __('words.about') }}</h3> --}}
                                {{-- <p class="footer-about-text">{{ setting('site.about') }}</p> --}}

                                <div class=" mt-3 mb-3 d-flex justify-content-end align-items-center p-0">


                                    <div class="ec-subscribe-form ">
                                        <label for="" class="text-white mb-3"
                                            style="font-size:22px">{{ __('words.subcribe_now') }} :</label>
                                        <div id="ec_news_signup" class="ec-form footer-email">


                                            <button id="ec-news-btn" class="butn-dark2 " type="submit"
                                                name="subscribe" value="">
                                                <span><a target="_blank"
                                                        href="https://lp.egoi.page/1eIe6Y8m/signup">{{ __('words.subcribe') }}</a></span>
                                            </button>


                                        </div>
                                        <!-- Button trigger modal -->
                                        {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop">
                                        popup testing
                                    </button> --}}
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-3 offset-md-1">
                            <div class="footer-column footer-explore clearfix">

                                <h3 class="footer-title">{{ __('words.explore') }}</h3>
                                <div class="line-footer mb-2"></div>

                                <ul class="footer-explore-list list-unstyled">
                                    {{-- <li><a href="{{ route('homepage') }}"></a></li> --}}
                                    {{-- <li><a href="{{ route('about') }}">About</a></li> --}}
                                    <li><a href="{{ route('contact') }}">{{ __('words.contact') }}</a></li>
                                    <li><a
                                            href="{{ url('page/terms-and-conditions') }}">{{ __('words.terms_&_conditions') }}</a>
                                    </li>
                                </ul>
                                {{-- {!! menu('main', 'menus.bootstrap') !!} --}}

                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="footer-column footer-contact">
                                <h3 class="footer-title line-cont">{{ __('words.contact') }}</h3>
                                <div class="line-footer mb-2"></div>
                                <p class="footer-contact-text">{{ setting('site.description') }}</p>
                                <div class="footer-contact-info">
                                    <p class="footer-contact-phone"><span class="flaticon-call"></span>
                                        <a href="" class="text-white">{{ setting('site.phone') }}</a>
                                    </p>
                                    <p class="footer-contact-phone"><span class="flaticon-envelope"></span>
                                        <a href=""class="text-white">{{ setting('site.email') }}</a>
                                    </p>
                                    {{-- <p><a href="#" class="text-white">{{ __('Contact_us') }}</a></p> --}}
                                </div>
                                <div class="footer-about-social-list">
                                    <a href="{{ setting('social.fb_link') }}"><i
                                            class="fa-brands fa-facebook fa-lg"></i></a>
                                    <a href="{{ setting('social.inst_link') }}"><i
                                            class="fa-brands fa-square-instagram fa-lg"></i></a>
                                    <a href="{{ setting('social.twiter_link') }}"><i
                                            class="fa-brands fa-twitter fa-lg"></i></a>
                                    <a href="{{ setting('social.youtube') }}"><i
                                            class="fa-brands fa-youtube fa-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="footer-bottom-inner">
                                <img src="{{ asset('assets/easypay.png') }}" alt="" style="width:313px;">
                                <p class="footer-bottom-copy-right">{{ __('words.copyright') }}<a
                                        href="{{ url('/') }}"> {{ setting('site.title') }}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"
        integrity="sha512-6sSYJqDreZRZGkJ3b+YfdhB3MzmuP9R7X1QZ6g5aIXhRvR1Y/N/P47jmnkENm7YL3oqsmI6AK+V6AD99uWDnIw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <x-alert :exclude="[route('user.update_profile')]" />
    <!-- jQuery -->
    <script src="{{ asset('assets/frontend-assets/js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/jquery-migrate-3.0.0.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/modernizr-2.6.2.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/jquery.isotope.v3.0.2.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/pace.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/scrollIt.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/YouTubePopUp.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/select2.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/smooth-scroll.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/frontend-assets/js/custom.js') }}"></script>

    @if (request()->cookie('age-verification') == null)
        <script>
            const ageVerifyModal = document.getElementById('ageVerifyModal');
            if (ageVerifyModal) {
                // Assuming you are using Bootstrap for modal functionality
                let modal = new bootstrap.Modal(ageVerifyModal);
                modal.show();
            }
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('.toast').toast('show');
        })
        $('.toast_close').click(function() {
            $('.toast').toast('hide');
        })
    </script>
    <script>
        $(document).ready(function() {
            $('#language-select').on('change', function() {
                var selectedValue = $(this).val();
                lan(selectedValue);
            });

        });

        function lan(e) {
            var currentUrl = window.location.href;
            var url = new URL(currentUrl);
            url.searchParams.set("lang", e);
            var newUrl = url.href;
            window.location = newUrl;
        }
    </script>

    
    @yield('js')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js'></script>
    <script>
        $(document).ready(function() {
       
           
            var countryData = window.intlTelInputGlobals.getCountryData();
          
    
                input = document.querySelector("#intl-phone"),
                addressDropdown = document.querySelector("#country");

            // init plugin
            var iti = window.intlTelInput(input, {
                separateDialCode: true,
                hiddenInput: $("#intl-phone").attr('name'),
                preferredCountries:["pt",'es'],
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // just for formatting/placeholders etc
            });

            // populate the country dropdown
            for (var i = 0; i < countryData.length; i++) {
                var country = countryData[i];
                var optionNode = document.createElement("option");
                optionNode.value = country.iso2;
                var textNode = document.createTextNode(country.name);
                optionNode.appendChild(textNode);
                // addressDropdown.appendChild(optionNode);
            }
          
        });
    </script>
    <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="8fc255b6-8403-4435-9842-852bd91ab47f"
        data-blockingmode="auto" type="text/javascript"></script>
</body>

</html>
