<header id="page-topbar">

    <nav class="navbar navbar-expand-md bg-white border-bottom shadow-sm">

        <div class="container-fluid px-3 px-md-4">

            {{-- LOGO --}}
            <a href="{{ route('home') }}"
               class="navbar-brand d-flex align-items-center me-3">

                <img
                    src="{{ asset('assets/images/pothys-logo-white-text.png') }}"
                    alt="POTHYS"
                    class="pothys-logo"
                >

            </a>


            {{-- MOBILE TOGGLE --}}
            <button
                class="navbar-toggler border-0 shadow-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar"
                aria-controls="mainNavbar"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <i class="ri-menu-line fs-24"></i>
            </button>


            {{-- NAVIGATION --}}
            <div
                class="collapse navbar-collapse"
                id="mainNavbar"
            >

                @guest

                    {{-- GUEST MENU --}}
                    <ul class="navbar-nav mx-auto mb-2 mb-md-0">

                        {{-- IMAGE MERGER --}}
                        <li class="nav-item">

                            <a
                                href="{{ route('dashboard') }}"
                                class="nav-link
                                {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            >

                                <i class="ri-image-line me-1"></i>

                                Image Merger

                            </a>

                        </li>


                        {{-- URL MERGE --}}
                        <li class="nav-item">

                            <a
                                href="{{ route('url-shortener.index') }}"
                                class="nav-link
                                {{ request()->routeIs('url-shortener.*') ? 'active' : '' }}"
                            >

                                <i class="ri-link me-1"></i>

                                URL Merge

                            </a>

                        </li>


                        {{-- PDF --}}
                        <li class="nav-item">

                            <a
                                href="{{ route('pdf.index') }}"
                                class="nav-link
                                {{ request()->routeIs('pdf.*') ? 'active' : '' }}"
                            >

                                <i class="ri-file-pdf-line me-1"></i>

                                PDF → Image

                            </a>

                        </li>

                    </ul>


                    {{-- LOGIN REGISTER --}}
                    <div class="d-flex align-items-center gap-2">

                        <a
                            href="{{ route('login') }}"
                            class="btn btn-primary btn-sm px-3"
                        >

                            <i class="ri-login-box-line me-1"></i>

                            Login

                        </a>


                        @if(Route::has('register'))

                            <a
                                href="{{ route('register') }}"
                                class="btn btn-outline-primary btn-sm px-3"
                            >

                                <i class="ri-user-add-line me-1"></i>

                                Register

                            </a>

                        @endif

                    </div>

                @endguest


                @auth

                    @php

                        $user = Auth::user();

                        $role = strtolower(
                            optional($user->role)->name ?? ''
                        );

                    @endphp


                    {{-- LOGGED-IN MENU --}}
                    <ul class="navbar-nav mx-auto mb-2 mb-md-0">

                        {{-- ADMIN / SUPER ADMIN --}}
                        @if(in_array($role, ['admin', 'super-admin']))

                            <li class="nav-item">

                                <a
                                    href="{{ route('dashboard') }}"
                                    class="nav-link
                                    {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                >

                                    <i class="ri-image-line me-1"></i>

                                    Image Merger

                                </a>

                            </li>


                            <li class="nav-item">

                                <a
                                    href="{{ route('url-shortener.index') }}"
                                    class="nav-link
                                    {{ request()->routeIs('url-shortener.*') ? 'active' : '' }}"
                                >

                                    <i class="ri-link me-1"></i>

                                    URL Merge

                                </a>

                            </li>


                            <li class="nav-item">

                                <a
                                    href="{{ route('pdf.index') }}"
                                    class="nav-link
                                    {{ request()->routeIs('pdf.*') ? 'active' : '' }}"
                                >

                                    <i class="ri-file-pdf-line me-1"></i>

                                    PDF → Image

                                </a>

                            </li>


                            <li class="nav-item">

                                <a
                                    href="{{ route('sms.index') }}"
                                    class="nav-link
                                    {{ request()->routeIs('sms.*') ? 'active' : '' }}"
                                >

                                    <i class="ri-bar-chart-line me-1"></i>

                                    Pothys Reports

                                </a>

                            </li>

                        @endif


                        {{-- STAFF --}}
                        @if($role === 'staff')

                            <li class="nav-item">

                                <a
                                    href="{{ route('sms.index') }}"
                                    class="nav-link
                                    {{ request()->routeIs('sms.*') ? 'active' : '' }}"
                                >

                                    <i class="ri-message-2-line me-1"></i>

                                    SMS Credit

                                </a>

                            </li>

                        @endif


                        {{-- AUDITOR --}}
                        @if($role === 'auditor')

                            <li class="nav-item">

                                <a
                                    href="{{ route('sms.report') }}"
                                    class="nav-link
                                    {{ request()->routeIs('sms.report*') ? 'active' : '' }}"
                                >

                                    <i class="ri-bar-chart-line me-1"></i>

                                    Reports

                                </a>

                            </li>

                        @endif

                    </ul>


                    {{-- USER PROFILE --}}
                    <div class="dropdown">

                        <button
                            class="btn dropdown-toggle d-flex align-items-center"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >

                            <img
                                src="{{ asset('assets/images/users/avatar-1.jpg') }}"
                                alt="User"
                                class="rounded-circle me-2 profile-image"
                            >

                            <span class="d-none d-lg-inline">
                                {{ $user->name }}
                            </span>

                        </button>


                        <ul class="dropdown-menu dropdown-menu-end shadow">

                            <li>

                                <h6 class="dropdown-header">

                                    Welcome {{ $user->name }}

                                </h6>

                            </li>


                            @if(Route::has('profile.edit'))

                                <li>

                                    <a
                                        href="{{ route('profile.edit') }}"
                                        class="dropdown-item"
                                    >

                                        <i class="ri-user-line me-2"></i>

                                        Profile

                                    </a>

                                </li>

                            @endif


                            <li>
                                <hr class="dropdown-divider">
                            </li>


                            <li>

                                <form
                                    method="POST"
                                    action="{{ route('logout') }}"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="dropdown-item text-danger"
                                    >

                                        <i class="ri-logout-box-r-line me-2"></i>

                                        Logout

                                    </button>

                                </form>

                            </li>

                        </ul>

                    </div>

                @endauth

            </div>

        </div>

    </nav>

</header>


<style>

/* =====================================================
   TOP NAVBAR
===================================================== */

#page-topbar {
    width: 100%;
    background: #ffffff;
    z-index: 1000;
}


/* =====================================================
   LOGO
===================================================== */

.pothys-logo {
    height: 48px;
    width: auto;
    object-fit: contain;
}


/* =====================================================
   NAV LINKS
===================================================== */

#mainNavbar .nav-link {

    display: flex;

    align-items: center;

    padding: 24px 14px;

    color: #495057;

    font-size: 14px;

    font-weight: 500;

    white-space: nowrap;

    transition: all .2s ease;

}


