<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Healthcare</title>

        {{-- Google Fonts (loaded in CSS via @import, but listed here as fallback) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Maicons icon font --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    {{-- Owl Carousel CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/owl-carousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/owl-carousel/css/owl.theme.default.min.css') }}">

    {{-- Animate.css (for WOW.js) --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/animate/animate.min.css') }}">

    <!-- {{-- ✅ Our clean stylesheet --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> -->

    @stack('style')
    </head>

    <body>
        @include('layout.navbar') @yield('content') @include('layout.footer')

        {{-- ========== SCRIPTS ========== --}}
            {{-- jQuery --}}
            <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>

            {{-- Owl Carousel --}}
            <script src="{{ asset('assets/vendor/owl-carousel/js/owl.carousel.min.js') }}"></script>

            {{-- WOW.js --}}
            <script src="{{ asset('assets/vendor/wow/wow.min.js') }}"></script>

            {{-- Main app script --}}
            <script src="{{ asset('js/app.js') }}"></script>

            @stack('app')
        
    </body>
</html>
