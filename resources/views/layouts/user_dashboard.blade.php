@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/frontend-old-assets/css/style.css') }}" />
<link rel="stylesheet"
    href="{{ asset('assets/frontend-old-assets/css/plugins/slick.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/frontend-old-assets/responsive.css') }}" />
<link rel="stylesheet" id="bg-switcher-css"
    href="{{ asset('assets/frontend-old-assets/css/backgrounds/bg-4.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/seller.css') }}">

<style>
        .navbar .navbar-nav .nav-link {
            color: black;
        }
</style>
@endsection

@section('content')

{{-- <x-app.header /> --}}
{{-- <x-app.breadcrumb /> --}}


<!-- Vendor dashboard section -->
<section class="ec-page-content ec-vendor-dashboard section-space-p">
    <div class="container">
        <div class="row">
            <!-- Sidebar Area Start -->
            <x-app.user_sidebar />
            @yield('dashboard-content')
        </div>

    </div>
</section>
<!-- End Vendor dashboard section -->
@endsection
@section('js')
<script src="{{ asset('assets/frontend-old-assets/js/vendor/jquery.magnific-popup.min.js') }}">
</script>
<script src="{{ asset('assets/frontend-old-assets/js/plugins/jquery.sticky-sidebar.js') }}">
</script>

<script src="{{ asset('assets/frontend-old-assets/js/main.js') }}"></script>
@endsection
