<x-app-layout>
<x-slot name="title">Image Merger</x-slot>

    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                            <h4 class="mb-sm-0">Image Merger</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Image Merger</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                {{-- Routes & Flash --}}
                <script>
                    window.flashMessages = {
                        success: @json(session('success')),
                        error:   @json(session('error')),
                        validationErrors: @json($errors->all())
                    };
                    window.appUrl = "{{ url('/') }}";
                    window.routes = {
                        saveImage:    "{{ route('save.image') }}",
                        processImage: "{{ route('image.process') }}",
                        getImages:    "{{ route('get.images') }}"
                    };
                </script>

                {{-- ===== IMAGE MERGER FORM CARD ===== --}}
                <div class="row">
                        <div class="col-lg-12">
                            <form id="mergeForm" enctype="multipart/form-data">
                                    @csrf
							<div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Image Merger</h4>
                                </div><!-- end card header -->

                                
								<div class="card-body">
                                    <div class="live-preview">
                                        <div class="row mb-3">
                                            <div class="col-lg-6">
                                            <label class="form-label">Merge Direction</label>
                                            <select name="mode" class="form-select">
                                                <option value="vertical">Vertical (Top → Bottom)</option>
                                                <option value="horizontal">Horizontal (Left → Right)</option>
                                            </select>
                                            <div id="dynamicOptions" class="mt-2"></div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">District</label>
                                            <select name="district_id" id="district_id" class="form-select" required>
                                                <option value="">Select District</option>
                                                @foreach($districts ?? [] as $district)
													<option value="{{ $district->id }}" data-shortcode="{{ strtoupper($district->district_shortcode) }}">{{ $district->district_name }}</option>
												@endforeach
                                            </select>
                                        </div>
                                        </div>
                                            </div>
                                        </div>
								
								
                                        
								
								<div class="card-body">
                                    <div class="dropzone" id="myDropzone">
                                        <div class="fallback">
                                            <input name="images[]" type="file" multiple="multiple">
                                        </div>
                                        <div class="dz-message needsclick">
                                            <div class="mb-3">
                                                <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                            </div>

                                            <h4>Drop files here or click to upload.</h4>
                                        </div>
                                    </div>

                                    <ul class="list-unstyled mb-0" id="dropzone-preview">
                                        <li class="mt-2" id="dropzone-preview-list">
                                            <!-- This is used as the file preview template -->
                                            <div class="border rounded">
                                                <div class="d-flex p-2 align-items-center">
                                                    <div class="flex-shrink-0 me-2 dz-drag-handle" style="cursor: grab;" title="Drag to reorder">
                                                        <i class="ri-drag-move-2-line fs-18 text-muted"></i>
                                                    </div>
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar-sm bg-light rounded position-relative">
                                                            <span class="badge bg-primary rounded-pill dz-order-badge" style="position:absolute; top:-6px; left:-6px; font-size:10px;">1</span>
                                                            <img data-dz-thumbnail class="img-fluid rounded d-block" src="assets/images/new-document.png" alt="Dropzone-Image" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="pt-1">
                                                            <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                                            <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                                            <strong class="error text-danger" data-dz-errormessage></strong>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-3">
                                                        <button data-dz-remove class="btn btn-sm btn-danger">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <!-- end dropzon-preview -->
                                </div>
                                <!-- end card body -->
								<div class="card-header"> </div>
								{{-- Submit --}}
								<div class="mt-2 mb-2 text-center">
									<button type="submit" class="btn btn-primary">Generate Image 3</button>
								</div>
                            </div>
							</form>
                            <!-- end card -->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                {{-- ===== UPLOADED IMAGES TABLE CARD ===== --}}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Uploaded Images21</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                                <th>Short URL</th>
                                                <th>Total Views</th>
                                                <th>Analysis views</th>
                                                <!-- <th>City</th> -->
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
                                                    <a href="{{route('image.edit', $image->short_code) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="ri-edit-line"></i>
                                                    </a>

                                                    <form action="{{ route('image.destroy', $image->id) }}"
                                                        method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Delete this image?')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button class="btn btn-sm btn-danger">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>

                                                    </form>
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
                                                <td>{{ $image->clicks_count }}</td>
                                                <!-- <td>
                                                    <span class="badge bg-success">
                                                        {{ $image->today_clicks }}
                                                    </span>
                                                </td> -->
                                                <!-- //analyticsview -->
                                                <td>
                                                   <a href="{{ route('image.analysis', $image->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                        <i class="ri-bar-chart-line"></i> Analysis
                                                    </a>
                                                </td>
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

            </div><!-- container-fluid -->
        </div><!-- page-content -->

        @include('layouts.footer')
    </div><!-- main-content -->

    <!-- END layout-wrapper -->

    {{-- ===== LOADER OVERLAY ===== --}}
    <div id="loader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999; color:white; font-size:24px; justify-content:center; align-items:center;">
        Processing...
    </div>

    {{-- ===== RESULT OFFCANVAS ===== --}}
    <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="resultModal" aria-labelledby="resultModalLabel">
        <div class="d-flex align-items-center bg-primary bg-gradient p-3 offcanvas-header">
            <h5 class="m-0 me-2 text-white" id="resultModalLabel">
                <i class="ri-image-line me-2"></i> Final Output
            </h5>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <div class="text-center mb-3">
                <img id="modalImage"
                    style="max-width:100%; border-radius:8px; border:1px solid #e9ebec;"
                    alt="Merged Image">
            </div>
            <div>
                <label class="form-label fw-semibold">Image Name</label>
                <div class="form-control-plaintext fw-semibold text-primary" id="previewName">—</div>
                <div class="form-text text-muted">Auto-generated from district and today's date. This will be used as the filename and short URL.</div>
                <div class="text-danger" id="img_error"></div>
            </div>

            <div class="d-flex gap-2 justify-content-end mt-4">
                <button type="button" class="btn btn-light" data-bs-dismiss="offcanvas">
                    <i class="ri-close-line me-1"></i> Close
                </button>
                <button id="modalDownload" class="btn btn-success">
                    <i class="ri-download-2-line me-1"></i> Download
                </button>
                <button id="saveBtn" class="btn btn-primary">
                    <i class="ri-links-line me-1"></i> Create Short URL
                </button>
            </div>
        </div>
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

    {{-- ===== PAGE SCRIPTS ===== --}}
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script>
window.onload = function () {
    Dropzone.autoDiscover = false;

    var el = document.querySelector("#myDropzone");
    if (el && el.dropzone) {
        el.dropzone.destroy();
    }

    // Grab template HTML before clearing the list
    var previewTemplate = document.querySelector("#dropzone-preview-list").outerHTML;

    // Clear the preview list (remove the placeholder li)
    document.querySelector("#dropzone-preview").innerHTML = "";

    var myDropzone = new Dropzone("#myDropzone", {
		autoProcessQueue: false,
		url: "/",
		clickable: "#myDropzone",
		previewsContainer: "#dropzone-preview",
		previewTemplate: previewTemplate,
	});

    // ── Reordering (drag & drop) ────────────────────────────────────────
    function updatePreviewOrderBadges() {
        document.querySelectorAll('#dropzone-preview > li').forEach(function (li, idx) {
            var badge = li.querySelector('.dz-order-badge');
            if (badge) badge.textContent = idx + 1;
        });
    }

    myDropzone.on("addedfile", function () {
        updatePreviewOrderBadges();
    });

    myDropzone.on("removedfile", function () {
        updatePreviewOrderBadges();
    });

    if (typeof Sortable !== 'undefined') {
        Sortable.create(document.getElementById('dropzone-preview'), {
            animation: 150,
            handle: '.dz-drag-handle',
            onEnd: function () {
                // Rebuild myDropzone.files to match the new visual order
                var newOrder = [];
                document.querySelectorAll('#dropzone-preview > li').forEach(function (li) {
                    var match = myDropzone.files.find(f => f.previewElement === li);
                    if (match) newOrder.push(match);
                });
                if (newOrder.length === myDropzone.files.length) {
                    myDropzone.files = newOrder;
                }
                updatePreviewOrderBadges();
            }
        });
    }

    document.getElementById('mergeForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (myDropzone.files.length === 0) {
            alert('Please add at least one image.');
            return;
        }

        const loader = document.getElementById('loader');
        loader.style.display = 'flex';

        const formData = new FormData();
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        formData.append('mode', document.querySelector('select[name="mode"]').value);
        formData.append('district_id', document.getElementById('district_id').value);
        myDropzone.files.forEach(file => formData.append('images[]', file));

        try {
            const response = await fetch(window.routes.processImage, {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json' }
            });

            loader.style.display = 'none';
            const text = await response.text();
            let data;
            try { data = JSON.parse(text); }
            catch (err) {
                alert('Unexpected server response. See console (F12).');
                console.error(text.substring(0, 1000));
                return;
            }

            if (data.image) {
                document.getElementById('modalImage').src = data.image;
                document.getElementById('modalImage').dataset.filePath = data.file_path;
                document.getElementById('previewName').textContent = computePreviewName();
                new bootstrap.Offcanvas(document.getElementById('resultModal')).show();
            } else {
                alert(data.message || 'Processing failed.');
            }
        } catch (err) {
            loader.style.display = 'none';
            alert('Network error. Please try again.');
            console.error(err);
        }
    });

    function todayCode() {
        const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        const d = new Date();
        const dd = String(d.getDate()).padStart(2, '0');
        const mon = months[d.getMonth()];
        const yy = String(d.getFullYear()).slice(-2);
        return `${dd}${mon}${yy}`;
    }

    function computePreviewName() {
        const sel = document.getElementById('district_id');
        const opt = sel.options[sel.selectedIndex];
        const shortcode = opt ? opt.dataset.shortcode : '';
        if (!shortcode) return '—';
        // Suffix (_1, _2...) is decided by the server at save time; this is a preview only.
        return `POTHYS_${shortcode}_${todayCode()}_1`;
    }

    document.getElementById('modalDownload').addEventListener('click', function () {
        const a = document.createElement('a');
        a.href = document.getElementById('modalImage').src;
        const name = document.getElementById('previewName').textContent;
        a.download = (name && name !== '—' ? name : 'merged-image') + '.jpeg';
        a.click();
    });

    document.getElementById('saveBtn').addEventListener('click', async function () {
        document.getElementById('img_error').textContent = '';

        const filePath   = document.getElementById('modalImage').dataset.filePath;
        const districtId = document.getElementById('district_id').value;
        if (!districtId) { alert('Please select a district before saving.'); return; }

        try {
            const response = await fetch(window.routes.saveImage, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ file_path: filePath, district_id: districtId })
            });
            const data = await response.json();
            if (data.status === 'success') {
                bootstrap.Offcanvas.getInstance(document.getElementById('resultModal')).hide();
                location.reload();
            } else {
                document.getElementById('img_error').textContent = data.message || 'Failed to create short URL.';
            }
        } catch (err) {
            alert('Error saving. Please try again.');
            console.error(err);
        }
    });
};


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
</script>

</x-app-layout>