#mainNavbar .nav-link:hover {

    color: #405189;

    background: rgba(64, 81, 137, .05);

}


#mainNavbar .nav-link.active {

    color: #405189;

    font-weight: 600;

    position: relative;

}


#mainNavbar .nav-link.active::after {

    content: "";

    position: absolute;

    left: 12px;

    right: 12px;

    bottom: 8px;

    height: 3px;

    background: #405189;

    border-radius: 3px;

}


/* =====================================================
   PROFILE
===================================================== */

.profile-image {

    width: 36px;

    height: 36px;

    object-fit: cover;

}


/* =====================================================
   MOBILE
===================================================== */

@media (max-width: 767.98px) {

    .pothys-logo {
        height: 40px;
    }


    #mainNavbar {

        padding-top: 10px;

        padding-bottom: 10px;

    }


    #mainNavbar .navbar-nav {

        width: 100%;

    }


    #mainNavbar .nav-link {

        padding: 12px 10px;

        border-bottom: 1px solid #f0f0f0;

    }


    #mainNavbar .nav-link.active::after {

        display: none;

    }


    #mainNavbar > .d-flex {

        margin-top: 10px;

        width: 100%;

    }


    #mainNavbar > .d-flex .btn {

        flex: 1;

    }

}


/* =====================================================
   SMALL MOBILE
===================================================== */

@media (max-width: 400px) {

    .pothys-logo {

        height: 36px;

    }

}

</style>