<?php

namespace App\Http\Controllers;

use App\Models\PmppDetails;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\ItemCategory;
use App\Models\Item;
use App\Models\ManageLogs;
use App\Models\PmppHeader;
use App\Models\Department;
use App\Models\PmppCategories;
use App\Models\Notifications;
use App\Models\Uom;

class PmppController extends Controller
{
    public function index(){
        $title = "Create PPMP";
        $secondtitle = "Create PPMP";
        $thirdtitle = "Request";
        $category = $this->getItemCategory();
        $item = $this->getItemList();
        $uom = $this->getUom();
        $department = $this->getDepartmentList();
        $year = $this->getPmppYear();
        $pmpp_category = $this->getCategoryList();

        return view('users.create-pmpp', compact([
            'title', 
            'secondtitle', 
            'thirdtitle', 
            'category', 
            'item', 
            'uom', 
            'department', 
            'year',
            'pmpp_category'
        ]));
    }

    public function getItemCategory(){
        $data = ItemCategory::all();

        return $data;
    }

    public function getItemList(){
        $data = Item::all();

        return $data;
    }

    public function getUom(){
        $data = Uom::all();

        return $data;
    }

    public function getDepartmentList(){
        $data = Department::all();

        return $data;
    }

    public function getPmppYear(){
        $data = PmppHeader::distinct()->pluck('year')->toArray();

        return $data;
        // dd($data);
    }

    public function getCategoryList(){
        $data = PmppCategories::get();

        return $data;
    }

    public function addPmpp(Request $request){
        try{
            $validatedData = $request->validate([
                'project' => 'required',
                'year' => 'required|unique:pmpp_hdr,year,except,id',
            ]);
            $currentYear = date('Y');
            $data = PmppHeader::create([
                'project' => $request->project,
                'prepared_by' => auth()->user()->id,
                // 'fund_source' => $request->fund,
                'budget' => $request->budget,
                'year' => $request->year,
                'status' => 1,
                'description' => $request->remark,
                'main_category' => $request->main_category,
                'sub_category_a' => $request->sub_category_a,
                'sub_category_b' => $request->sub_category_b,
                'sub_category_c' => $request->sub_category_c,
                'uacs_code' => '50203010000',
                'code' => 'C1'
            ]);

            $userid = auth()->user()->id;
            $idArray = array(3, 29, 21, $userid);
            foreach($idArray as $item){
                $notif = Notifications::create([
                    'transact_by' => auth()->user()->id,
                    'belong_to' => $item,
                    'department' => auth()->user()->department,
                    'title' => "Purchase Request",
                    'message_to_creator' => "You Successfully  Create ".$data->year ." PPMP ",
                    'message_to_others' => ucwords(auth()->user()->firstname.' '.auth()->user()->lastname." Created ".$data->year." PPMP")
                ]);
            }
          
            return response()->json(['message' => 'Pmpp Created successfully'], 200);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }

    }

