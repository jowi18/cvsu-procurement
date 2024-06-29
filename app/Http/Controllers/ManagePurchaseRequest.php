<?php

namespace App\Http\Controllers;
use App\Models\PurchaseRequestHeader;
use App\Models\PurchaseRequestDetails;
use App\Models\User;
use App\Models\Item;
use App\Models\ManageLogs;
use App\Models\Notifications;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Models\OtpModel;
use Illuminate\Validation\ValidationException;

use App\Models\ReasonModel;
use Illuminate\Http\Request;

class ManagePurchaseRequest extends Controller
{
    public function index(){
        $title = "Manage Purchase Request";
        $secondtitle = "Requisition";
        $thirdtitle = "Manage Purchase Request";
        $items = $this->getItemList();
        return view('users.manage-purchase-request', compact(['title', 'secondtitle', 'thirdtitle', 'items']));
    }

    public function getRequestList(){
        $response = [];
        $user = User::all();
        if(auth()->user()->position_dtls->user_level == 2){
            $data = PurchaseRequestHeader::whereNull('deleted_at')->where('status', 2)->orWhere('status', 3)->orWhere('status', 4)->orderBy('created_at', 'desc')->get();
        }else if(auth()->user()->position_dtls->user_level == 1){
            $data = PurchaseRequestHeader::whereNull('deleted_at')->whereNotNull('supplies_approval')->orderBy('created_at', 'desc')->get();
        }else if(auth()->user()->position_dtls->user_level == 0){
            $data = PurchaseRequestHeader::whereNull('deleted_at')->whereNotNull('dean_approval')->orderBy('created_at', 'desc')->get();
        }else{
            $data = PurchaseRequestHeader::where('department_id', auth()->user()->department_dtls->id)->whereNull('deleted_at')->orderBy('created_at', 'desc')->get();
        }
        
        // $data = PurchaseRequestHeader::whereNull('deleted_at')->get();
        foreach($data as $key=>$item){
            $buttons = "";
            $status = "";
            switch($item->status){
                case 1:

                    if(auth()->user()->id != $item->created_by && auth()->user()->position_dtls->user_level != 2 && auth()->user()->position_dtls->user_level != 6){
                        $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        <button type="button" class="btn btn-info d-flex align-items-center btn-sm px-3" id="pdf-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fas fa-file-pdf"></i></button>
                        <button type="button" class="btn btn-warning d-flex align-items-center btn-sm px-3"  id="edit-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Edit Request"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-primary d-flex align-items-center btn-sm px-3"  id="forward-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Forward Request"><i class="fas fa-forward" ></i></button>
                        <button type="button" class="btn btn-danger d-flex align-items-center btn-sm px-3"  id="reject-request-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Reject Request"><i class="fa fa-ban" ></i></button>
                        </div>';
                        $status = '<span class="badge bg-warning">Pending</span>';
                    }else if(auth()->user()->position_dtls->user_level == 2){
                        $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        <button type="button" class="btn btn-info d-flex align-items-center btn-sm px-3" id="pdf-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fas fa-file-pdf"></i></button>
                        <button type="button" class="btn btn-warning d-flex align-items-center btn-sm px-3"  id="edit-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Edit Request"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-success d-flex align-items-center btn-sm px-3" id="approve-request-btn" data-item-id="'.$item->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve Request"><i class="fa fa-thumbs-up"></i></button> 
                        <button type="button" class="btn btn-danger d-flex align-items-center btn-sm px-3" id="reject-request-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Reject Request"><i class="fa fa-ban"></i></button>   
                        </div>';
                        $status = '<span class="badge bg-warning">Pending</span>';
                    }else{
                        $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        <button type="button" class="btn btn-info d-flex align-items-center btn-sm px-3" id="pdf-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fas fa-file-pdf"></i></button>
                        <button type="button" class="btn btn-primary d-flex align-items-center btn-sm px-3" id="follow-up-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fas fa-arrow-up"></i></button>

                        </div>';                        
                        $status = '<span class="badge bg-warning">Pending</span>';
                    }
                    break;
                case 2:
                    if(auth()->user()->position_dtls->user_level == 1 || auth()->user()->position_dtls->user_level == 2){
                        $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        <button type="button" class="btn btn-info d-flex align-items-center btn-sm px-3" id="pdf-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fas fa-file-pdf"></i></button>
                        <button type="button" class="btn btn-warning d-flex align-items-center btn-sm px-3"  id="edit-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Edit Request"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-success d-flex align-items-center btn-sm px-3" id="approve-request-btn" data-item-id="'.$item->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve Request"><i class="fa fa-thumbs-up"></i></button> 
                        <button type="button" class="btn btn-danger d-flex align-items-center btn-sm px-3" id="reject-request-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Reject Request"><i class="fa fa-ban"></i></button>   
                        </div>';
                        $status = '<span class="badge bg-primary">For Approval</span>';
    
                    }else{
                        $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        <button type="button" class="btn btn-info d-flex align-items-center btn-sm px-3" id="pdf-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fas fa-file-pdf"></i></button>
                        <button type="button" class="btn btn-warning d-flex align-items-center btn-sm px-3"  id="edit-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Edit Request"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-primary d-flex align-items-center btn-sm px-3" id="follow-up-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fas fa-arrow-up"></i></button>

                        </div>';
                        $status = '<span class="badge bg-primary">For Approval</span>';
                    }
                    break;
                case 3:
                    if(auth()->user()->position_dtls->user_level == 1){
                        if(empty($item->dean_approval)){
                            $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                            <button type="button" class="btn btn-info d-flex align-items-center btn-sm px-3" id="pdf-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fas fa-file-pdf"></i></button>
                            <button type="button" class="btn btn-success d-flex align-items-center btn-sm px-3" id="approve-request-btn" data-item-id="'.$item->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve Request"><i class="fa fa-thumbs-up"></i></button> 
                            <button type="button" class="btn btn-danger d-flex align-items-center btn-sm px-3" id="reject-request-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Reject Request"><i class="fa fa-ban"></i></button>   
                            </div>';
                            $status = '<span class="badge bg-success">Approved by ' . $item->supplies_approval_dtls->firstname.' '.$item->supplies_approval_dtls->lastname. ' </span>';
                        }else{
                            $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                            <button type="button" class="btn btn-info d-flex align-items-center btn-sm px-3" id="pdf-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fas fa-file-pdf"></i></button>
                            </div>';
                            $status = '<span class="badge bg-success">Approved by ' . $item->dean_approval_dtls->firstname.' '.$item->dean_approval_dtls->lastname. ' </span>';
                        }
                    }else if(auth()->user()->position_dtls->user_level == 0){
                            if(empty($item->president_approval)){
                                $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <button type="button" class="btn btn-info d-flex align-items-center btn-sm px-3" id="pdf-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fas fa-file-pdf"></i></button>
                                <button type="button" class="btn btn-success d-flex align-items-center btn-sm px-3" id="approve-request-btn" data-item-id="'.$item->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve Request"><i class="fa fa-thumbs-up"></i></button> 
                                <button type="button" class="btn btn-danger d-flex align-items-center btn-sm px-3" id="reject-request-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Reject Request"><i class="fa fa-ban"></i></button>   
                                </div>';
                                $status = '<span class="badge bg-success">Approved by ' . $item->dean_approval_dtls->firstname.' '.$item->dean_approval_dtls->lastname. ' </span>';
                            }else{
                                $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <button type="button" class="btn btn-info d-flex align-items-center btn-sm px-3" id="pdf-btn" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fas fa-file-pdf"></i></button>
                                </div>';
                                $status = '<span class="badge bg-success">Approved by ' . $item->president_approval_dtls->firstname.' '.$item->president_approval_dtls->lastname. ' </span>';
                            }
                    }else{
                        $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        <button type="button" class="btn btn-info d-flex align-items-center btn-sm px-3" id="pdf-btn" data-item-id="'.$item->id.'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View Request"><i class="fas fa-file-pdf"></i></button>
                        </div>';
                        if((empty($item->president_approval) && (!empty($item->dean_approval)))){
                            $status = '<span class="badge bg-success">Waiting for approval of the president</span>';
                        }else if(empty($item->dean_approval) && empty($item->president_approval)){
                            $status = '<span class="badge bg-success">Waiting for approval of the dean</span>';
                        }else{
                            $status = '<span class="badge bg-success">Approved by ' . $item->president_approval_dtls->firstname.' '.$item->president_approval_dtls->lastname. ' </span>';
                        }
                        
                    }
                    
                    break;
                default: 
                    $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <button type="button" class="btn btn-info d-flex align-items-center btn-sm px-3" id="pdf-btn"data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fas fa-file-pdf"></i></button>
                    <button type="button" class="btn btn-primary d-flex align-items-center btn-sm px-3" id="reason-modal" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fas fa-question-circle "></i></button>
                    </div>';
                    $status = '<span class="badge bg-danger">Rejected</span>';
                    break;
            }
            $response[] = array(
                'no' => ++$key,
                'pr_code' => $item->pr_code,
                'created_by' => ucwords($item->created_by_dtls->firstname.' '.$item->created_by_dtls->lastname).' '.'<span class="badge bg-warning">' .$item->created_by_dtls->position_dtls->position.'</span>',
                'department' => $item->department_dtls->department,
                'status' => $item->status_dtls->status,
                'status_badge' => $status,
                'date_created' => date('M d, Y', strtotime($item->created_at)),
                'action' => $buttons
            );
        }
        return response()->json($response, 200);
    }

