<x-guest-layout>

    <x-slot name="title">
        LOGIN
    </x-slot>


    <!-- LOGIN CARD -->
    <div class="login-card">

        <!-- HEADER -->
        <div class="login-header">

            <div class="login-icon">
               
                <img
                    src="{{ asset('assets/images/pothys-logo-white-text.png') }}"
                    alt="Ideal-logo"
                >
            </div>

            <h1>Welcome Back!</h1>

            <p>
                Sign in to continue to Short Image URL
            </p>

        </div>


        <!-- SESSION MESSAGE -->
        <x-auth-session-status
            class="session-message"
            :status="session('status')"
        />


        <!-- VALIDATION ERRORS -->
        @if ($errors->any())

            <div class="error-box">

                <strong>Please check the following:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif


        <!-- LOGIN FORM -->
        <form method="POST" action="{{ route('login') }}">

            @csrf


            <!-- EMAIL -->
            <div class="form-group">

                <label
                    for="email"
                    class="form-label"
                >
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
                    autofocus
                    autocomplete="username"
                >

                @error('email')
                    <div class="field-error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <!-- PASSWORD -->
            <div class="form-group">

                <label
                    for="password-input"
                    class="form-label"
                >
                    Password
                </label>

                <div class="input-wrapper">

                    <input
                        id="password-input"
                        type="password"
                        name="password"
                        class="form-input password-input"
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword('password-input', this)"
                    >
                        Show
                    </button>

                </div>

                @error('password')
                    <div class="field-error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <!-- REMEMBER / FORGOT -->
            <div class="remember-row">

                <label class="remember-label">

                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="remember-checkbox"
                    >

                    <span>Remember me</span>

                </label>


                @if (Route::has('password.request'))

                    <a
                        href="{{ route('password.request') }}"
                        class="forgot-link"
                    >
                        Forgot password?
                    </a>

                @endif

            </div>


            <!-- LOGIN BUTTON -->
            <div class="login-button-wrapper">

                <button
                    type="submit"
                    class="login-button"
                >
                    Sign In
                </button>

            </div>


            <!-- REGISTER -->
            <div class="register-section">

                <span>
                    Don't have an account?
                </span>

                <a
                    href="{{ route('register') }}"
                    class="register-link"
                >
                    Create Account
                </a>

            </div>

        </form>

    </div>


    <!-- FOOTER -->
    <div class="login-footer">

        © {{ date('Y') }} Ideal Corporate Services.
        All rights reserved.

    </div>


<style>

/* =========================================================
   LOGIN PAGE
========================================================= */

.login-card {

    width: 100%;
    max-width: 560px;

    margin: 20px auto 0;

    padding: 42px 46px;

    background: rgba(255, 255, 255, 0.98);

    border-radius: 24px;

    border-top: 5px solid #b5121b;

    box-shadow:
        0 25px 70px rgba(0, 0, 0, 0.25),
        0 8px 25px rgba(0, 0, 0, 0.10);

    position: relative;

    z-index: 2;

}


/* =========================================================
   LOGIN HEADER
========================================================= */

.login-header {

    text-align: center;

    margin-bottom: 32px;

}


.login-icon {
    width: 100px;
    height: 100px;

    margin: 0 auto 20px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #ffffff;

    border-radius: 22px;

    padding: 12px;

    box-shadow:
        0 10px 30px rgba(0, 0, 0, 0.15);

    overflow: hidden;
}

.login-icon img {
    width: 100%;
    height: 100%;

    object-fit: contain;

    display: block;
}

/* 
.login-icon span {

    font-size: 28px;

} */


.login-header h1 {

    margin: 0;

    color: #172554;

    font-size: 29px;

    font-weight: 700;

    letter-spacing: -0.3px;

}


.login-header p {

    margin: 9px 0 0;

    color: #64748b;

    font-size: 14px;

}


/* =========================================================
   FORM
========================================================= */

.form-group {

    margin-bottom: 21px;

}


.form-label {

    display: block;

    margin-bottom: 8px;

    color: #334155;

    font-size: 14px;

    font-weight: 600;

}


.form-input {

    width: 100%;

    height: 50px;

    padding: 0 15px;

    border: 1px solid #d7dee8;

    border-radius: 11px;

    background: #f8fafc;

    color: #1e293b;

    font-size: 14px;

    outline: none;

    transition: all 0.2s ease;

}


