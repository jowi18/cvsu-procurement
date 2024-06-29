<?php

namespace App\Http\Controllers;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ManageLogs;
use App\Models\Notifications;
use App\Models\PurchaseRequestDetails;
use App\Models\PurchaseRequestHeader;
use App\Models\Uom;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
class RequisitionController extends Controller
{
    public function index(){
        $title = "Create Request";
        $secondtitle = "Purchase Request";
        $thirdtitle = "Create Request";
        $items = $this->getItemList();
        $uom = $this->getUom();
        $category = $this->getCategoryList();
        $approver_list = $this->approver_userlist();
        return view('users.create-requisition', compact(['title', 'secondtitle', 'thirdtitle', 'items', 'approver_list', 'uom', 'category']));
    }

    public function getItemList(){
        $items = Item::get();
        return $items;
    }

    public function approver_userlist(){
        $data = User::whereNull('deleted_at')->where('position', 2)->get();

        return $data;
    }

    public function getUom(){
        $data = Uom::all();

        return $data;
    }

    public function getCategoryList(){
        $data = ItemCategory::all();
        return $data;
    }


    public function insertPurchaseRequest(Request $request){
        try{
            $validatedData = $request->validate([
                'itemRequest' => 'required|array',
               
            ],
            [
                'itemRequest.required' => 'Purchase Request cannot be Empty.',
            ]);

            $latestCode = PurchaseRequestHeader::latest()->first();
         
            $req_code="";
            if ($latestCode) {
                $lastChar = substr($latestCode->pr_code, -1);
            
                $incrementedLastChar = intval($lastChar) + 1;
            
                $latestCode->pr_code = substr_replace($latestCode->pr_code, $incrementedLastChar, -1);
            
                $req_code =  $latestCode->pr_code;
            } else {
               $req_code = "PRS".''.date('Y').''."1"; 
            }

            $itemRequests = $request->input('itemRequest');

            if(auth()->user()->position_dtls->user_level == 5){
                $status = 2;
            }else if(auth()->user()->position_dtls->user_level == 1 || auth()->user()->position == 2){
                $status = 3;
                $approved_by = auth()->user()->id;
            }else{
                $status = 1;
            }
           
            $header_data = PurchaseRequestHeader::create([
                'pr_code' => $req_code,
                'created_by' => auth()->user()->id,
                'department_id' => auth()->user()->department,
                'status' => $status,
                'purpose' => $request->purpose,
                'created_at' => carbon::now('Asia/Manila'),
                'for_approval' =>(auth()->user()->position_dtls->user_level != 2) ? $request->approver_id : 2,
                'supplies_approval' => (auth()->user()->position_dtls->user_level == 2) ? $approved_by : null
            ]);
            
            foreach($itemRequests as $item){
                $details_data = PurchaseRequestDetails::create([
                    'pr_hdr_id' => $header_data->id,
                    'item_id' => $item['itemId'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }

            $log = ManageLogs::create([
                'user_id' => auth()->user()->id,
                'action' => 'Created Purchase Request '.$req_code,
            ]);
          
            $department_count = User::where('department', auth()->user()->department)->orWhere('position', 2)->get();
            foreach($department_count as $item){
                $notif = Notifications::create([
                    'transact_by' => auth()->user()->id,
                    'belong_to' => $item->id,
                    'department' => auth()->user()->department,
                    'title' => "Purchase Request",
                    'message_to_creator' => "You Successfully Created Purchase Request ".$req_code,
                    'message_to_others' => ucwords(auth()->user()->firstname.' '.auth()->user()->lastname." Created Purchase Request ".$req_code)
                ]);
            }
            
            return response()->json(['message' => 'Purchase Request Added Successfully'], 200);
            
        }catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }
    }


    public function addDepartmentItem(Request $request){
        try{
            $validatedData = $request->validate([
                'item' => [
                    'required',
                    Rule::unique('item')->where(function ($query) use ($request) {
                        return $query->where('deleted_at', null)
                                     ->where('department', auth()->user()->department);
                    }),
                ],
                'category' => 'required',
                'item_price' => 'required|integer',
                'unit_of_measurement' => 'required'
            ]);
            $data = Item::create([
                'department' => auth()->user()->department,
                'item' => $request->item,
                'category' => $request->category,
                'item_code' => 'ITMAB2024001',
                'item_price' => $request->item_price,
                'item_description' => $request->item_description,
                'unit_of_measurement' => $request->unit_of_measurement,
            ]);
            $log = ManageLogs::create([
                'user_id' => auth()->user()->id,
                'action' => 'Added New Item',
            ]);
            return response()->json(['message' => 'Item Added successfully'], 200);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }
    }
  
}

