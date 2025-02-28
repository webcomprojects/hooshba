<!doctype html>
<html class="no-.js" lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">

    <!-- viewport meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('meta')

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets\front\img\favicon.ico')}}">



    <title>
        @isset($title)
            {{ $title }} |
        @endisset

        {{ option('info_site_title', 'هوشبا') }}
    </title>

    @stack('befor-styles')
    <!-- Place favicon.ico in the root directory -->
    <!-- CSS here -->
    <link rel="stylesheet" href="{{asset('assets\front\css\bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets\front\css\animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets\front\css\magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('assets\front\css\fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets\front\css\flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets\front\css\odometer.css')}}">
    <link rel="stylesheet" href="{{asset('assets\front\css\swiper-bundle.css')}}">
    <link rel="stylesheet" href="{{asset('assets\front\css\aos.css')}}">
    <link rel="stylesheet" href="{{asset('assets\front\css\default.css')}}">
    <link rel="stylesheet" href="{{asset('assets\front\css\main.css')}}">
    <link rel="stylesheet" href="{{asset('assets\front\css\custom.css')}}">
    <link rel="stylesheet" href="{{asset('assets\front\css\font-css\iransans.css')}}">
    <link rel="stylesheet" href="{{asset('assets\front\css\new-style.css')}}">
    @stack('styles')

    {!! option('info_header_codes') !!}
</head>
<body>
    <!--Preloader-->
    <div id="preloader">
        <div id="loader" class="loader">
            <div class="loader-container">
                <div class="loader-icon"><img src="{{ asset(option('info_icon')) }}" alt="Preloader"></div>
            </div>
        </div>
    </div>
    <!--Preloader-end -->
    <!-- Scroll-top -->
    <button class="scroll__top scroll-to-target" data-target="html">
        <i class="fas fa-angle-up"></i>
    </button>
    <!-- Scroll-top-end-->
    <!-- header-area -->
    @include('front.partials.header')
    <!-- header-area-end -->
    <!-- main-area -->
    <main class="fix">
         @yield('content')
    </main>
    <!-- main-area-end -->
    <!-- footer-area -->


        @include('front.partials.footer')
    <!-- footer-area-end -->
    <!-- JS here -->
    <script>
        var BASE_URL = "{{ route('front.index') }}";
        var IS_RTL = {{ @$current_local['direction'] == 'rtl' ? 1 : 0 }};
    </script>

    <script src="{{asset('assets\front\js\vendor\jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets\front\js\bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets\front\js\jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('assets\front\js\jquery.odometer.min.js')}}"></script>
    <script src="{{asset('assets\front\js\jquery.appear.js')}}"></script>
    <script src="{{asset('assets\front\js\gsap.js')}}"></script>
    <script src="{{asset('assets\front\js\ScrollTrigger.js')}}"></script>
    <script src="{{asset('assets\front\js\SplitText.js')}}"></script>
    <script src="{{asset('assets\front\js\gsap-animation.js')}}"></script>
    <script src="{{asset('assets\front\js\jquery.parallaxScroll.min.js')}}"></script>
    <script src="{{asset('assets\front\js\swiper-bundle.js')}}"></script>
    <script src="{{asset('assets\front\js\ajax-form.js')}}"></script>
    <script src="{{asset('assets\front\js\wow.min.js')}}"></script>
    <script src="{{asset('assets\front\js\aos.js')}}"></script>
    <script src="{{asset('assets\front\js\main.js')}}"></script>
    @stack('scripts')

    <script>
        function rangeSlide(value) {
            document.getElementById('rangeValue').innerHTML = value;
        }
    </script>


{!! option('info_scripts') !!}

</body>
</html>