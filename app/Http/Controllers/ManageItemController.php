<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\PmppHeader;
use App\Models\Uom;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
class ManageItemController extends Controller
{
    public function index(){
        $title = "Item List";
        $secondtitle = "Manage Item";
        $thirdtitle = "Item List";
        $category = $this->getItemCategory();
        $uom = $this->getUomList();
        // $a = $this->getPmppYear();

        return view('users.manage-item', compact(['title', 'secondtitle', 'thirdtitle', 'category', 'uom']));
    }

    public function getItemCategory(){
        $data = ItemCategory::all();

        return $data;
    }

    public function getUomList(){
        $data = Uom::all();

        return $data;
    }

   

    public function addItem(Request $request){
        try{
            $validatedData = $request->validate([
                'item' => 'required|unique:item,item,NULL,id,deleted_at,NULL',
                'category' => 'required',
                'item_price' => 'required|integer',
               
                'unit_of_measurement' => 'required'
            ]);
            $data = Item::create([
                'item' => $request->item,
                'category' => $request->category,
                'item_code' => 'ITMAB2024001',
                'item_price' => $request->item_price,
                'item_description' => $request->item_description,
                'unit_of_measurement' => $request->unit_of_measurement,
    
            ]);
          
            return response()->json(['message' => 'Item Added successfully'], 200);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }

    }

    public function getItemList(){
        $response = [];
        $data = Item::whereNull('deleted_at')->get();
        foreach($data as $key=>$item){
            $response[] = [
                'no' => ++$key,
                'id' => $item->id,
                'item' =>  ucwords($item->item),
                'category' => $item->category_dtls->category,
                'item_code' => $item->item_code,
                'item_price' => $item->item_price,
                'uom' => ucwords($item->unit_of_measurement_dtls->uom),
                'action' => '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                <button type="button" class="btn btn-warning d-flex align-items-center btn-sm px-3" id="view-item-modal" data-id="'.$item->id.'"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger d-flex align-items-center btn-sm px-3" id="delete-item-btn" data-id="'.$item->id.'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve Request"><i class="fa fa-trash"></i></button> 
                </div>'
            ];
        }

        return response()->json($response, 200);

    }

    public function deleteItem($id){
        $data = Item::where('id', $id)->delete();

        return response()->json(['message' => 'Item Deleted successfully'], 200);
    }

    public function addCategory(Request $request){
        try{
            $validatedData = $request->validate([
                'category' => 'required|unique:item,category,NULL,id,deleted_at,NULL',
            ]);
            return response()->json(['message' => 'Item Category Added successfully'], 200);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }
    }

    public function viewItem($id){
        $data = Item::where('id', $id)->first();

        return response()->json($data, 200);
    }

    public function updateItem($id, Request $request){ 
        try{

            $validatedData = $request->validate([
                'update_item' => 'required|unique:item,item,' . $id . ',id,deleted_at,NULL',
                'update_category' => 'required',
                'update_item_price' => 'required'
            ]);
            $data = Item::where('id', $id)->update([
                'item' => $request->update_item,
                'category' => $request->update_category,
                'item_price' => $request->update_item_price,
                'unit_of_measurement' => $request->update_unit_of_measurement,
            ]);
            return response()->json(['message' => 'Item Updated successfully'], 200);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }
    }

}
