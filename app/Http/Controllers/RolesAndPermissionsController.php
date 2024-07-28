<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DB;
use Yajra\DataTables\DataTables as DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class RolesAndPermissionsController extends Controller
{
    //   


    public function addRoles(Request $request){
    //   $role = Role::create([
    //         'name'=> 'Admin'
    //     ]);

        // foreach($request->permission as $permission){
        //     $role->givePermissionTo($permission);
        // }
      //  $role->givePermissionTo('Add-Supplier');
        // foreach($request->users as $user){
        //     $user = User::find($user);
        //     $role->assignRole($role->name);
        // }
        $user = User::find(1);
        $user->assignRole('super-admin');
        dd('success');

    }

    
    public function listRoles(Request $request)
    {
        if ($request->ajax()) {
        
        //$roles = Role::orderBy('id','DESC')->get();
        $roles = Role::whereNot('name','super-admin')
                            ->orderBy('id','DESC')
                            ->get();
        return DataTables::of($roles)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $encodedId = base64_encode($row->id);      
        
            // View button
            $viewButton = '';
            if (auth()->user()->can('view-role')) {
            $viewButton = '<a type="button" href="/show-role/' . $encodedId . '" class="btn btn-success">View</a>';
            }
        
            // Edit button, only if the user has the 'edit-role' permission
            $editButton = '';
            if (auth()->user()->can('edit-role')) {
                $editButton = '<li><a class="dropdown-item" data-id="' . $encodedId . '" id="update_roles_button" href="#">Edit</a></li>';
            }
        
            // Delete button, only if the user has the 'delete-role' permission
            $deleteButton = '';
            if (auth()->user()->can('destroy-role')) {
                $deleteButton = '<li><a class="dropdown-item" data-id="' . $encodedId . '" id="delete_role_button" href="#">Delete</a></li>';
            }
        
            return '
            <div class="btn-group">
                ' . $viewButton . '
                <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    ' . $editButton . '
                    ' . $deleteButton . '
                </ul>
            </div>';
        })
        
        ->rawColumns(['action'])
        ->make(true);
        }
        return view('permissions.list-roles');
    }
    public function createRoles(): View
    {
        $permissions = Permission::orderBy('grouping_id','ASC')
                                ->get()
                                ->groupBy('grouping_id');
                               
        return view('permissions.create_role',compact('permissions'));
    }
    

    public function storeRoles(Request $request): JsonResponse
    {
        //dd($request->all());
        try{
        $validated = Validator::make($request->all(), [
                        'role_name' => 'required|unique:roles,name',
                        'permission' => 'required',
                    ]);
        if ($validated->fails()) {
            
            return response()->json(['status' =>'error', 'message' => $validated->errors()->all()]);
        }
        $permissionsID = array_map(
            function($value) { return (int)$value; },
            $request->input('permission')
        );
    
        $role = Role::create(['name' => $request->input('role_name')]);
        $role->syncPermissions($permissionsID);
        return response()->json(['status' =>'success','role_id'=>$role['id'] ,'message' => 'Role created']);

    }catch (\Exception $e) {
                    
        return response()->json(['status' => 'error', 'message' => $e]);
    }
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showRole($encoded_role_id): View
    { $id = base64_decode($encoded_role_id);
        $role = Role::find($id);
        $rolePermissionsGroups = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
                                            ->where("role_has_permissions.role_id", $id)
                                            ->orderBy('grouping_id','ASC')
                                            ->get()
                                            ->groupBy('grouping_id');
        return view('permissions.show_role',compact('role','rolePermissionsGroups'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editRole($encoded_role_id): JsonResponse
    { $id = base64_decode($encoded_role_id);
        $role = Role::find($id);
        $permissions = Permission::orderBy('grouping_id','ASC')
                        ->get()
                        ->groupBy('grouping_id');
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    
        return response()-> json(['permissions' => $permissions, 'rolePermissions' => $rolePermissions, 'role'=>$role]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRole(Request $request): JsonResponse
    {   
        $role_details = $request->all();

        $validated = Validator::make($role_details, [
            'role_name' => 'required|unique:roles,name,' .  $role_details['role_id'],
            'permission' => 'required',
        ]);
        if ($validated->fails()) {
                        
            return response()->json(['status' =>'error', 'message' => $validated->errors()->all()]);
        }
    
        $role = Role::find($role_details['role_id']);
        $role->name = $request->input('role_name');
        $role->save();

        $permissionsID = array_map(
            function($value) { return (int)$value; },
            $request->input('permission')
        );
    
        $role->syncPermissions($permissionsID);
    
        return response()->json(['status' =>'success', 'role_id'=>$role['id'], 'message' => 'Role Edited']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyRole($encoded_role_id): JsonResponse
    {
        try{
$role_id = base64_decode($encoded_role_id);
        DB::table("roles")->where('id',$role_id)->delete();
        return response()->json(['status' =>'success', 'message' => 'Role Deleted']);
    }catch (\Exception $e) {
                    
        return response()->json(['status' => 'error', 'message' => $e]);
    }
    }

    public function createPermission(){
        return view('permissions.create_permission');
    }
    public function storePermissions(Request $request){
        $permissions = $request->all();
        if ($permissions['no_of_permissions'] > 0) {
            
          //  dd($permissions);
            for ($i = 1; $i <= $permissions['no_of_permissions']; $i++) {
                $permission_key = "permission_" . $i;
                //permission_1
                //dd($permission_key);
                if (isset($permissions[$permission_key])) {
                   $created= Permission::create([
                        'name'=> $permissions[$permission_key]
                    ]);
                   // dd();
                }
                
            }
            return response()->json(['status' => 'success', 'message' => 'Permission Created']);
            
        }else{
            return response()->json(['status' => 'error', 'message' => 'Kindly Enter Permission']);
        }
           
        }

        public function editPermissionLevel($encoded_user_id){
            $user_id = base64_decode($encoded_user_id);
            $user = User::find($user_id);
            $roles = Role::whereNot('name','super-admin')
                            ->orderBy('id','DESC')
                            ->pluck('name','name');
            $userRole = $user->roles->pluck('name','name')->first();

            return response()->json(['roles'=>$roles , 'userRole'=>$userRole]);

        }

        public function updatePermissionLevel(Request $request){
           $user_detail = $request->all();
           
            $validated = Validator::make($user_detail, [
                'password' => ['required','current_password'],
                'roles' => ['required'],
            ]);
        
            if ($validated->fails()) {
                
                return response()->json(['status' =>'error', 'message' => $validated->errors()->all()]);
            }
            try{
                $user_id = base64_decode($user_detail['user_id']);
            $user = User::find($user_id);
            DB::table('model_has_roles')->where('model_id',$user_id)->delete();
    
            $user->assignRole($request->input('roles')); 
            return response()->json(['status' => 'success', 'message' => 'Permission Level Edited']);
        } catch (\Exception $e) {
                    
            return response()->json(['status' => 'error', 'message' => 'Ann Error Occured']);
        }
            
        }
        
   
}
