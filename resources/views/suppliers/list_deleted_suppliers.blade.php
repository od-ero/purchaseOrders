@extends('layouts.my_app')
@section('subtitle')
 Deleted suppliers
@endsection

@section('contentheader_title')
 Deleted Suppliers
@endsection

@section('content')
@include('suppliers.updateSupplier')
<div class="container-fluid px-4">
                        <h1 class="mt-4">Deleted Suppliers</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('admins.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Deleted Suppliers</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                               List Deleted Suppliers
                            </div>
                            <div class="card-body">
            <table id="deleted_suppliers_table" class="table table-bordered data-table">
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