    public function viewPurchaseRequest($id){
        $response = []; 
        $data = PurchaseRequestHeader::with('pr_dtls')->where('id', $id)->get();
        $get_id = PurchaseRequestHeader::where('id', $id)->first();
        $total = 0;
        foreach($data as $item){
            foreach($item->pr_dtls as $key=>$value){
               
                $response[] = array(
                    'no' => ++$key,
                    'item' => $value->item_dtls->item,
                    'item_id' => $value->item_id,
                    'quantity' => $value->quantity,
                    'price' => $value->price,
                    'total' => $value->quantity * $value->price,
                    'action' => '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <button type="button" class="btn btn-info d-flex align-items-center btn-sm px-3" id="update-request-btn" data-id="'.$value->id.'" data-item="'.$value->item_id.'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View Request"><i class="fas fa-save"></i></button>
                    <button type="button" class="btn btn-danger d-flex align-items-center btn-sm px-3" id="remove-request-btn" data-id="'.$value->id.'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View Request"><i class="fas fa-trash-alt"></i></button>
                    </div>'
                );
            }
        }
        $items = Item::all(); 
       
       
        return response()->json([
            'purchase_request' => $response,
            'items' => $items, // Uncomment this line if you want to send items list
        ], 200);
        
    }

    public function approveRequest($id, Request $request) {
        try{
            // $validatedData = $request->validate([
            //     'otp' => 'required',
            // ]);

            // $otp = $request->input('otp');
            // $otp_val = OtpModel::where('request_id', $id)->latest()->first();
            // $correctOtp = $otp_val->otp;
           
            // if ($otp !== $correctOtp) {
            //     $errors = ['errors' => ['The provided OTP is incorrect.']];
            //     throw ValidationException::withMessages($errors);
            // }
            $data = PurchaseRequestHeader::find($id);
            $data->status = 3;
            if(auth()->user()->position_dtls->user_level == 0){
                $data->president_approval = auth()->user()->id;
            }else if(auth()->user()->position_dtls->user_level == 1){
                $data->dean_approval = auth()->user()->id;
            }else{
                $data->supplies_approval = auth()->user()->id;
            }
            $data->save();
            $log = ManageLogs::create([
                'user_id' => auth()->user()->id,
                'action' => 'Approved Purchase Request '.$data->pr_code,
            ]);

            $userid = auth()->user()->id;
            $idArray = array($data->created_by, $userid);
            foreach($idArray as $item){
                $notif = Notifications::create([
                    'transact_by' => auth()->user()->id,    
                    'belong_to' => $item,
                    'department' => auth()->user()->department,
                    'title' => "Purchase Request",
                    'message_to_creator' => "You Successfully Approved Purchase Request ".$data->pr_code,
                    'message_to_others' => ucwords(auth()->user()->firstname.' '.auth()->user()->lastname." Approved Your Purchase Request")
                ]);
            }
            return response()->json($data, 200);
        }catch(ValidationException $e){
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }
    }

