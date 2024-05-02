<?php

namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\User;
use App\Models\Position;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class ManageUser extends Controller
{
    public function index(){
        $title = "User List";
        $secondtitle = "Manage User";
        $thirdtitle = "User List";
        $departments = $this->getDepartmentList();
        $positions = $this->getPositionList();
       
        return view('users.manage-user', compact(['title', 'secondtitle', 'thirdtitle', 'departments', 'positions']));
    }

    public function getDepartmentList(){
        $data = Department::all();

        return $data;
    }

    public function getPositionList(){
        $data = Position::all();

        return $data;
    }


    public function addUser(Request $request){
        try{
            $validatedData = $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|unique:users,email,except,id',
                'position' => 'required',
                'department' => 'required'
            ]);
            $data = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'password' => bcrypt($request->lastname),
                'emp_id' => '20242310',
                'department' => $request->department,
                'position' => $request->position,
            ]);

                $data = [
                    'subject'=>'Below is your new password',
                    'body' => $request->lastname
                ];
            
            $user_email = $request->email;

            Mail::send('users.email-notification', $data, function($message) use ($user_email) {
                $message->to($user_email, 'cvsu')->subject
                ('Account Password');
                $message->from('angel.saraya18@gmail.com','cvsu');
            });
          
            return response()->json(['message' => 'User Added successfully'], 200);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }
      
    }

    public function getUserList(){
        $response = [];
        $data = User::withTrashed()->get();

        foreach($data as $key=>$user){
            $buttons = '';

            if(empty($user->deleted_at)){
                $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                <button type="button" class="btn btn-warning d-flex align-items-center btn-sm px-3" id="update-user-modal" data-id="'.$user->id.'"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger d-flex align-values-center btn-sm px-3" id="deactivate-user-btn" data-id="'.$user->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reject Request"><i class="fa fa-ban"></i></button>   
                </div>';
            }else{
                $buttons = '<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                <button type="button" class="btn btn-warning d-flex align-items-center btn-sm px-3" id="update-user-modal" data-id="'.$user->id.'"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-success d-flex align-items-center btn-sm px-3" id="activate-user-btn" data-id="'.$user->id.'"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Approve Request"><i class="fa fa-user-shield"></i></button> 
                </div>';
            }
            $response[] = array(
                'no' => ++$key,
                'name' => ucwords($user->firstname.' '.$user->lastname),
                'email' => $user->email,
                'emp_id' => $user->emp_id,
                'department' => ucwords($user->department_dtls->department),
                'position' => ucwords($user->position),
                'created_at' => date('M d, Y', strtotime($user->created_at)),
                'status' => (!empty($user->deleted_at)) ? '<span class="badge bg-danger">Deactivated</span>' : '<span class="badge bg-success">Active</span>',
                'action' => $buttons,
            );
        }
        return response()->json($response, 200);

    }

    public function deactivatedUser($id){
        $data = User::find($id);
        $data->delete();

    //     $data = [
    //         'subject'=>'Below is your new password',
    //         'body' => '1234'
    //     ];

    // Mail::send('users.email-notification', $data, function($message) {
    //     $message->to('joey.ametin@gmail.com', 'cvsu')->subject
    //     ('New Password');
    //     $message->from('angel.saraya18@gmail.com','cvsu');
    // });
        return response()->json(['message' => 'User Deactivated successfully'], 200);
    }

    public function activateUser($id)
    {
        $user = User::where('id', $id)->restore();
        return response()->json(['message' => 'User Activated successfully'], 200);
    
    }

    public function viewUser($id){
        $data = User::find($id);
        
        return response()->json($data, 200);
    }

    public function updateUser($id, Request $request){

        try{
            $validatedData = $request->validate([
                'update_firstname' => 'required',
                'update_lastname' => 'required',
                'update_email' => 'required|unique:users,email,' . $id . ',id',
                'update_department' => 'required',
                'update_position' => 'required'
            ]);
            $data = User::where('id', $id)->update([
                'firstname' => $request->update_firstname,
                'lastname' => $request->update_lastname,
                'email' => $request->update_email,
                'department' => $request->update_department,
                'position' => $request->update_position,
            ]);
            return response()->json(['message' => 'User Updated successfully'], 200);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }
    }


}
