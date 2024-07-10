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
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Create a user account</h3></div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('postRegister') }}">
                            @csrf
                            <input class="form-control" id="inputPassword" name="moreUser" value="{{$multipleUser}}" type="text" placeholder="Enter user email"  required hidden />
                            <div class="row mb-3">
                            <input class="form-control" id="inputId_password" name="password" value="123456890" type="password" placeholder="Enter user email" hidden required />
                                    <div class="col-md-4">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="inputfname" name="fName" type="text" placeholder="Enter user first name"  required />
                                            <label for="inputPassword">First Name</label>
                                            @if ($errors->has('fName'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('fName') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                    <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="inputMname" name="mName" type="text" placeholder="Enter other names" />
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
                                            <input class="form-control" id="inputLname" name="lName" type="text" placeholder="Enter your last name"  required />
                                            <label for="inputPassword">Last Name</label>
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
                                            <input class="form-control" id="inputId_no" name="id_no" type="text" placeholder="Enter user id number"  required />
                                            <label for="inputPassword">Id Number</label>
                                            @if ($errors->has('id_no'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('id_no') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                        
                                </div>
                                <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputPhone" name="phone" type="tel" placeholder="Enter user phone No"  required />
                                        <label for="inputPassword">Phone Number</label>
                                        @if ($errors->has('phone'))
                                            <div class="text-danger mt-2">
                                                {{ $errors->first('phone') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="inputSphone" name="sPhone" type="tel" placeholder="Enter user second phone No" />
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
                                                <input class="form-control" id="inputId_no" name="email" type="email" placeholder="Enter user email"  required />
                                                <label for="inputEmail">Email Address</label>
                                                @if ($errors->has('email'))
                                                    <div class="text-danger mt-2">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                @endif
                                            </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="inputIdphy_address" name="phy_address" type="text" placeholder="Enter user physical address"  required />
                                            <label for="inputPassword">Physical Address</label>
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
                                            <div class="form-floating mb-3 mb-md-0">
                                                <select class="form-control appselect2" id="inputrole" name="role_id" required>
                                                    <option value="" disabled selected>Select employees role</option>
                                                    @foreach ($roles as $role)
                                                    <option value="{{$role['id']}}">{{$role['role_name']}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="inputRole"></label>
                                                @if ($errors->has('role_id'))
                                                    <div class="text-danger mt-2">
                                                        {{ $errors->first('role_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                </div>
                                <div class="mt-4 mb-0 text-center">
                                    <button type="submit" class="btn btn-primary">Save and View</button>
                                        
                                        <button type="submit" class="btn btn-secondary">Save and Add New</button>
                                   
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
@endsection


