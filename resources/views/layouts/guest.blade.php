<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>
        {{ $title ?? config('app.name') }}
        |
        {{ config('app.name') }}
    </title>


    <!-- Favicon -->
    <link rel="shortcut icon"
          href="{{ asset('assets/images/favicon.ico') }}">


    <!-- Bootstrap -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}"
          rel="stylesheet">


    <!-- Icons -->
    <link href="{{ asset('assets/css/icons.min.css') }}"
          rel="stylesheet">


    <!-- App CSS -->
    <link href="{{ asset('assets/css/app.min.css') }}"
          rel="stylesheet">


    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/custom.min.css') }}"
          rel="stylesheet">


    <!-- Remix Icon -->
    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.6.0/fonts/remixicon.css"
        rel="stylesheet"
    >


    <style>

        /* =====================================================
           RESET
        ====================================================== */

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }


        html,
        body {
            width: 100%;
            min-height: 100%;
            margin: 0;
            padding: 0;
        }


        body {
            overflow-x: hidden;

            font-family:
                "Inter",
                "Segoe UI",
                Arial,
                sans-serif;

            background: #eef1f7;
        }


        /* =====================================================
           MAIN WRAPPER
        ====================================================== */

        .auth-page-wrapper {

            position: relative;

            min-height: 100vh;
            min-height: 100dvh;

            overflow: hidden;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 35px 20px;
        }


        /* =====================================================
           BACKGROUND
        ====================================================== */

        .auth-background {

            position: absolute;

            inset: 0;

            overflow: hidden;

            background:
                linear-gradient(
                    135deg,
                    #28365f 0%,
                    #405189 45%,
                    #596ba0 100%
                );

            z-index: 0;
        }


        .auth-background::before {

            content: "";

            position: absolute;

            width: 600px;
            height: 600px;

            top: -280px;
            left: -180px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(255,255,255,.18),
                    rgba(255,255,255,0)
                );
        }


        .auth-background::after {

            content: "";

            position: absolute;

            width: 700px;
            height: 700px;

            right: -300px;
            bottom: -350px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(255,255,255,.13),
                    rgba(255,255,255,0)
                );
        }


        /* =====================================================
           DECORATIVE CIRCLES
        ====================================================== */

        .bg-circle {

            position: absolute;

            border-radius: 50%;

            border:
                1px solid
                rgba(255,255,255,.10);
        }


        .bg-circle-one {

            width: 280px;
            height: 280px;

            top: 8%;
            left: 7%;
        }


        .bg-circle-two {

            width: 180px;
            height: 180px;

            right: 12%;
            top: 15%;
        }


        .bg-circle-three {

            width: 350px;
            height: 350px;

            bottom: -180px;
            left: 30%;
        }


        /* =====================================================
           CONTENT
        ====================================================== */

        .auth-page-content {

            position: relative;

            z-index: 5;

            width: 100%;

            max-width: 560px;

            margin: auto;
        }


        /* =====================================================
           BRAND
        ====================================================== */

        .auth-brand {

            text-align: center;

            margin-bottom: 24px;
        }


        .auth-brand-logo {

            display: inline-flex;

            align-items: center;
            justify-content: center;

            padding: 9px 18px;

            background:
                rgba(255,255,255,.96);

            border-radius: 12px;

            box-shadow:
                0 12px 35px
                rgba(0,0,0,.18);
        }


        .auth-brand-logo img {

            display: block;

            width: auto;

            max-width: 200px;

            height: 52px;

            object-fit: contain;
        }


        .auth-brand-title {

            margin-top: 13px;

            margin-bottom: 0;

            color: #fff;

            font-size: 14px;

            font-weight: 500;

            letter-spacing: .4px;

            text-shadow:
                0 2px 10px
                rgba(0,0,0,.15);
        }


        /* =====================================================
           CARD
        ====================================================== */

        .auth-card {

            position: relative;

            width: 100%;

            background:
                rgba(255,255,255,.96);

            border: 1px solid
                rgba(255,255,255,.65);

            border-radius: 22px;

            overflow: hidden;

            box-shadow:
                0 30px 80px
                rgba(15,25,50,.25);

            backdrop-filter:
                blur(20px);

            -webkit-backdrop-filter:
                blur(20px);
        }


        /* Top POTHYS line */

        .auth-card::before {

            content: "";

            display: block;

            width: 100%;

            height: 5px;

            background:
                linear-gradient(
                    90deg,
                    #a80f19,
                    #d71f2b,
                    #a80f19
                );
        }


        /* =====================================================
           CARD INNER
        ====================================================== */

        .auth-card-inner {

            padding: 34px;
        }


        /* =====================================================
           FORM TITLE
        ====================================================== */

        .auth-form-title {

            text-align: center;

            margin-bottom: 26px;
        }


        .auth-form-icon {

            width: 54px;
            height: 54px;

            margin: 0 auto 12px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 15px;

            color: #fff;

            font-size: 24px;

            background:
                linear-gradient(
                    135deg,
                    #b5121b,
                    #e03943
                );

            box-shadow:
                0 9px 22px
                rgba(181,18,27,.25);
        }


        .auth-form-title h4 {

            margin: 0;

            color: #202638;

            font-size: 23px;

            font-weight: 700;
        }


        .auth-form-title p {

            margin:
                6px 0 0;

            color: #8b94a7;

            font-size: 13px;
        }


        /* =====================================================
           INPUT STYLING
        ====================================================== */

        .auth-card .form-label {

            color: #465066;

            font-size: 13px;

            font-weight: 600;

            margin-bottom: 7px;
        }


        .auth-card .form-control {

            height: 47px;

            border:
                1px solid #dfe3eb;

            border-radius: 10px;

            background: #f8f9fc;

            color: #202638;

            font-size: 14px;

            transition:
                border-color .2s,
                box-shadow .2s,
                background .2s;
        }


        .auth-card .form-control:focus {

            background: #fff;

            border-color: #405189;

            box-shadow:
                0 0 0 3px
                rgba(64,81,137,.10);
        }


        /* =====================================================
           BUTTON
        ====================================================== */

        .auth-card .btn-primary {

            height: 48px;

            border: 0;

            border-radius: 10px;

            background:
                linear-gradient(
                    135deg,
                    #b5121b,
                    #df2935
                );

            box-shadow:
                0 8px 20px
                rgba(181,18,27,.22);

            font-size: 14px;

            font-weight: 600;

            transition:
                transform .2s,
                box-shadow .2s;
        }


        .auth-card .btn-primary:hover {

            transform:
                translateY(-1px);

            box-shadow:
                0 12px 26px
                rgba(181,18,27,.30);
        }


        /* =====================================================
           LINKS
        ====================================================== */

        .auth-card a {

            color: #405189;

            font-weight: 500;

            text-decoration: none;
        }


        .auth-card a:hover {

            color: #b5121b;
        }


        /* =====================================================
           ERROR
        ====================================================== */

        .auth-card .text-danger {

            font-size: 12px;
        }


        /* =====================================================
           FOOTER
        ====================================================== */

        .auth-footer {

            text-align: center;

            margin-top: 20px;

            color:
                rgba(255,255,255,.72);

            font-size: 12px;
        }


        /* =====================================================
           MOBILE
        ====================================================== */

        @media (max-width: 575.98px) {

            .auth-page-wrapper {

                align-items: flex-start;

                padding:
                    24px
                    12px
                    20px;
            }


            .auth-page-content {

                max-width: 100%;
            }


            .auth-brand {

                margin-bottom: 18px;
            }


            .auth-brand-logo {

                padding: 7px 14px;

                border-radius: 10px;
            }


            .auth-brand-logo img {

                height: 42px;

                max-width: 170px;
            }


            .auth-brand-title {

                margin-top: 9px;

                font-size: 12px;
            }


            .auth-card {

                border-radius: 16px;
            }


            .auth-card-inner {

                padding:
                    25px 18px;
            }


            .auth-form-title {

                margin-bottom: 21px;
            }


            .auth-form-icon {

                width: 48px;
                height: 48px;

                font-size: 21px;

                border-radius: 13px;
            }


            .auth-form-title h4 {

                font-size: 20px;
            }


            .auth-form-title p {

                font-size: 12px;
            }


            .auth-card .form-control {

                height: 45px;

                font-size: 13px;
            }


            .auth-card .btn-primary {

                height: 46px;
            }
        }


        /* =====================================================
           VERY SMALL MOBILE
        ====================================================== */

        @media (max-width: 360px) {

            .auth-page-wrapper {

                padding:
                    18px 8px;
            }


            .auth-card-inner {

                padding:
                    22px 14px;
            }


            .auth-brand-logo img {

                height: 38px;
            }
        }


        /* =====================================================
           TABLET
        ====================================================== */

        @media (min-width: 576px)
               and (max-width: 991.98px) {

            .auth-page-content {

                max-width: 500px;
            }
        }


    </style>

