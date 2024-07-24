@extends('layouts.my_app')
@section('subtitle')
 View Batch
@endsection

@section('contentheader_title')
 View Batch
@endsection

@section('content')
@include('orders.delete_orders');
<div class="container-fluid px-4">
<form>
    <input type="text" name="saved_batch_id" value="{{$encoded_batch_id}}" id="saved_batch_id" hidden>
</form>
                        <h1 class="mt-4">Batch Items</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('admins.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Batch Items</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                              Batch Items
                            </div>
                            <div class="card-body">
                            <div class="row mb-3">
                               
                               <div class="col-md-3">
                                   <div class="form-floating  mb-3 mb-md-0">
                                       <input class="form-control" id="upload_and_view_batch_name" value="{{$batch_details['batch_name']}}" name="batch_name" type="text" placeholder="Enter Batch Name"  disabled />
                                       <label for="inputBatchName">Batch Name  </label>
                                       @if ($errors->has('supplier_name'))
                                           <div class="text-danger mt-2">
                                               {{ $errors->first('mName') }}
                                           </div>
                                       @endif
                                   </div>
                               </div>
                                   <div class="col-md-6">
                               <div class="form-floating mb-3 mb-md-0">
                                       <input class="form-control" id="upload_and_view_supplier_name" name="supplier_name" type="text" value="{{ $batch_details['supplier_name'] }}" placeholder="Enter other names"  disabled/>
                                       <label for="inputPassword">Supplier</label>
                                       @if ($errors->has('supplier_name'))
                                           <div class="text-danger mt-2">
                                               {{ $errors->first('mName') }}
                                           </div>
                                       @endif
                                   </div>
                               </div>
                               <div class="col-md-3">
                               <div class="form-floating mb-3 mb-md-0">
                                       <input class="form-control" id="upload_and_view_order_number" name="order_number" type="text" value="{{$batch_details['order_no']}}" placeholder="Enter Your Order Number"  disabled />
                                       <label for="inputPassword">Order Number &emsp; <strong class="text-danger text-right" >*</strong></label>
                                       @if ($errors->has('lName'))
                                           <div class="text-danger mt-2">
                                               {{ $errors->first('lName') }}
                                           </div>
                                       @endif
                                   </div>
                               </div>
                           </div>                    
            <table id="view_batch_table" class="table table-bordered data-table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Quantity</th>
                    <th>Product Name</th>
                    <th>Cost</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <a class="btn btn-info btn-sm" id="back_button"
                          style="color: #fff !important;"><i class="fa fa-backward"></i></a>
             
            @if($batch_details['ordered']!=1)          
                <a data-id="{{$encoded_batch_id}}" id="update_batch_button" href="/update/batch/{{$encoded_batch_id}}" class="btn btn-primary">Edit</a>
                @if ($batch_details['deleted_at'] == null)
                    <a class="btn btn-primary" data-id="{{$encoded_batch_id}}"  href="/make-orders/{{$encoded_batch_id}}">Send Order</a>
                    <a class="btn btn-success" data-id="{{$encoded_batch_id}}" id="delete_batch_order_button" href="#">Delete</a>
                @endif
                @if ($batch_details['deleted_at'])
                <a class="btn btn-success" data-id="{{$encoded_batch_id}}" id="delete_batch_order_button" href="#">Activate</a>
                @endif
            @endif
        </div>
                        </div>
                    </div>
                    </main
@endsection                   