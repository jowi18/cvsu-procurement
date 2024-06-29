<?php

namespace App\Http\Controllers;
use App\Models\Notifications;
use App\Models\PurchaseRequestHeader;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PurchaseRequestReport extends Controller
{
    public function index($id){

        $data = [];
        $list = PurchaseRequestHeader::with('pr_dtls')->where('id', $id)->first();
        $values = PurchaseRequestHeader::with('pr_dtls')->where('id', $id)->get();
        foreach ($values as $value) {
            foreach ($value->pr_dtls as $item) {
                $data[] = [
                    'item' => $item->item_dtls->item,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->quantity * $item->price,
                    'unit' => $item->item_dtls->unit_of_measurement_dtls->uom,
                   
                ];
            }
        }

        if(auth()->user()->position_dtls->user_level == 2){
            $is_view = PurchaseRequestHeader::where('id', $id)->update([
                'is_view' => auth()->user()->id
            ]);
            $notif = Notifications::create([
                'belong_to' => $list->created_by,
                'transact_by' => $list->created_by,
                'department' => auth()->user()->department,
                'title' => "Purchase Request",
                'message_to_creator' => ucwords(auth()->user()->firstname.' '.auth()->user()->lastname." View Your Purchase Request"),
                'message_to_others' => ucwords(auth()->user()->firstname.' '.auth()->user()->lastname." View Your Purchase Request")
            ]);
            
        }

        $item = [
            'date' => date('M d, Y', strtotime($list->created_at)),
            'pr_code' => $list->pr_code,
            'purpose' => $list->purpose,
            'approver' => $list->for_approval_dtls->firstname.' '.$list->for_approval_dtls->lastname,
            'approver_department' => $list->for_approval_dtls->department_dtls->department,
            'requestor_name' => $list->created_by_dtls->firstname.' '.$list->created_by_dtls->lastname,
            'dean_name' => (!empty($list->dean_approval)) ? $list->dean_approval_dtls->firstname : '',
            'requestor_department' => $list->created_by_dtls->department_dtls->department,
            'requestor_signature' => $list->created_by_dtls->image_signature,
            'approver_signature' => $list->for_approval_dtls->image_signature,
            'request_status' => $list->status,
            'dean_signature' => (!empty($list->dean_approval)) ? $list->dean_approval_dtls->image_signature : ''
    
        ];

        $pdf = PDF::loadView('pdfreports.purchase-request-report', ['data' => $data, 'item' => $item])->setPaper('a4', 'portrait');
        return $pdf->stream('purchase_request_report.pdf');
    
    }
}