    public function rejectRequest($id, Request $request){
        try{
            $validatedData = $request->validate([
                'reason' => 'required',
            ]);
        
            $data = PurchaseRequestHeader::find($id);
            $data->status = 4;
            $data->save();
            $log = ManageLogs::create([
                'user_id' => auth()->user()->id,
                'action' => 'Rejected Purchase Request '.$data->pr_code,
            ]);

            $reason = ReasonModel::create([
                'reason' => $request->reason,
                'request_id' => $id,
                'user_id' => auth()->user()->id
            ]);

            $userid = auth()->user()->id;
            $idArray = array($data->created_by, $userid);
            foreach($idArray as $item){
                $notif = Notifications::create([
                    'transact_by' => auth()->user()->id,
                    'belong_to' => $item,
                    'department' => auth()->user()->department,
                    'title' => "Purchase Request",
                    'message_to_creator' => "You Successfully Rejected Purchase Request ".$data->pr_code,
                    'message_to_others' => ucwords(auth()->user()->firstname.' '.auth()->user()->lastname." Rejected Your Purchase Request")
                ]);
            }
            return response()->json($data, 200);
        }catch(ValidationException $e){
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }
    }

    public function forwardRequest($id){
        $data = PurchaseRequestHeader::find($id);
        $data->status = 2;
        $data->save();
        $log = ManageLogs::create([
            'user_id' => auth()->user()->id,
            'action' => 'Forwarded Purchase Request '.$data->pr_code,
        ]);

            $userid = auth()->user()->id;
            $idArray = array($data->created_by, $userid);
            foreach($idArray as $item){
                $notif = Notifications::create([
                    'transact_by' => auth()->user()->id,    
                    'belong_to' => $item,
                    'department' => auth()->user()->department,
                    'title' => "Purchase Request",
                    'message_to_creator' => "You Successfully Forward Purchase Request ".$data->pr_code,
                    'message_to_others' => ucwords(auth()->user()->firstname.' '.auth()->user()->lastname." Forward Your Purchase Request")
                ]);
            }
        return response()->json($data, 200);
    }

