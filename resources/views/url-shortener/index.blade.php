<x-app-layout>

    <x-slot name="title">
        URL Shortener
    </x-slot>


    <div class="main-content">

        <div class="page-content">

            <div class="container-fluid">


                {{-- =====================================================
                    PAGE TITLE
                ====================================================== --}}

                <div class="row">
                    <div class="col-12">

                        <div class="page-title-box">

                            <h4 class="mb-0 p-0 p-lg-3">
                                URL Shortener
                            </h4>

                        </div>

                    </div>
                </div>


                {{-- =====================================================
                    SUCCESS MESSAGE
                ====================================================== --}}

                @if(session('success'))

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: @json(session('success')),
                                confirmButtonText: 'OK'
                            });

                        });
                    </script>

                @endif


                {{-- =====================================================
                    VALIDATION ERROR
                ====================================================== --}}

                @if($errors->any())

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: @json($errors->first()),
                                confirmButtonText: 'OK'
                            });

                        });
                    </script>

                @endif


                {{-- =====================================================
                    GENERATED SHORT URL
                ====================================================== --}}

                @if(session('short_url'))

                    <div class="card mb-3">

                        <div class="card-body">

                            <div class="row align-items-center g-2">

                                <div class="col-md-9">

                                    <input
                                        type="text"
                                        id="generatedShortUrl"
                                        class="form-control"
                                        value="{{ session('short_url') }}"
                                        readonly
                                    >

                                </div>

                                <div class="col-md-3">

                                    <button
                                        type="button"
                                        class="btn btn-primary w-100"
                                        onclick="copyGeneratedUrl()"
                                    >

                                        <i class="ri-file-copy-line me-1"></i>

                                        Copy URL

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                @endif


                {{-- =====================================================
                    CREATE SHORT URL
                ====================================================== --}}

                <div class="card mb-3">

                    <div class="card-header">

                        <h5 class="card-title mb-0">
                            Create Short URL
                        </h5>

                    </div>


                    <div class="card-body">

                        <form
                            action="{{ route('url-shortener.store') }}"
                            method="POST"
                        >

                            @csrf


                            <div class="row align-items-end">

                                <div class="col-lg-8 col-md-8 mb-3 mb-md-0">

                                    <label class="form-label">
                                        Enter URL
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="url"
                                        name="original_url"
                                        class="form-control"
                                        placeholder="https://example.com"
                                        value="{{ old('original_url') }}"
                                        required
                                    >

                                </div>


                                <div class="col-lg-4 col-md-4">

                                    <button
                                        type="submit"
                                        class="btn btn-primary w-100"
                                    >

                                        <i class="ri-links-line me-1"></i>

                                        Create Short URL

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>


                {{-- =====================================================
                    LOGGED-IN USER TABLE
                ====================================================== --}}

                @auth

                    <div class="card">

                        <div class="card-header">

                            <h5 class="card-title mb-0">
                                Short URLs
                            </h5>

                        </div>


                        <div class="card-body">

                            <div class="table-responsive">

                                <table
                                    id="example"
                                    class="table table-bordered table-striped align-middle"
                                    style="width:100%"
                                >

                                    <thead>

                                        <tr>

                                            <th>#</th>

                                            <th>Original URL</th>

                                            <th>Short URL</th>

                                            <th>Total Clicks</th>

                                            <th>Date</th>

                                        </tr>

                                    </thead>


                                    <tbody>

                                        @forelse($urls as $url)

                                            <tr>

                                                {{-- Number --}}

                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>


                                                {{-- Original URL --}}

                                                <td>

                                                    <a
                                                        href="{{ $url->original_url }}"
                                                        target="_blank"
                                                        class="text-primary text-decoration-none"
                                                    >

                                                        {{ \Illuminate\Support\Str::limit($url->original_url, 50) }}

                                                    </a>

                                                </td>


                                                {{-- Short URL --}}

                                                <td>

                                                    <div class="d-flex align-items-center gap-2">

                                                        <a
                                                            href="{{ url('/' . $url->short_code) }}"
                                                            target="_blank"
                                                            class="text-primary"
                                                        >

                                                            {{ url('/' . $url->short_code) }}

                                                        </a>


                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-light border"
                                                            onclick="copyLink(
                                                                this,
                                                                '{{ url('/' . $url->short_code) }}'
                                                            )"
                                                            title="Copy"
                                                        >

                                                            <i class="ri-file-copy-line"></i>

                                                        </button>

                                                    </div>

                                                </td>


                                                {{-- Click Count --}}

                                                <td>
                                                    {{ $url->click_count ?? 0 }}
                                                </td>


                                                {{-- Date --}}

                                                <td>

                                                    {{ $url->created_at->format('d M Y') }}

                                                    <br>

                                                    <small class="text-muted">
                                                        {{ $url->created_at->format('h:i A') }}
                                                    </small>

                                                </td>

                                            </tr>

                                        @empty

                                            <tr>

                                                <td
                                                    colspan="5"
                                                    class="text-center text-muted py-4"
                                                >

                                                    No short URLs found.

                                                </td>

                                            </tr>

                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                @endauth


            </div>

        </div>

    </div>


    {{-- ================================================================
        SWEETALERT2
    ================================================================= --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>

        /*
        |--------------------------------------------------------------------------
        | Copy Generated Short URL
        |--------------------------------------------------------------------------
        */

        function copyGeneratedUrl()
        {
            const input = document.getElementById('generatedShortUrl');

            if (!input) {
                return;
            }

            navigator.clipboard
                .writeText(input.value)
                .then(function () {

                    Swal.fire({
                        icon: 'success',
                        title: 'Copied!',
                        text: 'Short URL copied successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    });

                })
                .catch(function () {

                    input.select();
                    document.execCommand('copy');

                    Swal.fire({
                        icon: 'success',
                        title: 'Copied!',
                        text: 'Short URL copied successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    });

                });
        }


        /*
        |--------------------------------------------------------------------------
        | Copy URL From Table
        |--------------------------------------------------------------------------
        */

        function copyLink(button, url)
        {
            navigator.clipboard
                .writeText(url)
                .then(function () {

                    Swal.fire({
                        icon: 'success',
                        title: 'Copied!',
                        text: 'Short URL copied successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    });

                })
                .catch(function () {

                    Swal.fire({
                        icon: 'error',
                        title: 'Copy Failed',
                        text: 'Unable to copy the URL.',
                        confirmButtonText: 'OK'
                    });

                });
        }


        /*
        |--------------------------------------------------------------------------
        | DataTable
        |--------------------------------------------------------------------------
        */

        document.addEventListener('DOMContentLoaded', function () {

            if (
                document.querySelector('#example') &&
                typeof $ !== 'undefined' &&
                $.fn.DataTable
            ) {

                $('#example').DataTable({

                    responsive: true,

                    pageLength: 10,

                    order: [
                        [4, 'desc']
                    ],

                    columnDefs: [

                        {
                            orderable: false,
                            targets: [1, 2]
                        }

                    ]

                });

            }

        });

    </script>


</x-app-layout>