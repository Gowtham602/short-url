{{-- ===== IMAGE MERGER FORM CARD ===== --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Profile Information</h4>
                            </div>
                            <div class="card-body">
							<p class="text-muted">Update your account's profile information and email address.</p>
                                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
									@csrf
								</form>
								<form method="post" action="{{ route('profile.update') }}" class="row g-3">
								@csrf
								@method('patch')

								<div class="col-md-6">
									<label for="name" class="form-label">{{ __('Name') }}</label>
									<input type="text" 
										   name="name" 
										   id="name" 
										   class="form-control @error('name') is-invalid @enderror" 
										   value="{{ old('name', $user->name) }}" 
										   required autofocus autocomplete="name">
									
									@error('name')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>

								<div class="col-md-6">
									<label for="email" class="form-label">{{ __('Email') }}</label>
									<input type="email" 
										   name="email" 
										   id="email" 
										   class="form-control @error('email') is-invalid @enderror" 
										   value="{{ old('email', $user->email) }}" 
										   required autocomplete="username">
									
									@error('email')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror

									{{-- Verification Logic --}}
									@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
										<div class="mt-2">
											<p class="small text-muted">
												{{ __('Your email address is unverified.') }}
												<button form="send-verification" class="btn btn-link p-0 align-baseline">
													{{ __('Click here to re-send the verification email.') }}
												</button>
											</p>
											@if (session('status') === 'verification-link-sent')
												<div class="text-success small">{{ __('A new verification link has been sent.') }}</div>
											@endif
										</div>
									@endif
								</div>

								<div class="col-12 d-flex align-items-center gap-3">
									<button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

									@if (session('status') === 'profile-updated')
										<span class="text-success small" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2000)">
											{{ __('Saved.') }}
										</span>
									@endif
								</div>
							</form>
                            </div>
                        </div>
                    </div>
                </div>