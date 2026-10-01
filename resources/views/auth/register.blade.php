<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Account | Short Image URL</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            background:
                radial-gradient(circle at 10% 20%, rgba(78, 105, 190, .35), transparent 30%),
                radial-gradient(circle at 90% 80%, rgba(91, 67, 180, .35), transparent 30%),
                linear-gradient(135deg, #172554, #263b78 45%, #394f92);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
            color: #1e293b;
        }

        .register-wrapper {
            width: 100%;
            max-width: 460px;
        }

        .brand {
            text-align: center;
            margin-bottom: 22px;
            color: white;
        }

        .brand-logo {
            width: 82px;
            height: 82px;
            object-fit: contain;
            background: white;
            padding: 8px;
            border-radius: 18px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, .20);
            margin-bottom: 14px;
        }

        .brand-title {
            font-size: 25px;
            font-weight: 700;
            margin: 0;
            letter-spacing: -.4px;
        }

        .brand-subtitle {
            margin-top: 6px;
            font-size: 14px;
            opacity: .82;
        }

        .register-card {
            background: rgba(255, 255, 255, .97);
            border-radius: 24px;
            padding: 34px;
            box-shadow:
                0 25px 70px rgba(0, 0, 0, .25),
                0 5px 20px rgba(0, 0, 0, .08);
        }

        .card-header {
    text-align: center;
    margin-bottom: 30px;
}

.register-logo-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 18px;
}

.register-logo {
    width: 82px;
    height: 82px;
    object-fit: contain;
    background: #ffffff;
    padding: 10px;
    border-radius: 18px;

    box-shadow:
        0 10px 25px rgba(0, 0, 0, 0.12);
}

.card-header h1 {
    margin: 0;
    font-size: 27px;
    font-weight: 700;
    color: #172554;
}

.card-header p {
    margin: 8px 0 0;
    color: #64748b;
    font-size: 14px;
}
        .card-header h1 {
            margin: 0;
            font-size: 27px;
            font-weight: 700;
            color: #172554;
        }

        .card-header p {
            margin: 8px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 19px;
        }

        .form-label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            height: 48px;
            border: 1px solid #dbe2ea;
            border-radius: 11px;
            padding: 0 14px;
            font-size: 14px;
            outline: none;
            background: #f8fafc;
            color: #1e293b;
            transition: all .2s ease;
        }

        .form-input:focus {
            background: white;
            border-color: #4f63a8;
            box-shadow: 0 0 0 4px rgba(79, 99, 168, .12);
        }

        .password-input {
            padding-right: 48px;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            cursor: pointer;
            color: #64748b;
            font-size: 14px;
        }

        .error-message {
            margin-top: 5px;
            color: #dc2626;
            font-size: 12px;
        }

        .register-button {
            width: 100%;
            height: 49px;
            border: none;
            border-radius: 11px;
            background: linear-gradient(135deg, #3b4f91, #5268b1);
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s ease;
            box-shadow: 0 8px 20px rgba(59, 79, 145, .25);
        }

        .register-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 25px rgba(59, 79, 145, .32);
        }

        .login-section {
            text-align: center;
            margin-top: 23px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            color: #64748b;
        }

        .login-link {
            color: #40559c;
            font-weight: 600;
            text-decoration: none;
            margin-left: 5px;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        .footer {
            text-align: center;
            color: rgba(255, 255, 255, .72);
            font-size: 12px;
            margin-top: 20px;
        }

        @media (max-width: 480px) {

            body {
                padding: 20px 12px;
            }

            .register-card {
                padding: 25px 20px;
                border-radius: 20px;
            }

            .brand-logo {
                width: 70px;
                height: 70px;
            }

            .brand-title {
                font-size: 22px;
            }

            .card-header h1 {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>

<div class="register-wrapper">

    <!-- BRAND -->
    <div class="brand">

        

        <h2 class="brand-title">
            Short Image URL
        </h2>

        <div class="brand-subtitle">
            
            Create and manage your image links easily
        </div>

    </div>


    <!-- REGISTER CARD -->
    <div class="register-card">

        <div class="card-header">

            <div class="register-logo-wrapper">
                <img
                    src="{{ asset('assets/images/pothys-logo-white-text.png') }}"
                    alt="Ideal Corporate Services"
                    class="register-logo"
                >
            </div>

            <h1>Create your account</h1>

            <p>
                Register to start using Short Image URL
            </p>

        </div>


        <form method="POST" action="{{ route('register') }}">

            @csrf


            <!-- NAME -->
            <div class="form-group">

                <label for="name" class="form-label">
                    Full Name
                </label>

                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-input"
                    placeholder="Enter your full name"
                    required
                    autofocus
                    autocomplete="name"
                >

                @error('name')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <!-- EMAIL -->
            <div class="form-group">

                <label for="email" class="form-label">
                    Email Address
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-input"
                    placeholder="Enter your email"
                    required
                    autocomplete="username"
                >

                @error('email')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <!-- PASSWORD -->
            <div class="form-group">

                <label for="password" class="form-label">
                    Password
                </label>

                <div class="input-wrapper">

                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-input password-input"
                        placeholder="Create a password"
                        required
                        autocomplete="new-password"
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword('password', this)"
                    >
                        Show
                    </button>

                </div>

                @error('password')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <!-- CONFIRM PASSWORD -->
            <div class="form-group">

                <label for="password_confirmation" class="form-label">
                    Confirm Password
                </label>

                <div class="input-wrapper">

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        class="form-input password-input"
                        placeholder="Confirm your password"
                        required
                        autocomplete="new-password"
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword('password_confirmation', this)"
                    >
                        Show
                    </button>

                </div>

                @error('password_confirmation')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <!-- REGISTER -->
            <button type="submit" class="register-button">

                Create Account

            </button>


            <!-- LOGIN -->
            <div class="login-section">

                Already have an account?

                <a
                    href="{{ route('login') }}"
                    class="login-link"
                >
                    Sign in
                </a>

            </div>

        </form>

    </div>


    <!-- FOOTER -->
    <div class="footer">

        © {{ date('Y') }} Ideal Corporate Services.
        All rights reserved.

    </div>

</div>


<script>

function togglePassword(id, button) {

    const input = document.getElementById(id);

    if (input.type === 'password') {

        input.type = 'text';

        button.textContent = 'Hide';

    } else {

        input.type = 'password';

        button.textContent = 'Show';

    }

}

</script>

</body>
</html>