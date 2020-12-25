<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    {{-- {{ HTML::style('css/vendor.css') }} --}}
    <link href="/css/vendor.css" rel="stylesheet" type="text/css">
    <link href="/css/theme.css" rel="stylesheet" type="text/css">
    <link href="/css/app.css" rel="stylesheet" type="text/css">
    {{-- <link href="/css/patch.css" rel="stylesheet" type="text/css"> --}}
    @yield('pages_styles')

    <link rel="shortcut icon" href="/favicon.ico"/>
</head>

<!-- begin::Body -->
<body
    class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
<!-- side_menu -->
<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed " style="background-color: #1e1e2d">
    <div class="kt-header-mobile__logo">
        <a href="{{route('index')}}" style="color:#fff">
            {{-- <img alt="Logo" src="/images/logo_large.png"/> --}}
            氣象局播報系統
        </a>
    </div>
    <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler">
            <span></span></button>

        <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
                class="flaticon-more"></i></button>
    </div>
</div>
<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        @include('backend._partials.side_menu')
        <div id="kt_wrapper" class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper">
            <!-- header -->
            @include('backend._partials.header')
            <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                @include('backend._partials._flash_message')
                @yield('content')
            </div>
        </div>
    </div>
</div>

<!-- end:: Page -->


<!-- begin::Scrolltop -->
<!-- <div id="kt_scrolltop" class="kt-scrolltop">
    <i class="la la-arrow-up"></i>
</div> -->
<!-- end::Scrolltop -->

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>
<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="/js/vendor.js"></script>
<script src="/js/theme.js"></script>
<script src="/js/app.js"></script>
<script src="/js/common.js"></script>
{{--<script src="/js/socket.js"></script>--}}
<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this pages) -->
<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this pages) -->
@yield('pages_scripts')
<!--end::Page Scripts -->

</body>
<!-- end::Body -->
</html>
