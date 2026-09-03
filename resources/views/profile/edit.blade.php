<x-app-layout>
<x-slot name="title">Profile</x-slot>

    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                            <h4 class="mb-sm-0">Profile Information</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Profile Information</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                
				@include('profile.partials.update-profile-information-form')
				
				@include('profile.partials.update-password-form')
				
				@include('profile.partials.delete-user-form')
                

                

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