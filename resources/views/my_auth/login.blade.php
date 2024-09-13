@extends('layouts.my_auth_master')
@section('subtitle')
  Login
@endsection

@section('contentheader_title')
  Login
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
            <div class="card-body">
                <form id="login_form">
                    @csrf
                  
                    <div class="row mb-3">
                        <div class="col-sm-10 pe-0">
                            <div class="form-floating">
                            <input type="password" class="form-control" id="password" placeholder="Password">
                            <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="col-sm-2 ps-0">
                            <button class="btn btn-outline-primary w-100 h-100" type="button" id="togglePassword">
                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                    </div>



                    <div class="form-floating">
                        <select class="form-select mt-3" id="login_userid" name="login_userid" aria-label="Floating label select example">
                        <option value="" disabled selected>Select Username</option>
                            @foreach ($users as $user)
                                <option value="{{ base64_encode($user['id']) }}">{{ $user['first_name'].' '.$user['last_name'] }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelectGrid">Username <strong class="text-danger">*</strong></label>
                        </div>
                    <div class="form-floating login_form_password my-3">
                        <input class="form-control" id="login_password" type="password" name="login_password" autocomplete="new-password" placeholder="Password" />
                        <label for="login_password">Password <strong class="text-danger">*</strong></label>
                        @if ($errors->has('password'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div id="remember_me_class" class="form-check mb-3">
                        <input class="form-check-input" id="inputRememberPassword" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} autocomplete='off'/>
                        <label class="form-check-label" for="inputRememberPassword">Remember Me</label>
                    </div>
                     <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                       
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div> 
                </form>
            </div>
            <div class="card-footer text-center py-3">
                
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordField = document.getElementById('password');
    const icon = document.getElementById('togglePasswordIcon');
    
    // Toggle the input type between password and text
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});
</script>
@endsection
