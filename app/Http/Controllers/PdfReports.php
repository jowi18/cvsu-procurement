<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PmppHeader;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class PdfReports extends Controller
{
    public function index($year){
        $data = [];
        $data_hdr = PmppHeader::with('pmpp_dtls')->where('year', $year)->first();
        $values = PmppHeader::with('pmpp_dtls')->where('year', $year)->get();
        
        foreach ($values as $value) {
            foreach ($value->pmpp_dtls as $key=>$item) {
                $data[] = [
                    
                    'no' => ++$key,
                    'item' => $item->item_name_dtls->item,
                    // 'fund' => $value->fund_dtls->fund_source,
                    // 'department' => $value->department_dtls->department,
                    'amount' => $item->item_name_dtls->item_price,
                    'project' => $value->project,
                    'uom' => $item->item_name_dtls->unit_of_measurement_dtls->uom,
                    'item_price' => $item->item_name_dtls->item_price,
                    'item_quantity' => $item->item_quantity,
                    'total_amount' => $item->item_quantity * $item->item_name_dtls->item_price,
                    'main_category' => strtoupper($value->main_category_dtls->category),
                    'sub_category_a' => strtoupper($value->sub_category_a_dtls->category),
                    'sub_category_b' => strtoupper($value->sub_category_b_dtls->category),
                    'sub_category_c' => strtoupper($value->sub_category_c_dtls->category),
                    'code' => strtoupper($value->code),
                    
                ];
            }
        }

        $items = [
            'year' => $data_hdr->year,
            'dean_signature' => (!empty($data_hdr->forwarded_by)) ? $data_hdr->forwarded_by_dtls->image_signature : '',
            'budget_signature' => (!empty($data_hdr->reviewed_by_dtls)) ? $data_hdr->reviewed_by_dtls->image_signature: '',
            'pres_signature' => (!empty($data_hdr->approved_by_dtls)) ? $data_hdr->approved_by_dtls->image_signature : '',
            'president' => (!empty($data_hdr->approved_by_dtls)) ? $data_hdr->approved_by_dtls->firstname.' '.$data_hdr->approved_by_dtls->lastname : '',
            'dean' => (!empty($data_hdr->forwarded_by)) ? $data_hdr->forwarded_by_dtls->firstname.' '.$data_hdr->forwarded_by_dtls->lastname : '',
            'budget' => (!empty($data_hdr->reviewed_by_dtls)) ? $data_hdr->reviewed_by_dtls->firstname.' '.$data_hdr->reviewed_by_dtls->lastname: '',
        ];

        $pdf = PDF::loadView('pdfreports.pmpp-annual-report', ['data' => $data, 'items' => $items])
        ->setPaper('a4', 'landscape');
        //   ->setPaper([0, 0, 842, 1170], 'landscape');

        return $pdf->stream('pmpp_annual_report.pdf');
    }


    // public function sendPdf($year) {

    //     $pdf = PDF::loadView('pdfreports.pmpp-annual-report', ['data' => $data])->setPaper('a4', 'landscape');
    //     $pdfContent = $pdf->output(); // Get PDF content as string
    
    //     Mail::send('users.email-notification', $data, function($message) use ($user_email, $pdfContent) {
    //         $message->to($user_email, 'cvsu')->subject('PDF REPORT');
    
    //         // Attach PDF to the email
    //         $message->attachData($pdfContent, 'pmpp_annual_report.pdf', [
    //             'mime' => 'application/pdf',
    //         ]);
    
    //         $message->from('angel.saraya18@gmail.com', 'cvsu');
    //     });
    
    //     return redirect()->back()->with('success', 'Email sent successfully with PDF attachment.');
    // }

  
}
