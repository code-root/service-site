<!DOCTYPE html>
<html class="no-js" lang="{{ $locale }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $basicFields['site_name'] ?? 'Amazing' }} | @yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ asset('storage/' . ($basicFields['logo'] ?? 'default-logo.png')) }}">
    <!-- CSS
 ============================================ -->
    <link rel="stylesheet" href="/assets/site/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/site/css/vendor/icomoon.css">
    <link rel="stylesheet" href="/assets/site/css/vendor/remixicon.css">
    <link rel="stylesheet" href="/assets/site/css/vendor/magnifypopup.min.css">
    <link rel="stylesheet" href="/assets/site/css/vendor/odometer.min.css">
    <link rel="stylesheet" href="/assets/site/css/vendor/lightbox.min.css">
    <link rel="stylesheet" href="/assets/site/css/vendor/animation.min.css">
    <link rel="stylesheet" href="https://edublink.html.devsblink.com/assets/css/vendor/jqueru-ui-min.css">
    <link rel="stylesheet" href="/assets/site/css/vendor/swiper-bundle.min.css">
    <link rel="stylesheet" href="/assets/site/css/vendor/tipped.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="/assets/site/css/app.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<style>
    /* https://wa.me/+971507251519 */
    .whatsapp-float {
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 40px;
        right: 40px;
        background-color: #25d366;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        font-size: 4rem;
        box-shadow: 2px 2px 3px #999;
        z-index: 100;

    }

    body {
        font-family: system-ui !important;
    }
</style>


@include('site.layouts.navbar')


@yield('content')


@include('site.layouts.footer')

<script src="/assets/site/js/vendor/modernizr.min.js"></script>
<!-- Jquery Js -->
<script src="https://edublink.html.devsblink.com/assets/js/vendor/bootstrap.min.js"></script>
<script src="/assets/site/js/vendor/sal.min.js"></script>
<script src="/assets/site/js/vendor/jquery.waypoints.js"></script>
<script src="https://edublink.html.devsblink.com/assets/js/vendor/backtotop.min.js"></script>
<script src="/assets/site/js/vendor/magnifypopup.min.js"></script>
<script src="/assets/site/js/vendor/jquery.countdown.min.js"></script>
<script src="/assets/site/js/vendor/jQuery.rProgressbar.min.js"></script>
<script src="/assets/site/js/vendor/easypie.js"></script>
<script src="/assets/site/js/vendor/odometer.min.js"></script>
<script src="/assets/site/js/vendor/isotop.min.js"></script>
<script src="/assets/site/js/vendor/imageloaded.min.js"></script>
{{-- <script src="/assets/site/js/vendor/lightbox.min.js"></script> --}}
<script src="/assets/site/js/vendor/paralax.min.js"></script>
<script src="/assets/site/js/vendor/paralax-scroll.min.js"></script>
<script src="/assets/site/js/vendor/jquery-ui.min.js"></script>
<script src="/assets/site/js/vendor/swiper-bundle.min.js"></script>
<script src="/assets/site/js/vendor/svg-inject.min.js"></script>
<script src="/assets/site/js/vendor/vivus.min.js"></script>
<script src="/assets/site/js/vendor/tipped.min.js"></script>
<script src="/assets/site/js/vendor/smooth-scroll.min.js"></script>
<script src="/assets/site/js/vendor/isInViewport.jquery.min.js"></script>
<!-- Site Scripts -->

<script src="/assets/site/js/app.js"></script>


@yield('scripts')
</body>

</html>
