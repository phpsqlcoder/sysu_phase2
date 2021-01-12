<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="author" content="SYSU International Inc">

    <meta property="og:locale" content="tl_PH">
    <meta property="og:type" content="website">
    <meta property="og:title" content="SYSU International Inc">
    <meta property="og:site_name" content="SYSU International Inc">
    <meta property="og:description" content="{{ $page->meta_description }}">
    <meta name="keywords" content="{{ $page->meta_keyword }}">

    @if (!empty($page->name) || !empty($page->meta_title))
        <title>{{ (empty($page->meta_title) ? $page->name:$page->meta_title) }} | {{ Setting::info()->company_name }}</title>
    @endif
    <link rel="shortcut icon" href="{{ Setting::get_company_favicon_storage_path() }}" type="image/x-icon" />   
  

    <link rel="shortcut icon" href="{{ asset('theme/sysu/images/misc/favicon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/bootstrap/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/fontawesome/css/fontawesome-all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/linearicon/linearicon.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/slick/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/ion.rangeslider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/sysu/css/tagsinput.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/rd-navbar/rd-navbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/aos/dist/aos.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/xZoom/src/xzoom.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/sysu/css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/sysu/css/style.css') }}" />
    
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('theme/sysu/images/icons/logos/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('theme/sysu/images/icons/logos/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('theme/sysu/images/icons/logos/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('theme/sysu/images/icons/logos/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('theme/sysu/images/icons/logos/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('theme/sysu/images/icons/logos/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('theme/sysu/images/icons/logos/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('theme/sysu/images/icons/logos/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('theme/sysu/images/icons/logos/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('theme/sysu/images/icons/logos/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('theme/sysu/images/icons/logos/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('theme/sysu/images/icons/logos/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('theme/sysu/images/icons/logos/favicon-16x16.png') }}">

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('theme/sysu/images/icons/logos/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
  

    @yield('pagecss')

    {!! \Setting::info()->google_analytics !!}
</head>
<body id="app">
    <div class="page">
    
        @include('theme.sysu.layout.header')
        <main>
            @yield('content')
        </main>
        
        <footer>
            @include('theme.sysu.layout.footer')
        </footer>
        <div id="privacy-policy" class="privacy-policy" style="display:none;">
            <div class="privacy-policy-desc">
                <p class="title">{{ Setting::info()->data_privacy_title }}</p>
                <p>
                    {{ Setting::info()->data_privacy_popup_content }}
                </p>
            </div>
            <div class="privacy-policy-btn">
                <a class="primary-btn btn-md" href="#" id="cookieAcceptBarConfirm">Accept</a>
                <a class="default-btn btn-md" href="{{ route('privacy-policy') }}">Learn More</a>
            </div>
        </div>
        <div id="top" class="side-widget">
            <span class="lnr lnr-chevron-up"></span>
        </div>
    </div>
    
    @include('theme.sysu.layout.privacy-policy')

    <script type="text/javascript">
        var bannerFxIn = "fadeIn";
        var bannerFxOut = "fadeOut";
        var autoPlayTimeout = 4000;
        var bannerID = "banner";
    </script>



    <script src="{{ asset('theme/sysu/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('theme/sysu/js/script.js') }}"></script>
    <script src="{{ asset('theme/sysu/plugins/materialize/js/materialize.js') }}"></script>
    <script src="{{ asset('theme/sysu/plugins/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('theme/sysu/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/sysu/plugins/rd-navbar/dist/js/jquery.rd-navbar.js') }}"></script>
    <script src="{{ asset('theme/sysu/plugins/slick/slick.js') }}"></script>
    <script src="{{ asset('theme/sysu/plugins/slick/slick.extension.js') }}"></script>
    <script src="{{ asset('theme/sysu/plugins/aos/dist/aos.js') }}"></script>
    <script src="{{ asset('theme/sysu/js/privacy_policy.js') }}"></script>

    @yield('pagejs')
    
    @yield('customjs')

    
</body>
</html>
