@extends('layouts.my_app')
@section('subtitle')
 Active suppliers
@endsection

@section('contentheader_title')
 Active Suppliers
@endsection

@section('content')
@include('orders.delete_orders')
<div class="container-fluid px-4">
                        <h1 class="mt-4">Imported Batches</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('admins.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Imported Batches</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                               List Imported Batches
                            </div>
                            <div class="card-body">
            <table id="imported_batches_table" class="table table-bordered data-table">
                <thead>
                    <tr><th>#</th>
                     <th>Date</th>
                        <th>Order Number</th>
                        <th>Supplier</th>
                        <th>Items</th>
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