    public function getPmppList(){
        $response = [];
        //dean
        if(auth()->user()->position_dtls->user_level == 1){
            $data = PmppHeader::whereNull('deleted_at')->orderBy('created_at', 'desc')->get();
        }else if(auth()->user()->position_dtls->user_level == 4){ 
            $data = PmppHeader::whereNull('deleted_at')->whereNotNull('forwarded_by')->orderBy('created_at', 'desc')->get();
        }else if(auth()->user()->position_dtls->user_level == 0){
            $data = PmppHeader::whereNull('deleted_at')->whereNotNull('reviewed_by')->orderBy('created_at', 'desc')->get();
        }else if(auth()->user()->position_dtls->user_level == 2){
            $data = PmppHeader::whereNull('deleted_at')->orderBy('created_at', 'desc')->get();
        }

        
        foreach($data as $key=>$value){
            $buttons = "";
            $status = "";
            switch($value->status){
                case 1:
                    if(auth()->user()->id == $value->prepared_by){
                        $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        <button type="button" class="btn btn-warning d-flex align-items-center btn-sm px-3 add-item-btn-class" data-id="'.$value->id.'"><i class="fa fa-plus"></i></button>
                        </div>';
                    }else{
                        $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        <button type="button" class="btn btn-primary d-flex align-items-center btn-sm px-3" id="forward-btn" data-id="'.$value->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve Request"><i class="fa fa-forward"></i></button> 
                        <button type="button" class="btn btn-danger d-flex align-values-center btn-sm px-3" id="rejected-btn" data-id="'.$value->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reject Request"><i class="fa fa-ban"></i></button>
                        </div>';
                    }
                    $status = '<span class="badge bg-warning">Pending</span>';
                    break;
                case 2:
                    if(auth()->user()->position_dtls->user_level == 4 && empty($value->reviewed_by)){
                        $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        <button type="button" class="btn btn-primary d-flex align-items-center btn-sm px-3" id="review-btn" data-id="'.$value->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve Request"><i class="fa fa-check-square"></i></button> 
                        <button type="button" class="btn btn-danger d-flex align-values-center btn-sm px-3" id="rejected-btn" data-id="'.$value->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reject Request"><i class="fa fa-ban"></i></button>
                        </div>';
                    }else if(auth()->user()->position_dtls->user_level == 0){
                        $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        <button type="button" class="btn btn-success d-flex align-items-center btn-sm px-3" id="approved-btn" data-id="'.$value->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve Request"><i class="fa fa-thumbs-up"></i></button> 
                        <button type="button" class="btn btn-danger d-flex align-values-center btn-sm px-3" id="rejected-btn" data-id="'.$value->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reject Request"><i class="fa fa-ban"></i></button>
                        </div>';
                    }else{
                        $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                        <button type="button" disabled class="btn btn-primary d-flex align-items-center btn-sm px-3" id="review-btn" data-id="'.$value->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve Request"><i class="fa fa-check-square"></i></button> 
                        <button type="button" disabled class="btn btn-danger d-flex align-values-center btn-sm px-3" id="rejected-btn" data-id="'.$value->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reject Request"><i class="fa fa-ban"></i></button>
                        </div>';
                    }
        
                    $status = '<span class="badge bg-info">Waiting for Approval of the President</span>';
                    break;
                case 3:
                    $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <button type="button" disabled class="btn btn-warning d-flex align-items-center btn-sm px-3 add-item-btn-class" data-id="'.$value->id.'"><i class="fa fa-plus"></i></button>
                    </div>';
                    $status = '<span class="badge bg-success">Approved</span>';
                    break;
                default: 
                    $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <button type="button" disabled class="btn btn-warning d-flex align-items-center btn-sm px-3 add-item-btn-class" data-id="'.$value->id.'"><i class="fa fa-plus"></i></button>
                    </div>';
                    $status = '<span class="badge bg-danger">Rejected</span>';
                    break;
            }
            $response[] = array(
                'no' => ++$key,
                'prepared_by' => $value->prepared_by_dtls->firstname.' '.$value->prepared_by_dtls->lastname,
                // 'department' => $value->department_dtls->department,
                'project' => $value->project,
                // 'fund' => $value->fund_dtls->fund_source,
                'budget' => $value->budget,
                'year' => $value->year,
                'created_at' => date('M d, Y', strtotime($value->created_at)),
                'description' => $value->description,
                'status' => $value->status_dtls->status,
                'status_badge' => $status,
                'action' => $buttons
            );
        }
        return response()->json($response, 200);
        // dd($response);
    }

