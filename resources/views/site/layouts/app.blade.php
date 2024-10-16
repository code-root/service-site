<!DOCTYPE html>
<html class="no-js" lang="{{ $locale }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $basicFields['site_name'] ?? 'My Website' }} {{ $locale }} | @yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ asset('public/storage/' . ($basicFields['logo'] ?? 'default-logo.png')) }}">
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
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <!-- Site Stylesheet -->
    <link rel="stylesheet" href="/assets/site/css/app.css">
</head>



@include('site.layouts.navbar')


@yield('content')


@include('site.layouts.footer')

<!-- JS
 ============================================ -->
<!-- Modernizer JS -->
<script src="assets/site/js/vendor/modernizr.min.js"></script>
<!-- Jquery Js -->
<script src="assets/site/js/vendor/jquery.min.js"></script>
<script src="https://edublink.html.devsblink.com/assets/js/vendor/bootstrap.min.js"></script>
<script src="assets/site/js/vendor/sal.min.js"></script>
<script src="assets/site/js/vendor/jquery.waypoints.js"></script>
<script src="https://edublink.html.devsblink.com/assets/js/vendor/backtotop.min.js"></script>
<script src="assets/site/js/vendor/magnifypopup.min.js"></script>
<script src="assets/site/js/vendor/jquery.countdown.min.js"></script>
<script src="assets/site/js/vendor/jQuery.rProgressbar.min.js"></script>
<script src="assets/site/js/vendor/easypie.js"></script>
<script src="assets/site/js/vendor/odometer.min.js"></script>
<script src="assets/site/js/vendor/isotop.min.js"></script>
<script src="assets/site/js/vendor/imageloaded.min.js"></script>
<script src="assets/site/js/vendor/lightbox.min.js"></script>
<script src="assets/site/js/vendor/paralax.min.js"></script>
<script src="assets/site/js/vendor/paralax-scroll.min.js"></script>
<script src="assets/site/js/vendor/jquery-ui.min.js"></script>
<script src="assets/site/js/vendor/swiper-bundle.min.js"></script>
<script src="assets/site/js/vendor/svg-inject.min.js"></script>
<script src="assets/site/js/vendor/vivus.min.js"></script>
<script src="assets/site/js/vendor/tipped.min.js"></script>
<script src="assets/site/js/vendor/smooth-scroll.min.js"></script>
<script src="assets/site/js/vendor/isInViewport.jquery.min.js"></script>

<!-- Site Scripts -->
<script src="assets/site/js/app.js"></script>

@yield('scripts')
</body>

</html>
