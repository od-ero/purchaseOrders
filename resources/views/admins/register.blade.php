@extends('layouts.my_app')
@section('subtitle')
  Dashoard
@endsection

@section('contentheader_title')
  Dashboard
@endsection


@section('content')

            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-2">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Create a user account</h3></div>
                        <div class="card-body">
                            <form id="register_employee_form" >
                            @csrf
                            <div class="row mb-3">
                               
                                    <div class="col-md-4">
                                        <div class="form-floating  mb-3 mb-md-0">
                                            <input class="form-control" id="register_first_name" name="first_name" type="text" placeholder="Enter user first name"   />
                                            <label for="inputPassword">First Name  &emsp; <strong class="text-danger" >*</strong></label>
                                            @if ($errors->has('first_name'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('first_name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                        <div class="col-md-4">
                                    <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="register_middle_name" name="middle_name" type="text" placeholder="Enter other names" />
                                            <label for="inputPassword">Middle Names</label>
                                            @if ($errors->has('mName'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('mName') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                    <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="register_last_name" name="last_name" type="text" placeholder="Enter your last name"   />
                                            <label for="inputPassword">Last Name &emsp; <strong class="text-danger text-right" >*</strong></label>
                                            @if ($errors->has('lName'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('lName') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="register_id_no" name="id_no" type="text" placeholder="Enter user id number"   />
                                            <label for="inputPassword">Id Number &emsp; <strong class="text-danger text-right" >*</strong></label>
                                            @if ($errors->has('id_no'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('id_no') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="register_staff_no" name="staff_no" type="text" placeholder="Enter user staff number"   />
                                            <label for="inputPassword">Staff Number </label>
                                            @if ($errors->has('staff_no'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('staff_no') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                        
                                </div>
                                <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="register_phone" name="phone" type="tel" placeholder="Enter user phone No"   />
                                        <label for="inputPassword">Phone Number &emsp; <strong class="text-danger text-right" >*</strong></label>
                                        @if ($errors->has('phone'))
                                            <div class="text-danger mt-2">
                                                {{ $errors->first('phone') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="register_second_phone" name="second_phone" type="tel" placeholder="Enter user second phone No" />
                                            <label for="inputPassword">Phone Number 2</label>
                                            @if ($errors->has('sPhone'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('sPhone') }}
                                                </div>
                                            @endif
                                        </div>
                                </div>
                                </div>  
                                <div class="row mb-3">
                                <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="register_email" name="email" type="email" placeholder="Enter user email"   />
                                                <label for="inputEmail">Email</label>
                                                @if ($errors->has('email'))
                                                    <div class="text-danger mt-2">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                @endif
                                            </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="register_phy_address" name="phy_address" type="text" placeholder="Enter user physical address"   />
                                            <label for="inputPassword">Address</label>
                                            @if ($errors->has('phy_address'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('phy_address') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    
                                        <div class="col-md-6">
                                        <div class="form-floating">
            <select class="form-select" id="register_role_id" name="role_id"  aria-label="Floating label select example">
            <option value="" disabled selected>Select Permission</option>
                @foreach ($roles as $role)
                <option value="{{$role['id']}}">{{$role['role_name']}}</option>
                @endforeach
            </select>
  <label for="floatingSelect">Permission Level</label>
</div>
                                            
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="register_password" name="password" type="password" placeholder="Enter user password" />
                                                <label for="inputPassword">Password &emsp; <i>(> 3)</i>&emsp; <strong class="text-danger text-right" > *</strong></label>
                                                @if ($errors->has('password'))
                                                    <div class="text-danger mt-2">
                                                        {{ $errors->first('password') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                </div>
                                
                                <div class="mt-4 mb-0 text-center">
                                    <button type="submit" id="register_save_view" class="btn btn-primary  btn-submit">Save and View</button>  
                                        <button type="submit" id="register_save_and_add_new" class="btn btn-secondary">Save and Add New</button>
                                   
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

          
       

          
@endsection


