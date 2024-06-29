<?php

namespace App\Http\Controllers;
use Illuminate\Validation\ValidationException;
use App\Models\PurchaseRequestHeader;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use App\Models\Department;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $title = "Dashboard";
        $secondtitle = "Dashboard";
        $thirdtitle = "";
        // $approvedRequestCount = $this->approvedRequestCount();
        // $pendingRequestCount = $this->pendingRequestCount();
        // $forwardedRequestCount = $this->forwardedRequestCount();
        // $rejectedRequestCount = $this->rejectedRequestCount();
        $data = $this->getRequestDepartmentCount();
        $request_count = $this->requestCount();
        return view('home', compact(['title', 'secondtitle', 'thirdtitle', 'request_count']));
    }

    public function getSampleData()
    {
        try{
            $data = [
            'labels' => ['Reds', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            'values' => [12, 19, 3, 5, 2, 3]
            ];
            return response()->json($data);
        }catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }
    }

    public function requestCount(){

        if(auth()->user()->position_dtls->user_level == 2 || auth()->user()->position_dtls->user_level == 1){
            $statusCounts = [
                'pending' => PurchaseRequestHeader::where('status', 1)->count(),
                'forwarded' => PurchaseRequestHeader::where('status', 2)->count(),
                'approved' => PurchaseRequestHeader::where('status', 3)->count(),
                'rejected' => PurchaseRequestHeader::where('status', 4)->count()
            ];
        }else{
            $statusCounts = [
                'pending' => PurchaseRequestHeader::where('department_id', auth()->user()->department_dtls->id)->where('status', 1)->count(),
                'forwarded' => PurchaseRequestHeader::where('department_id', auth()->user()->department_dtls->id)->where('status', 2)->count(),
                'approved' => PurchaseRequestHeader::where('department_id', auth()->user()->department_dtls->id)->where('status', 3)->count(),
                'rejected' => PurchaseRequestHeader::where('department_id', auth()->user()->department_dtls->id)->where('status', 4)->count()
            ];
        }
        return $statusCounts;
    }

    public function getRequestDepartmentCount(){
        $currentYear = Carbon::now()->year;
        $departments = Department::where('id', auth()->user()->department)->get();

        $results = [];

        foreach ($departments as $department) {
            $departmentReport = [
                'department_id' => $department->id,
                'department_name' => $department->department,
                'year' => $currentYear,
                'monthly_data' => []
            ];

            for ($month = 1; $month <= 12; $month++) {
                $requestCount = PurchaseRequestHeader::where('department_id', auth()->user()->department)
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)
                    ->count();

                $monthName = Carbon::create()->month($month)->format('F');
                // Add the data to the monthly_data array
                $departmentReport['monthly_data'][] = [
                    'month' => $month,
                    'month_name' => $monthName,
                    'request_count' => $requestCount
                ];
            }

            $results[] = $departmentReport;
        }

        // dd($results);
        return response()->json($results);
    }

}
