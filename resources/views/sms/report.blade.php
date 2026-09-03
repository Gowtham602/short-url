<x-app-layout>

    <x-slot name="title">
        SMS Credit Report
    </x-slot>

    <div class="main-content">

        <div class="page-content">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-12">

                        <!-- Filter Card -->
                        <div class="card">

                            <div class="card-header">

                                <h4 class="card-title mb-0">
                                    SMS Credit Report
                                </h4>

                            </div>

                            <div class="card-body">

                                <form id="reportForm">

                                    @csrf

                                    <div class="row">

                                        <!-- Branch -->
                                        <div class="col-md-4">

                                            <label class="form-label">
                                             Branch <span class="text-danger">*</span>
                                    </label>

                                    <select name="branch_id" class="form-select" required>
                                        <option value="">-- Select Branch --</option>

                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}">
                                                {{ $branch->branch_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <span class="text-danger small" id="branch_id_error"></span>
                                        </div>

                                        <!-- From -->
                                        <div class="col-md-3">

                                            <label class="form-label">
                                                From Date
                                            </label>

                                            <input type="date" name="from_date" class="form-control" required>
                                            <span class="text-danger small" id="from_date_error"></span>

                                        </div>

                                        <!-- To -->
                                        <div class="col-md-3">

                                            <label class="form-label">
                                                To Date
                                            </label>

                                            <input type="date" name="to_date" class="form-control" required>

                                            <span class="text-danger small" id="to_date_error"></span>
                                        </div>

                                        <!-- Button -->
                                        <div class="col-md-2 d-flex align-items-end">

                                            <button type="submit" class="btn btn-primary w-100">

                                                <i class="ri-search-line"></i>

                                                Generate

                                            </button>

                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                        <!-- Summary -->
                        <div class="card mt-3">

                            <div class="card-body">

                                <div class="row text-center">

                                    <div class="col-md-4">

                                        <h6>Total Messages</h6>

                                        <h3 id="totalMessages">
                                            0
                                        </h3>

                                    </div>

                                    <div class="col-md-4">

                                        <h6>Total Submit</h6>

                                        <h3 id="totalSubmit">
                                            0
                                        </h3>

                                    </div>

                                    <div class="col-md-4">

                                        <h6>Total Credit</h6>

                                        <h3 id="totalCredit">
                                            0
                                        </h3>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Report Table -->
                        <div class="card mt-3">

                            <div class="card-header d-flex justify-content-between">

                                <h5 class="mb-0">
                                    Report Result
                                </h5>

                                <div class="d-flex gap-2">



                                    <a href="#" id="pdfBtn" class="btn btn-danger">
                                        PDF
                                    </a>

                                    <a href="#" id="excelBtn" class="btn btn-success">
                                        Excel
                                    </a>

                                </div>

                            </div>

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table class="table table-bordered table-striped">

                                        <thead class="table-light">

                                            <tr>

                                                <th>#</th>

                                                <th>Branch</th>

                                                <th>Date</th>

                                                <th>Message</th>

                                                <th>Submit</th>

                                                <th>Credit</th>

                                            </tr>

                                        </thead>

                                        <tbody id="reportBody">

                                            <tr>

                                                <td colspan="6" class="text-center">

                                                    No Records

                                                </td>

                                            </tr>

                                        </tbody>

                                        <tfoot>

                                            <tr class="table-secondary fw-bold">

                                                <td colspan="4" class="text-end">

                                                    TOTAL

                                                </td>

                                                <td id="footerSubmit">
                                                    0
                                                </td>

                                                <td id="footerCredit">
                                                    0
                                                </td>

                                            </tr>

                                        </tfoot>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    @push('scripts')

        <script>

            const reportUrl = "{{ route('sms.report.data') }}";

            $('#reportForm').submit(function (e) {

                e.preventDefault();

                $.ajax({

                    url: reportUrl,

                    type: "POST",

                    data: $(this).serialize(),
                    beforeSend: function () {

                        $('.text-danger').html('');

                    },

                    success: function (res) {

                        let html = '';

                        let i = 1;

                        if (res.data.length == 0) {

                            html = `
                            <tr>
                                <td colspan="6" class="text-center">
                                    No Records Found
                                </td>
                            </tr>`;

                        } else {

                            $.each(res.data, function (index, row) {

                                html += `
                                <tr>

                                    <td>${i++}</td>

                                    <td>${row.branch.branch_name}</td>

                                  
                                    <td>
                                        ${row.date}<br>
                                        <small class="text-muted">${row.time}</small>
                                    </td>


                                    <td>${row.message.replace(/\n/g, '<br>')}</td>

                                    <td>${row.submit_count}</td>

                                    <td>${row.credit}</td>

                                </tr>`;
                            });

                        }

                        $('#reportBody').html(html);

                        $('#totalMessages').text(res.data.length);

                        $('#totalSubmit').text(res.submit);

                        $('#totalCredit').text(res.credit);

                        $('#footerSubmit').text(res.submit);

                        $('#footerCredit').text(res.credit);

                    },
                    error: function (xhr) {

                        $('.text-danger').html('');

                        if (xhr.status === 422) {

                            let errors = xhr.responseJSON.errors;

                            $.each(errors, function (key, value) {

                                $('#' + key + '_error').html(value[0]);

                            });

                        }

                    }

                });

            });

          

            $('#printBtn').click(function () {

                window.print();

            });



            $('#pdfBtn').click(function () {

                let data = $('#reportForm').serialize();

                window.open("{{ route('sms.report.pdf') }}?" + data);

            });

            $('#excelBtn').click(function () {

                let data = $('#reportForm').serialize();

                window.open("{{ route('sms.report.excel') }}?" + data);

            });

        </script>



    @endpush

</x-app-layout>