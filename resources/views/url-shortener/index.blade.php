<x-app-layout>

    <x-slot name="title">
        URL Shortener
    </x-slot>

    <div class="main-content">

        <div class="page-content">

            <div class="container-fluid">

                {{-- Page Title --}}
                <div class="row">
                    <div class="col-12">

                        <div class="page-title-box d-sm-flex
                                    align-items-center
                                    justify-content-between">

                            <h4 class="mb-sm-0">
                                URL Shortener
                            </h4>

                        </div>

                    </div>
                </div>


                {{-- SUCCESS MESSAGE --}}
                @if(session('success'))

                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>

                @endif


                {{-- VALIDATION ERROR --}}
                @if($errors->any())

                    <div class="alert alert-danger">

                        <ul class="mb-0">

                            @foreach($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- CREATE SHORT URL --}}
                <div class="row">

                    <div class="col-lg-12">

                        <div class="card">

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


                                    <div class="row">


                                        {{-- URL --}}
                                        <div class="col-lg-6 mb-3">

                                            <label class="form-label">
                                                Enter URL
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


                                        {{-- DISTRICT --}}
                                        <div class="col-lg-6 mb-3">

                                            <label class="form-label">
                                                District
                                            </label>

                                            <select
                                                name="district_id"
                                                class="form-select"
                                                required
                                            >

                                                <option value="">
                                                    Select District
                                                </option>

                                                @foreach($districts as $district)

                                                    <option
                                                        value="{{ $district->id }}"
                                                        {{ old('district_id') == $district->id ? 'selected' : '' }}
                                                    >

                                                        {{ $district->district_name }}

                                                    </option>

                                                @endforeach

                                            </select>

                                        </div>


                                    </div>


                                    <div class="text-end">

                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                        >

                                            <i class="ri-links-line me-1"></i>

                                            Create Short URL

                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- URL LIST --}}
                {{-- URL LIST --}}
<div class="row">

    <div class="col-lg-12">

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
                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%"
                    >

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>Original URL</th>

                                <th>District</th>

                                <th>Short URL</th>

                                <th>Total Clicks</th>

                                <th>Date</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($urls as $url)

                                <tr>

                                    {{-- # --}}
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


                                    {{-- District --}}
                                    <td>

                                        {{ $url->district->district_name ?? '-' }}

                                    </td>


                                    {{-- Short URL --}}
                                    <td>

                                        <div class="d-flex align-items-center gap-2">

                                            <a
                                                href="{{ url('/'.$url->short_code) }}"
                                                target="_blank"
                                                class="text-primary small text-truncate"
                                                style="max-width:220px;"
                                            >

                                                {{ url('/'.$url->short_code) }}

                                            </a>


                                            {{-- Copy --}}
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-light border"
                                                onclick="copyLink(this, '{{ url('/'.$url->short_code) }}')"
                                            >

                                                <i class="ri-file-copy-line"></i>

                                            </button>

                                        </div>

                                    </td>


                                    {{-- Clicks --}}
                                    <td>

                                        {{ $url->click_count }}

                                    </td>


                                    {{-- Date --}}
                                    <td class="text-muted small">

                                        {{ $url->created_at->format('d M Y') }}<br>

                                        {{ $url->created_at->format('h:i A') }}

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="text-center text-muted"
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

    </div>

</div>

            </div>

        </div>

    </div>


    <script>

        function copyLink(button, url)
        {
            navigator.clipboard
                .writeText(url)
                .then(function () {

                    button.innerHTML =
                        '<i class="ri-check-line text-success"></i>';

                    setTimeout(function () {

                        button.innerHTML =
                            '<i class="ri-file-copy-line"></i>';

                    }, 2000);

                });
        }

    </script>

</x-app-layout>