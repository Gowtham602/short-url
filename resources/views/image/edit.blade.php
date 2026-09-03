<x-app-layout>
    <x-slot name="title">Edit Image</x-slot>

    <div class="container py-5">
        <div class="row justify-content-center">

            <div class="col-lg-7">

                <div class="card shadow border-0 rounded-4">

                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0">
                            <i class="ri-image-edit-line me-2"></i>
                            Update Image
                        </h4>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('image.update', $image->short_code) }}"
                              method="POST"
                              enctype="multipart/form-data">

                            @csrf
                            @method('PUT')

                            <div class="text-center mb-4">

                                <img src="{{ asset('storage/'.$image->file_path) }}"
                                     class="img-fluid rounded shadow"
                                     style="max-height:450px">

                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Replace Image
                                </label>

                                <input type="file"
                                       name="image"
                                       class="form-control"
                                       accept="image/*"
                                       required>

                                @error('image')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">

                                <a href="{{ route('dashboard') }}"
                                   class="btn btn-outline-secondary">
                                    <i class="ri-arrow-left-line"></i>
                                    Back
                                </a>

                                <button class="btn btn-primary px-4">
                                    <i class="ri-save-line"></i>
                                    Update Image
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>