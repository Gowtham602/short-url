<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 8px;
        }

        th {
            background: #f2f2f2;
        }

        h2,
        p {
            text-align: center;
            margin: 5px;
        }

        tfoot td {
            font-weight: bold;
        }
    </style>

</head>

<body>

    <h2>REPORT</h2>

    <p>
    <strong>Branch :</strong> {{ $branch->branch_name }}
</p>
    <p>
        From : {{ request('from_date') }}
        &nbsp;&nbsp;&nbsp;
        To : {{ request('to_date') }}
    </p>

    <table>

        <thead>

            <tr>
                <th>#</th>
                <th>Branch</th>
                <th>Date</th>
                <th>Message</th>
                <th>Submit</th>
                <th>Credit</th>
            </tr>

        </thead>

        <tbody>

            @foreach($records as $row)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $row->branch->branch_name }}</td>

                <!-- <td>{{ $row->date->format('d-m-Y') }}</td> -->
                 <td>
                    {{ \Carbon\Carbon::parse($row->date)->format('d-m-Y') }}<br>
                    {{ $row->created_at->format('h:i A') }}
                </td>

                <!-- <td>{{ $row->message }}</td> -->
                 <td>
                    {!! nl2br(e($row->message)) !!}
                </td>

                <td>{{ number_format($row->submit_count) }}</td>

                <td>{{ number_format($row->credit) }}</td>

            </tr>

            @endforeach

        </tbody>

        <tfoot>

            <tr>

                <td colspan="4" align="right">
                    TOTAL
                </td>

                <td>{{ number_format($totalSubmit) }}</td>

                <td>{{ number_format($totalCredit) }}</td>

            </tr>

        </tfoot>

    </table>

</body>

</html>