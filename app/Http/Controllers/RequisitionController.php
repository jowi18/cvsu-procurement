<?php

namespace App\Http\Controllers;
use App\Models\Item;
use App\Models\PurchaseRequestDetails;
use App\Models\PurchaseRequestHeader;
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
        return view('users.create-requisition', compact(['title', 'secondtitle', 'thirdtitle', 'items']));
    }

    public function getItemList(){
        $items = Item::get();
        return $items;
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
           
            $header_data = PurchaseRequestHeader::create([
                'pr_code' => $req_code,
                'created_by' => auth()->user()->id,
                'department_id' => auth()->user()->department,
                'status' => 1,
                'purpose' => $request->purpose,

            ]);

            foreach($itemRequests as $item){
                $details_data = PurchaseRequestDetails::create([
                    'pr_hdr_id' => $header_data->id,
                    'item_id' => $item['itemId'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }
            
            return response()->json(['message' => 'Purchase Added Successfully'], 200);
            
        }catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }
    }

  
}