    public function addPmppItem(Request $request, $id){
        try{

            $validatedData = $request->validate([
                'item' => 'required',
                'quantity' => 'required',
            ]);

            $data = PmppDetails::create([
                
                'pmpp_hdr_id' => $id,
                'item_category' => $request->category,
                'item_name' => $request->item,
                'unit_of_measurement' => $request->uom,
                'item_quantity' => $request->quantity,
                'item_description' => $request->item_description,
              
                
            ]);
            return response()->json(['message' => 'Item Submitted successfully'], 200);
        }catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }

    }

    public function viewPmppitem($id){
        $response = [];
        $data = PmppHeader::with('pmpp_dtls')->where('id', $id)->whereNull('deleted_at')->orderBy('created_at', 'desc')->get();
        $amount = 0;
        foreach($data as $value){
            foreach($value->pmpp_dtls as $key => $item){
                $amount = $item->item_name_dtls->item_price * $item->item_quantity;
                $response[] = array(
                    'no' => ++$key,
                    'prepared_by' => $value->prepared_by_dtls->firstname.' '.$value->prepared_by_dtls->lastname,
                    // 'department' => $value->department_dtls->department,
                    'project' => $value->project,
                    // 'fund' => $value->fund_dtls->fund_source,
                    'item_category' => $item->item_category_dtls->category,
                    'item_name' => $item->item_name_dtls->item,
                    'unit_of_measurement' => $item->unit_of_measurement_dtls->uom,
                    'item_quantity' => $item->item_quantity,    
                    'item_description' => $item->item_description,
                    'price' => $item->item_name_dtls->item_price,
                    'total' => $amount,
                    'action' =>  '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <button type="button" class="btn btn-danger d-flex align-items-center btn-sm px-3 remove-item"  data-id="'.$item->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve Request"><i class="fa fa-ban"></i></button> 
                    </div>'
                   
                    
                );
            }
        }
        return response()->json($response, 200);
        // dd($response);
    }

    public function approvedPmpp($id){
        $data = PmppHeader::where('id', $id)->update([
            'approved_by' => auth()->user()->id,
            'status' => 3
        ]);
        $log = ManageLogs::create([
            'user_id' => auth()->user()->id,
            'action' => 'Approved PMPP',
        ]);
        $year = PmppHeader::where('id', $id)->first();
        $userid = auth()->user()->id;
        $idArray = array($year->prepared_by, 3, 29, 21, $userid);
            foreach($idArray as $item){
                $notif = Notifications::create([
                    'transact_by' => auth()->user()->id,
                    'belong_to' => $item,
                    'department' => auth()->user()->department,
                    'title' => "Purchase Request",
                    'message_to_creator' => "You Successfully  Approved ".$year->year ." PPMP ",
                    'message_to_others' => ucwords(auth()->user()->firstname.' '.auth()->user()->lastname." Approved ".$year->year." PPMP")
                ]);
            }
        return response()->json(['message' => 'Pmpp Approved successfully'], 200);
    }

    public function rejectedPmpp($id){
        $data = PmppHeader::where('id', $id)->update([
            'approved_by' => auth()->user()->id,
            'status' => 4
        ]);
        $log = ManageLogs::create([
            'user_id' => auth()->user()->id,
            'action' => 'Rejected PMPP',
        ]);
        return response()->json(['message' => 'Pmpp Rejected successfully'], 200);
    }

    public function reviewedPmpp($id){
        $data = PmppHeader::where('id', $id)->update([
            'reviewed_by' => auth()->user()->id,
            'status' => 2
        ]);
        $log = ManageLogs::create([
            'user_id' => auth()->user()->id,
            'action' => 'Reviewed PMPP',
        ]);
        $year = PmppHeader::where('id', $id)->first();
        $userid = auth()->user()->id;
        $idArray = array($year->prepared_by, 3, 29, 21, $userid);
            foreach($idArray as $item){
                $notif = Notifications::create([
                    'transact_by' => auth()->user()->id,
                    'belong_to' => $item,
                    'department' => auth()->user()->department,
                    'title' => "Purchase Request",
                    'message_to_creator' => "You Successfully pass to the president the ".$year->year ." PPMP ",
                    'message_to_others' => ucwords(auth()->user()->firstname.' '.auth()->user()->lastname. " Passed " .$year->year." PPMP to the president")
                ]);
            }
        return response()->json(['message' => 'Pmpp Done Reviewing'], 200);
    }

    public function forwaredPmpp($id){
        $data = PmppHeader::where('id', $id)->update([
            'forwarded_by' => auth()->user()->id,
            'status' => 2
        ]);

        $year = PmppHeader::where('id', $id)->first();
        $log = ManageLogs::create([
            'user_id' => auth()->user()->id,
            'action' => 'Forward PMPP',
        ]);
        $userid = auth()->user()->id;
        $idArray = array($year->prepared_by, 3, 29, 21, $userid);
            foreach($idArray as $item){
                $notif = Notifications::create([
                    'transact_by' => auth()->user()->id,
                    'belong_to' => $item,
                    'department' => auth()->user()->department,
                    'title' => "Purchase Request",
                    'message_to_creator' => "You Successfully  Forwarded ".$year->year ." PPMP ",
                    'message_to_others' => ucwords(auth()->user()->firstname.' '.auth()->user()->lastname." Forwarded ".$year->year." PPMP")
                ]);
            }
        return response()->json(['message' => 'Pmpp Forwarded to review'], 200);
    }

    public function removeItem($id){
        $data = PmppDetails::where('id', $id)->delete();
        return response()->json(['message' => 'Item Removed successfully'], 200);
    }
}
