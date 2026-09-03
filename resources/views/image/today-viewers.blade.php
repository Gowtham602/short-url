<x-app-layout>

    <x-slot name="title">
        Today's Image Viewers
    </x-slot>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- Page Title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                            <h4 class="mb-sm-0">Today's Image Viewers</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        Today's Image Viewers
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    Today's View Details
                                </h5>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">

                                    <table id="example"
                                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                        style="width:100%">

                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>IP Address</th>
                                                <th>Browser</th>
                                                <th>Device</th>
                                                <th>City</th>
                                                <th>Country</th>
                                                <th>Date & Time</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse($todayClicks as $click)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ optional($click->image)->image_name ?? '-' }}</td>
                                                    <td>{{ $click->ip_address }}</td>
                                                    <td>{{ $click->browser }}</td>
                                                    <td>{{ $click->device_type }}</td>
                                                    <td>{{ $click->city ?? '-' }}</td>
                                                    <td>{{ $click->country ?? '-' }}</td>
                                                    <td>{{ $click->created_at->format('d M Y h:i A') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">
                                                        No views found today.
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

        <!-- @include('layouts.footer') -->
    </div>

    <script>
        $(function () {
            $('#example').DataTable({
                responsive: true,
                pageLength: 10,
                ordering: true,
                searching: true,
                lengthChange: true,
                autoWidth: false
            });
        });
    </script>

</x-app-layout>