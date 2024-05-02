<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequestHeader;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PurchaseRequestReport extends Controller
{
    public function index($id){

        $data = [];
        $list = PurchaseRequestHeader::with('pr_dtls')->where('id', $id)->first();
        $values = PurchaseRequestHeader::with('pr_dtls')->where('id', $id)->get();
        $counter = 0; 
        foreach ($values as $value) {
            foreach ($value->pr_dtls as $item) {
                $data[] = [
                    'item' => $item->item_dtls->item,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->quantity * $item->price,
                    'unit' => $item->item_dtls->unit_of_measurement_dtls->uom,
                ];
                $counter++;
                if ($counter % 10 == 0) {
                    $data[] = ['page_break' => true]; // Add a flag for page break
                }
            }
        }

        $item = [
            'date' => date('M d, Y', strtotime($list->created_at)),
            'pr_code' => $list->pr_code,
            'purpose' => $list->purpose,
        ]; 
        

        $pdf = PDF::loadView('pdfreports.purchase-request-report', ['data' => $data, 'item' => $item])->setPaper('a4', 'portrait');
        return $pdf->stream('purchase_request_report.pdf');
    
    }
}
