<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {   //$roles = Role::whereNot('id',1)->get();
        $roles = Role::whereNot('name','super-admin')
                        ->orderBy('id','DESC')
                         ->pluck('name','name');
        return view('admins.register',['roles'=>$roles]);
    }
   

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
{   $validated_details= $request->all();
    $user_present= User::where('first_name',$validated_details['first_name'])
                        ->where('last_name',$validated_details['last_name'])
                        ->first();
                       
            if($user_present)
            {
                return response()->json(['status' => 'error', 'message' => ['Similar full name exists with another person']]);
            }
            else{              
                try { 
                    $validated = Validator::make($request->all(), [
                        'first_name' => ['required', 'string', 'max:255'],
                        'last_name' => ['required', 'string', 'max:255'],
                        'middle_name' => ['nullable', 'string', 'max:255'],
                        'id_no' => ['required', 'string', 'unique:users,id_no'],
                        'staff_no' => ['nullable', 'string', 'unique:users,staff_no'],
                        'phone' => ['required', 'string', 'unique:users,phone'],
                        'second_phone' => ['nullable', 'string', ],
                        'email' => ['nullable', 'email', 'unique:users,email'],
                        'phy_address' => ['nullable', 'string', 'max:255'],
                        'password' => ['required', 'string', 'min:3',],
                    ]);
                
                    if ($validated->fails()) {
                        
                        return response()->json(['status' =>'error', 'message' => $validated->errors()->all()]);
                    }
                
                    $user = User::create([
                        'first_name' => $validated_details['first_name'],
                        'last_name' => $validated_details['last_name'],
                        'middle_name' => $validated_details['middle_name'],
                        'id_no' => $validated_details['id_no'],
                        'staff_no' => $validated_details['staff_no'],
                        'phone' => $validated_details['phone'],
                        'second_phone' => $validated_details['second_phone'],
                        'login_access' => 1,
                        'email' => $validated_details['email'],
                        'phy_address' => $validated_details['phy_address'],
                        'special_access' => 0,
                        'password' => Hash::make($validated_details['password']),
                    ]);
                    $user->assignRole($request->input('roles'));
            
                    event(new Registered($user));
                
                        return response()->json(['status' => 'success', 'user_id' => $user['id'],'message' =>  'Employee registered successfully']);
                } 
                catch (\Exception $e) {
                    return response()->json(['status' => 'error', 'message' => ['An error occurred please try again later']]);
                }
            }
         
             
        

    
}  
public function update(Request $request): JsonResponse
{   $validated_details= $request->all();
    $user_present= User::where('first_name',$validated_details['first_name'])
                        ->where('last_name',$validated_details['last_name'])
                        ->whereNot('id',$validated_details['user_id'])
                        ->first();    
            if($user_present)
            {
                return response()->json(['status' => 'error', 'message' => ['Similar full name exists with another person']]);
            }
            else{              
                try { 
                    $validated = Validator::make($request->all(), [
                        'first_name' => ['required', 'string', 'max:255'],
                        'last_name' => ['required', 'string', 'max:255'],
                        'middle_name' => ['nullable', 'string', 'max:255'],
                        'id_no' => ['required', 'string', 'unique:users,id_no,' . $validated_details['user_id']],
                        'staff_no' => ['nullable', 'string', 'unique:users,staff_no,' . $validated_details['user_id']],
                        'phone' => ['required', 'string', 'unique:users,phone,' . $validated_details['user_id']],
                        'second_phone' => ['nullable', 'string', ],
                        'email' => ['nullable', 'email', 'unique:users,email,' . $validated_details['user_id']],
                        'phy_address' => ['nullable', 'string', 'max:255'],
                    ]);
                
                    if ($validated->fails()) {
                        
                        return response()->json(['status' =>'error', 'message' => $validated->errors()->all()]);
                    }
                            $user = User::find($validated_details['user_id']);
                            $user->update($validated_details);
                
                        return response()->json(['status' => 'success', 'user_id' => $validated_details['user_id'],'message' =>  'Employee updated successfully']);
                } 
                catch (\Exception $e) {
                    
                    return response()->json(['status' => 'error', 'message' => [$e]]);
                }
            }
} 

public function delete($user_id){

    try { 
    $user_id= base64_decode($user_id);
     User::where('id',$user_id)
            ->update([
               'login_access'=> 0 
            ]);  
            return response()->json(['status' => 'success', 'message' => 'Employee deleted']);
        } 
        catch (\Exception $e) {
            
            return response()->json(['status' => 'error', 'message' => [$e]]);
        }                    
}
public function activate($decoded_user_id){

    try { 
    $user_id= base64_decode($decoded_user_id);
     User::where('id',$user_id)
            ->update([
               'login_access'=> 1 
            ]);  
            return response()->json(['status' => 'success', 'user_id' => $decoded_user_id, 'message' => 'Employee Activated']);
        } 
        catch (\Exception $e) {
            
            return response()->json(['status' => 'error', 'message' => [$e]]);
        }                    
}
}

    

