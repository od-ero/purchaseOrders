<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use App\Models\BusinessDetail;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {   $users = User::whereNot('special_access',1)
                        ->where('login_access',1)
                        ->get();
        return view('my_auth.login',['users'=>$users]);
    }

    /**
     * Handle an incoming authentication request.
     */
    
    public function store(LoginRequest $request): JsonResponse
    { 
        try {
            $request->authenticate();
          $request->session()->regenerate();
          $system_name = BusinessDetail::where('id',1)
                                        ->value('system_name');
          $request->session()->put(['system_name' => $system_name, ]);

          $intendedUrl =  $request->session()->pull('url.intended', '/admin/home');
      
            return response()->json(['status'=>'success','intendedUrl' =>$intendedUrl, 'message' => 'login successfull']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Invalid Username or Password']);
        }
    }

    public function devStore(LoginRequest $request): JsonResponse
    { //dd( $request->all());
       
        $user = User::where('username', $request->login_userid)->first();
        if($user == null){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Username or Password.',
            ]);
        }elseif($user->special_access != 1){
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Username or Password.',
            ]);
        }else{
            try {
                $request->authenticateDev();
              $request->session()->regenerate();
              $system_name = BusinessDetail::where('id',1)
                                            ->value('system_name');
              $request->session()->put(['system_name' => $system_name, ]);
    
              $intendedUrl =  $request->session()->pull('url.intended', '/admin/home');
          
                return response()->json(['status'=>'success','intendedUrl' =>$intendedUrl, 'message' => 'login successfull']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => 'Invalid Username or Password']);
            }
    }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function userRole($user_id){
        $user_id = base64_decode($user_id);
        $user = User::find($user_id);
        $userRole = $user->roles->pluck('id')->first();
        
        return response()->json(['user_role_id' => $userRole]);                   
    }
}
