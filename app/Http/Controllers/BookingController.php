<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
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
}
