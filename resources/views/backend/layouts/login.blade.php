<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    <link href="/css/vendor.css" rel="stylesheet" type="text/css">
    <link href="/css/theme.css" rel="stylesheet" type="text/css">
    <link href="/css/login.css" rel="stylesheet" type="text/css">
    @yield('pages_styles')

    <link rel="shortcut icon" href="/favicon.ico"/>
</head>

<!-- begin::Body -->
	<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
        <!-- begin:: Page -->
        <div class="kt-grid kt-grid--ver kt-grid--root">
            <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
              <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-color:#ffffff">
                <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                  <div class="kt-login__container">
                    {{-- <div class="kt-login__logo">
                      <a href="#" style="color:#ffffff">
                        <img src="/images/login/logo.png">
                      </a>
                    </div> --}}
                    <h3 href="#" style="color:#083F8C;font-size:26px;text-align:center">
                        交通部中央氣象局
                    </h3>
                    @yield('content')
                  </div>
                </div>
              </div>
            </div>
        </div>

		<!-- end:: Page -->

        <!--begin::Global Theme Bundle(used by all pages) -->
        {{-- <script src="/js/vendor.js"></script>
        <script src="/js/theme.js"></script>
        <script src="/js/app.js"></script> --}}
        {{-- <script src="/js/common.js"></script> --}}
        <!--end::Global Theme Bundle -->

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
						"danger": "#fd3995",
					},
					"base": {
						"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
						"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
					}
				}
			};
		</script>
		<!-- end::Global Config -->

        <!--begin::Page Scripts(used by this pages) -->
        @yield('pages_scripts')
        <!--end::Page Scripts -->
	</body>
<!-- end::Body -->
</html>
