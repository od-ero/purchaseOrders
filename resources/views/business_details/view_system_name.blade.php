@extends('layouts.my_app')
@section('subtitle')
  Systerm Business Name
@endsection

@section('contentheader_title')
  Systerm Business Name
@endsection

@section('content')
@include('business_details.update_system_name')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">System Name</h3></div>
            <div class="card-body">
                <form id="view_systerm_business_name_form">
                    @csrf
                    <label for="login_password">System Business Name</label>
                    <div class="form-floating login_form_password my-3">
                        <input class="form-control" id="company_name" type="text" name="login_password" value="{{$system_name}}" disabled />
                       
                        @if ($errors->has('password'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                   
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <a type="submit" id="update_systerm_name_button" class="btn btn-primary">Edit</a>
                    </div>
                </form>
            </div>
           
        </div>
    </div>
</div>


@endsection
