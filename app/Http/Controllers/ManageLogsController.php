<?php

namespace App\Http\Controllers;
use App\Models\ManageLogs;
use Illuminate\Http\Request;

class ManageLogsController extends Controller
{
    public function index(){
        $title = "Manage Logs";
        $secondtitle = "Manage Logs";
        $thirdtitle = "Manage Logs";

        return view('users.manage-logs', compact('title','secondtitle','thirdtitle'));
    }

    public function getLogsHistory(){
        $response = [];
        if(auth()->user()->position_dtls->user_level <= 2){
            $data = ManageLogs::orderBy('created_at', 'desc')->get();
        }else{
            $data = ManageLogs::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        }
        
        foreach($data as $key=>$row){
            $response[] = [
                'no' => ++$key,
                'name' => $row->user_dtls->firstname.' '.$row->user_dtls->lastname,
                'department' => $row->user_dtls->department_dtls->department,
                'action' => $row->action,
                'date' =>  date('M d, Y h:i A', strtotime($row->created_at)),
                'action_time' => $row->action_time,
            ];
        }

        return response()->json($response);
    }
}
