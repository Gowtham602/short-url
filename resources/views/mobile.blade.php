<x-app-layout>
<x-slot name="title">Data Analytics</x-slot>

    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                            <h4 class="mb-sm-0">Image Viewers</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Image Viewers</li>
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
                                <h5 class="card-title mb-0">Image Viewers32</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
												<th>Image Name</th>
												<th>IP</th>
												<th>Browser</th>
												<th>Device</th>
                                                <th>city</th>
												<th>Country</th>
												<th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($imageClicks as $click)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $click->image_name }}</td>
												<td>{{ $click->ip_address }}</td>
												<td>{{ $click->browser }}</td>
												<td>{{ $click->device_type }}</td>
                                                <td>{{ $click->city ?? 'Unknown' }}</td>
												<td>{{ $click->country ?? 'Unknown' }}</td>
												<td>{{ $click->created_at }}</td>
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

    

</x-app-layout>