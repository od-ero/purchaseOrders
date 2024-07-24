@extends('layouts.my_app')
@section('subtitle')
 Change Employee Password
@endsection

@section('contentheader_title')
 Change Employee Password
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Change Employee Password</h3></div>
            <div class="card-body">
                <form id="admin_update_password_form">
                    @csrf
                    <div class="form-floating">
                    <select class="form-select mt-3" id="update_user_id" name="user_id" aria-label="Floating label select example">
                    <option value="" disabled selected>Select Username</option>
                                            @foreach ($users as $user)
                                                <option value="{{ base64_encode($user['id']) }}">{{ $user['first_name'].' '.$user['last_name'] }}</option>
                                            @endforeach
                    </select>
                    <label for="floatingSelectGrid">Username <strong class="text-danger">*</strong></label>
                    </div>
                    <div class="form-floating my-3">
                    <input class="form-control" id="update_password_current_password" name="current_password" type="password" placeholder="Current Password" />
                        <label for="login_password">Your Password <strong class="text-danger">*</strong></label>
                        @if ($errors->has('password'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-floating login_form_password my-3">
                    <input class="form-control" id="update_password_password" name="password" type="password" placeholder="New Password"/>
                        <label for="login_password">User Password <strong class="text-danger">*</strong></label>
                        @if ($errors->has('password'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-floating login_form_password my-3">
                        <input class="form-control" id="update_password_password_confirmation" name="password_confirmation" type="password" placeholder="Confirm Password"/>
                        <label for="login_password"> Confirm Password <strong class="text-danger">*</strong></label>
                        @if ($errors->has('password'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                   
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                       
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
           
        </div>
    </div>
</div>


@endsection
