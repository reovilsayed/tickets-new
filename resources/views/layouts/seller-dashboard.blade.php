@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend-old-assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/slick.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-old-assets/responsive.css') }}" />
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('assets/frontend-old-assets/css/backgrounds/bg-4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/seller.css') }}">
    <style>
        .navbar .navbar-nav .nav-link {
            color: black;
        }

        @media (min-width: 1200px){
             .container {
            max-width: 1300px !important;
        }
    }
    </style>
    @yield('styles')
@endsection

@section('content')
    <!-- Vendor dashboard section -->
    <section class="ec-page-content ec-vendor-dashboard section-space-p">
        <div class="container">
            <div class="row">
                <!-- Sidebar Area Start -->
                <x-app.seller_sidebar />
                @yield('dashboard-content')
            </div>
        </div>
    </section>
    <!-- End Vendor dashboard section -->
@endsection
@section('js')
    <script src="{{ asset('assets/frontend-old-assets/js/plugins/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/multiple-select.js') }}"></script>

    <script src="{{ asset('assets/frontend-old-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-old-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>
    <script src="{{ asset('assets/frontend-old-assets/js/vendor/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('assets/frontend-old-assets/js/main.js') }}"></script>
    
    {{-- <script>
        $(document).ready(function() {
    
    $('input[name="input"]').tagsinput({
        trimValue: true,
        confirmKeys: [13, 44, 32],
        focusClass: 'my-focus-class'
    });
    
    $('.bootstrap-tagsinput input').on('focus', function() {
        $(this).closest('.bootstrap-tagsinput').addClass('has-focus');
    }).on('blur', function() {
        $(this).closest('.bootstrap-tagsinput').removeClass('has-focus');
    });
    
    });
    
    </script> --}}
    @yield('scripts')
@endsection
