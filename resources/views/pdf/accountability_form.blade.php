
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ICT Device/Equipment Accountability Form</title>
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

<h2>ICT Device/Equipment Accountability Form</h2>

<table>
    <tr>
        <td><strong>Reference Number:</strong> {{ $form->reference_number }}</td>
        <td><strong>Date:</strong> {{ \Carbon\Carbon::parse($form->created_date)->toFormattedDateString() }}</td>
    </tr>
    <tr>
        <td><strong>Name:</strong> {{ $user->name }}</td>
        <td><strong>Campus:</strong> {{ $user->system_office }}</td>
    </tr>
    <tr>
        <td><strong>Designation:</strong> {{ $user->designation }}</td>
        <td><strong>Department/Office:</strong> {{ $user->department }}</td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th>Quantity</th>
            <th>Equipment Name</th>
            <th>Description</th>
            <th>Model/Brand</th>
            <th>Serial Number</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td style="text-align: center">{{ $item->quantity }}</td>
                <td style="text-align: center">{{ $item->name }}</td>
                <td style="text-align: center">{{ $item->description }}</td>
                <td style="text-align: center">{{ $item->model_brand }}</td>
                <td style="text-align: center">{{ $item->serial_number }}</td>       
            </tr>
        @endforeach
    </tbody>
</table>

<p>
    This is to acknowledge that I am accountable for the above items. I understand that I will pay or replace the
    same unit in case of loss or damage due to my fault or negligence. In case of resignation, separation or
    transfer, I will return the item/s before issuance of any clearance.
</p>

<table style="border:none">
    <tr>
        <td style="border: none">Received By:<br><br><br>
            <div class="signature" > Signature over Printed Name </div>
            <br>Received Date:</td>
         <td style="border: none">Prepared and Issued By:<br><br><br>
            <div class="signature">Signature over Printed Name </div>
            <br>Issuance Approved By:<br><br><br>
            <div class="signature">Signature over Printed Name </div>
            <br><br></td>
    </tr>
</table>

<p><strong>This portion is to be accomplished by ITDC personnel.</strong></p>

<table>
    <tr>
        <td>Returned Date:</td>
          <td>Returned to:</td>
     
    </tr>
    <tr>
         
             <td >Equipment Status:</td>
        <td>Signature:</td>
    </tr>
</table>

<p style="font-size: 10px; margin-top: 30px;">
    2/F Vidal A. Tan Hall, Quirino Ave. cor. Velasquez St.<br>
    University of the Philippines, Diliman, Quezon City<br>
    Tel: (+63) 028 376 3100, (+63) 028 920 2080<br>
    Telefax: (+63) 02 920 2036<br>
    Website: itdc.up.edu.ph
</p>

</body>
</html>
