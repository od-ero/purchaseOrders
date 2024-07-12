<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use DataTables;

class Users extends Component
{
    public $users, $name, $email,$phone, $role_name, $role_id,$user_id, $password, $roles;
    public $updateMode = false;

    public function render()
    {
        $this->users = User::leftJoin('roles','roles.id','users.role_id')
                            ->select('users.*','roles.role_name')
                            ->get();
        return view('livewire.users');
    }

    private function resetInputFields(){
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->role_id = '';
    }

    public function store()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'role_id' => 'required',
            'password' => 'required',
        ]);

        User::create($validatedDate);
        $this->dispatch('userStore');
        session()->flash('message', 'Users Created Successfully.');
       
        $this->resetInputFields();
        
        // $this->dispatch('userStore');
        //$this->emit('userStore'); // Close model to using to jquery

    }

    public function edit($id)
    {
        $this->updateMode = true;
        $user = User::where('id',$id)->first();
        $roles = Role::all();
        $roles = $this->roles =  $roles;
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->role_id = $user->role_id;
        
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();


    }

    public function update()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'role_id' => 'required',
        ]);

        if ($this->user_id) {
            $user = User::find($this->user_id);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
            'role_id' => $this->role_id,
            ]);
            $this->updateMode = false;
           
            session()->flash('message', 'Users Updated Successfully.');
            $this->resetInputFields();
            $this->dispatch('userStore');

        }
    }

    public function delete($id)
    {
        if($id){
            User::where('id',$id)->delete();
            session()->flash('message', 'Users Deleted Successfully.');
        }
    }
}
