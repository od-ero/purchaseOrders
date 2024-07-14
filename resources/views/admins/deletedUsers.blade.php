@extends('layouts.my_app')
@section('subtitle')
Deleted Employees
@endsection

@section('contentheader_title')
 Deleted Employees
@endsection

@section('content')
@include('admins.updateUser');
<div class="container-fluid px-4">
                        <h1 class="mt-4">Deleted Employees</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('admins.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Deleted Employees</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                               List Deleted Employees
                            </div>
                            <div class="card-body">
            <table id="deleted_employees_table" class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Name</th>
                        <th>Details</th>
                        <th>Permission Level</th>
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