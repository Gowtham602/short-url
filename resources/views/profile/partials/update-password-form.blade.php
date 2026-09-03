{{-- ===== IMAGE MERGER FORM CARD ===== --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Update Password</h4>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">Ensure your account is using a long, random password to stay secure.</p>
								<form method="post" action="{{ route('password.update') }}" class="row g-3">
									@csrf
									@method('put')

									<div class="col-12">
										<label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
										<input type="password" 
											   name="current_password" 
											   id="update_password_current_password" 
											   class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
											   autocomplete="current-password">
										
										@error('current_password', 'updatePassword')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>

									<div class="col-md-6">
										<label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
										<input type="password" 
											   name="password" 
											   id="update_password_password" 
											   class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
											   autocomplete="new-password">
										
										@error('password', 'updatePassword')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>

									<div class="col-md-6">
										<label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
										<input type="password" 
											   name="password_confirmation" 
											   id="update_password_password_confirmation" 
											   class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
											   autocomplete="new-password">
										
										@error('password_confirmation', 'updatePassword')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>

									<div class="col-12 d-flex align-items-center gap-3">
										<button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

										@if (session('status') === 'password-updated')
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