.form-input::placeholder {

    color: #94a3b8;

}


.form-input:hover {

    border-color: #aebbd0;

}


.form-input:focus {

    background: #ffffff;

    border-color: #4f63a8;

    box-shadow:
        0 0 0 4px rgba(79, 99, 168, 0.12);

}


/* =========================================================
   PASSWORD
========================================================= */

.input-wrapper {

    position: relative;

}


.password-input {

    padding-right: 75px;

}


.password-toggle {

    position: absolute;

    right: 13px;

    top: 50%;

    transform: translateY(-50%);

    border: none;

    background: transparent;

    color: #4f63a8;

    font-size: 13px;

    font-weight: 600;

    cursor: pointer;

    padding: 5px;

}


.password-toggle:hover {

    color: #263b78;

}


/* =========================================================
   REMEMBER
========================================================= */

.remember-row {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-top: 3px;

    font-size: 13px;

}


.remember-label {

    display: flex;

    align-items: center;

    gap: 8px;

    color: #64748b;

    cursor: pointer;

}


.remember-checkbox {

    width: 16px;

    height: 16px;

    cursor: pointer;

    accent-color: #4f63a8;

}


.forgot-link {

    color: #4f63a8;

    font-weight: 600;

    text-decoration: none;

}


.forgot-link:hover {

    color: #263b78;

    text-decoration: underline;

}


/* =========================================================
   LOGIN BUTTON
========================================================= */

.login-button-wrapper {

    margin-top: 27px;

}


.login-button {

    width: 100%;

    height: 51px;

    border: none;

    border-radius: 11px;

    background: linear-gradient(
        135deg,
        #354a91,
        #5268b1
    );

    color: white;

    font-size: 15px;

    font-weight: 600;

    cursor: pointer;

    transition: all 0.2s ease;

    box-shadow:
        0 8px 20px rgba(59, 79, 145, 0.25);

}


.login-button:hover {

    transform: translateY(-1px);

    box-shadow:
        0 12px 25px rgba(59, 79, 145, 0.32);

}


.login-button:active {

    transform: translateY(0);

}


/* =========================================================
   REGISTER
========================================================= */

.register-section {

    display: flex;

    justify-content: center;

    align-items: center;

    gap: 5px;

    margin-top: 25px;

    padding-top: 21px;

    border-top: 1px solid #e5e7eb;

    color: #64748b;

    font-size: 14px;

}


.register-link {

    color: #40559c;

    font-weight: 600;

    text-decoration: none;

}


.register-link:hover {

    color: #263b78;

    text-decoration: underline;

}


/* =========================================================
   ERROR
========================================================= */

.error-box {

    margin-bottom: 22px;

    padding: 13px 15px;

    background: #fff1f2;

    border: 1px solid #fecdd3;

    border-radius: 10px;

    color: #be123c;

    font-size: 13px;

}


.error-box strong {

    display: block;

    margin-bottom: 5px;

}


.error-box ul {

    margin: 5px 0 0;

    padding-left: 18px;

}


.field-error {

    margin-top: 6px;

    color: #dc2626;

    font-size: 12px;

}


.session-message {

    margin-bottom: 18px;

    color: #15803d;

    font-size: 13px;

}


/* =========================================================
   FOOTER
========================================================= */

.login-footer {

    width: 100%;

    text-align: center;

    margin: 22px 0 30px;

    color: rgba(255,255,255,0.78);

    font-size: 12px;

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 600px) {

    .login-card {

        width: calc(100% - 24px);

        margin-top: 15px;

        padding: 30px 22px;

        border-radius: 20px;

    }


    .login-header h1 {

        font-size: 25px;

    }


    .login-icon {

        width: 58px;

        height: 58px;

    }


    .remember-row {

        align-items: flex-start;

    }

}


@media (max-width: 400px) {

    .login-card {

        padding: 27px 18px;

    }


    .remember-row {

        flex-direction: column;

        gap: 10px;

    }


    .register-section {

        flex-direction: column;

    }

}

</style>


<script>

function togglePassword(id, button) {

    const input = document.getElementById(id);

    if (!input) return;

    if (input.type === 'password') {

        input.type = 'text';

        button.textContent = 'Hide';

    } else {

        input.type = 'password';

        button.textContent = 'Show';

    }

}

</script>


</x-guest-layout>