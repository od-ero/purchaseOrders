@extends('layouts.my_app')
@section('subtitle')
 Roles
@endsection

@section('contentheader_title')
 Roles
@endsection

@section('content')
@include('permissions.update_role')
<div class="container-fluid px-4">
                        <h1 class="mt-4">Roles</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('admins.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Roles</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                               List Roles
                            </div>
                            <div class="card-body">
            <table id="list_roles_table" class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th>Name</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
                        </div>
                    </div>
                    </main
@endsection                   