<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Released Equipment for Staff</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; margin: 40px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        td, th { border: 1px solid black; padding: 6px; vertical-align: top; }
        .no-border { border: none; }
        .signature{
            border-top: solid black 1px;
        }
    </style>
</head>
<body>

<h2>Summary of ICT Devices/Equipments Released</h2>

<table>
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
            <th>Equipment Name</th>
            <th>Description</th>
            <th>Model/Brand</th>
            <th>Serial Number</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($staff->applications as $application)
            @foreach ($application->equipments as $equipment)
                <tr>
                    <td style="text-align: center">{{ $application->reference_number }}</td>
                    <td style="text-align: center">
                        {{ \Carbon\Carbon::parse($application->application_date)->format('F d, Y') }}
                    </td>
                    <td style="text-align: center">{{ $equipment->quantity }}</td>
                    <td style="text-align: center">{{ $equipment->name }}</td>
                    <td style="text-align: center">{{ $equipment->description ?? '-' }}</td>
                    <td style="text-align: center">{{ $equipment->model_brand ?? '-' }}</td>
                    <td style="text-align: center">{{ $equipment->serial_number ?? '-' }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

<p>
    This summary lists all devices released to the staff based on submitted accountability forms.
</p>

<p style="font-size: 10px; margin-top: 30px;">
    2/F Vidal A. Tan Hall, Quirino Ave. cor. Velasquez St.<br>
    University of the Philippines, Diliman, Quezon City<br>
    Tel: (+63) 028 376 3100, (+63) 028 920 2080<br>
    Telefax: (+63) 02 920 2036<br>
    Website: itdc.up.edu.ph
</p>

</body>
</html>
