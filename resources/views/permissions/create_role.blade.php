@extends('layouts.my_app')
@section('subtitle')
  Create Role
@endsection

@section('contentheader_title')
  Create Role
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Role</h3></div>
            <div class="card-body">
                <form id="create_role_form">
                    @csrf
                    <div class="form-floating login_form_password my-3">
                        <input class="form-control" id="role_name" type="text" name="role_name"  placeholder="role_name" />
                        <label for="role_name"> Role Name<strong class="text-danger">*</strong></label>
                        @if ($errors->has('password'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div id="role_permissions" class="permission">
                        @foreach($permissions as $grouping_id => $permissionGroup)
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>{{ $grouping_id }}</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($permissionGroup as $permission)
                                    <tr>
                                        <td>
                                            <label class="form-check-label" for="inputRememberPassword">{{ $permission->display_name }}</label>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input"  name="permission[{{$permission->id}}]" value="{{$permission->id}}" type="checkbox" role="switch" id="flexSwitch_{{ $permission->id }}">
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach    
                                </tbody>
                            </table>
                        @endforeach
                    </div>
                     <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                     <a class="btn btn-info btn-sm" id="back_button"
                     style="color: #fff !important;"><i class="fa fa-backward"></i></a>
                       
                        <button type="submit" class="btn btn-primary"> <i class="fa-solid fa-floppy-disk"></i> Save</button>
                    </div> 
                </form>
            </div>
            <div class="card-footer text-center py-3">
                
            </div>
        </div>
    </div>
</div>


@endsection
