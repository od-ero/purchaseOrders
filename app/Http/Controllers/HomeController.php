<?php

namespace App\Http\Controllers;

use App\Models\supplier;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){
        $suppliers = supplier::count();
        return view('admins.dashboard',['suppliers'=>$suppliers]);
    }
}
