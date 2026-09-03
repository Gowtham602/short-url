    <x-app-layout>

        <x-slot name="title">
            SMS Credit
        </x-slot>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">
                                    Reports Management
                                </h4>

                                <div class="page-title-right">
    <ol class="breadcrumb m-0">
        <!-- <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
                Dashboard
            </a>
        </li>

        <li class="breadcrumb-item">
            <a href="{{ route('sms.index') }}">
                SMS Credit
            </a>
        </li> -->

        <li class="breadcrumb-item active">
          
            <a href="{{ route('sms.report') }}">
                 Report
            </a>

        </li>
    </ol>
</div>
                            </div>
                        </div>
                    </div>

                    <!-- =========================
                            ENTRY FORM
                    ========================== -->

                    <div class="row">

                        <div class="col-lg-12">

                            <div class="card">

                                <div class="card-header">

                                    <div class="d-flex justify-content-between align-items-center">

                                        <h4 class="card-title mb-0">
                                            SMS Credit Entry 1
                                        </h4>

                                        <button
                                            type="button"
                                            id="addRow"
                                            class="btn btn-success btn-sm">

                                            <i class="ri-add-line"></i>

                                            Add Row

                                        </button>

                                    </div>

                                </div>

                                <div class="card-body">

                                    <form id="smsForm">

                                        @csrf

                                        <div class="table-responsive">

                                            <table
                                                class="table table-bordered align-middle"
                                                id="entryTable">

                                                <thead class="table-light">

                                                    <tr>

                                                        <th width="20%">
                                                            Branch
                                                        </th>

                                                        <th width="15%">
                                                            Date
                                                        </th>

                                                        <th>
                                                            Message
                                                        </th>

                                                        <th width="10%">
                                                            Submit Count
                                                        </th>

                                                        <th width="10%">
                                                            Credit
                                                        </th>

                                                        <th width="8%">
                                                            Action
                                                        </th>

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    <tr>

                                                        <!-- Branch -->

                                                        <td>

                                                            <select
                                                                name="rows[0][branch_id]"
                                                                class="form-select"
                                                                required>

                                                                <option value="">
                                                                    Select Branch
                                                                </option>

                                                                @foreach($branches as $branch)

                                                                    <option value="{{ $branch->id }}">

                                                                        {{ $branch->branch_name }}

                                                                    </option>

                                                                @endforeach

                                                            </select>

                                                        </td>

                                                        <!-- Date -->

                                                        <td>

                                                            <input
                                                                type="date"
                                                                name="rows[0][date]"
                                                                class="form-control"
                                                                value="{{ date('Y-m-d') }}"
                                                                required>

                                                        </td>

                                                        <!-- Message -->

                                                        <td>

                                                            <textarea
                                                                name="rows[0][message]"
                                                                rows="2"
                                                                class="form-control"
                                                                placeholder="Enter SMS Message"
                                                                required></textarea>

                                                        </td>

                                                        <!-- Submit Count -->

                                                        <td>

                                                            <input
                                                                type="number"
                                                                name="rows[0][submit_count]"
                                                                class="form-control"
                                                                min="0"
                                                                placeholder="0"
                                                                required>

                                                        </td>

                                                        <!-- Credit -->

                                                        <td>

                                                            <input
                                                                type="number"
                                                                name="rows[0][credit]"
                                                                class="form-control"
                                                                min="0"
                                                                placeholder="0"
                                                                required>

                                                        </td>

                                                        <!-- Remove -->

                                                        <td class="text-center">

                                                            <button
                                                                type="button"
                                                                class="btn btn-danger btn-sm removeRow">

                                                                <i class="ri-delete-bin-line"></i>

                                                            </button>

                                                        </td>

                                                    </tr>

                                                </tbody>

                                            </table>

                                        </div>

                                        <div class="text-end mt-3">

                                            <button
                                                type="reset"
                                                class="btn btn-secondary">

                                                <i class="ri-refresh-line"></i>

                                                Reset

                                            </button>

                                            <button
                                                type="submit"
                                                class="btn btn-primary">

                                                <i class="ri-save-line"></i>

                                                Save SMS Credit

                                            </button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- =========================
                            DATATABLE
                    ========================== -->
    
                    <div class="row mt-4">

                        <div class="col-lg-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title mb-0">

                                        SMS Credit List

                                    </h4>

                                </div>

                                <div class="card-body">

                                    <div class="table-responsive">

                                        <table
                                            id="smsTable"
                                            class="table table-bordered table-striped align-middle w-100">

                                            <thead class="table-light">

                                                <tr>

                                                    <th width="5%">
                                                        #
                                                    </th>

                                                    <th>
                                                        Branch
                                                    </th>

                                                    <th width="12%">
                                                        Date
                                                    </th>

                                                    <th>
                                                        Message
                                                    </th>

                                                    <th width="10%">
                                                        Submit
                                                    </th>

                                                    <th width="10%">
                                                        Credit
                                                    </th>

                                                    <!-- <th width="10%">
                                                        Action
                                                    </th> -->

                                                </tr>

                                            </thead>

                                            <tbody>

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
    <!-- ==========================================
            Validation Alert
    =========================================== -->

    <div id="validationErrors" class="alert alert-danger d-none mt-3">
        <ul class="mb-0" id="errorList"></ul>
    </div>


    <!-- ==========================================
            EDIT SMS CREDIT MODAL
    =========================================== -->

    <div class="modal fade"
        id="editModal"
        tabindex="-1"
        aria-labelledby="editModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <!-- Modal Header -->

                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title" id="editModalLabel">

                        <i class="ri-edit-line"></i>

                        Edit SMS Credit

                    </h5>

                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <!-- Form -->

                <form id="editForm">

                    @csrf

                    <input
                        type="hidden"
                        id="edit_id"
                        name="id">

                    <div class="modal-body">

                        <div class="row">

                            <!-- Branch -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Branch

                                    <span class="text-danger">*</span>

                                </label>

                                <select
                                    class="form-select"
                                    id="edit_branch_id"
                                    name="branch_id"
                                    required>

                                    <option value="">

                                        Select Branch

                                    </option>

                                    @foreach($branches as $branch)

                                        <option value="{{ $branch->id }}">

                                            {{ $branch->branch_name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            <!-- Date -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Date

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="edit_date"
                                    name="date"
                                    required>

                            </div>

                        </div>

                        <div class="row">

                            <!-- Message -->

                            <div class="col-md-12 mb-3">

                                <label class="form-label">

                                    Message

                                    <span class="text-danger">*</span>

                                </label>

                                <textarea
                                    class="form-control"
                                    id="edit_message"
                                    name="message"
                                    rows="4"
                                    required></textarea>

                            </div>

                        </div>

                        <div class="row">

                            <!-- Submit Count -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Submit Count

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    id="edit_submit_count"
                                    name="submit_count"
                                    required>

                            </div>

                            <!-- Credit -->

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Credit

                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    id="edit_credit"
                                    name="credit"
                                    required>

                            </div>

                        </div>

                        <!-- Validation -->

                        <div id="editValidationErrors"
                            class="alert alert-danger d-none">

                            <ul class="mb-0"
                                id="editErrorList">
                            </ul>

                        </div>

                    </div>

                    <!-- Footer -->

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                            <i class="ri-close-line"></i>

                            Close

                        </button>

                        <button
                            type="submit"
                            id="updateBtn"
                            class="btn btn-primary">

                            <i class="ri-save-line"></i>

                            Update SMS Credit

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
    @push('scripts')

    <script>
    $(document).ready(function () {

        let rowIndex = 1;

        /*=========================================
            Dynamic Row Template
        =========================================*/
        function createRow(index) {

            return `
            <tr>

                <td>
                    <select
                        name="rows[${index}][branch_id]"
                        class="form-select"
                        required>

                        <option value="">Select Branch</option>

                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">
                                {{ $branch->branch_name }}
                            </option>
                        @endforeach

                    </select>
                </td>

                <td>
                    <input
                        type="date"
                        name="rows[${index}][date]"
                        class="form-control"
                        value="{{ date('Y-m-d') }}"
                        required>
                </td>

                <td>
                    <textarea
                        name="rows[${index}][message]"
                        class="form-control"
                        rows="2"
                        placeholder="Enter SMS Message"
                        required></textarea>
                </td>

                <td>
                    <input
                        type="number"
                        name="rows[${index}][submit_count]"
                        class="form-control"
                        min="0"
                        placeholder="0"
                        required>
                </td>

                <td>
                    <input
                        type="number"
                        name="rows[${index}][credit]"
                        class="form-control"
                        min="0"
                        placeholder="0"
                        required>
                </td>

                <td class="text-center">

                    <button
                        type="button"
                        class="btn btn-danger btn-sm removeRow">

                        <i class="ri-delete-bin-line"></i>

                    </button>

                </td>

            </tr>
            `;
        }

        /*=========================================
            Add Row
        =========================================*/
        $("#addRow").click(function () {

            $("#entryTable tbody").append(createRow(rowIndex));

            rowIndex++;

        });

        /*=========================================
            Remove Row
        =========================================*/
        $(document).on("click", ".removeRow", function () {

            if ($("#entryTable tbody tr").length == 1) {

                Swal.fire({
                    icon: "warning",
                    title: "Warning",
                    text: "At least one row is required."
                });

                return;
            }

            $(this).closest("tr").remove();

        });

        /*=========================================
            Reset Form Helper
        =========================================*/
        function resetForm() {

            $("#smsForm")[0].reset();

            $("#entryTable tbody").html(createRow(0));

            rowIndex = 1;

        }

        /*=========================================
            jQuery Validation
        =========================================*/
        $("#smsForm").validate({

            submitHandler: function (form) {

                $.ajax({

                    url: "{{ route('sms.store') }}",

                    type: "POST",

                    data: $(form).serialize(),

                    success: function (response) {

                        Swal.fire({

                            icon: "success",

                            title: "Success",

                            text: response.message,

                            timer: 2000,

                            showConfirmButton: false

                        });

                        resetForm();

                        table.ajax.reload(null, false);

                    },

                    error: function (xhr) {

                        let message = "Something went wrong.";

                        if (xhr.responseJSON && xhr.responseJSON.message) {

                            message = xhr.responseJSON.message;

                        }

                        Swal.fire({

                            icon: "error",

                            title: "Error",

                            text: message

                        });

                    }

                });

            }

        });

        /*=========================================
            DataTable
        =========================================*/
        let table = $("#smsTable").DataTable({

            processing: true,

            serverSide: true,

            ajax: "{{ route('sms.list') }}",

            columns: [

                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    searchable: false,
                    orderable: false
                },

                {
                    data: "branch",
                    name: "branch"
                },

                {
                    data: "date",
                    name: "date"
                },

                {
                    data: "message",
                    name: "message"
                },

                {
                    data: "submit_count",
                    name: "submit_count"
                },

                {
                    data: "credit",
                    name: "credit"
                },

                // {
                //     data: "action",
                //     name: "action",
                //     searchable: false,
                //     orderable: false
                // }

            ]

        });


            /*========================================
            =
            jQuery Validation
        =========================================*/

    
        /*=========================================
            Reload DataTable Helper
        =========================================*/

        function reloadTable()
        {

            table.ajax.reload(null, false);

        }

    });



    </script>

    @endpush

    </x-app-layout>