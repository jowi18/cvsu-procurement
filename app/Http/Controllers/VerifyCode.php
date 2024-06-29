<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\ManageLogs;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VerifyCode extends Controller
{
    public function index(){
        $title = "Verify Code";
        $secondtitle = "Requisition";
        $thirdtitle = "Manage Approve Purchase Request";
        return view('users.verify-code', compact('title', 'secondtitle', 'thirdtitle'));
    }

    public function verifyCode(Request $request){

        try {
            $request->validate([
                'verification_code' => 'required|numeric',
            ]);

            $sessionCode = $request->session()->get('verification_code');

            if ($request->verification_code == $sessionCode) {
                // Clear the verification code from the session
                $request->session()->forget('verification_code');

                $userId = auth()->user()->id;

                if ($userId === null) {
                    return redirect('/');
                }

                User::where('id', $userId)->update([
                    'secured_account' => now(),
                ]);

                ManageLogs::create([
                    'user_id' => $userId,
                    'action' => 'Logged In ' . Carbon::now('Asia/Manila'),
                ]);

                return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
            }

            return back()->withErrors(['verification_code' => 'Invalid verification code.']);
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'An error occurred while verifying the code. Please try again.');
        }
    }


    protected function redirectPath()
    {
        return '/home'; // Replace with your intended default path
    }
}
