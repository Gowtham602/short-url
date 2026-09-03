<x-guest-layout>
<x-slot name="title">Forgot Password</x-slot>
    <div class="card mt-4 card-bg-fill">
	<div class="card-body p-4">
        
        <!-- Header -->
        <div class="text-center mt-2">
            <h5 class="text-primary">Forgot Password?</h5>
            <lord-icon 
                src="https://cdn.lordicon.com/rhvddzym.json" 
                trigger="loop" 
                colors="primary:#0ab39c" 
                class="avatar-xl">
            </lord-icon>
        </div>

        <!-- Alert -->
        <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">
            Enter your email and instructions will be sent to you!
        </div>

        <!-- Form -->
        <div class="p-2">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="Enter Email" 
                        required 
                        autofocus
                    />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-success w-100" style="background-color: #0ab39c; border-color: #0ab39c;">
                        Send Reset Link
                    </button>
                </div>

            </form>
        </div>

    </div>
	
	</div>
	<div class="mt-4 text-center">
                            <p class="mb-0">Wait, I remember my password... <a href="/" class="fw-semibold text-primary text-decoration-underline"> Click here </a> </p>
                        </div>
</x-guest-layout>