<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

<style type="text/css">
    .tg  {border-collapse:collapse;border-spacing:0;margin-top: 10px}
    .tg td{border-color:black;border-style:solid;border-width:2px;font-family:Arial, sans-serif;font-size:14px;
        overflow:hidden;padding:10px 5px;word-break:normal;}
    .tg th{border-color:black;border-style:solid;border-width:2px;font-family:Arial, sans-serif;font-size:14px;
        font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
    .tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top;font-weight: bold;}
    .tg .tg-0lax{text-align:left;vertical-align:top}
    tr.borderless th{
    border: none; /* Remove border */
}
.page-break {
        page-break-after: always;
    }
</style>
</head>
<body>
    {{-- <div class="row">
        <div class="col-lg-12" style="display: flex; justify-content: center; align-items: center; flex-direction: column; text-align: center;">
            <img src="{{ public_path('storage/user_images/cvsu-icon1.png') }}" alt="User Image" style="width: 100px; height: 100px;">
            <p style="margin: 0;">CAVITE STATE UNIVERSITY</p>
        </div>
    </div> --}}
  
    <table class="tg">
        <thead>
            <tr class="borderless">
                <th class="tg-0pky" colspan="2" style="text-align: right"><img src="{{ public_path('storage/user_images/cvsu-icon1.png') }}" alt="User Image" style="width: 100px; height: 100px;"></th>
                <th class="tg-0pky" colspan="4" style="text-align: left;padding: 4px;"><br>
                    <span class="cvsu" style="font-weight: bold; font-size: 20px">CAVITE STATE UNIVERSITY - IMUS CAMPUS </span> <br>
                    <span style="font-size: 14px; margin-left: 55px">Cavite Civic Center, Palico IV, Imus City, Cavite</span> <br>
                    <span style="font-size: 14px;margin-left: 26px" >Contact. Admin: (046) 471-6607. Registrar: (046) 436-6584</span>

                </th>
            </tr>
          <tr>
            <th class="tg-0pky" colspan="6" style="text-align: center; font-size: 21px">PURCHASE REQUEST</th>
          </tr>
          <tr>
            <th class="tg-0pky" colspan="4">Entity Name: CAVITE STATE UNIVERSITY</th>
            <th class="tg-0pky" colspan="2">Fund Cluster: </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="tg-0pky" colspan="2">Office Section</td>
            <td class="tg-0pky" colspan="2">PR No.: {{ $item['pr_code'] }}</td>
            <td class="tg-0pky" colspan="2">Date: {{ $item['date'] }}</td>
          </tr>
          <tr>
            <td class="tg-0pky" colspan="6">Responsibility Center Code</td>
          </tr>
          <tr>
            <td class="tg-0pky">Stock/Property No.</td>
            <td class="tg-0pky">Unit</td>
            <td class="tg-0pky">Item Description</td>
            <td class="tg-0pky">Quantity</td>
            <td class="tg-0pky">Unit Cost</td>
            <td class="tg-0pky">Total Cost</td>
          </tr>
        
          @foreach ($data as $items)
            <tr>
                <td class="tg-0lax">ITEM21323</td>
                <td class="tg-0lax">{{ $items['unit'] }}</td>
                <td class="tg-0lax">{{ $items['item'] }}</td>
                <td class="tg-0lax">{{ $items['quantity'] }}</td>
                <td class="tg-0lax">{{ $items['price'] }}</td>
                <td class="tg-0lax">{{ $items['total'] }}</td>
            </tr>
           
          @endforeach
          <tr>
            <td class="tg-0lax" colspan="6" style="text-align: right; font-weight: bold">TOTAL: 
                @php
                $total = 0;
                  foreach ($data as $value) {
                    $total += $value['total'];  
                  }
                  echo number_format($total, 2);
                @endphp
            </td>
          </tr>
          <tr class="borderless">
            <td class="tg-0lax" colspan="6">Purpose: {{ $item['purpose'] }}</td>
          </tr>
          <tr>
            <td class="tg-0pky" colspan="2" style="text-align: center">Requested By:</td>
            <td class="tg-0pky" colspan="2" style="text-align: center">Approved By:</td>
            <td class="tg-0pky" colspan="2"></td>
          </tr>
          <tr>
              {{-- <td class="tg-0pky" colspan="2" style="text-align: center"><img src="{{ asset('signatures/'.$item['requestor_signature']) }}" style="width: 150px; height: 60px;"></td>
              @if($item['request_status'] == 3)
                <td class="tg-0pky" colspan="2" style="text-align: center"><img src="{{ asset('signatures/'.$item['approver_signature']) }}" style="width: 150px; height: 60px;"></td>
              @else
                <td class="tg-0pky" colspan="2"></td>
              @endif
              <td class="tg-0pky" colspan="2" style="text-align: center"><img src="{{ asset('signatures/'.$item['dean_signature']) }}" style="width: 150px; height: 60px;"></td> --}}
              <td class="tg-0pky" colspan="2" style="text-align: center"></td>
              @if($item['request_status'] == 3)
                <td class="tg-0pky" colspan="2" style="text-align: center"></td>
              @else
                <td class="tg-0pky" colspan="2"></td>
              @endif
              <td class="tg-0pky" colspan="2" style="text-align: center"></td>

          
            </tr>
          <tr>
           
            <td class="tg-0pky" colspan="2" style="text-align: center">{{ $item['requestor_name'] }}</td>
            <td class="tg-0pky" colspan="2" style="font-weight: bold; text-align: center">{{ $item['approver'] }}</td>
            <td class="tg-0pky" colspan="2" style="text-align: center">{{ $item['dean_name'] }}</td>
          </tr>
          <tr>
           
            <td class="tg-0pky" colspan="2" style="text-align: center">{{ $item['requestor_department'] }}</td>
            <td class="tg-0pky" colspan="2" style="text-align: center">{{ $item['approver_department'] }}</td>
            <td class="tg-0pky" colspan="2" style="text-align: center">Deans Office</td>
          </tr>
        </tbody>
        </table>

    
</body>
</html>