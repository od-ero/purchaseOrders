<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    {   $roles = Role::whereNot('id',1)->get();
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
                        ->get();
                        $user_present = User::where('first_name', $validated_details['first_name'])
                    ->where('last_name', $validated_details['last_name'])
                    ->get();


if ($user_present->isNotEmpty()) {
    return response()->json(['status' => 'error', 'message' => 'Given name exists']);
}
 else {              
        try { 
            $validated = Validator::make($request->all(), [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'middle_name' => ['nullable', 'string', 'max:255'],
                'id_no' => ['required', 'string', 'unique:users,id_no'],
                'staff_no' => ['required', 'string', 'unique:users,staff_no'],
                'role_id' => ['required', 'integer'],
                'phone' => ['required', 'string', 'unique:users,phone'],
                'second_phone' => ['nullable', 'string', ],
                'email' => ['nullable', 'email', 'unique:users,email'],
                'phy_address' => ['nullable', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:3',],
            ]);
           
            if ($validated->fails()) {
                
               
                return response()->json(['status' => 'error', 'message' => $validated->errors()->all()]);
            }
           
            $user = User::create([
                'first_name' => $validated_details['first_name'],
                'last_name' => $validated_details['last_name'],
                'middle_name' => $validated_details['middle_name'],
                'id_no' => $validated_details['id_no'],
                'role_id' => $validated_details['role_id'],
                'phone' => $validated_details['phone'],
                'second_phone' => $validated_details['second_phone'],
                'login_access' => 1,
                'email' => $validated_details['email'],
                'phy_address' => $validated_details['phy_address'],
                'special_acess' => 0,
                'password' => Hash::make($validated_details['password']),
            ]);
    
            event(new Registered($user));
           
                return response()->json(['status' => 'success', 'message' =>  'Employee registered successfully']);
        } catch (\Exception $e) {
            
            return response()->json(['status' => 'error', 'message' => 'An error occurred please try again later']);
        }}
    
}  
}

    

