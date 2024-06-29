<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <style type="text/css">
        .tg  {border-collapse:collapse;border-spacing:0;}
        .tg td{border-color:black;border-style:solid;border-width:2px;font-family:Arial, sans-serif;font-size:14px;
          overflow:hidden;padding:10px 5px;word-break:normal;}
        .tg th{border-color:black;border-style:solid;border-width:2px;font-family:Arial, sans-serif;font-size:14px;font-weight:bold !important;
          font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
        .tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
        .tg .tg-0lax{text-align:left;vertical-align:top}
        tr.borderless th{
            border: none; /* Remove border */
        }
        .head_text{
          font-weight: bold;
          background-color: green;
        }
    </style>
</head>
<body>
    
  {{-- <div class="row">
    <div class="col" style="display: flex; align-items: center; justify-content: center; text-align: center;">
        <div>
            <img src="{{ public_path('storage/user_images/cvsu-icon1.png') }}" alt="User Image" style="width: 100px; height: 100px; display: block; margin: 0 auto;">
            <div style="text-align: center;">
                <h1 style="margin: 0;">Cavite State University</h1>
                <h2 style="margin: 0;">Imus City</h2>
                <p style="margin: 0;">Annual Procurement Plan - Calendar Year 2024</p>
            </div>
        </div>
    </div>
</div> --}}


    
{{-- <table class="tg">
    <thead>
      <tr class="borderless">
        <th class="tg-0pky" colspan="3" style="text-align: right"><img src="{{ public_path('storage/user_images/cvsu-icon1.png') }}" alt="User Image" style="width: 100px; height: 100px;"></th>
        <th class="tg-0pky" colspan="3" style="text-align: left;padding: 4px;"><br>
            <span class="cvsu" style="font-weight: bold; font-size: 17px">CAVITE STATE UNIVERSITY - IMUS </span> <br>
            <span style="font-size: 11px; margin-left: 20px">Cavite Civic Center, Palico IV, Imus City, Cavite</span> <br>
            <span style="font-size: 10px;margin-left: 7" >Contact. Admin: (046) 471-6607. Registrar: (046) 436-6584</span>

        </th>
      </tr>
      <tr class="borderless">
        <th class="tg-0pky" colspan="7" style="text-align: center;font-size: 21px;">Annual Procurement Plan - Calendar Year 2024</th>
      </tr>
    <tr>
      <tr style="font-weight: bold">
        <th class="tg-0pky">CODE (PAP)</th>
        <th class="tg-0pky">Procurement Program/Project</th>
        <th class="tg-0pky">PMO/End-User</th>
        <th class="tg-0pky">Mode of Procurement</th>
        <th class="tg-0pky">Source of Funds</th>
        <th class="tg-0pky">Total</th>
        <th class="tg-0pky">Remarks</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="tg-0lax" colspan="7"></td>
      </tr>
        @foreach ($data as $item)
        <tr>
            <td class="tg-0lax"></td>
            <td class="tg-0lax">{{ $item['project'] }}</td>
            <td class="tg-0lax">{{ $item['department'] }}</td>
            <td class="tg-0lax">shopping</td>
            <td class="tg-0lax">{{ $item['fund'] }}</td>
            <td class="tg-0lax">{{ $item['amount'] }}</td>
            <td class="tg-0lax"> Wide-Angle Airflow, Efficient Compressor, World's No. 1 Air Treatment Brand, Prime Guard</td>
        </tr>
        @endforeach
        <tr>
          <td class="tg-0lax" colspan="7"></td>
        </tr>
        <tr>
          <td class="tg-0lax"></td>
          <td class="tg-0lax"></td>
          <td class="tg-0lax"></td>
          <td class="tg-0lax"></td>
          <td class="tg-0lax">TOTAL</td>
          <td class="tg-0lax">
            @php
              $total = 0;
              foreach ($data as $item){
                $total += $item['amount'];
              }
              echo $total;
            @endphp
          </td>
          <td class="tg-0lax"></td>
      </tr>
      
    </tbody>
</table> --}}

<table class="tg">
  <thead>
  <tr class="borderless">
    <th class="tg-0pky" colspan="2" style="text-align: right"><img src="{{ public_path('storage/user_images/cvsu-icon1.png') }}" alt="User Image" style="width: 100px; height: 100px;"></th>
    <th class="tg-0pky" colspan="4" style="text-align: left;padding: 4px;"><br>
        <span class="cvsu" style="font-weight: bold; font-size: 17px">CAVITE STATE UNIVERSITY - IMUS </span> <br>
        <span style="font-size: 11px; margin-left: 20px">Cavite Civic Center, Palico IV, Imus City, Cavite</span> <br>
        <span style="font-size: 10px;margin-left: 7" >Contact. Admin: (046) 471-6607. Registrar: (046) 436-6584</span>

    </th>
  </tr>
  <tr class="borderless">
    <th class="tg-0pky" colspan="6" style="text-align: center;font-size: 21px;">{{ $items['year'] }} PROJECT PROCUREMENT MANAGEMENT_PLAN (PPMP)</th>
  </tr>
  <tr>
    <th class="tg-0pky">UNIT</th>
    <th class="tg-0lax" colspan="4">IMUS CAMPUS</th>
    <th class="tg-0pky" colspan="2">SOURCE OF INCOME</th>
    <th class="tg-0lax">164</th>
  </tr>

<tr class="head_text"> 
  <td class="tg-0pky" rowspan="2">UACS</td>
  <td class="tg-0pky" rowspan="2">GENERAL DESRIPTION</td>
  <td class="tg-0pky" rowspan="2">CODE</td>
  <td class="tg-0pky" rowspan="2">TOTAL AMOUNT</td>
  <td class="tg-0pky" colspan="4">SCHEDULE/MILESTONE OF ACTIVITIES</td>
</tr>
<tr class="head_text">
  <td class="tg-0lax">Q1</td>
  <td class="tg-0lax">Q2</td>
  <td class="tg-0lax">Q3</td>
  <td class="tg-0lax">Q4</td>
</tr>
</thead>
<tbody>
  @foreach ($data as $key=>$item)
  <tr>
    <td class="tg-0lax">50203010000</td>
    <td class="tg-0lax">{{ $item['item'] }}</td>
    <td class="tg-0lax">{{ $item['code'] }}</td>
    <td class="tg-0lax">{{ $item['item_price'] }}</td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
    <td class="tg-0lax"></td>
  </tr>
  @endforeach

</tbody>
 
</table>
<table class="tg">
  <thead>
  <tr >
    <td class="tg-0lax" colspan="8" style="border: none">Prepared and submitted by</td>
    <td class="tg-0lax" colspan="8" style="border: none">Reviewed By</td>
    <td class="tg-0lax" colspan="8" style="border: none">Approved By</td>
  </tr>
  </thead>
  <tbody>
  <tr>
    <th class="tg-0lax" colspan="8" style="border: none"><img src="{{ asset('signatures/'.$items['dean_signature']) }}"  style="width: 150px; height: 60px;"></th>
    <th class="tg-0lax" colspan="8" style="border: none"><img src="{{ asset('signatures/'.$items['budget_signature']) }}"  style="width: 150px; height: 60px;"></th>
    <th class="tg-0lax" colspan="8" style="border: none"><img src="{{ asset('signatures/'.$items['pres_signature']) }}"  style="width: 150px; height: 60px;"></th>
  </tr>
  <tr>
    <td class="tg-0lax" colspan="8" style="border: none">{{ $items['dean'] }}</td>
    <td class="tg-0lax" colspan="8" style="border: none">{{ $items['budget'] }}</td>
    <td class="tg-0lax" colspan="8" style="border: none"> {{ $items['president'] }}</td>
  </tr>
  </tbody>
</table>

        
</body>
</html>


