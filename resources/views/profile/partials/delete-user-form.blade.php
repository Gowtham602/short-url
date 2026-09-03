<section class="space-y-6">
    <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Delete Account</h4>
                            </div>
                            <div class="card-body">
							
							<p class="text-muted">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
    {{ __('Delete Account') }}
</button>

<div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{ route('profile.destroy') }}" class="modal-content">
            @csrf
            @method('delete')

            <div class="modal-header">
                <h5 class="modal-title" id="confirmUserDeletionModalLabel">{{ __('Are you sure you want to delete your account?') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p class="text-muted small">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div class="mb-3">
                    <label for="password" class="form-label visually-hidden">{{ __('Password') }}</label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                           placeholder="{{ __('Password') }}" 
                           required>

                    @error('password', 'userDeletion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>

</section>
