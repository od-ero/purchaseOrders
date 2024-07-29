@extends('layouts.my_app')

@section('subtitle')
 Edit Order
@endsection

@section('contentheader_title')
 Edit Order
@endsection

@section('content')
@include('orders.delete_orders')
<div class="container-fluid px-4">
                        <h1 class="mt-4">Edit Orders</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('admins.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Edit Orders</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                              Edit Orders
                            </div>
                            <div class="card-body">
                            <div class="row mb-3">
                               
                               <div class="col-md-3">
                                @php
                                $encoded_batch_id = base64_encode($batch_details['id']);
                                @endphp
                               <input class="form-control" id="upload_and_view_batch_id" value="{{ $batch_details['id'] }}" name="batch_id" type="text" placeholder="Enter Batch Id"  hidden />
                                       
                                  <div class="form-floating  mb-3 mb-md-0">
                                    
                                       <input class="form-control" id="upload_and_view_batch_name" value="{{ $batch_details['batch_name'] }}" name="batch_name" type="text" placeholder="Enter Batch Name"   />
                                       <label for="inputBatchName">Batch Name  </label>
                                       @if ($errors->has('supplier_name'))
                                           <div class="text-danger mt-2">
                                               {{ $errors->first('mName') }}
                                           </div>
                                       @endif
                                   </div>
                               </div>
                                   <div class="col-md-6">
                                    <div class="form-floating login_form_userid mb-3 mb-md-0">
                                        <select name="supplier_id" id="upload_and_view_supplier_id">
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ base64_encode($supplier['id']) }}"
                                             @if ($supplier['id']==$batch_details['supplier_id'])
                                            selected
                                            @endif>
                                            {{ $supplier['supplier_name'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                            @if ($errors->has('supplier_name'))
                                                <div class="text-danger mt-2">
                                                    {{ $errors->first('supplier_name') }}
                                                </div>
                                            @endif
                                        </div>
                               </div>
                               <div class="col-md-3">
                               <div class="form-floating mb-3 mb-md-0">
                                       <input class="form-control" id="upload_and_view_order_number" name="order_number" type="text" value="{{$batch_details['order_no']}}" placeholder="Enter Your Order Number"   />
                                       <label for="inputPassword">Order Number &emsp; <strong class="text-danger text-right" >*</strong></label>
                                       @if ($errors->has('lName'))
                                           <div class="text-danger mt-2">
                                               {{ $errors->first('lName') }}
                                           </div>
                                       @endif
                                   </div>
                               </div>
                           </div>
                            <table class="table table-bordered data-table" id="purchaseOrdersTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th style="width: 80px;">Quantity</th>
                    <th>Product Name</th>
                    <th style="width: 80px;">Cost</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
            <?php $total_price=0 ?>
           
            <form>
            @foreach($batch_items as $index => $row)

            <tr>
                <td class="order-id">{{ $index + 1 }}</td>
                <td  class="quantity"> <input id="quantity" value="{{ $row['quantity'] ?? '0' }}" style="width: 80px;"> </td>
                <td > <input id="product_name" value="{{ $row['product_name'] ?? '0' }}" style="width: 350px;"></td>
                <td class="price text-end"> <input id="price" value="{{number_format( $row['price_quantity'] ?? '0', 0) }}" class="text-end" style="width: 80px;"> </td> 
                <td class="subtotal text-end">{{number_format($row['price_quantity'] * $row['quantity'], 0)}}</td>
            </tr>
           
            @endforeach
            </form>
            </tbody>
            </table>
            <a class="btn btn-info btn-sm" id="back_button"
                          style="color: #fff !important;"><i class="fa fa-backward"></i></a>
             @can('view-order')             
            <a data-id="{{$encoded_batch_id}}" href="/view/batch/{{$encoded_batch_id}}" class="btn btn-primary">View</a>
            @endcan
            @can('edit-order')
                <a class="btn btn-primary" data-id="{{$encoded_batch_id}}" id="update_batch_button" href="#">Save and View</a>
                @if ($batch_details['deleted_at'] == null)
                    @can('send-order')
                    <a class="btn btn-primary" data-id="{{$encoded_batch_id}}" id="update_and_make_order_button" href="#">Save and Send Order</a>
                    @endcan
            @endcan
            @can('destroy-order')
                <a class="btn btn-success" data-id="{{$encoded_batch_id}}" id="delete_batch_order_button" href="#">Delete</a>
            @endcan    
            @endif
            @can('activate-order')
                @if ($batch_details['deleted_at'])
                <a class="btn btn-success" data-id="{{$encoded_batch_id}}" id="activate_batch_order_button" href="#">Activate</a>
                @endif
            @endcan
            </div>
                        </div>
                    </div>
</main>
<style>
    .total-row {
    font-weight: bold;
    background-color: #f9f9f9;
}
</style>                 
@endsection                   


