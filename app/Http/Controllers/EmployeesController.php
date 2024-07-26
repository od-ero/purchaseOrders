<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables as DataTables;


class EmployeesController extends Controller
{
        public function index(Request $request)
        {
            if ($request->ajax()) {

                $data = User::select('users.*')
                                ->where('login_access', 1)
                                ->where('special_access',0)
                                ->get();

                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('full_name', function($row) {
                            return $row->first_name . ' ' . $row->last_name;
                        })
                        ->addColumn('role_name', function($user) {
                            $userRole = $user->roles->pluck('name')->first();
                          
                            return $userRole;
                           
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
         <li><a class="dropdown-item" data-id="' . $encodedId . '" id="update_permission_level_button" href="#">Edit Permission Level</a></li>
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

            $data = User::select('users.*')
                            ->where('login_access',0)
                            ->where('special_access',0)
                            ->get();

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('full_name', function($row) {
                return $row->first_name . ' ' . $row->last_name;
            })
            ->addColumn('role_name', function($user) {
                $userRole = $user->roles->pluck('name','name')->all();
                return $userRole;
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
        $user = User::find($id);
        return response()->json($user);
    }
    public function show($id){
        $id= base64_decode($id);
        $user_details= $user = User::find($id);
        return view('admins.viewUser',['user_details'=> $user_details]);
    }


}
