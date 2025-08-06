<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Released Equipment for Staff</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
        }

        .content {
            margin-top: 20px;
            margin-bottom: 50px;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            page-break-inside: auto;
            margin-top: 20px
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        td, th {
            border: 1px solid black;
            padding: 6px;
            vertical-align: top;
            text-align: center;
        }

        .no-border {
            border: none;
        }

        h2, h3, h4 {
            margin: 0;
            padding: 0;
        }

        .header-table td {
            border: none;
            vertical-align: middle;
        }

        .pagenum:before {
            content: counter(page);
        }

        .total-pages:before {
            content: counter(pages);
        }

        .meta-table td {
            border: 1px solid black;
        }
    </style>
</head>
<body>


<header>
<img src="{{ public_path('storage/upitdc_images/logo-2.png') }}" alt="Logo" style="height: 80px;">
<h3><strong>UNIVERSITY OF THE PHILIPPINES</strong> </h3>
<hr style="border: 1px solid black; margin: 0;">

<table style="margin: 0">
       <tr>
        <td style="border: none">  <h4 style="margin: 0;">OFFICE OF THE VICE PRESIDENT FOR DIGITAL TRANSFORMATION</h4></td>
        <td style="border: none">  <img src="{{ public_path('storage/upitdc_images/OIP.jfif') }}" alt="UPITDC-LOGO" style="height: 100px;"></td>
    </tr>
</table>

</header>

<div class="content">
    <h2>Summary of ICT Devices/Equipments Released</h2>

    <table class="meta-table">
        <tr>
            <td><strong>Name:</strong> {{ $staff->name }}</td>
            <td><strong>System Office:</strong> {{ $staff->system_office }}</td>
        </tr>
        <tr>
            <td><strong>Designation:</strong> {{ $staff->designation }}</td>
            <td><strong>Department/Office:</strong> {{ $staff->department }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Reference #</th>
                <th>Date Released</th>
                <th>Quantity</th>
                <th>Description</th>
                <th>Model/Brand</th>
                <th>Serial Number</th>
                <th>Status</th>
                <th>Returned At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($staff->applications as $application)
                @foreach ($application->equipments as $equipment)
                    <tr>
                        <td>{{ $application->reference_number }}</td>
                        <td>{{ \Carbon\Carbon::parse($application->application_date)->format('F d, Y') }}</td>
                        <td>{{ $equipment->quantity }}</td>
                        <td>{{ $equipment->name }}</td>
                        <td>{{ $equipment->model_brand ?? '-' }}</td>
                        <td>{{ $equipment->serial_number ?? '-' }}</td>
                        <td>{{ ucfirst($application->status) ?? '-' }}</td>
                        <td>
                            @if ($application->returned_at)
                                {{ \Carbon\Carbon::parse($application->returned_at)->format('F d, Y') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 15px;">
        This summary lists all devices released to the staff based on submitted accountability forms.
    </p>
</div>

<footer>
    <div style="margin-top: 5px;">
        2/F Vidal A. Tan Hall, Quirino Ave. cor. Velasquez St., University of the Philippines, Diliman, Quezon City<br>
        Tel: (+63) 028 376 3100, (+63) 028 920 2080 | Telefax: (+63) 02 920 2036 | Website: itdc.up.edu.ph
    </div>

</footer>

</body>
</html>
