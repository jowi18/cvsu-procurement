<?php

namespace App\Http\Controllers;
use Illuminate\Validation\ValidationException;
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
        return view('home', compact(['title', 'secondtitle', 'thirdtitle']));
    }

    public function getSampleData()
    {
        try{
            $data = [
            'labels' => ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            'values' => [12, 19, 3, 5, 2, 3]
            ];
            return response()->json($data);
        }catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(['errors' => $errors], 422);
        }
    }
}