</head>


<body>


<div class="auth-page-wrapper">


    <!-- =====================================================
         BACKGROUND
    ====================================================== -->

    <div class="auth-background">

        <div class="bg-circle bg-circle-one"></div>

        <div class="bg-circle bg-circle-two"></div>

        <div class="bg-circle bg-circle-three"></div>

    </div>


    <!-- =====================================================
         MAIN CONTENT
    ====================================================== -->

    <div class="auth-page-content">


        <!-- =================================================
             BRAND
        ================================================== -->

        <div class="auth-brand">

            <a
                href="{{ route('home') }}"
                class="auth-brand-logo"
            >

                <img
                    src="{{ asset('assets/images/pothys-logo-white-text.png') }}"
                    alt="POTHYS"
                >

            </a>


            <p class="auth-brand-title">

                Short Image URL

            </p>

        </div>


        <!-- =================================================
             CARD
        ================================================== -->

        <div class="auth-card">


            <div class="auth-card-inner">


                <!-- =========================================
                     SLOT
                ========================================== -->

                {{ $slot }}


            </div>


        </div>


        <!-- =================================================
             FOOTER
        ================================================== -->

        <div class="auth-footer">

            © {{ date('Y') }} Ideal.
            All rights reserved.

        </div>


    </div>


</div>


<!-- =========================================================
     JAVASCRIPT
========================================================== -->

<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>

<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>

<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>

<script src="{{ asset('assets/js/plugins.js') }}"></script>

<script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>


@stack('scripts')


</body>

</html>