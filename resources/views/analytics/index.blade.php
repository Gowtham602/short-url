<!-- <x-app-layout>

    <x-slot name="title">
        SMS Credit
    </x-slot>
    

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Entry Form --}}
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">SMS Credit Entry 2</h4>
                            </div>

                            <div class="card-body">

                                <form id="smsForm">
                                    @csrf

                                    <table class="table table-bordered" id="entryTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="20%">Branch</th>
                                                <th width="15%">Date</th>
                                                <th>Message</th>
                                                <th width="10%">Submit</th>
                                                <th width="10%">Credit</th>
                                                <th width="8%">
                                                    <button type="button"
                                                        class="btn btn-success btn-sm"
                                                        id="addRow">
                                                        +
                                                    </button>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <tr>

                                                <td>
                                                    <select name="rows[0][branch_id]"
                                                        class="form-select" required>

                                                        <option value="">Select Branch</option>

                                                        @foreach ($branches as $branch)
                                                            <option value="{{ $branch->id }}">
                                                                {{ $branch->branch_name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </td>

                                                <td>
                                                    <input type="date"
                                                        class="form-control"
                                                        name="rows[0][date]"
                                                        value="{{ date('Y-m-d') }}"
                                                        required>
                                                </td>

                                                <td>
                                                    <textarea
                                                        name="rows[0][message]"
                                                        class="form-control"
                                                        rows="2"
                                                        required></textarea>
                                                </td>

                                                <td>
                                                    <input type="number"
                                                        class="form-control"
                                                        name="rows[0][submit_count]"
                                                        required>
                                                </td>

                                                <td>
                                                    <input type="number"
                                                        class="form-control"
                                                        name="rows[0][credit]"
                                                        required>
                                                </td>

                                                <td class="text-center">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm removeRow">
                                                        -
                                                    </button>
                                                </td>

                                            </tr>

                                        </tbody>

                                    </table>

                                    <button type="submit"
                                        class="btn btn-primary">
                                        Save
                                    </button>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>

                {{-- List --}}
                <div class="row mt-4">
                    <div class="col-lg-12">

                        <div class="card">

                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                    SMS Credit List
                                </h4>
                            </div>

                            <div class="card-body">

                                <table class="table table-bordered" id="smsTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Branch</th>
                                            <th>Date</th>
                                            <th>Message</th>
                                            <th>Submit</th>
                                            <th>Credit</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')

    <script>

        $(function () {

            let row = 1;

            //--------------------------------------------------
            // Generate New Row
            //--------------------------------------------------

            function newRow(index)
            {
                return `

                <tr>

                    <td>

                        <select name="rows[${index}][branch_id]"
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

                        <input type="date"
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
                            required></textarea>

                    </td>

                    <td>

                        <input type="number"
                            name="rows[${index}][submit_count]"
                            class="form-control"
                            required>

                    </td>

                    <td>

                        <input type="number"
                            name="rows[${index}][credit]"
                            class="form-control"
                            required>

                    </td>

                    <td class="text-center">

                        <button
                            type="button"
                            class="btn btn-danger btn-sm removeRow">
                            -
                        </button>

                    </td>

                </tr>

                `;
            }

            //--------------------------------------------------
            // Add Row
            //--------------------------------------------------

            $("#addRow").on("click", function () {

                $("#entryTable tbody").append(newRow(row));

                row++;

            });

            //--------------------------------------------------
            // Remove Row
            //--------------------------------------------------

            $(document).on("click", ".removeRow", function () {

                if ($("#entryTable tbody tr").length > 1) {

                    $(this).closest("tr").remove();

                }

            });

            //--------------------------------------------------
            // Form Validation
            //--------------------------------------------------

            $("#smsForm").validate({

                submitHandler: function (form) {

                    $.ajax({

                        url: "{{ route('sms.store') }}",

                        type: "POST",

                        data: $(form).serialize(),

                        success: function (response) {

                            // toastr.success(response.message);

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });


                            form.reset();

                            $("#entryTable tbody").html(newRow(0));

                            row = 1;

                            table.ajax.reload(null, false);

                        },

                        error: function () {

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong!'
                            });

                        }

                    });

                }

            });

            //--------------------------------------------------
            // DataTable
            //--------------------------------------------------

            let table = $("#smsTable").DataTable({

                processing: true,

                serverSide: true,

                ajax: "{{ route('sms.list') }}",

                columns: [

                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        orderable: false,
                        searchable: false
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

                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false
                    }

                ]

            });

        });

    </script>

    @endpush

</x-app-layout> -->