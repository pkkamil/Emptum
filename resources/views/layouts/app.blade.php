<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="apple-mobile-web-app-title" content="Emptum"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    {{-- <link rel="manifest" href="/site.webmanifest"> --}}
    <link rel="shortcut icon" href={{ asset("../favicon.ico")}} />
    <link rel="apple-touch-icon" sizes="180x180" href={{ asset("../apple-touch-icon.png") }}>
    <link rel="icon" type="image/png" sizes="32x32" href={{ asset("../favicon-32x32.png") }}>
    <link rel="icon" type="image/png" sizes="16x16" href={{ asset("../favicon-16x16.png") }}>
    <link rel="apple-touch-icon" sizes="256x256" href={{ asset("../apple-touch-icon.png") }} />
    <link rel="apple-touch-startup-image" href={{ asset("../favicon.ico") }} />

    <!-- Open Graph -->
    <meta property="og:title" content="Emptum - Sklep marzeń" />
    <meta property="og:description" content="" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content={{ asset("../favicon.ico") }} />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="Emptum" />

    @if (isset($title))
        <title>{{ $title . ' | Emptum' }}</title>
    @else
        <title>Emptum - Sklep marzeń</title>
    @endif
    <!-- Canonical link -->
    <link rel="canonical" href="" />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/scripts.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/95a2d2c3f2.js" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')
    @if (isset($lazy))
        <div class="loader-wrapper"></div></div>
        <script>
            $(window).on("load",function(){
                $(".loader-wrapper").delay(200).fadeOut(700);
            });
        </script>
    @endif
    @yield('content')
    @include('partials.footer')
</body>
</html>
