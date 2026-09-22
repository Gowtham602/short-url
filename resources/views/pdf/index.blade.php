<x-app-layout>
<x-slot name="title">PDF to Image Generator</x-slot>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                            <h4 class="mb-sm-0 p-0 p-md-3">PDF to Image Generator</h4>
                            
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                    <li class="breadcrumb-item active">PDF to Image Generator</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                

                

                {{-- ===== UPLOADED IMAGES TABLE CARD ===== --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Upload a PDF file</h5>
                            </div>
                            <div class="card-body">
                                <form id="pdfForm" enctype="multipart/form-data">

                @csrf

                <input type="file"   id="newImage"  accept="image/*"  hidden>

                <div class="row align-items-end g-3">

                    <div class="col-lg-10">

                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <label for="pdf" class="form-label fw-semibold mb-0">
                                <i class="fa-solid fa-file-arrow-up me-1 text-primary"></i>
                                Choose PDF File
                            </label>

                            <small class="text-danger">
                                Supported format: PDF (Maximum 10 MB)
                            </small>

                        </div>

                        <input  type="file" name="pdf"  id="pdf" class="form-control" accept=".pdf">

                    </div>

                    <div class="col-lg-2">

                        <button  type="submit"  class="btn btn-primary">
                            <i class="fa-solid fa-cloud-arrow-up me-2"></i>
                            Upload PDF
                        </button>

                    </div>

                </div>

            </form>
                            </div>
                        </div>
                        <div class="row mt-4" id="preview">

    </div>
    
    
    <div class="card shadow-lg border-0 rounded-4 mt-4">

    <div class="card-header">
                                <h5 class="card-title mb-0">Generate Final Image</h5>
								<small>Configure your image settings before generating</small>
                            </div>

    <div class="card-body p-4">

        <div class="row g-4">

            <!-- Merge Type -->
            <div class="col-md-4">

                <label class="form-label fw-bold">

                    <i class="fa-solid fa-layer-group text-primary me-2"></i>

                    Merge Type

                </label>

                <select
                    id="mode"
                    class="form-select">

                    <option value="vertical">
                         Vertical
                    </option>

                    <option value="horizontal">
                         Horizontal
                    </option>

                </select>

            </div>

            <!-- District -->
            <div class="col-md-4">

                <label class="form-label fw-bold">

                    <i class="fa-solid fa-location-dot text-danger me-2"></i>

                    Branch

                </label>

                <select
                    id="district_id"
                    class="form-select">

                    <option value="">
                        Select Branch
                    </option>

                    @foreach($districts as $district)
<!-- 
                    <option value="{{ $district->id }}">
                        {{ $district->district_name }}
                    </option> -->
                            <option
    value="{{ $district->id }}"
    data-shortcode="{{ strtoupper($district->district_shortcode) }}">
    {{ $district->district_name }}
</option>
                    @endforeach

                </select>

            </div>

            <!-- Image Name -->
            <!-- <div class="col-md-4">

                <label class="form-label fw-bold">

                    <i class="fa-solid fa-tag text-success me-2"></i>

                    Image Name

                </label>

                <input
                    type="text"
                    id="image_name"
                    class="form-control"
                    placeholder="Festival Banner">

            </div> -->


            <div class="col-md-4">
    <label class="form-label fw-bold">
        <i class="fa-solid fa-tag text-success me-2"></i>
        Auto Image Name
    </label>

    <input
        type="text"
        id="image_name_preview"
        class="form-control"
        readonly>
</div>
        </div>

        <hr>

        <!-- Loading -->
        <div
            id="loadingBox"
            class="text-center my-4"
            style="display:none;">

            <img
                src="https://i.gifer.com/ZKZg.gif"
                width="120">

            <h5 class="mt-3 text-success">

                Generating Image...

            </h5>

            <p class="text-muted">

                Please wait while we merge your pages.

            </p>

        </div>

        <!-- Button -->

        <div class="text-center">

            <button
                id="generateBtn"
                class="btn btn-primary px-5 rounded-pill shadow">

                <i class="fa-solid fa-image me-2"></i>

                Generate Image 1

            </button>

        </div>

    </div>

</div>

{{-- ===== UPLOADED IMAGES TABLE CARD ===== --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Short URL</th>
                                                <th>Count</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($images as $image)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="{{ asset('storage/'.$image->file_path) }}" target="_blank" class="text-dark fw-semibold text-decoration-none">
                                                        {{ $image->image_name }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <a href="{{ url('/'.$image->short_code) }}" target="_blank" class="text-primary small text-truncate" style="max-width:220px;">
                                                            {{ url('/'.$image->short_code) }}
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-light border" onclick="copyLink(this, '{{ url('/'.$image->short_code) }}')">
                                                            <i class="ri-file-copy-line"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td>{{ $image->click_count }}</td>
                                                <td class="text-muted small">
                                                    {{ $image->created_at->format('d M Y') }}<br>
                                                    {{ $image->created_at->format('h:i A') }}
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
    
    <!-- NEW OFFCANVAS -->
    <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="resultModal" data-bs-backdrop="static" aria-labelledby="resultModalLabel">
        <div class="d-flex align-items-center bg-success bg-gradient text-white p-3 offcanvas-header">
            <h5 class="m-0 me-2" id="resultModalLabel">
                <i class="fa fa-image me-2"></i>
                Generated Image
            </h5>
            <button
                type="button"
                class="btn-close btn-close-white ms-auto"
                data-bs-dismiss="offcanvas">
            </button>
        </div>
        <div class="offcanvas-body">
            <div class="border rounded bg-light text-center"
                style="height:45vh;overflow:auto;">
                <img
                    id="finalImage"
                    class="img-fluid">
            </div>
            <div class="mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <label class="fw-bold">
                            Short Code
                        </label>
                        <div
                            id="resultShortCode"
                            class="form-control bg-light">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">
                            Short URL
                        </label>
                        <div
                            class="form-control bg-light">
                            <a
                                id="resultShortUrl"
                                target="_blank">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 justify-content-end mt-4">
                <button
                    class="btn btn-light"
                    data-bs-dismiss="offcanvas">
                    <i class="fa fa-times"></i>
                    Close
                </button>
               
                    <a
                        id="downloadBtn"
                        class="btn btn-success"
                        download>
                        <i class="fa fa-download"></i>
                        Download
                    </a>
                <button
                    id="saveImage"
                    class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    Save Image
                </button>
            </div>
        </div>
    </div>

<!-- //image preview modal -->
<div class="modal fade" id="previewModal" tabindex="-1">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">Image Preview</h5>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body text-center">

                <img id="previewImg"
                    class="img-fluid">

            </div>

        </div>

    </div>

</div>
    
    
    
                    </div>
                </div>

            </div><!-- container-fluid -->
        </div><!-- page-content -->

        @include('layouts.footer')
    </div><!-- main-content -->

    <!-- END layout-wrapper -->

    {{-- ===== LOADER OVERLAY ===== --}}
    <div id="loader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999; color:white; font-size:24px; justify-content:center; align-items:center;">
        Processing...
    </div>

    

    {{-- ===== BACK TO TOP ===== --}}
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>

    {{-- ===== PRELOADER ===== --}}
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>





<script>

let shortcode = $(this).find(":selected").data("shortcode");
    function todayCode() {
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    const d = new Date();

    return String(d.getDate()).padStart(2,'0')
        + months[d.getMonth()]
        + String(d.getFullYear()).slice(-2);
}

$("#district_id").change(function () {

    let shortcode = $(this).find(":selected").data("shortcode");

    if (!shortcode) {
        $("#image_name_preview").val("");
        return;
    }

    $("#image_name_preview").val(
        `POTHYS_${shortcode}_${todayCode()}`
    );
});
    function renderPages(res) {

    $("#preview").html("");

    const baseUrl = "{{ asset('storage/temp-pages') }}";

    $.each(res.images ?? res, function(index, item) {

        const fileName = item.image.split('/').pop();

        $("#preview").append(`
            <div class="col-md-3 mb-4">
                <div class="card shadow">

                    <img src="/storage/temp-pages/${fileName}" class="card-img-top">

                    <div class="card-body text-center">
                        <h5>Page ${item.sort_order}</h5>

                        <div class="d-grid gap-2 mt-2">
                            <button class="btn btn-info btn-sm preview-image"
                                data-image="${item.image}">
                                Preview
                            </button>

                            <button class="btn btn-warning btn-sm add-before"
                                data-order="${item.sort_order}">
                                Add Image Before
                            </button>

                            <button class="btn btn-success btn-sm add-after"
                                data-order="${item.sort_order}">
                                Add Image After
                            </button>

                            <button class="btn btn-danger btn-sm delete-page"
                                data-id="${item.id}">
                                Delete
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        `);
    });
}
    $("#pdfForm").submit(function(e) {

        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({

            url: "{{ route('pdf.upload') }}",

            type: "POST",

            data: formData,

            processData: false,

            contentType: false,

            success: function(res) {
                console.log(res,"...res01");
                renderPages(res);
                  

            },

            error: function(xhr) {

    console.log(xhr);

    if (xhr.responseJSON) {
        alert(xhr.responseJSON.message);
    } else {
        alert(xhr.responseText);
    }
}

        });

    });




    let insertPosition = 0;

    $(document).on("click", ".add-before", function() {

        insertPosition = $(this).data("order");

        $("#newImage").click();

    });

    $(document).on("click", ".add-after", function() {

        insertPosition = $(this).data("order") + 1;

        $("#newImage").click();

    });

    $("#newImage").change(function() {

        let fd = new FormData();

        fd.append("image", this.files[0]);

        fd.append("position", insertPosition);

        fd.append("_token", "{{ csrf_token() }}");

        $.ajax({

            url: "{{ route('pdf.add.image') }}",

            method: "POST",

            data: fd,

            processData: false,

            contentType: false,

            success: function() {

                loadPages();

            }

        });

    });


    $(document).on("click", ".delete-page", function() {

        let id = $(this).data("id");

        $.post(

            "{{ route('pdf.delete.page') }}",

            {

                id: id,

                _token: "{{ csrf_token() }}"

            },

            function() {

                loadPages();

            }

        );

    });

    function loadPages() {

        $.get("{{ route('pdf.pages') }}", function(res) {

            renderPages(res);

        });

    }
    $(document).on("click", ".preview-image", function() {

        let image = $(this).data("image");

        $("#previewImg").attr("src", image);

        let modal = new bootstrap.Modal(document.getElementById('previewModal'));

        modal.show();

    });

    // Updated for Offcanvas
    const resultOffcanvas = new bootstrap.Offcanvas(
        document.getElementById('resultModal')
    );

 $("#generateBtn").click(function () {

    // let district = $("#district_id").val();
    // let imageName = $("#image_name").val().trim();
    let district = $("#district_id").val();

    if (district === "") {
        toastr.warning("Please select a district.");
        return;
    }

    // if (imageName === "") {
    //     toastr.warning("Please enter an image name.");
    //     return;
    // }

    // Show Loading
    $("#loadingBox").fadeIn();

    $("#generateBtn")
        .prop("disabled", true)
        .removeClass("btn-success btn-secondary")
        .addClass("btn-warning")
        .html('<i class="fa fa-spinner fa-spin me-2"></i> Generating...');

    $.ajax({

        url: "{{ route('pdf.generate') }}",

        type: "POST",

        data: {

            _token: "{{ csrf_token() }}",

            mode: $("#mode").val(),

            district_id: district,

            // image_name: imageName

        },

        success: function (res) {

            $("#loadingBox").fadeOut();

            // Image
            $("#finalImage").attr("src", res.image_url);

            $("#downloadBtn").attr("href", res.image_url);

            $("#resultShortCode").text(res.short_code);

            $("#resultShortUrl")
                .attr("href", res.redirect_url)
                .text(res.redirect_url);

            $("#resultImageName").text(res.image_name);

            toastr.success(res.message);

            // Button -> Generated
            $("#generateBtn")
                .removeClass("btn-warning")
                .addClass("btn-secondary")
                .prop("disabled", false)
                .html('<i class="fa fa-check me-2"></i> Generated');

            resultOffcanvas.show();

        },

        error: function (xhr) {

            $("#loadingBox").fadeOut();

            $("#generateBtn")
                .prop("disabled", false)
                .removeClass("btn-warning btn-secondary")
                .addClass("btn-success")
                .html('<i class="fa-solid fa-image me-2"></i> Generate Image');

            if (xhr.status === 422) {

                toastr.error(xhr.responseJSON.message);

            } else {

                toastr.error("Something went wrong.");

            }

        }

    });

});
  // save the images in to db 
    $("#saveImage").click(function() {

        $.ajax({

            url: "{{ route('pdf.save.image') }}",

            type: "POST",

            data: {

                _token: "{{ csrf_token() }}",

                district_id: $("#district_id").val(),

                //  image_name: $("#image_name_preview").val(),

                file_path: $("#downloadBtn")
                    .attr("href")
                    .replace(window.location.origin + "/storage/", ""),

                short_code: $("#resultShortCode").text()

            },

            beforeSend: function() {

                $("#saveImage")
                    .prop("disabled", true)
                    .html('<i class="fa fa-spinner fa-spin"></i> Saving...');

            },

            success: function(res) {

    $("#saveImage")
        .prop("disabled", false)
        .html('<i class="fa fa-save"></i> Save Image');

    toastr.success(res.message);

    resultOffcanvas.hide();

    // Reset Upload Form
    $("#pdfForm")[0].reset();

    // Reset Generate Form
    $("#image_name_preview").val("");
    $("#district_id").val("");
    $("#mode").val("vertical");

    // Clear Preview
    $("#preview").empty();

    // Hide Loading
    $("#loadingBox").hide();

    // Clear Result Modal
    $("#finalImage").attr("src", "");
    $("#downloadBtn").attr("href", "#");
    $("#resultShortCode").text("");
    $("#resultShortUrl")
        .attr("href", "#")
        .text("");

    // Reset Generate Button
    $("#generateBtn")
        .prop("disabled", false)
        .removeClass("btn-secondary btn-warning")
        .addClass("btn-success")
        .html('<i class="fa-solid fa-image me-2"></i> Generate Image');

    // Reload DataTable
    //$("#example").DataTable().ajax.reload(null, false);
	$('#example').load(location.href + ' #example > *');

},

            error: function(xhr) {

                $("#saveImage")
                    .prop("disabled", false)
                    .html('<i class="fa fa-save"></i> Save Image');

                if (xhr.status === 422) {

                    toastr.error(xhr.responseJSON.message);

                } else {

                    toastr.error("Something went wrong.");

                }

            }

        });

    });
    


    function copyLink(button, url) {
    navigator.clipboard.writeText(url).then(() => {
        button.innerHTML = '<i class="ri-check-line text-success"></i>';
        setTimeout(() => {
            button.innerHTML = '<i class="ri-file-copy-line"></i>';
        }, 2000);

    }).catch(err => {
        console.error(err);
    });
}

document.getElementById('page-header-user-dropdown').addEventListener('click', function () {
  const menu = this.nextElementSibling;
  menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
});
</script>    

</x-app-layout>