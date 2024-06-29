<?php

namespace App\Http\Controllers;

use App\Models\ManageApprovePrModel;
use App\Models\PurchaseRequestHeader;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class ManageApprovePr extends Controller
{
    public function index(){
        $title = "Manage Approve Purchase Request";
        $secondtitle = "Requisition";
        $thirdtitle = "Manage Approve Purchase Request";
        // $d = $this->getPrAttachment(72);
        return view('users.manage-approve-pr', compact(['title', 'secondtitle', 'thirdtitle']));
    }

    public function getRequestList(){
        $response = [];

        $data = PurchaseRequestHeader::whereNotNull('for_approval')->where('status', 2)->orWhere('status', 3)->get();

        foreach($data as $key => $item){
            $response[] = array(
                'no' => ++$key,
                'pr_code' => $item->pr_code,
                'created_by' => $item->created_by_dtls->firstname,
                'action' => '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                <button type="button" class="btn btn-info d-flex align-items-center btn-sm px-3 view-attachment" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fas fa-file-pdf"></i></button>
                <button type="button" class="btn btn-warning d-flex align-items-center btn-sm px-3 add-attachment" data-item-id="'.$item->id.'" data-toggle="tooltip" data-placement="top" title="Download PDF"><i class="fas fa-plus"></i></button>
                </div>',
            );
        }

        return response()->json($response, 200);
    }

    public function addPrAttachment($id, Request $request){
        try{
            $validatedData = $request->validate([
                'attachment' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            
            ]);
            if ($request->hasFile('attachment')) {
                $image = $request->file('attachment');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('pr_attachment'), $imageName);
                
                $data = ManageApprovePrModel::create([
                    'pr_hdr_id' => $id,
                    'attachment' => $imageName,
                ]);
            }
            return response()->json(['message' => 'Attachment Added successfully'], 200);
        }catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }
    
    }

    public function viewPrAttachment($id){
        $response = [];
        $data = PurchaseRequestHeader::where('id', $id)->with('pr_attachment_dtls')->get();

        foreach($data as $value){
            foreach($value->pr_attachment_dtls as $item){
                $response[] = array(
                    'attachment' =>  '<img class="mx-2" src="'.asset('pr_attachment/'.$item->attachment).'" style="width: 330px; height: 300px">',
                );
            }
        }
        return response()->json($response, 200);
        // dd($response);
    }
}
