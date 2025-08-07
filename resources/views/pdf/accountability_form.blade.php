
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ICT Device/Equipment Accountability Form</title>
    <style>
            @page {
            margin: 40px;
            size: A4 portrait;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0px;
            right: 0px;
            height: 70px;
            font-size: 10px;
            line-height: 15px;
            text-align: center;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            page-break-inside: avoid;
            table-layout: auto; /* allows flexible column widths */
        }

        td, th {
            border: 1px solid black;
            padding: 6px;
            vertical-align: top;
            height: auto;
            word-break: break-word; /* allow breaking long serials */
        }

        .no-border {
            border: none;
        }

        .signature {
            border-top: solid black 1px;    
            text-align: center;
        }

        .name {
            text-align: center;
            font-weight: bold;
        }

        .section-break {
            page-break-before: always;
        }
        .tableSerial {
            text-align: center

        }
    </style>
</head>
<body>

<header>
<img src="{{ public_path('storage/upitdc_images/logo-2.png') }}" alt="Logo" style="height: 80px;">
<h3><strong>UNIVERSITY OF THE PHILIPPINES</strong> </h3>
<hr style="border: 1px solid black; margin: 0;">

<table>
       <tr>
        <td style="border: none">  <h4 style="margin: 0;">OFFICE OF THE VICE PRESIDENT FOR DIGITAL TRANSFORMATION</h4></td>
        <td style="border: none">  <img src="{{ public_path('storage/upitdc_images/OIP.jfif') }}" alt="UPITDC-LOGO" style="height: 100px;"></td>
    </tr>
</table>
  


</header>
<footer>
    2/F Vidal A. Tan Hall, Quirino Ave. cor. Velasquez St.<br>
    University of the Philippines, Diliman, Quezon City<br>
    Tel: (+63) 028 376 3100, (+63) 028 920 2080 | Telefax: (+63) 02 920 2036 | Website: itdc.up.edu.ph

</footer>
<main>
  

<h2>ICT Device/Equipment Accountability Form</h2>

<table>
       <tr>
        <td><strong>Reference Number:</strong> {{ $form->reference_number }}</td>
        <td><strong>Date:</strong> {{ \Carbon\Carbon::parse($form->created_date)->toFormattedDateString() }}</td>
    </tr>
</table>
 
<table>
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
            <th style="width: 10%;">Quantity</th>
            <th style="width: 35%;">Description</th>
            <th style="width: 35%;">Model/Brand</th>
            <th style="width: 20%;">Serial Number</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td style="text-align: center; word-break: break-word;">{{ $item->quantity }}</td>
                <td style="text-align: center; word-break: break-word;">{{ $item->name }}</td>
                <td style="text-align: center; word-break: break-word;">{{ $item->model_brand }}</td>
                <td style="text-align: center; word-break: break-word;">
                    {!! str_replace(',', '<br>', e($item->serial_number)) !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<table>
        <tr>
            <th style="width: 20%;">Remarks:</th>
            <th style="width: 80%;"></th>
        </tr>
</table>

<p style="font-size: 9px">
    This is to acknowledge that I am accountable for the above items. I understand that I will pay or replace the
    same unit in case of loss or damage due to my fault or negligence. In case of resignation, separation or
    transfer, I will return the item/s before issuance of any clearance.
</p>

<table style="border:none">
    <tr>
        <td style="border: none">Received By:<br><br><br>
            <div class="signature" > Signature over Printed Name </div>
            <br>Received Date: <br> <br> <br>
              <hr style="border-top: 1px black; margin: 0;">
        </td>
          
         <td style="border: none">Prepared and Issued By:<br><br>
            <div class="name">{{ auth()->user()->name ?? 'Signature over Printed Name' }}</div>
            <div class="signature">Signature over Printed Name </div>
            <br>Issuance Approved By:<br><br>
            <div class="name">Jason R. Balais</div>
            <div class="signature">Signature over Printed Name </div>
            <br><br></td>
    </tr>
</table>

<p><strong>This portion is to be accomplished by ITDC personnel.</strong></p>

<table>
    <tr>
        <td>Returned Date:
            @if($returnedAt)
            <strong>{{ \Carbon\Carbon::parse($returnedAt)->format('F j, Y h:i A') }}</strong>
            @else
                <strong >Not Returned</strong>
            @endif
        </td>
          <td>Returned to:</td>
     
    </tr>
    <tr>
         
        <td >Equipment Status: <strong>{{ ucfirst($status) }}</strong></td>
        <td>Signature:</td>
    </tr>
</table>

{{-- 
<script>
    if (isset($pdf)){

            $x = 502;
            $y = 780;
            $text = {PAGE_NUM}/{PAGE_COUNT};
            $font = $fontMetrics->getFont('DejaVu Sans', 'normal');
            $size = 10;
            $pdf->page_text($x, $y, $text, $font, $size,);
    }
</script> --}}
</main>

</body>


</html>
