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
        $item = [];
        $values = PmppHeader::with('pmpp_dtls')->where('year', $year)->get();

        foreach ($values as $value) {
            foreach ($value->pmpp_dtls as $item) {
                $data[] = [
                    
                    'item' => $item->item_name_dtls->item,
                    'fund' => $value->fund_dtls->fund_source,
                    'department' => $value->department_dtls->department,
                    'amount' => $item->item_name_dtls->item_price,
                    'project' => $value->project

                ];
            }
        }

        $pdf = PDF::loadView('pdfreports.pmpp-annual-report', ['data' => $data])->setPaper('a4', 'landscape');
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
