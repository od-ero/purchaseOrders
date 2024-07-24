@extends('layouts.my_auth_master')
@section('subtitle')
    Developer Login
@endsection

@section('contentheader_title')
  Developer Login
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Developer Login</h3></div>
            <div class="card-body">
                <form id="developers_login_form">
                    @csrf
                   
                    <div class="form-floating login_form_password my-3">
                        <input class="form-control" id="developer_user_name" type="text" name="login_userid"  placeholder="Username" />
                        <label for="login_password">Username <strong class="text-danger">*</strong></label>
                        @if ($errors->has('password'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-floating login_form_password my-3">
                        <input class="form-control" id="developer_password" type="password" name="login_password" autocomplete="new-password" placeholder="Password" />
                        <label for="login_password">Password <strong class="text-danger">*</strong></label>
                        @if ($errors->has('password'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" id="inputRememberPassword" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} autocomplete='off'/>
                        <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small"><a href="{{ route('login') }}">Not a Developer!</a></div>
            </div>
        </div>
    </div>
</div>


@endsection
