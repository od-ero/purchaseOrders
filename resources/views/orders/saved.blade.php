@extends('layouts.my_app')
@section('subtitle')
 Saved
@endsection

@section('contentheader_title')
 Saved
@endsection

@section('content')
@include('admins.updateUser');

<div class="container-fluid px-4">
<form>
    <input type="text" name="saved_batch_id" value="{{$encoded_batch_id}}" id="saved_batch_id" hidden>
</form>
                        <h1 class="mt-4">Uploaded Orders</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('admins.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Uploaded Orders</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                               List Active Employees
                            </div>
                            <div class="card-body">
            <table id="saved_table" class="table table-bordered data-table">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Description</th>
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