    public function getItemList(){
        $data = Item::whereNull('deleted_at')->get();
        return $data;
    }

    public function updateRequest($item_id, Request $request){
        try{
            $data  = Item::where('id', $request->itemid)->first();
            $item_name = $data->item;
            $price = $data->item_price;
            $uom = $data->unit_of_measurement_dtls->unit_of_measurement;
            $data = PurchaseRequestDetails::where('id' ,$request->id)->update([
                'item_id' => $request->itemid,
                'price' => $price,
                'quantity' => $request->quantity,
            ]);

            $log = ManageLogs::create([
                'user_id' => auth()->user()->id,
                'action' => 'Update Purchase Request',
            ]);
            return response()->json(['message' => 'Item Updated successfully'], 200);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }
    }

    public function removeRequest($id){
        $data = PurchaseRequestDetails::find($id);
        $data->delete();
        return response()->json(['message' => 'Item Deleted successfully'], 200);
    }

    public function addNewItem($id, Request $request){
        try{
            $validatedData = $request->validate([
                'item' => [
                    'required',
                    Rule::unique('purchase_request_dtls', 'item_id')
                        ->where(function ($query) use ($id) {
                            return $query->where('pr_hdr_id', $id)
                                ->whereNull('deleted_at');
                    })
                ]
            ]);

            $data  = Item::where('id', $request->item)->first();
            $price = $data->item_price;

            $data = PurchaseRequestDetails::create([
                'pr_hdr_id' => $id,
                'item_id' => $request->item,
                'quantity' => $request->quantity,
                'price' => $price,

            ]);
            return response()->json(['message' => 'Item Added successfully'], 200);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }
    }

    public function viewRejection($id){
        $data = ReasonModel::where('request_id', $id)->first();

        return response()->json($data, 200);
    }

    public function generateOtp($id){
        $randomNumber = random_int(100000, 999999);
        $data = OtpModel::create([
            'user_id' => auth()->user()->id,
            'otp' => $randomNumber,
            'request_id' => $id,
        ]);
        $user_email = auth()->user()->email;
        $data = [
            'subject'=>'Below is your OTP',
            'body' => $randomNumber
        ];
        Mail::send('users.email-notification', $data, function($message) use ($user_email){
            $message->to($user_email, 'cvsu')->subject
            ('ONE TIME PASSWORD');
            $message->from('angel.saraya18@gmail.com','cvsu');
        });
        return response()->json(['message' => 'The OTP has been send to your registered email'], 200);
    }

    public function followUpRequest($id){
        $data = PurchaseRequestHeader::find($id);
        $userid = auth()->user()->id;
        $idArray = array($data->for_approval, $userid);
        foreach($idArray as $item){
            $notif = Notifications::create([
                'transact_by' => $userid,    
                'belong_to' => $item,
                'department' => auth()->user()->department,
                'title' => "Purchase Request",
                'message_to_creator' => "You Successfully Follow Up your Purchase Request ".$data->pr_code,
                'message_to_others' => ucwords(auth()->user()->firstname.' '.auth()->user()->lastname." Follow up Purchase Request ".$data->pr_code)
            ]);
        }
        return response()->json(['message' => 'Purchase Request follow up successfully'], 200);
    }
}
