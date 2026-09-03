<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name') }} | {{ config('app.name') }}</title>

        <!-- App favicon -->
		<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

		<!-- Layout config Js -->
		<script src="{{ asset('assets/js/layout.js') }}"></script>

		<!-- Bootstrap Css -->
		<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

		<!-- Icons Css -->
		<link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

		<!-- App Css -->
		<link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

		<!-- Custom Css -->
		<link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body>

    <div class="auth-page-wrapper">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="/" class="d-inline-block auth-logo">
                                    <img src="{{ asset('assets/images/pothys-logo-white-text.png') }}" alt="" height="50">
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium">Short Image Url</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4 card-bg-fill">

                            
									{{ $slot }}
								
                        </div>
                        <!-- end card -->

                        

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        
    </div>
    <!-- end auth-page-wrapper -->
    </body>
	<!-- JAVASCRIPT -->
	<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
	<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
	<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
	<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
	<script src="{{ asset('assets/js/plugins.js') }}"></script>

	<!-- particles js -->
	<!--<script src="{{ asset('assets/libs/particles.js/particles.js') }}"></script>-->

	<!-- particles app js -->
	<!--<script src="{{ asset('assets/js/pages/particles.app.js') }}"></script>-->

	<!-- password-addon init -->
	<script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>
</html>
