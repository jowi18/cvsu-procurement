<?php

namespace App\Http\Controllers;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function showNotification(){
        
        $response = [];

        $data = Notifications::where('belong_to', auth()->user()->id)
        ->orderBy('created_at','desc')
        // ->orWhere('department', auth()->user()->department)
        ->get();
        foreach($data as $item){
            $response[] = array(
                'id' => $item->id,
                'transact_by' => ucwords($item->transactBy_dtls->firstname.' '.$item->transactBy_dtls->lastname),
                'belong_to' => ucwords($item->belongTo_dtls->firstname.' '.$item->belongTo_dtls->lastname),
                'message' => (auth()->user()->id == $item->transact_by) ? ucwords($item->message_to_creator) : ucwords($item->message_to_others),
                'message_to_others' => ucwords($item->message_to_others),
                'title' => ucwords($item->title),
                'read_at' => $item->read_at,
                'created_at' => $item->created_at,
                'image' =>'<img src="'.asset('images/default.png').'" class="img-size-50 mr-3 img-circle">',

            );
        }
            echo json_encode($response);
    }

    public function readNotification($id){
        $data = Notifications::where('id', $id)->update([
            'read_at' => now()
        ]);

        return response()->json(['message' => 'Success'], 200);
    }

    public function countNotification(){
        // $data = Notifications::where('department', auth()->user()->department)
        $data = Notifications::where('belong_to', auth()->user()->id)
        ->whereNull('read_at')->count();
        echo json_encode($data);
    }

    public function getUserData(){
        $response = [];
        $data = User::where('id', auth()->user()->id)->first();

        $response[] = array(
            'user_id' => $data->id,
            'user_level' => $data->position_dtls->user_level,
            'department' => $data->department
        );
        return response()->json($response);
    }
}
