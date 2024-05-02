<?php

namespace App\Http\Controllers;
use App\Models\PurchaseRequestHeader;
use App\Models\PurchaseRequestDetails;
use App\Models\Item;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
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
        $data = PurchaseRequestHeader::whereNull('deleted_at')->get();

        foreach($data as $key=>$item){
            $buttons = "";
            $status = "";
            switch($item->status){
                case 1:
                    $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <button type="button" class="btn btn-info d-flex align-items-center btn-sm px-3" id="pdf-btn" data-item-id="'.$item->id.'" ><i class="fas fa-file-pdf" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></i></button>
                    <button type="button" class="btn btn-warning d-flex align-items-center btn-sm px-3"  id="edit-btn" data-item-id="'.$item->id.'"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-success d-flex align-items-center btn-sm px-3" id="approve-request-btn" data-item-id="'.$item->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve Request"><i class="fa fa-thumbs-up"></i></button> 
                    <button type="button" class="btn btn-danger d-flex align-items-center btn-sm px-3" id="reject-request-btn" data-item-id="'.$item->id.' data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reject Request"><i class="fa fa-ban"></i></button>   
                    </div>';
                    $status = '<span class="badge bg-warning">Pending</span>';
                    break;
                case 3:
                    $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <button type="button" class="btn btn-info d-flex align-items-center btn-sm px-3" id="pdf-btn" data="'.$item->id.'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View Request"><i class="fas fa-file-pdf"></i></button>
                    <button type="button" class="btn btn-warning d-flex align-items-center btn-sm px-3"  id="edit-btn" data-item-id="'.$item->id.'"><i class="fas fa-edit"></i></button>

                    </div>';
                    $status = '<span class="badge bg-success">Approved</span>';
                    break;
                default: 
                    $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <button type="button" class="btn btn-info d-flex align-items-center btn-sm px-3" id="pdf-btn" data="'.$item->id.'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View Request"><i class="fas fa-file-pdf"></i></button>
                    <button type="button" class="btn btn-warning d-flex align-items-center btn-sm px-3"  id="edit-btn" data-item-id="'.$item->id.'"><i class="fas fa-edit"></i></button>

                    </div>';
                    $status = '<span class="badge bg-danger">Rejected</span>';
                    break;
            }
            $response[] = array(
                'no' => ++$key,
                'pr_code' => $item->pr_code,
                'created_by' => ucwords($item->created_by_dtls->firstname.' '.$item->created_by_dtls->lastname),
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
        //  dd($response);
    }

    public function approveRequest($id){ 
        $data = PurchaseRequestHeader::find($id);
        $data->status = 3;
        $data->save();
        return response()->json($data, 200);
    }

    public function rejectRequest($id){
        $data = PurchaseRequestHeader::find($id);
        $data->status = 4;
        $data->save();
        return response()->json($data, 200);
    }

    // public function getItemList(){
    //     $data = Item::all();
    //     return response()->json($data, 200);
    // }

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
}
