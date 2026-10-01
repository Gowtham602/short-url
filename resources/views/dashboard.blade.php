<x-app-layout>

    <x-slot name="title">
        Image Merger
    </x-slot>


    {{-- ============================================================
    MAIN CONTENT
    ============================================================ --}}

    <div class="vertical-overlay"></div>

    <div class="main-content">

        <div class="page-content">

            <div class="container-fluid">


                {{-- ====================================================
                PAGE TITLE
                ==================================================== --}}

                <div class="row">

                    <div class="col-12">

                        <div
                            class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">

                            <h4 class="mb-sm-0 p-0 p-md-3">
                                Image Merger 0
                            </h4>

                            <div class="page-title-right">

                                <ol class="breadcrumb m-0">

                                    <li class="breadcrumb-item">
                                        <a href="{{ route('home') }}">
                                            Dashboard
                                        </a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        Image Merger 07
                                    </li>

                                </ol>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ====================================================
                JAVASCRIPT ROUTES
                ==================================================== --}}

                <script>

                    window.appUrl = "{{ url('/') }}";

                    window.routes = {

                        saveImage:
                            "{{ route('save.image') }}",

                        processImage:
                            "{{ route('image.process') }}"

                    };

                </script>



                {{-- ====================================================
                IMAGE MERGER
                ==================================================== --}}

                <div class="row">

                    <div class="col-lg-12">

                        <form id="mergeForm" enctype="multipart/form-data">

                            @csrf


                            <div class="card">


                                {{-- CARD HEADER --}}

                                <div class="card-header">

                                    <h4 class="card-title mb-0">
                                        Image Merger 07
                                    </h4>

                                </div>



                                {{-- CARD BODY --}}

                                <div class="card-body">


                                    <div class="row mb-3">


                                        {{-- MERGE DIRECTION --}}

                                        <div class="col-lg-6">

                                            <label class="form-label">
                                                Merge Direction o7
                                            </label>

                                            <select name="mode" class="form-select" required>

                                                <option value="vertical">
                                                    Vertical (Top → Bottom)
                                                </option>

                                                <option value="horizontal">
                                                    Horizontal (Left → Right)
                                                </option>

                                            </select>

                                        </div>



                                        {{-- DISTRICT --}}

                                        <!-- <div class="col-lg-6">

                                            <label class="form-label">
                                                District
                                            </label>

                                            <select name="district_id" id="district_id" class="form-select" required>

                                                <option value="">
                                                    Select District
                                                </option>

                                                @foreach($districts ?? [] as $district)

                                                    <option value="{{ $district->id }}"
                                                        data-shortcode="{{ strtoupper($district->district_shortcode) }}">

                                                        {{ $district->district_name }}

                                                    </option>

                                                @endforeach

                                            </select>

                                        </div> -->

                                    </div>


                                </div>



                                {{-- ====================================================
                                DROPZONE
                                ==================================================== --}}

                                <div class="card-body">

                                    <div class="dropzone" id="myDropzone">

                                        <div class="fallback">

                                            <input name="images[]" type="file" multiple>

                                        </div>


                                        <div class="dz-message needsclick">

                                            <div class="mb-3">

                                                <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>

                                            </div>

                                            <h4>
                                                Drop files here or click to upload.
                                            </h4>

                                        </div>

                                    </div>


                                    {{-- DROPZONE PREVIEW --}}

                                    <ul class="list-unstyled mb-0" id="dropzone-preview">

                                        <li class="mt-2" id="dropzone-preview-list">

                                            <div class="border rounded">

                                                <div class="d-flex p-2 align-items-center">


                                                    <div class="flex-shrink-0 me-2 dz-drag-handle" style="cursor:grab;">

                                                        <i class="ri-drag-move-2-line fs-18 text-muted"></i>

                                                    </div>


                                                    <div class="flex-shrink-0 me-3">

                                                        <div class="avatar-sm bg-light rounded position-relative">

                                                            <span class="badge bg-primary rounded-pill dz-order-badge"
                                                                style="
                                                                    position:absolute;
                                                                    top:-6px;
                                                                    left:-6px;
                                                                    font-size:10px;
                                                                ">
                                                                1
                                                            </span>

                                                            <img data-dz-thumbnail class="img-fluid rounded d-block"
                                                                src="{{ asset('assets/images/new-document.png') }}"
                                                                alt="Preview">

                                                        </div>

                                                    </div>


                                                    <div class="flex-grow-1">

                                                        <div class="pt-1">

                                                            <h5 class="fs-14 mb-1" data-dz-name>
                                                                &nbsp;
                                                            </h5>

                                                            <p class="fs-13 text-muted mb-0" data-dz-size></p>

                                                            <strong class="error text-danger"
                                                                data-dz-errormessage></strong>

                                                        </div>

                                                    </div>


                                                    <div class="flex-shrink-0 ms-3">

                                                        <button data-dz-remove type="button"
                                                            class="btn btn-sm btn-danger">
                                                            Delete
                                                        </button>

                                                    </div>

                                                </div>

                                            </div>

                                        </li>

                                    </ul>


                                </div>



                                {{-- GENERATE BUTTON --}}

                                <div class="card-footer text-center">

                                    <button type="submit" class="btn btn-primary" id="generateBtn">

                                        Generate Image

                                    </button>

                                </div>


                            </div>

                        </form>

                    </div>

                </div>



                {{-- ====================================================
                UPLOADED IMAGES
                ==================================================== --}}

                @auth

                    <div class="row">

                        <div class="col-lg-12">

                            <div class="card">

                                <div class="card-header">

                                    <h5 class="card-title mb-0">
                                        Uploaded Images
                                    </h5>

                                </div>


                                <div class="card-body">

                                    <div class="table-responsive">

                                        <table id="example" class="table table-bordered table-striped align-middle"
                                            style="width:100%">

                                            <thead>

                                                <tr>

                                                    <th>#</th>

                                                    <th>
                                                        Image
                                                    </th>

                                                    <!-- <th>
                                                                Action
                                                            </th> -->

                                                    <th>
                                                        Short URL
                                                    </th>

                                                    <th>
                                                        Total Views
                                                    </th>

                                                    <!-- <th>
                                                            Analysis
                                                        </th> -->

                                                    <th>
                                                        Date
                                                    </th>

                                                </tr>

                                            </thead>


                                            <tbody>

                                                @foreach($images ?? [] as $image)

                                                    <tr>


                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>


                                                        <td>

                                                            <a href="{{ asset('storage/' . $image->file_path) }}"
                                                                target="_blank"
                                                                class="text-dark fw-semibold text-decoration-none">

                                                                {{ $image->image_name }}

                                                            </a>

                                                        </td>

                                                        <!-- 
                                                                        <td>

                                                                            @if(Route::has('image.edit'))

                                                                                <a href="{{ route('image.edit', $image->short_code) }}"
                                                                                    class="btn btn-sm btn-primary">

                                                                                    <i class="ri-edit-line"></i>

                                                                                </a>

                                                                            @endif


                                                                            @if(Route::has('image.destroy'))

                                                                                <form action="{{ route('image.destroy', $image->id) }}"
                                                                                    method="POST" class="d-inline"
                                                                                    onsubmit="return confirm('Delete this image?')">

                                                                                    @csrf

                                                                                    @method('DELETE')

                                                                                    <button type="submit" class="btn btn-sm btn-danger">

                                                                                        <i class="ri-delete-bin-line"></i>

                                                                                    </button>

                                                                                </form>

                                                                            @endif

                                                                        </td> -->


                                                        <td>

                                                            <div class="d-flex align-items-center gap-2">

                                                                <a href="{{ url('/' . $image->short_code) }}" target="_blank"
                                                                    class="text-primary small">

                                                                    {{ url('/' . $image->short_code) }}

                                                                </a>


                                                                <button type="button" class="btn btn-sm btn-light border"
                                                                    onclick="copyLink(this, '{{ url('/' . $image->short_code) }}')">

                                                                    <i class="ri-file-copy-line"></i>

                                                                </button>

                                                            </div>

                                                        </td>


                                                        <td>

                                                            {{ $image->click_count ?? 0 }}

                                                        </td>


                                                        <!-- <td>

                                                                    @if(Route::has('image.analysis'))

                                                                        <a href="{{ route('image.analysis', $image->id) }}"
                                                                            class="btn btn-sm btn-primary">

                                                                            <i class="ri-bar-chart-line"></i>

                                                                            Analysis

                                                                        </a>

                                                                    @endif

                                                                </td> -->


                                                        <td class="text-muted small">

                                                            {{ $image->created_at?->format('d M Y') }}

                                                            <br>

                                                            {{ $image->created_at?->format('h:i A') }}

                                                        </td>


                                                    </tr>

                                                @endforeach

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                @endauth


            </div>

        </div>


        @include('layouts.footer')

    </div>



    {{-- ============================================================
    LOADER
    ============================================================ --}}

    <div id="loader" style="
            display:none;
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,.6);
            z-index:9999;
            color:white;
            font-size:24px;
            justify-content:center;
            align-items:center;
        ">

        Processing...

    </div>



    {{-- ============================================================
    RESULT OFFCANVAS
    ============================================================ --}}

    <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="resultModal">


        {{-- HEADER --}}

        <div class="d-flex align-items-center bg-primary bg-gradient p-3 offcanvas-header">

            <h5 class="m-0 text-white">

                <i class="ri-image-line me-2"></i>

                Final Output

            </h5>


            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas"></button>

        </div>



        {{-- BODY --}}

        <div class="offcanvas-body">


            {{-- IMAGE --}}

            <div class="text-center mb-3">

                <img id="modalImage" src="" style="
                        max-width:100%;
                        border-radius:8px;
                        border:1px solid #e9ebec;
                    " alt="Merged Image">

            </div>



            {{-- IMAGE NAME --}}

            <div class="mb-3">

                <!-- <label class="form-label fw-semibold">

                    Image Name

                </label> -->


                <div class="form-control-plaintext fw-semibold text-primary" id="previewName">

                    —

                </div>


                <div class="alert alert-info text-center mt-3 mb-0 py-2">
                    <i class="ri-information-line me-1"></i>
                    <strong>Important:</strong>
                    Short URL is automatically copied.
                    This window will close automatically after <strong>7 seconds</strong>.
                </div>


                <div class="text-danger mt-2" id="img_error"></div>

            </div>



            {{-- SHORT URL --}}

            <div id="shortUrlBox" class="mt-4" style="display:none;">

                <label class="form-label fw-semibold">

                    Short URL

                </label>


                <div class="input-group">

                    <input type="text" id="shortUrlInput" class="form-control" readonly>


                    <button type="button" class="btn btn-primary" id="copyShortUrl">

                        <i class="ri-file-copy-line me-1"></i>

                        Copy

                    </button>

                </div>


                <div class="mt-2">

                    <a href="#" target="_blank" id="openShortUrl" class="btn btn-success btn-sm">

                        <i class="ri-external-link-line me-1"></i>

                        Open Short URL

                    </a>

                </div>

            </div>



            {{-- BUTTONS --}}

            <div class="d-flex gap-2 justify-content-end mt-4">


                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">

                    <i class="ri-close-line me-1"></i>

                    Close

                </button>


                <button type="button" id="modalDownload" class="btn btn-success">

                    <i class="ri-download-2-line me-1"></i>

                    Download

                </button>


                <button type="button" id="saveBtn" class="btn btn-primary">

                    <i class="ri-links-line me-1"></i>

                    Create Short URL 09

                </button>


            </div>

        </div>

    </div>



    {{-- ============================================================
    SORTABLE
    ============================================================ --}}

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>



    {{-- ============================================================
    MAIN JAVASCRIPT
    ============================================================ --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {


            /*
            |--------------------------------------------------------------------------
            | VARIABLES
            |--------------------------------------------------------------------------
            */

            Dropzone.autoDiscover = false;


            const dropzoneElement =
                document.querySelector('#myDropzone');


            const previewContainer =
                document.querySelector('#dropzone-preview');


            const previewTemplateElement =
                document.querySelector('#dropzone-preview-list');


            const mergeForm =
                document.querySelector('#mergeForm');


            const loader =
                document.querySelector('#loader');


            const generateBtn =
                document.querySelector('#generateBtn');


            const saveBtn =
                document.querySelector('#saveBtn');


            const resultModal =
                document.querySelector('#resultModal');



            /*
            |--------------------------------------------------------------------------
            | DROPZONE
            |--------------------------------------------------------------------------
            */

            let previewTemplate =
                previewTemplateElement.outerHTML;


            previewContainer.innerHTML = '';


            const myDropzone =
                new Dropzone(
                    '#myDropzone',
                    {

                        autoProcessQueue: false,

                        url: '/',

                        clickable: '#myDropzone',

                        previewsContainer:
                            '#dropzone-preview',

                        previewTemplate:
                            previewTemplate

                    }
                );



            /*
            |--------------------------------------------------------------------------
            | UPDATE ORDER
            |--------------------------------------------------------------------------
            */

            function updatePreviewOrderBadges() {

                document
                    .querySelectorAll(
                        '#dropzone-preview > li'
                    )
                    .forEach(
                        function (li, index) {

                            const badge =
                                li.querySelector(
                                    '.dz-order-badge'
                                );


                            if (badge) {

                                badge.textContent =
                                    index + 1;

                            }

                        }
                    );

            }



            myDropzone.on(
                'addedfile',
                updatePreviewOrderBadges
            );


            myDropzone.on(
                'removedfile',
                updatePreviewOrderBadges
            );



            /*
            |--------------------------------------------------------------------------
            | SORTABLE
            |--------------------------------------------------------------------------
            */

            if (
                typeof Sortable !== 'undefined'
            ) {

                Sortable.create(
                    previewContainer,
                    {

                        animation: 150,

                        handle: '.dz-drag-handle',

                        onEnd: function () {

                            const newOrder = [];


                            document
                                .querySelectorAll(
                                    '#dropzone-preview > li'
                                )
                                .forEach(
                                    function (li) {

                                        const file =
                                            myDropzone.files.find(
                                                function (file) {
                                                    return file.previewElement === li;
                                                }
                                            );


                                        if (file) {

                                            newOrder.push(file);

                                        }

                                    }
                                );


                            if (
                                newOrder.length ===
                                myDropzone.files.length
                            ) {

                                myDropzone.files =
                                    newOrder;

                            }


                            updatePreviewOrderBadges();

                        }

                    }
                );

            }



            /*
            |--------------------------------------------------------------------------
            | TODAY CODE
            |--------------------------------------------------------------------------
            */

            function todayCode() {

                const months = [

                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'

                ];


                const date =
                    new Date();


                const day =
                    String(
                        date.getDate()
                    ).padStart(2, '0');


                const month =
                    months[
                    date.getMonth()
                    ];


                const year =
                    String(
                        date.getFullYear()
                    ).slice(-2);


                return day + month + year;

            }



            /*
            |--------------------------------------------------------------------------
            | IMAGE NAME
            |--------------------------------------------------------------------------
            */

            // function computePreviewName() {

            // const district =
            //     document.querySelector(
            //         '#district_id'
            //     );


            // if (!district) {

            //     return '—';

            // }


            // const option =
            //     district.options[
            //     district.selectedIndex
            //     ];


            // if (
            //     !option ||
            //     !option.dataset.shortcode
            // ) {

            //     return '—';

            // }


            //     return (
            //         'POTHYS_' +
            //         option.dataset.shortcode.toUpperCase() +
            //         '_' +
            //         todayCode() +
            //         '_1'
            //     );

            // }

            /*
            |--------------------------------------------------------------------------
            | RESET FOR NEXT IMAGE
            |--------------------------------------------------------------------------
            */

            function resetForNextImage() {

                console.log('Resetting image merger...');

                // ==========================================
                // 1. REMOVE ALL OLD UPLOADED FILES
                // ==========================================

                myDropzone.removeAllFiles(true);


                // ==========================================
                // 2. CLEAR FINAL IMAGE PREVIEW
                // ==========================================

                const modalImage =
                    document.querySelector('#modalImage');

                modalImage.src = '';

                modalImage.removeAttribute('data-file-path');


                // ==========================================
                // 3. RESET IMAGE NAME
                // ==========================================

                document.querySelector('#previewName')
                    .textContent = '—';


                // ==========================================
                // 4. HIDE SHORT URL
                // ==========================================

                document.querySelector('#shortUrlBox')
                    .style.display = 'none';


                // ==========================================
                // 5. CLEAR SHORT URL
                // ==========================================

                document.querySelector('#shortUrlInput')
                    .value = '';

                document.querySelector('#openShortUrl')
                    .href = '#';


                // ==========================================
                // 6. CLEAR ERROR
                // ==========================================

                document.querySelector('#img_error')
                    .textContent = '';


                // ==========================================
                // 7. RESET DISTRICT
                // ==========================================

                // document.querySelector('#district_id')
                //     .value = '';


                // ==========================================
                // 8. RESET MERGE MODE
                // ==========================================

                const modeSelect =
                    document.querySelector(
                        'select[name="mode"]'
                    );

                if (modeSelect) {

                    modeSelect.value = 'vertical';
                }


                // ==========================================
                // 9. RESET CREATE SHORT URL BUTTON
                // ==========================================

                saveBtn.disabled = false;

                saveBtn.innerHTML =
                    '<i class="ri-links-line me-1"></i> Create Short URL';


                console.log(
                    'Old files removed. Ready for new upload.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | GENERATE IMAGE
            |--------------------------------------------------------------------------
            */

            mergeForm.addEventListener(
                'submit',
                async function (event) {

                    event.preventDefault();

                    if (myDropzone.files.length === 0) {

                        alert('Please add at least one image.');

                        return;
                    }

                    loader.style.display = 'flex';

                    generateBtn.disabled = true;

                    generateBtn.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span> Processing...';

                    const formData = new FormData();

                    formData.append(
                        '_token',
                        document.querySelector(
                            'input[name="_token"]'
                        ).value
                    );

                    formData.append(
                        'mode',
                        document.querySelector(
                            'select[name="mode"]'
                        ).value
                    );

                    myDropzone.files.forEach(function (file) {

                        formData.append(
                            'images[]',
                            file
                        );

                    });

                    try {

                        const response = await fetch(
                            window.routes.processImage,
                            {
                                method: 'POST',

                                headers: {
                                    'Accept': 'application/json'
                                },

                                body: formData
                            }
                        );

                        const text = await response.text();

                        let data;

                        try {

                            data = JSON.parse(text);

                        } catch (error) {

                            console.error(text);

                            throw new Error(
                                'Invalid server response'
                            );
                        }

                        if (!response.ok) {

                            throw new Error(
                                data.message ||
                                'Image processing failed.'
                            );
                        }

                        if (data.image) {

                            const modalImage =
                                document.querySelector(
                                    '#modalImage'
                                );

                            modalImage.src =
                                data.image_url || data.image;

                            modalImage.dataset.filePath =
                                data.file_path;

                            // Since district is removed,
                            // don't call computePreviewName()
                            // document.querySelector(
                            //     '#previewName'
                            // ).textContent =
                            //     'Merged Image';

                            document.querySelector(
                                '#shortUrlBox'
                            ).style.display = 'none';

                            document.querySelector(
                                '#shortUrlInput'
                            ).value = '';

                            document.querySelector(
                                '#img_error'
                            ).textContent = '';

                            saveBtn.disabled = false;

                            saveBtn.innerHTML =
                                '<i class="ri-links-line me-1"></i> Create Short URL';

                            const offcanvas =
                                bootstrap.Offcanvas.getOrCreateInstance(
                                    resultModal
                                );

                            offcanvas.show();

                        } else {

                            throw new Error(
                                data.message ||
                                'Image processing failed.'
                            );
                        }

                    } catch (error) {

                        console.error(
                            'Generate Error:',
                            error
                        );

                        alert(
                            error.message ||
                            'Something went wrong.'
                        );

                    } finally {

                        loader.style.display = 'none';

                        generateBtn.disabled = false;

                        generateBtn.innerHTML =
                            'Generate Image';
                    }

                }
            );



            /*
            |--------------------------------------------------------------------------
            | DOWNLOAD
            |--------------------------------------------------------------------------
            */

            document
                .querySelector('#modalDownload')
                .addEventListener(
                    'click',
                    function () {

                        const image =
                            document.querySelector(
                                '#modalImage'
                            );


                        if (!image.src) {

                            return;

                        }


                        const name =
                            document.querySelector(
                                '#previewName'
                            ).textContent.trim();


                        const link =
                            document.createElement('a');


                        link.href =
                            image.src;


                        link.download =
                            (
                                name &&
                                    name !== '—'
                                    ? name
                                    : 'merged-image'
                            ) +
                            '.jpeg';


                        document.body.appendChild(
                            link
                        );


                        link.click();


                        link.remove();

                    }
                );



            /*
            |--------------------------------------------------------------------------
            | CREATE SHORT URL
            |--------------------------------------------------------------------------
            */
            saveBtn.addEventListener(
                'click',
                async function () {

                    const button = this;

                    const errorBox =
                        document.querySelector('#img_error');

                    errorBox.textContent = '';

                    const modalImage =
                        document.querySelector('#modalImage');

                    const filePath =
                        modalImage.dataset.filePath;

                    // =========================================
                    // VALIDATION
                    // =========================================

                    if (!filePath) {

                        errorBox.textContent =
                            'Generated image file path is missing.';

                        return;
                    }

                    // =========================================
                    // BUTTON LOADING
                    // =========================================

                    button.disabled = true;

                    button.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span> Creating...';

                    try {

                        const response = await fetch(
                            window.routes.saveImage,
                            {
                                method: 'POST',

                                headers: {

                                    'Content-Type':
                                        'application/json',

                                    'X-CSRF-TOKEN':
                                        document.querySelector(
                                            'input[name="_token"]'
                                        ).value,

                                    'Accept':
                                        'application/json'
                                },

                                body: JSON.stringify({

                                    file_path: filePath

                                })
                            }
                        );

                        const data =
                            await response.json();

                        console.log(
                            'Save Image Response:',
                            data
                        );

                        if (!response.ok) {

                            errorBox.textContent =
                                data.message ||
                                'Unable to create short URL.';

                            button.disabled = false;

                            button.innerHTML =
                                '<i class="ri-links-line me-1"></i> Create Short URL';

                            return;
                        }

                        if (data.status === 'success') {

                            // =========================================
                            // SHOW SHORT URL
                            // =========================================

                            document.querySelector('#shortUrlInput').value =
                                data.short_url;

                            document.querySelector('#openShortUrl').href =
                                data.short_url;

                            document.querySelector('#shortUrlBox').style.display =
                                'block';


                            // =========================================
                            // AUTO COPY SHORT URL
                            // =========================================

                            try {

                                await navigator.clipboard.writeText(data.short_url);

                                if (typeof toastr !== 'undefined') {

                                    toastr.success(
                                        'Short URL created and copied successfully!'
                                    );

                                }

                            } catch (error) {

                                console.error('Copy failed:', error);

                                if (typeof toastr !== 'undefined') {

                                    toastr.info(
                                        'Short URL created. Please click Copy to copy it.'
                                    );

                                }
                            }


                            // =========================================
                            // UPDATE IMAGE
                            // =========================================

                            if (data.image_url) {

                                modalImage.src = data.image_url;

                            }


                            // =========================================
                            // BUTTON
                            // =========================================

                            button.disabled = true;

                            button.innerHTML =
                                '<i class="ri-check-line me-1"></i> URL Created';


                            // =========================================
                            // SUCCESS MESSAGE
                            // =========================================

                            if (typeof toastr !== 'undefined') {

                                toastr.success(
                                    'Short URL created successfully!'
                                );

                            }


                            // =========================================
                            // CLOSE AFTER 7 SECONDS
                            // =========================================

                            // =========================================
                            // AUTO CLOSE + REFRESH AFTER 7 SECONDS
                            // =========================================

                            setTimeout(function () {

                                const offcanvas =
                                    bootstrap.Offcanvas.getInstance(resultModal);

                                if (offcanvas) {

                                    // Close Final Output
                                    offcanvas.hide();

                                    // Wait until offcanvas is completely closed
                                    resultModal.addEventListener(
                                        'hidden.bs.offcanvas',
                                        function () {

                                            // Reset merger
                                            resetForNextImage();

                                            // Reload page
                                            // This loads the latest saved image into the table
                                            window.location.reload();

                                        },
                                        { once: true }
                                    );

                                } else {

                                    // Safety fallback
                                    window.location.reload();

                                }

                            }, 7000);

                        } else {

                            errorBox.textContent =
                                data.message ||
                                'Unable to create short URL.';

                            button.disabled = false;

                            button.innerHTML =
                                '<i class="ri-links-line me-1"></i> Create Short URL';
                        }

                    } catch (error) {

                        console.error(
                            'Save Image Error:',
                            error
                        );

                        errorBox.textContent =
                            'Something went wrong. Please try again.';

                        button.disabled = false;

                        button.innerHTML =
                            '<i class="ri-links-line me-1"></i> Create Short URL';
                    }

                }
            );

            document
                .querySelector('#copyShortUrl')
                .addEventListener(
                    'click',
                    async function () {

                        const input =
                            document.querySelector(
                                '#shortUrlInput'
                            );


                        const url =
                            input.value;


                        if (!url) {

                            return;

                        }


                        try {


                            await navigator.clipboard.writeText(
                                url
                            );


                            if (
                                typeof toastr !==
                                'undefined'
                            ) {

                                toastr.success(
                                    'Short URL copied!'
                                );

                            }


                        }
                        catch (error) {


                            input.select();


                            document.execCommand(
                                'copy'
                            );


                            if (
                                typeof toastr !==
                                'undefined'
                            ) {

                                toastr.success(
                                    'Short URL copied!'
                                );

                            }

                        }

                    }
                );

        });

        function copyLink(button, url) {

            navigator.clipboard
                .writeText(url)
                .then(
                    function () {

                        button.innerHTML =
                            '<i class="ri-check-line text-success"></i>';


                        setTimeout(
                            function () {

                                button.innerHTML =
                                    '<i class="ri-file-copy-line"></i>';

                            },
                            2000
                        );

                    }
                )
                .catch(
                    function (error) {

                        console.error(error);

                    }
                );

        }
        // ============================================================
        // DATATABLE
        // ============================================================

        if (document.querySelector('#example')) {

            $('#example').DataTable({
                responsive: true,
                pageLength: 10,
                order: [
                    [5, 'desc']
                ],
                columnDefs: [
                    {
                        orderable: false,
                        targets: [1, 2, 3, 5]
                    }
                ]
            });

        }

    </script>


</x-app-layout>