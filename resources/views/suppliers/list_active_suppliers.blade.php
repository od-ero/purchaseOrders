@extends('layouts.my_app')
@section('subtitle')
 Active suppliers
@endsection

@section('contentheader_title')
 Active Suppliers
@endsection

@section('content')
@include('suppliers.updateSupplier');
<div class="container-fluid px-4">
                        <h1 class="mt-4">Active Suppliers</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('admins.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Active Suppliers</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                               List Active Suppliers
                            </div>
                            <div class="card-body">
            <table id="active_suppliers_table" class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
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