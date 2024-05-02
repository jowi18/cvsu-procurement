<?php

namespace App\Http\Controllers;

use App\Models\PmppDetails;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\ItemCategory;
use App\Models\Item;
use App\Models\PmppHeader;
use App\Models\Department;
use App\Models\Uom;

class PmppController extends Controller
{
    public function index(){
        $title = "Create PMPP";
        $secondtitle = "Create PMPP";
        $thirdtitle = "Request";
        $category = $this->getItemCategory();
        $item = $this->getItemList();
        $uom = $this->getUom();
        $department = $this->getDepartmentList();
        $year = $this->getPmppYear();

        return view('users.create-pmpp', compact(['title', 'secondtitle', 'thirdtitle', 'category', 'item', 'uom', 'department', 'year']));
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

    public function addPmpp(Request $request){
        try{
            $validatedData = $request->validate([
                'department' => 'required',
                'project' => 'required',
                'fund' => 'required',
            ]);
            $currentYear = date('Y');
            $data = PmppHeader::create([
                'project' => $request->project,
                'prepared_by' => auth()->user()->id,
                'department' => $request->department,
                'fund_source' => $request->fund,
                'budget' => $request->budget,
                'year' => $currentYear,
                'status' => 1,
                'description' => $request->remark
            ]);
          
            return response()->json(['message' => 'Pmpp Created successfully'], 200);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }

    }

    public function getPmppList(){
        $response = [];
        $data = PmppHeader::whereNull('deleted_at')->orderBy('created_at', 'desc')->get();
        
        foreach($data as $key=>$value){
            $buttons = "";
            $status = "";
            switch($value->status){
                case 1:
                    $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <button type="button" class="btn btn-warning d-flex align-items-center btn-sm px-3 add-item-btn-class" data-id="'.$value->id.'"><i class="fa fa-plus"></i></button>
                    <button type="button" class="btn btn-success d-flex align-items-center btn-sm px-3" id="approved-btn" data-id="'.$value->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve Request"><i class="fa fa-thumbs-up"></i></button> 
                    <button type="button" class="btn btn-danger d-flex align-values-center btn-sm px-3" id="rejected-btn" data-id="'.$value->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reject Request"><i class="fa fa-ban"></i></button>
                    <button type="button" class="btn btn-info d-flex align-values-center btn-sm px-3" id="forward-btn" data-id="'.$value->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reject Request"><i class="fa fa-share"></i></button>
                    </div>';
                    $status = '<span class="badge bg-warning">Pending</span>';
                    break;
                case 3:
                    $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <button type="button" class="btn btn-warning d-flex align-items-center btn-sm px-3 add-item-btn-class" data-id="'.$value->id.'"><i class="fa fa-plus"></i></button>
                    <button type="button" class="btn btn-info d-flex align-values-center btn-sm px-3" id="forward-btn" data-id="'.$value->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reject Request"><i class="fa fa-share"></i></button>
                    </div>';
                    $status = '<span class="badge bg-success">Approved</span>';
                    break;
                default: 
                    $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <button type="button" class="btn btn-warning d-flex align-items-center btn-sm px-3 add-item-btn-class" data-id="'.$value->id.'"><i class="fa fa-plus"></i></button>
                    <button type="button" class="btn btn-info d-flex align-values-center btn-sm px-3" id="forward-btn" data-id="'.$value->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reject Request"><i class="fa fa-share"></i></button>
                    </div>';
                    $status = '<span class="badge bg-danger">Rejected</span>';
                    break;
            }
            $response[] = array(
                'no' => ++$key,
                'prepared_by' => $value->prepared_by_dtls->firstname.' '.$value->prepared_by_dtls->lastname,
                'department' => $value->department_dtls->department,
                'project' => $value->project,
                'fund' => $value->fund_dtls->fund_source,
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
                'item_category' => 'required',
                'item_name' => 'required',
                'item_quantity' => 'required',
            ]);

            $data = PmppDetails::create([
                'pmpp_hdr_id' => $id,
                'item_category' => $request->item_category,
                'item_name' => $request->item_name,
                'unit_of_measurement' => $request->unit_of_measurement,
                'item_quantity' => $request->item_quantity,
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
                    'item_category' => $item->item_category_dtls->category,
                    'item_name' => $item->item_name_dtls->item,
                    'unit_of_measurement' => $item->unit_of_measurement_dtls->uom,
                    'item_quantity' => $item->item_quantity,    
                    'item_description' => $item->item_description,
                    'price' => $item->item_name_dtls->item_price,
                    'total' => $amount,
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

        return response()->json(['message' => 'Pmpp Approved successfully'], 200);
    }

    public function rejectedPmpp($id){
        $data = PmppHeader::where('id', $id)->update([
            'approved_by' => auth()->user()->id,
            'status' => 4
        ]);

        return response()->json(['message' => 'Pmpp Rejected successfully'], 200);
    }
}
