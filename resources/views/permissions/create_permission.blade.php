@extends('layouts.my_app')
@section('subtitle')
  Create Permission
@endsection

@section('contentheader_title')
  Create Permission
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Permission</h3></div>
            <div class="card-body">
                <form id="create_permission_form">
                    @csrf
                    <div class="form-floating my-3 ">
                    <input class="form-control" id="no_of_permissions" type="number" name="no_of_permissions" value="0" hidden />
                    </div>
                    <div class="form-floating my-3 mb-md-0">
                    <div id="permissionsContainer"></div>
                        
                </div>
                <div class="my-3">
                <button class="btn btn-outline-primary" id="create_permission_add">Add Permission</button>
            </div>
                     <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                     <a class="btn btn-info btn-sm" id="back_button"
                     style="color: #fff !important;"><i class="fa fa-backward"></i></a>
                        <button id="create_permission_button" type="submit" class="btn btn-primary">  Save</button>
                    </div> 
                </form>
            </div>
            <div class="card-footer text-center py-3">
                
            </div>
        </div>
    </div>
</div>


@endsection
