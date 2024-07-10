<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {   $roles = Role::whereNot('id',1)->get();
        return view('admins.register',['roles'=>$roles,
        'multipleUser'=>"neither"]);
    }
    public function mulCreate(): View
    {   $roles = Role::whereNot('id',1)->get();
        return view('admins.register',['roles'=>$roles,
        'multipleUser'=>"yes"]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
       
      $validated_details=  $request->validate([
            'fName' => ['required', 'string', 'max:255'],
            'lName' => ['required', 'string', 'max:255'],
            'mName',
            'id_no' => ['required'],
            'role_id'=> ['required'],
            'phone' => ['required','unique:'.User::class],
            'sPhone',
            'email' => ['string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phy_address' => ['required', 'string', 'max:255'],
            'password'=> ['required']
            
        ]);
       
        $user = User::create($validated_details);

    
        event(new Registered($user));
    
        if ($request->moreUser == "yes") {
            $notification = [
                'message' => 'User added successfully. Go ahead and add another.',
                'alert-type' => 'success',
            ];
    
            return redirect()->back()->with($notification);
        } elseif ($request->moreUser == "neither") {
            return redirect(route('admins.dashboard', [], false));
        }
    
        // Ensure a default response is returned if no conditions match
        return redirect()->route('default.route'); // Replace 'default.route' with an appropriate route name
    }
    

}