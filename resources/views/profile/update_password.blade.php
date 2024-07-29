@extends('layouts.my_app')
@section('subtitle')
 Change Password
@endsection

@section('contentheader_title')
 Change Password
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Change Password</h3></div>
            <div class="card-body">
                <form id="update_password_form">
                    @csrf
                    <div class="form-floating my-3">
                    <input class="form-control" id="update_password_current_password" name="current_password" type="password" placeholder="Current Password" />
                        <label for="login_password">Current Password <strong class="text-danger">*</strong></label>
                        @if ($errors->has('password'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-floating login_form_password my-3">
                    <input class="form-control" id="update_password_password" name="password" type="password" placeholder="New Password"/>
                        <label for="login_password">New Password <strong class="text-danger">*</strong></label>
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
                       @can('reset-password')
                            <button type="submit" class="btn btn-primary">Save</button>
                        @endcan
                    </div>
                </form>
            </div>
           
        </div>
    </div>
</div>


@endsection
