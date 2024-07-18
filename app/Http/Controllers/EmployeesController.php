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
                                ->where('login_access', 1)
                                ->where('special_access',0)
                                ->get();

                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('full_name', function($row) {
                            return $row->first_name . ' ' . $row->last_name;
                        })
                        ->addColumn('details', function($row) {
                            return $row->phone . '<br>' . $row->id_no;
                        })
                        ->addColumn('action', function($row){
                            $encodedId = base64_encode($row->id);      
                                return
    '<div class="btn-group">
    <a type="button"  href="/employee/view/' . $encodedId . '" class="btn btn-success">View</a>
    <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="visually-hidden">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" data-id="' . $encodedId . '" id="update_employees_details" href="#">Edit</a></li>
        <li><a class="dropdown-item" data-id="' . $encodedId . '" id="delete_user_button" href="#">Delete</a></li>
        
        
    </ul>
    </div>';
                                                })
                        ->rawColumns(['details','action'])
                        ->make(true);
            }
            
            return view('admins.users');
        }

    public function indexDeleted(Request $request)
    {
        if ($request->ajax()) {

            $data = User::leftJoin('roles','roles.id','users.role_id')
                            ->select('users.*','roles.role_name')
                            ->where('login_access',0)
                            ->where('special_access',0)
                            ->get();

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('full_name', function($row) {
                return $row->first_name . ' ' . $row->last_name;
            })
            ->addColumn('details', function($row) {
                return $row->phone . '<br>' . $row->id_no;
            })
            ->addColumn('action', function($row){
                $encodedId = base64_encode($row->id);      
                    return
'<div class="btn-group">
<a type="button"  href="/employee/view/' . $encodedId . '" class="btn btn-success">View</a>
<button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
<span class="visually-hidden">Toggle Dropdown</span>
</button>
<ul class="dropdown-menu">
<li><a class="dropdown-item" data-id="' . $encodedId . '" id="update_employees_details" href="#">Edit</a></li>
<li><a class="dropdown-item" data-id="' . $encodedId . '" id="activate_user_button" href="#">Activate</a></li>


</ul>
</div>';
                                       })
            ->rawColumns(['details','action'])
            ->make(true);
}
  
        return view('admins.deletedUsers');
    }

    public function edit($id){
    
        $id= base64_decode($id);
        
        $user_details= User::leftJoin('roles','roles.id', '=','users.role_id')
                            -> where('users.id',$id)
                            -> select('users.*','roles.role_name')
                            -> first();
                            return response()->json($user_details);
    }
    public function show($id){
        $id= base64_decode($id);
        $user_details= User::leftJoin('roles','roles.id', '=','users.role_id')
                            -> where('users.id',$id)
                            -> select('users.*','roles.role_name')
                            -> first();

        return view('admins.viewUser',['user_details'=> $user_details]);
    }


}
