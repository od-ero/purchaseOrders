<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): JsonResponse
    { 
        $password = $request->all();
        $validator = Validator::make($password, [
            'current_password' => ['required', 'current_password'],
            'password' => ['required',  'confirmed', 'different:current_password'],
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
       
        $request->user()->update([
            'password' => Hash::make($password['password']),
        ]);

        return response()->json(['status'=>'success', 'message'=>'Password Changed']);
    }

    public function edit(){
        return view('profile.update_password');
    }
    public function adminEditPassword(){
        $users = User::whereNot('special_access',1)
                    ->where('login_access',1)
                    ->get();
        return view('profile.admin_update_password',['users'=>$users]);
    }
    public function adminUpdatePassword(Request $request): JsonResponse
    { 

        $password = $request->all();
        $validator = Validator::make($password, [
            'current_password' => ['required', 'current_password'],
            'password' => ['required',  'confirmed',],
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->all()]);
        }
       $user_id = base64_decode($password['user_id']);
        User::where('id',$user_id)
                ->update([
                    'password' => Hash::make($password['password']),
                ]);

        return response()->json(['status'=>'success', 'message'=>'Password Changed']);
    }
}
