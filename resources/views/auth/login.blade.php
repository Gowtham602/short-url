<x-guest-layout>
<x-slot name="title">LOGIN</x-slot>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue.</p>
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible bg-danger text-white alert-label-icon fade show mb-3 material-shadow" role="alert">
                                        <i class="ri-error-warning-line label-icon"></i>
                                
                                        <ul class="mb-0 mt-1 ps-3">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                
                                        <button type="button"
                                                class="btn-close btn-close-white"
                                                data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                    </div>
                                @endif
                                <div class="p-2 mt-4">
	
	<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <x-input-label for="email" class="form-label" :value="__('Email')" />
        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter email" />
        <!--<x-input-error :messages="$errors->get('email')" class="mt-2" />-->
    </div>

    <div class="mb-3">
        <?php /* ?><div class="float-end">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-muted">Forgot password?</a>
            @endif
        </div><?php */ ?>
        
        <x-input-label class="form-label" for="password-input" :value="__('Password')" />
        
        <div class="position-relative auth-pass-inputgroup mb-3">
            <x-text-input id="password-input" class="form-control pe-5 password-input"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="Enter password" />
            
            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none" type="button" id="password-addon">
                <i class="ri-eye-fill align-middle"></i>
            </button>
        </div>
        <!--<x-input-error :messages="$errors->get('password')" class="mt-2" />-->
    </div>

    <div class="form-check">
        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
        <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
    </div>

    <div class="mt-4">
        <x-primary-button class="btn btn-success w-100">
            {{ __('Sign In') }}
        </x-primary-button>
    </div>
</form>
</div>
                            </div>
                            <!-- end card body -->
</x-guest-layout>
