<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>404 - Page Not Found</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;

            background:
                radial-gradient(
                    circle at 10% 15%,
                    rgba(255,255,255,0.10) 0,
                    rgba(255,255,255,0.10) 170px,
                    transparent 171px
                ),
                linear-gradient(
                    135deg,
                    #263d7b,
                    #4d63a5
                );

            position: relative;
            overflow: hidden;
        }

        .error-page::before,
        .error-page::after {
            content: "";
            position: absolute;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 50%;
        }

        .error-page::before {
            width: 280px;
            height: 280px;
            top: 80px;
            right: 10%;
        }

        .error-page::after {
            width: 220px;
            height: 220px;
            bottom: -50px;
            left: 12%;
        }

        .error-card {
            position: relative;
            z-index: 2;

            width: 100%;
            max-width: 600px;

            background: rgba(255,255,255,0.97);

            border-radius: 22px;

            padding: 45px 40px;

            text-align: center;

            box-shadow:
                0 25px 70px rgba(0,0,0,0.25);
        }

        .error-logo-box {
            width: 100px;
            height: 100px;

            margin: 0 auto 25px;

            background: #ffffff;

            border-radius: 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            box-shadow:
                0 10px 30px rgba(0,0,0,0.15);
        }

        .error-logo {
            width: 85px;
            height: 85px;

            object-fit: contain;
        }

        .error-code {
            font-size: 90px;
            line-height: 1;

            font-weight: 800;

            color: #4057a5;

            margin-bottom: 15px;
        }

        .error-title {
            font-size: 30px;

            font-weight: 700;

            color: #1e293b;

            margin-bottom: 12px;
        }

        .error-message {
            font-size: 16px;

            line-height: 1.7;

            color: #64748b;

            max-width: 450px;

            margin: 0 auto 30px;
        }

        .error-button {
            display: inline-block;

            padding: 13px 30px;

            background: #4057a5;

            color: #ffffff;

            text-decoration: none;

            border-radius: 8px;

            font-size: 15px;

            font-weight: 600;

            transition: 0.2s ease;
        }

        .error-button:hover {
            background: #30458e;

            transform: translateY(-1px);
        }

        .error-footer {
            margin-top: 30px;

            color: #94a3b8;

            font-size: 13px;
        }

        @media (max-width: 600px) {

            .error-page {
                padding: 20px 15px;
            }

            .error-card {
                padding: 35px 20px;
            }

            .error-code {
                font-size: 65px;
            }

            .error-title {
                font-size: 24px;
            }

            .error-message {
                font-size: 14px;
            }

            .error-logo-box {
                width: 85px;
                height: 85px;
            }

            .error-logo {
                width: 72px;
                height: 72px;
            }

        }

    </style>

</head>

<body>

<div class="error-page">

    <div class="error-card">

        <div class="error-logo-box">

            <img
                src="{{ asset('assets/images/pothys-logo-white-text.png') }}"
                alt="Ideal Corporate Services"
                class="error-logo"
            >

        </div>

        <div class="error-code">
            404
        </div>

        <h1 class="error-title">
            Page Not Found
        </h1>

        <p class="error-message">
            Sorry, the page you are looking for
            could not be found or may have been moved.
        </p>

        <a
            href="{{ url('/') }}"
            class="error-button"
        >
            Go to Home
        </a>

        <div class="error-footer">
            © {{ date('Y') }} Ideal Corporate Services.
            All rights reserved.
        </div>

    </div>

</div>

</body>

</html>