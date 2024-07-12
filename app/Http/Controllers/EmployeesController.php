<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\User;
use DataTables;
class EmployeesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = User::leftJoin('roles','roles.id','users.role_id')
                            ->select('users.*','roles.role_name')
                            ->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
       
                            $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
      
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
          
        return view('admins.users');
    }
}
