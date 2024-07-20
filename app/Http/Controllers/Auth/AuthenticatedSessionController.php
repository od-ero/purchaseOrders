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
    {   $users = User::whereNot('role_id',1)->get();
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
      
            return response()->json(['status'=>'success', 'message' => 'login successfull']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Invalid Username or Password']);
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
}
