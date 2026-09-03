    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name') }} | {{ config('app.name') }}</title>

        <!-- App favicon -->
		<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
		
		<!--datatable css-->
		<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
		<!--datatable responsive css-->
		<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
	
		<!-- dropzone css -->
		<link rel="stylesheet" href="{{ asset('assets/libs/dropzone/dropzone.css') }}" type="text/css" />



		<!-- Filepond css -->
		<link rel="stylesheet" href="{{ asset('assets/libs/filepond/filepond.min.css') }}" type="text/css" />
		<link rel="stylesheet" href="{{ asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">

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
        <div id="layout-wrapper">
            @include('layouts.navigation')

            <span class="navbar-menu" id="two-column-menu" style="display:none"></span>
			<span id="scrollbar" style="display:none"></span>
			<span id="navbar-nav" style="display:none"></span>
			<span id="vertical-hover" style="display:none"></span>
			<span id="removeNotificationModal" style="display:none"></span>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- JAVASCRIPT -->
		<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
		<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
		<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
		<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
		<script src="{{ asset('assets/js/plugins.js') }}"></script>
		
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

		<!--datatable js-->
		<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
		<!-- jquery  -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
		<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
		<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

		<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
	
		<!-- dropzone min -->
		<script src="{{ asset('assets/libs/dropzone/dropzone-min.js') }}"></script>
		<!-- filepond js -->
		<script src="{{ asset('assets/libs/filepond/filepond.min.js') }}"></script>
		<script src="{{ asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
		<script src="{{ asset('assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
		<script src="{{ asset('assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
		<script src="{{ asset('assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>

		<!--<script src="{{ asset('assets/js/pages/form-file-upload.init.js') }}"></script>-->
		
		<!-- App js -->
		<script src="{{ asset('assets/js/app.js') }}"></script>
		<!-- sweet alert   -->
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

			
		@stack('scripts')
    </body>

    </html>